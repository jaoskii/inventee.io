<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\Web\Session;
use yii\web\Request;
use app\models\Common;
use app\models\Client;
use app\models\Cntnum;
use app\models\Transnum;
use app\models\Pohead;
use app\models\Postock;
use app\models\Log;
use yii\base\ErrorException;
use yii\helpers\Url;

class frontendfunctions extends Component{

	public function dateFarmRange($fromdate, $todate) {
		try {
		    $datefarm = [];
		    $fromdate = \DateTime::createFromFormat('Y-m-d', $fromdate);
		    $todate = \DateTime::createFromFormat('Y-m-d', $todate);
		    $dateperiod = new \DatePeriod($fromdate,new \DateInterval('P1D'),$todate->modify('+1 day'));

			foreach($dateperiod as $date) {
			   $datefarm[] =  $date->format('Y-m-d');
			}//end for each

			return $datefarm;
		} catch (ErrorException $e) {
			echo $e;
		}
	}//end frunction

	public function getRoomDetailedAvailability($roomid,$startdate,$enddate,$bookedrooms,$pax){
		$qry = "select left(monthname(left(rplan.dateid,10)),3) as month,day(left(rplan.dateid,10)) as day,
				year(left(rplan.dateid,10)) as year,rhead.nopax,(rplan.qty-rplan.iss) as balance,
				case when (rplan.qty-rplan.iss) = 0 then 'NAVAILABLE'
				     when (rplan.qty-rplan.iss) >= ".$bookedrooms." then 'AVAILABLE'
				     when (rplan.qty-rplan.iss) < ".$bookedrooms." then 'INSUFFICIENT' end as roomstatus
				from roomplan as rplan
				left join rthead as rhead on rhead.trno = rplan.trno
				where left(rplan.dateid,10) between '".$startdate."' and '".$enddate."'
				and md5(rplan.trno) = '".$roomid."'";
		$roomdetails = Yii::$app->sbccommon->opentable($qry);

		if(!empty($roomdetails)){
			foreach ($roomdetails as $key => $value) {
				switch ($value['roomstatus']) {
					case 'AVAILABLE':
						$roomdetails[$key]['isav'] = 1;
					break;

					case 'INSUFFICIENT':
						$roomdetails[$key]['isav'] = 0;
						$roomdetails[$key]['roomstatus'] = 'INSUFFICIENT ROOMS';
					break;
					
					case 'NAVAILABLE':
						$roomdetails[$key]['isav'] = 0;
						$roomdetails[$key]['roomstatus'] = 'NOT AVAILABLE';	
					break;
				}//end switch
			}//end for each
		}//end if

		return $roomdetails;
	}//end function

    public function getRoomAvailabilities($startdate,$enddate,$bookedroom,$pax){
       	$roomids = [];
       	$strcompare = '';
       	$datefarm = $this->dateFarmRange($startdate,$enddate);
       	$roomtypes = $this->getActiveRoomTypes();


       		foreach ($roomtypes  as $key => $value) {
       			foreach ($datefarm as $key => $value2) {
       				
       				$qry = "select left(roomplan.dateid,10) as dateid from roomplan
       						left join rthead as roomhead on roomhead.trno = roomplan.trno
							where left(roomplan.dateid,10) between '".$startdate."' and '".$enddate."' and md5(roomplan.trno) = '".$value['roomid']."'
							and (roomplan.qty-roomplan.iss) <> 0 
							and left(roomplan.dateid,10) = '".$value2."' 
							and roomhead.nopax >= ".$pax."
							order by left(roomplan.dateid,10) asc";

					$datechecker = Yii::$app->sbccommon->datareader($qry);

					if(empty($datechecker)){
						break 1;
					}//end if

					if($datechecker == $enddate){
						$roomids[] = $value['roomid'];
					}//end if
       			}//end for each
       		}//end if
       		
       		foreach ($roomids as $key => $value) {
       			if($strcompare == ''){
       				$strcompare .= '"'.$value.'"';
       			}else{
       				$strcompare .= ',"'.$value.'"';
       			}//end if
       		}//end function
       	
        if($strcompare == ''){
            $strcompare = '""';
        }//end if

       	$qryrooms = 'select head.roomtype,head.rem,md5(head.trno) as roomid from rthead as head where md5(head.trno) in ('.$strcompare.')';
       	return Yii::$app->sbccommon->opentable($qryrooms);
    }//end function

    public function getActiveRoomTypes(){
        $qry = "select head.rem,head.roomtype,md5(head.trno) as roomid from rthead as head where head.isinactive = 0";
        return Yii::$app->sbccommon->opentable($qry);
    }//end action 

    public function getFeaturedRoomtypes(){
        $qry = "select head.rem,head.roomtype,md5(head.trno) as roomid from rthead as head where head.isinactive = 0 limit 3";
        return Yii::$app->sbccommon->opentable($qry);
    }//end funciton

    public function getRoomdetails($md5roomid){
        $qry = "select head.rem,head.roomtype,md5(head.trno) from rthead as head where md5(head.trno) = '".$md5roomid."'";
        return Yii::$app->sbccommon->opentable($qry);
    }//end funciton

    public function getAvailableFlashDeal(){
        $qry = "select flashid,startdate,enddate from frontend_flashdeal where
        left(now('Y-m-d'),10) between startdate and  enddate limit 1";
        $flashinfo = Yii::$app->sbccommon->opentable($qry);
        
        if(empty($flashinfo)){
            $flashavail = false;
            $flashitems = array();
            $flashend = date('Y-m-d');
            $theflash = '';
        }else{
            $flashend = str_replace('/','-',$flashinfo[0]['enddate']);
            $flashavail = true;
            $theflash = $flashinfo[0]['flashid'];
        }//end if
       
        return array('flashavailable'=>$flashavail,'flashend'=>$flashend,'flashid'=>$theflash);
    }//end if

    public function postCheckedOutComplete($trno){
            $date=date("Y-m-d H:i:s");
            $user='COMPUTER';
            $posted=false;
            $lhead=Common::localhead('SO');
            $lstock=Common::localstock('SO');
            $hhead=Common::localhhead('SO');
            $hstock=Common::localhstock('SO');
            $docno=Cntnum::getdocno($trno,'SO');

            if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,
            dateid,terms,rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,
            lockuser,agent,wh,mop,moddate,modamt,modref,salestype) SELECT head.trno,head.doc, head.docno,client.client,
            head.clientname, head.address, head.shipto,head.dateid as dateid, head.terms, head.rem, head.forex,
            head.yourref, head.ourref, head.createdate,head.createby,head.editby,head.editdate,
            head.lockdate,head.lockuser,head.agent,head.wh,head.mop, head.moddate,head.modamt,head.modref,head.salestype
            FROM $lhead as head left join cntnum on cntnum.trno=head.trno left join client on head.client=client.client
            where head.trno=$trno limit 1")==1){
                if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,disc,amt,iss,
                void,loc,expiry,isamt,isqty,ext,encodeddate,qa,encodedby,editdate,editby,rem)
                SELECT trno, line, barcode, itemname, uom,wh,disc,amt, iss,void,loc,expiry,
                isamt, isqty, ext, encodeddate,qa, encodedby,editdate,editby,rem FROM $lstock where trno =$trno")==1){
                    $posted=true;                                        
                }else{
                    Transnum::deletehead($trno, $doc);
                }//END INSERT 
            }//end if insert to hhead for SO

            if($posted){
                if(Yii::$app->sbccommon->execqry("update transnum set postdate='$date',postedby='$user' where trno='$trno'")==1){
                    Log::writelog('SO', $trno, 'POST', $docno,$user);                                
                    Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
                    Yii::$app->sbccommon->execqry("DELETE from $lstock where trno='$trno'");
                }else{
                    Transnum::deletestock($trno, $doc);
                }//END IF UPDATE TRANS
            }//END IF POSTED
    }//end post checkedoutcomplete

    public function getAvailableDODHeader(){
        Yii::$app->systemsettings->setDefaultTimeZone();
        $qry = "select md5(dodid) as dodid,primarypic from frontend_dod where dod_date = '".date('Y-m-d')."'";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function isUnderHighlight($barcode){
        Yii::$app->systemsettings->setDefaultTimeZone();
        $itemid = Yii::$app->backend->requestItemid($barcode);
        $qry = "select hinfo.discount,hinfo.promostart,hinfo.promoend from frontend_highlightitems as hitem
        left join frontend_highlights as hinfo on hinfo.highid = hitem.highid
        where hitem.itemid = ".$itemid." and hinfo.promostart <= left(now(),10) and hinfo.promoend >= left(now(),10)
        group by hitem.highid
        order by hinfo.promostart limit 1";

        $highlights = Yii::$app->sbccommon->opentable($qry);
        if(!empty($highlights)){
            foreach ($highlights as $key => $value) {
                if($value['promostart'] >= date('Y-m-d') && $value['promoend'] >= date('Y-m-d')){
                    $status = true;
                }else{
                    $status = false;
                }//end if
            }//end for each highlights
        }else{
            $status = false;
        }//end if

        return array('status'=>$status,'hinfo'=>$highlights);
    }//end function

    public function retrieveHighlights($type = ''){
        switch (strtoupper($type)) {
              case 'FEATURED':
                  $qry ="select md5(highid) as highkey,high_desc,primarybanner,primarypic from frontend_highlights where isfeatured = 1 and left(now(),10) <= promoend";
                  //FILTERS BOTH START AND END DATE FOR HIGHLIGHT
                  /*$qry ="select md5(highid) as highkey,high_desc,primarybanner,primarypic from frontend_highlights where isfeatured = 1 
                  and left(now(),10) >= promostart and promoend >= left(now(),10)";*/
                  break;
              
              default:
                  $qry ="select md5(highid) as highkey,high_desc,primarybanner,primarypic from frontend_highlights where left(now(),10) <= promoend";
                  break;
          }//END SWITCH CASE

        return Yii::$app->sbccommon->opentable($qry);
    }//end function retrieve highlights

    public function verifyWhatLane($laneid){
        $qry = "select laneid from frontend_lanetree where catid = ".$laneid."";
        return Yii::$app->sbccommon->datareader($qry);
    }//end fucntion verify what lane

    public function checkItemPriceChanges($itemid,$compareamt){
        Yii::$app->systemsettings->setDefaultTimeZone();
        $qry = "select barcode,round(amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,promostart,promoend,
        round(saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice from item where itemid = ".$itemid."";
        $itemdetails = Yii::$app->sbccommon->opentable($qry);
        
        //default values;
        $msg = "";
        $changed = false;

        if($this->checkIfItemisSale($itemdetails[0]['barcode'])){
            //THIS MEANS ITEM IS SALE (COMPARES ORDER PRICE AND SALE PRICE)
            $changedamt = $itemdetails[0]['saleprice'];
            if($compareamt != $changedamt){
                $changed = true;
                if($itemdetails[0]['promoend'] > date('Y-m-d')){
                    $msg = "Sale price has been changed for this item.";
                }else{
                    $msg = "Promo period has ended on " . $itemdetails[0]['promoend'];
                }//end if item details promo end
            }else{
                $changed = false;
                $msg = "Nothing changed.";
            }//end if compareamt != salesprice
        }else{
            $changedamt = $itemdetails[0]['amt'];
            //THIS MEANS ITEM IS NOT SALE ANYMORE
            if($compareamt != $changedamt){
                $changed = true;
                $msg = "Price has been changed for this item.";
            }else{
                $changed = false;
                $msg = "Nothing changed.";
            }//end if compareamt != salesprice
        }//end if

        return array('changed'=>$changed,'msg'=>$msg,'changedamt'=>$changedamt);
    }//end if function

    public function generalSearch($searchstring,$lanekey){
        if($lanekey == "ALL"){
            $qry = "select ifnull(gallery.img1,'') as picture,item.barcode,item.fdiscounted,
            round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
            round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
            item.itemname from item
            left join item_gallery as gallery on gallery.itemid = item.itemid where item.itemname like '%".$searchstring."%'";
        }else{
            $qry = "select ifnull(gallery.img1,'') as picture,item.barcode,item.fdiscounted,
            round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
            round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
            item.itemname from item
            left join item_gallery as gallery on gallery.itemid = item.itemid 
            left join frontend_categories as cats on cats.catid = item.f_cattagging
            left join frontend_lanes as lanes on lanes.navid = cats.nav_parent
            where item.itemname like '%".$searchstring."%' and cats.nav_parent = ". $lanekey;
        }//end if

        $items = Yii::$app->sbccommon->opentable($qry);
        
        foreach ($items as $key => $value) {
            if($this->checkIfItemisSale($value['barcode'])){
                $items[$key]['issale'] = true;
            }else{
                $items[$key]['issale'] = false;
            }//end if
        }//end for each

        return $items;
    }//end functiion 

    public function isAllowedCheckoutperStep($step){
        if(empty($step) || !isset($step)){
            return false;
        }else{
            switch ($step) {
                case '1': case '2': case '3':
                    if(empty(Yii::$app->session['cart']) || !isset(Yii::$app->session['cart']) || !isset(Yii::$app->session['cart'])  && empty(Yii::$app->session['ongoingcheckout']) || !isset(Yii::$app->session['ongoingcheckout']) && empty(Yii::$app->session['cart'])){
                        return false;
                    }else{
                        return true;
                    }
                break;

                case '4':
                    if(isset(Yii::$app->session['ongoingcheckout']['ptype']) || !empty(Yii::$app->session['ongoingcheckout']['ptype'])){
                        return true;
                    }else{
                        return false;
                    }//end if
                break;
                
                default:
                    return true;
                break;
            }//end
        }//end if
    }//end function
    ################################### FOR STEAM LAYOUT    
    public function transferPendingtoCart($md5_trno){
        $qry = "select item.amt as currentretail,item.saleprice as currentsaleprice,head.trno,
        head.docno,images.picture,head.trno,stock.barcode,stock.isqty as qty,stock.isamt as price,
        (stock.isqty * stock.isamt) as totprice,stock.uom,
        stock.itemname from sohead as head
        left join sostock as stock on stock.trno = head.trno
        left join item on item.barcode = stock.barcode
        left join itimages as images on images.codeid = item.itemid
        where md5(head.trno) = '".$md5_trno."'";
        $cartitems = Yii::$app->sbccommon->opentable($qry);


        unset(Yii::$app->session['cart']);
        unset(Yii::$app->session['ongoingcheckout']);

        foreach ($cartitems as $key => $value) {
            if($this->checkIfItemisSale($value['barcode'])){
                $price = $value['currentsaleprice'];
            }else{
                $price = $value['currentretail'];
            }//end if else

            $totprice = floatval($price) * floatval($value['qty']);

            if(!empty(Yii::$app->session['cart'])){
                $addeditem = array('picture'=>$value['picture'],'itemname' => $value['itemname'],'uom'=>$value['uom'],
                'qty' => number_format($value['qty']),'price' => $price,'totprice' => $totprice);
                Yii::$app->session['cart'] = array_merge(Yii::$app->session['cart'], [$value['barcode'] => $addeditem]);
            }else{
                Yii::$app->session['cart'] = [$value['barcode'] => array('picture'=>$value['picture'],'itemname'=>$value['itemname'],
                'uom'=>$value['uom'],'qty'=>number_format($value['qty']),'price'=>$price,'totprice'=>$totprice)];
            }//end if
        }//end for each

      //  echo $qry;
        Yii::$app->session['ongoingcheckout'] = array('trno'=>$cartitems[0]['trno'],'docno'=>$cartitems[0]['docno']);
      /*  var_dump(Yii::$app->session['cart']);
        var_dump(Yii::$app->session['ongoingcheckout']);
        return 0;*/
    }//end function 

    public function checkifZero($type){
        switch ($type) {
            case 'CART':
                if(!empty(Yii::$app->session['cart']) && isset(Yii::$app->session['cart'])){
                    $gtotalamt = 0;
                    foreach (Yii::$app->session['cart'] as $key => $value) {
                        $total = floatval(Yii::$app->session['cart'][$key]['totprice']) + floatval($gtotalamt);

                        if($total > 0){
                            return false;
                        }else{
                            return true;
                        }//end if

                    }//end foreach
                }else{
                    return true;
                }//end if
                break;
        }//end switch
    }//end function

    public function checkIfItemisSale($barcode){
    try {
        Yii::$app->systemsettings->setDefaultTimeZone();
        $itemid = Yii::$app->backend->requestItemid($barcode);
        $qry = "select promostart,promoend from item where itemid = ".$itemid."";
        $promodates = Yii::$app->sbccommon->opentable($qry);
        
        /*if($promodates[0]['promostart'] == '0000-00-00' || $promodates[0]['promoend'] == '0000-00-00'){
            return false;
        }else{
            if($promodates[0]['promostart'] == '1900-01-01' || $promodates[0]['promoend'] == '1900-01-01'){
                return false;
            }else{
                if($promodates[0]['promostart'] == '' || $promodates[0]['promoend'] == ''){
                    return false;
                }else{
                    if($promodates[0]['promostart'] <= date('Y-m-d') && $promodates[0]['promoend'] >= date('Y-m-d')){
                        return true;
                    }else{
                        return false;
                    }//end if
                }//end if
            }//end if
        }//end if*/
    } catch (ErrorException $e) {
     echo $e;   
    }
    }//end function check if item is sale

    public function UpdateCustomerInfo($cdata){
        $qry = "update client set clientname = '".$cdata['infoname']."',email = '".$cdata['infoemail']."',tel2='".$cdata['infocontact']."',addr = '".$cdata['infoaddress']."'
        where clientid = '".Yii::$app->session['customerdata']['clid']."' and iscustomer = 1";
        return Yii::$app->sbccommon->execqry($qry);
    }//end function


    public function retrieveTopRecentOrders($customercode){
        $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,head.shipto,
                round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').")  as amt from sohead as head
                left join sostock as stock on stock.trno = head.trno
                left join transnum as num on num.trno = head.trno
                where head.client = '".$customercode."' and num.fromfrontend = 1 and num.fppayment = 1
                group by head.docno order by dateid desc limit 6";
        
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveOrderHistory($params = ""){
        if(!empty($params)){
            if(isset($params['search'])){
                $searchstring = " and head.docno like '%".$params['search']."%' ";
            }else{
                $searchstring = " ";
            }//end if
        }else{
            $searchstring = " ";
        }//end if

        $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,head.trno,
                round(sum(stock.amt),".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').")  as amt from sohead as head
                left join sostock as stock on stock.trno = head.trno
                left join client as customer on customer.client = head.client
                left join transnum as num on num.trno = head.trno
                where customer.clientid = ".Yii::$app->session['customerdata']['clid']."
                and num.fromfrontend = 1 and num.fppayment = 1 ".$searchstring."
                group by head.docno order by dateid desc";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function order history

     public function retrieveUnfinishedOrders(){
        $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,head.trno,
                round(sum(stock.amt),".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').")  as amt from sohead as head
                left join sostock as stock on stock.trno = head.trno
                left join item on item.barcode = stock.barcode
                left join client as customer on customer.client = head.client
                left join transnum as num on num.trno = head.trno
                where customer.clientid = ".Yii::$app->session['customerdata']['clid']."
                and num.fromfrontend = 1 and num.fppayment = 0
                group by head.docno order by head.createdate desc";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function order history



    public function retrieveOrderDetails($trno){
        $qry = "select stock.barcode,
        md5(head.trno) as trno,ifnull(gallery.img1,'') as img1,head.docno,left(head.dateid,10) as dateid,stock.itemname,
        round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').")  as amt,
        round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('fquantity').")  as qty,
        round((stock.isamt * stock.isqty),".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').")  as totalamt,stock.fstatus,head.shipto
        from sohead as head
        left join sostock as stock on stock.trno = head.trno
        left join transnum as num on num.trno = head.trno
        left join item on item.barcode = stock.barcode
        left join item_gallery as gallery on gallery.itemid = item.itemid
        where num.fromfrontend = 1 and head.trno = ".$trno."
        order by stock.line";

        $itemdetails = Yii::$app->sbccommon->opentable($qry);

        foreach ($itemdetails as $key => $value) {

            $itemid = Yii::$app->backend->requestItemid($value['barcode']);
            $pricechangedetails = $this->checkItemPriceChanges($itemid,$value['amt']);
            $itemdetails[$key]['ispricechanged'] = $pricechangedetails['changed'];
            $itemdetails[$key]['pricechangemsg'] = $pricechangedetails['msg'];        
            $itemdetails[$key]['currentamt'] = $pricechangedetails['changedamt'];        
        }//end for each
    
        return $itemdetails;
    }//end function order details 

    public function checkForPendingOrderItem($trno){
        $qry = "select stock.barcode from sostock as stock
        left join transnum as num on num.trno = stock.trno
        where stock.fstatus <> 'CLOSED'
        and num.fromfrontend = 1 and stock.trno = ".$trno."";

        return Yii::$app->sbccommon->opentable($qry);
    }//end check for order item pending

    public function checkIfStockisAvailable($itemid){
        $qry = "select fqty from item where itemid = ".$itemid."";
        $fqty = Yii::$app->sbccommon->datareader($qry);

        if($fqty <= 0){
            return false;
        }else{
            return true;
        }//end 
    }//end function

    public function verifyCustomerCredentials(){
        if(isset(Yii::$app->session['customerdata']) && !empty(Yii::$app->session['customerdata'])){
            return true;
        }else{
            return false;            
        }//end if
    }//end function

    public function generateAddressBook($userid){
        $qry = "select 'default' as addid,client.clientname as name,client.addr as address,
        ifnull(client.contact,'') as contact,client.email
        from client where iscustomer = 1 and client.clientid = ".$userid."
        UNION ALL
        select adbook.addid,ifnull(adbook.name,'') as name,ifnull(adbook.address,'') as address,
        ifnull(adbook.contact1,'') as contact,
        ifnull(adbook.email,'') as email from frontend_addressbook as adbook
        where adbook.customerid = ".$userid."";

        return Yii::$app->sbccommon->opentable($qry);
    }//end address book function

    public function retrieveAddressdetail($addid,$params){
       $addid = strtoupper($addid);
       switch ($addid) {
            case 'NEW':
               $addressdetail[0]['name'] = $params['add-name'];
               $addressdetail[0]['address'] = $params['add-address'] . ' ' . $params['add-province'] . ' ' . $params['add-city'] . ' ' . $params['add-municipality'];
               $addressdetail[0]['contact'] = $params['add-mobile'];
               $qry = "insert into frontend_addressbook (customerid,name,address,contact1,email,tagging)
               values(".Yii::$app->session['customerdata']['clid'].",'".$addressdetail[0]['name']."','".$addressdetail[0]['address']."',
               '".$addressdetail[0]['contact']."','".Yii::$app->session['customerdata']['email']."','DEFAULT')";
               Yii::$app->sbccommon->execqry($qry);
            break;
           
            case 'DEFAULT':
            $qry =  "select 'default' as addid,client.clientname as name,client.addr as address,
            ifnull(client.contact,'') as contact,client.email
            from client where iscustomer = 1 and client.clientid = ".Yii::$app->session['customerdata']['clid']."";
            $addressdetail =  Yii::$app->sbccommon->opentable($qry);
            break;

            default:
            $qry = "select adbook.addid,ifnull(adbook.name,'') as name,ifnull(adbook.address,'') as address,
            ifnull(adbook.contact1,'') as contact,
            ifnull(adbook.email,'') as email from frontend_addressbook as adbook
            where adbook.customerid = ".Yii::$app->session['customerdata']['clid']." and adbook.addid = ".$addid."";
            $addressdetail =  Yii::$app->sbccommon->opentable($qry);
            break;
       }//end switch case

       return $addressdetail;
    }//end switch case

    public function addItemViewingCount($barcode){
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
        Yii::$app->systemsettings->setDefaultTimeZone();
        $ip = Yii::$app->request->getUserIP();
        $url = Yii::$app->request->getAbsoluteUrl();
        $checkerqry = "select viewid from frontend_itemviews where ipaddress = '".$ip."' and barcode = '".$barcode."' and left(viewdate,10) ='".date('Y-m-d')."'";
        $viewid = Yii::$app->sbccommon->datareader($checkerqry);

        if(empty($viewid)){
            $insertview = "insert into frontend_itemviews (ipaddress,barcode,viewdate,url) values('".$ip."','".$barcode."','".$current_timestamp."','".$url."')";
        Yii::$app->sbccommon->execqry($insertview);
        }//end if
    }//end function

    public function retrieveCategoryBanners($keyid){
        $qry = "select ifnull(strimg,'') as strimg,bannerid,catid,line from frontend_catbanner where catid = ".$keyid." order by line asc";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveBrandBanners($keyid){
        $qry = "select ifnull(strimg,'') as strimg,md5(brandid) as brandid,bannerid,line from frontend_brbanner where brandid = '".$keyid."' order by line asc";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveHighlightBanners($keyid){
        $qry = "select ifnull(primarybanner,'') as strimg,md5(highid) as highid,0 as line from frontend_highlights where md5(highid) = '".$keyid."'";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveDODBanner($keyid){
        $qry = "select ifnull(primarybanner,'') as strimg,md5(dodid) as dodid,0 as line from frontend_dod where md5(dodid) = '".$keyid."'";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function ListAvailableProductsFor($parentid,$type){ //THIS WILL BE A GENERAL FUNCTION FOR PRODUCT LISTING (DON'T MODIFY)
    Yii::$app->systemsettings->setDefaultTimeZone();
    $orderby = ' item.itemid desc';

        switch ($type) {
            case 'CATEGORY':
                $qry = "select cats.catid as md5id,cats.cat_desc,ifnull(gallery.img1,'') as picture,item.barcode,item.fdiscounted,'default' as type,
                round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                item.itemname from item
                left join frontend_categories as cats on cats.catid = item.f_cattagging
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where f_cattagging = ".$parentid." and item.setfrontend = 1" . $orderby;
                break;
            
            case 'LANE':
                $qry = 'select item.f_cattagging as md5id,ifnull(gallery.img1,"") as picture,item.barcode,item.fdiscounted,"default" as type,
                round(item.amt,2) as amt,round(item.saleprice,2) as saleprice,item.itemname from item
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.f_cattagging in (select catid from frontend_lanetree where laneid = '.$parentid.' and item.setfrontend = 1)' . $orderby;
                break;

            case 'BRAND':
                $qry = 'select ebrands.brandid as md5id,ifnull(gallery.img1,"") as picture,item.barcode,item.fdiscounted,"default" as type,
                round(item.amt,2) as amt,round(item.saleprice,2) as saleprice,item.itemname from item
                left join item_gallery as gallery on gallery.itemid = item.itemid
                left join frontend_ebrands as ebrands on ebrands.brand_desc = item.brand
                where md5(ebrands.brandid) = "'.$parentid.'" and item.setfrontend = 1' . $orderby;
                break;

            case 'HIGHLIGHT':
                $qry = 'select hinfo.highid as md5id,"highlight" as type,hinfo.discount,ifnull(gallery.img1,"") as picture,item.barcode,item.fdiscounted,
                item.amt as amt,0 as saleprice,item.itemname from item
                left join item_gallery as gallery on gallery.itemid = item.itemid
                left join frontend_highlightitems as hitem on hitem.itemid = item.itemid
                left join frontend_highlights as hinfo on hinfo.highid = hitem.highid
                where md5(hinfo.highid) = "'.$parentid.'" and item.setfrontend = 1' . $orderby;
                break;

            case 'DOD': // DEAL OF THE DAY
                $qry = "select doditems.dodid as md5id,'dod' as type,cats.cat_desc,ifnull(gallery.img1,'') as picture,dod.dodid,dod.dod_date,
                item.itemname,item.barcode,item.promostart,item.promoend,item.itemid,
                item.fdiscounted,round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(doditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice
                from frontend_doditems as doditems
                left join frontend_dod as dod on dod.dodid = doditems.dodid
                left join item on item.itemid = doditems.itemid
                left join frontend_categories as cats on cats.catid = item.f_cattagging
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where dod.dod_date = '".date('Y-m-d')."' and item.setfrontend = 1";
            break;

            case 'FLASHDEAL':
                $qry="select fitems.flashid as md5id,'flashdeal' as type,fitems.itemid,
                cats.cat_desc,ifnull(gallery.img1,'') as picture,item.barcode,item.fdiscounted,
                round(fitems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(fitems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                item.itemname from frontend_fdealitems as fitems
                left join item on item.itemid = fitems.itemid
                left join frontend_categories as cats on cats.catid = item.f_cattagging
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where fitems.flashid = ".$parentid . $orderby;
            break;
        }//END SWITCH CASE

        $items = Yii::$app->sbccommon->opentable($qry);

        if(!empty($items)){
            switch ($type) {
                case 'CATEGORY': case 'LANE': case 'BRAND':
                    foreach ($items as $key => $value) {
                        if($this->checkIfItemisSale($value['barcode'])){
                            $items[$key]['issale'] = true;
                        }else{
                            $items[$key]['issale'] = false;
                        }//end if

                        $highinfo = $this->isUnderHighlight($value['barcode']);
                        
                        if($highinfo['status']){
                            $items[$key]['issale'] = true;
                            $discountedprice = Yii::$app->sbccommon->Discount($value['amt'],$highinfo['hinfo'][0]['discount']);
                            $items[$key]['amt'] = number_format($value['amt'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                            $items[$key]['saleprice'] = number_format($discountedprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                        }else{
                            $items[$key]['amt'] = number_format($value['amt'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                            $items[$key]['saleprice'] = number_format($value['saleprice'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                        }//end if
                    }//end for each
                    break;
                
                case 'HIGHLIGHT':
                    foreach ($items as $key => $value) {
                        $items[$key]['issale'] = true;
                        $discountedprice = Yii::$app->sbccommon->Discount($value['amt'],$value['discount']);
                        $items[$key]['saleprice'] = number_format($discountedprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                        $items[$key]['amt'] = number_format($value['amt'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                    }//END FOR EACH
                    break;

                case 'DOD':
                    foreach ($items as $key => $value) {
                        $items[$key]['issale'] = true;
                    }//end for each
                break;

                case 'FLASHDEAL':
                    foreach ($items as $key => $value) {
                        $items[$key]['issale'] = true;
                    }//end for each
                break;
            }//END SWITCH
        }//end if items is not empty

        return $items;
    }//end function

    public function getMostReviewedItems(){
        $qry = "select ifnull(gallery.img1,'') as picture,item.barcode,item.fdiscounted,
        round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
        round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
        item.itemname from item
        left join item_gallery as gallery on gallery.itemid = item.itemid
        where item.setfrontend = 1
        order by item.itemid desc limit 10";

        $items = Yii::$app->sbccommon->opentable($qry);
        if(!empty($items)){
            foreach ($items as $key => $value) {
                $items[$key]['amt'] = number_format($value['amt'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                $items[$key]['saleprice'] = number_format($value['saleprice'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                if($this->checkIfItemisSale($value['barcode'])){
                    $items[$key]['issale'] = true;
                }else{
                    $items[$key]['issale'] = false;
                }//end if
            }//end for each
        }

        return $items;
    }//end function

    public function getPersonallyPicked(){
        $qry = "select ifnull(gallery.img1,'') as picture,item.barcode,item.fdiscounted,
        round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
        round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
        item.itemname from item
        left join item_gallery as gallery on gallery.itemid = item.itemid
        order by item.itemid desc limit 10
        where item.setfrontend = 1";

        $items = Yii::$app->sbccommon->opentable($qry);
        if(!empty($items)){
            foreach ($items as $key => $value) {
                $items[$key]['amt'] = number_format($value['amt'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                $items[$key]['saleprice'] = number_format($value['saleprice'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
                if($this->checkIfItemisSale($value['barcode'])){
                    $items[$key]['issale'] = true;
                }else{
                    $items[$key]['issale'] = false;
                }//end if
            }//end for each
        }

        return $items;
    }//end function


    public function retrieveItemFrontendDetails($itemid){
        $qry = "select itimages.picture,item.f_cattagging,item.barcode,item.itemname,
        item.f_proddesc,item.fdiscounted,
        round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
        item.fqty,
        round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
        item.promostart,item.promoend,item.f_videourl,item.f_notes,item.f_freeitems,item.f_whatsbox,
        item.f_highlights,item.f_type,item.f_mainmaterial,item.f_dimensions,f_warrantperiod,f_warrantytype,f_warrantpolicy,
        item.f_prodweight,item.f_packheight,item.f_packlength,item.f_packwidth,item.f_packweight,item.f_delivopt,
        ifnull(gallery.img1,'') as img1,ifnull(gallery.img2,'') as img2,ifnull(gallery.img3,'') as img3,
        ifnull(gallery.img4,'') as img4,ifnull(gallery.img5,'') as img5,ifnull(gallery.img6,'') as img6,
        ifnull(gallery.img7,'') as img7,ifnull(gallery.img8,'') as img8 from item
        left join item_gallery as gallery on gallery.itemid = item.itemid
        left join itimages on itimages.codeid = item.itemid
        where item.itemid= ".$itemid." and item.setfrontend = 1";

        $items = Yii::$app->sbccommon->opentable($qry);

        foreach ($items as $key => $value) {
            $items[$key]['amt'] = number_format($value['amt'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
            $items[$key]['saleprice'] = number_format($value['saleprice'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
            if($this->checkIfItemisSale($value['barcode'])){
                $items[$key]['issale'] = true;
            }else{
                $items[$key]['issale'] = false;
            }//end if
        }//end for each



        return $items;
    }//end function item frontend details

    public function generateBreadcrumbs($type,$params){
    try {
        $breadcrumb = "";

        switch ($type) {
          case 'ITEM':
              $getcat = "select cats.catid,cats.nav_parent,item.itemname,item.f_cattagging,cats.cat_desc,cats.parent from item 
              left join frontend_categories as cats on cats.catid = item.f_cattagging
              where itemid = ".$params['itemid']."";

              $tagging = Yii::$app->sbccommon->opentable($getcat);
              $looptag = $tagging[0]['parent'];
              $navparent = $tagging[0]['nav_parent'];
              $breadcrumb = $breadcrumb .'<li class=""><strong>'.$tagging[0]['itemname'].'</strong></li>';
              $breadcrumb = '<li class="home"><a href="'.Url::to(['/frontend/products/', 'type' => 'category','v'=>$tagging[0]['catid']]).'">'.$tagging[0]['cat_desc'].'</a><span>&mdash;›</span></li>' . $breadcrumb;

                if($tagging[0]['parent'] != 0){
                  do {
                    $getcatdetailqry = "select cats.catid,cats.parent,cats.nav_parent,cats.cat_desc from frontend_categories as cats where cats.catid = ".$looptag.""; 
                    $catdetail = Yii::$app->sbccommon->opentable($getcatdetailqry);
                      if(empty($breadcrumb)){
                        $breadcrumb = $breadcrumb . '<li class="home"><a href="#">'.$catdetail[0]['cat_desc'].'</a></li>';
                      }else{
                       $breadcrumb = '<li class="home"><a href="'.Url::to(['/frontend/products/', 'type' => 'category','v'=>$catdetail[0]['catid']]).'">'.$catdetail[0]['cat_desc'].'</a><span>&mdash;›</span></li>' . $breadcrumb;
                      }//end if
                    $parent = $catdetail[0]['parent'];
                    $navparent = $catdetail[0]['nav_parent'];
                    $looptag = $catdetail[0]['catid'];
                  } while ($navparent == 0);
                }//end if

              $getlaneqry = "select navid,nav_desc from frontend_lanes where navid = ".$navparent."";
              $lane = Yii::$app->sbccommon->opentable($getlaneqry);
              $breadcrumb = '<li class="home"><a href="'.Url::to(['/frontend/products/', 'type' => 'lane','v'=>$lane[0]['navid']]).'">'.$lane[0]['nav_desc'].'</a><span>&mdash;›</span></li>' . $breadcrumb;
              
              $breadcrumb = '<ul>' . $breadcrumb;
              $breadcrumb = $breadcrumb . '</ul>';
              return $breadcrumb;
          break;

          case 'CATEGORY':
              $getcat = "select cats.nav_parent,cats.parent,cats.catid,cats.cat_desc from frontend_categories as cats where cats.catid = ".$params['v']."";
              $tagging = Yii::$app->sbccommon->opentable($getcat);
              $looptag = $tagging[0]['parent'];
              $navparent = $tagging[0]['nav_parent'];
              $breadcrumb = $breadcrumb .'<li class=""><a href="'.Url::to(['/frontend/products/', 'type' => 'category','v'=>$tagging[0]['catid']]).'"><strong>'.$tagging[0]['cat_desc'].'</strong></a></li>';

            if($tagging[0]['parent'] != 0){
                do {
                    $getcatdetailqry = "select cats.catid,cats.parent,cats.nav_parent,cats.cat_desc from frontend_categories as cats where cats.catid = ".$looptag.""; 
                    $catdetail = Yii::$app->sbccommon->opentable($getcatdetailqry);
                      if(empty($breadcrumb)){
                        $breadcrumb = $breadcrumb . '<li class="home"><a href="#">'.$catdetail[0]['cat_desc'].'</a></li>';
                      }else{
                       $breadcrumb = '<li class="home"><a href="'.Url::to(['/frontend/products/', 'type' => 'category','v'=>$catdetail[0]['catid']]).'">'.$catdetail[0]['cat_desc'].'</a><span>&mdash;›</span></li>' . $breadcrumb;
                      }//end if
                    $parent = $catdetail[0]['parent'];
                    $navparent = $catdetail[0]['nav_parent'];
                    $looptag = $catdetail[0]['catid'];
                } while ($navparent == 0);
            }//end if

              $getlaneqry = "select navid,nav_desc from frontend_lanes where navid = ".$navparent."";
              $lane = Yii::$app->sbccommon->opentable($getlaneqry);
              $breadcrumb = '<li class="home"><a href="'.Url::to(['/frontend/products/', 'type' => 'lane','v'=>$lane[0]['navid']]).'">'.$lane[0]['nav_desc'].'</a><span>&mdash;›</span></li>' . $breadcrumb;
              
              $breadcrumb = '<ul>' . $breadcrumb;
              $breadcrumb = $breadcrumb . '</ul>';
              return $breadcrumb;
          break;

          case 'LANE':
            $qry = "select nav_desc as lane from frontend_lanes where navid = ".$params['v']."";
            $lane = Yii::$app->sbccommon->datareader($qry);
            return '<ul><li class=""><strong>'.$lane.'</strong></li></ul>';
          break;

          case 'STOCKCARD':
            $getcat = "select cats.nav_parent,ifnull(cats.parent,0) as parent,cats.catid,cats.cat_desc from frontend_categories as cats where cats.catid = ".$params['f_cattagging']."";
            $tagging = Yii::$app->sbccommon->opentable($getcat);
            
            $breadcrumb = '';

            if(empty($tagging)){
                $looptag = 0;
                $navparent = 0;
            }else{
                $looptag = $tagging[0]['parent'];
                $navparent = $tagging[0]['nav_parent'];

                if($tagging[0]['parent'] != 0){
                    do {
                        $getcatdetailqry = "select cats.catid,cats.parent,cats.nav_parent,cats.cat_desc from frontend_categories as cats where cats.catid = ".$looptag.""; 
                        $catdetail = Yii::$app->sbccommon->opentable($getcatdetailqry);
                          if(empty($breadcrumb)){
                            $breadcrumb = $breadcrumb .$catdetail[0]['cat_desc'];
                          }else{
                           $breadcrumb = $catdetail[0]['cat_desc'].' > ' . $breadcrumb;
                          }//end if
                        $parent = $catdetail[0]['parent'];
                        $navparent = $catdetail[0]['nav_parent'];
                        $looptag = $catdetail[0]['catid'];
                    } while ($navparent == 0);
                }//end if

                $getlaneqry = "select navid,nav_desc from frontend_lanes where navid = ".$navparent."";
                $lane = Yii::$app->sbccommon->opentable($getlaneqry);
                $breadcrumb = $lane[0]['nav_desc'].' > ' . $breadcrumb;
            }//end if

              
            return $breadcrumb;
          break;
        }//END SWITCH CASE
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end function


    public function getLaneFeaturedItems($laneid){
        $qry = "select ifnull(itimages.picture,'') as picture,laneitem.line,
        item.barcode,item.saleprice,item.amt from frontend_laneitems as laneitem 
        left join item on item.barcode = laneitem.barcode 
        left join itimages on itimages.codeid = item.itemid where laneitem.laneid = ".$laneid."
        and item.setfrontend = 1";
        
        $items = Yii::$app->sbccommon->opentable($qry);
        if(!empty($items)){
            foreach ($items as $key => $value) {
                if($this->checkIfItemisSale($value['barcode'])){
                    $items[$key]['issale'] = true;
                }else{
                    $items[$key]['issale'] = false;
                }//end if
            }//end for each 
        }//end if !empty
        return $items;
    }//end function

    public function getLaneFeaturedCategories($laneid){
        $qry = "select catid,nav_parent,cat_desc from frontend_categories as cat where cat.nav_parent = ".$laneid." limit 4";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getLaneChildCategories($type,$parentid){
        switch ($type) {
            case 'LANES':
                $qry = "select catid,nav_parent,cat_desc from frontend_categories as cat where cat.nav_parent = ".$parentid."";
                break;
            
            case 'CATEGORY':
                $qry = "select catid,nav_parent,cat_desc from frontend_categories as cat where cat.parent = ".$parentid."";
                break;
        }//END SWITCH
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getLaneSliderPerLane($laneid){
        $qry = "select ifnull(strimg,'') as strimg,bannerid,laneid from frontend_laneslider where laneid = ".$laneid." order by line asc";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function 

    public function getAvailableBanners(){
        $qry = "select ifnull(strimg,'') as strimg,bannerid,line from frontend_banner";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function banners

    ################################### FOR STEAM LAYOUT



    ################################### REVISED FUNCTIONS FOR NEW FRONTEND (JAOSKI)
    public function verifyCustomerSignin($params,$type = 'DEFAULT'){
        switch (strtoupper($type)) {
            case 'FACEBOOK': case 'GOOGLE':
                $emailqry = "select client,email,pword as `password` from client where iscustomer = 1 
                and md5(md5(email)) = md5(md5('".$params['login-email']."'))
                and registeredfrom = '".$type."')
                and email <> '' and pword <> ''";
            break;

            default:
                $emailqry = "select client,email,pword as `password` from client where iscustomer = 1 
                and md5(md5(email)) = md5(md5('".$params['login-email']."'))
                and md5(md5(`pword`)) = md5(md5('".$params['login-password']."'))
                and email <> '' and pword <> '' and registeredfrom = 'DEFAULT'";
                break;
        }//end switch

        $vcred = Yii::$app->sbccommon->opentable($emailqry);

        if(empty($vcred)){
            $status = 0;
            $msg = "No accounts matched in our System! Please try again.";
        }else{
            if($vcred[0]['password'] == $params['login-password']){
                $status = 1;
                $msg = "<b>Login Successfull! Please wait as you are redirected, Thank you!</b>";  
                Yii::$app->frontend->createCustomerSession($vcred[0]['client']);
                Yii::$app->frontend->recordFrontendLogs('USER_LOGGED_IN',$vcred[0]['client']);
            }else{
                $status = 0;
                $msg = "<b>Email or Password is incorrect. Please try again.</b>";  
            }//end if
        }//end function

        return array('status'=>$status,'msg'=>$msg);
    }//end function

    
    ################################### REVISED FUNCTIONS FOR NEW FRONTEND (JAOSKI






















    public function recordFrontendLogs($activity,$refcode){
        $iplog = Yii::$app->getRequest()->getUserIP();
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
        if(isset(Yii::$app->session['customerdata'])){
            $user = Yii::$app->session['customerdata']['clientcode'];
        }else{
            $user = "GUEST";
        }
        //TYPES OF ACTIVITY
        // ## VIEW_ITM_DETAIL - OK
        // ## ADD_TO_CART - OK
        // ## EMAIL-TYPE NG EMAIL - 
        // ## REGISTER_USER - ok
        // ## USER_LOGGED_IN - ok
        // ## PLACE_ORDER - ok
        // ## CANCEL_PAYMENT - 
        
        $qry = "insert into frontend_logs (username,occurance,refcode,iplog,logtype) 
                values ('".$user."','".$current_timestamp."','".$refcode."','".$iplog."','".$activity."')";
        
        Yii::$app->sbccommon->execqry($qry);
    }//end record frontend logs
    
//################################CART FUNCTIONS##############################################   
    private function Addtocart($barcode,$qty,$type,$grpid){
    //QUERY FOR RETRIEVING ITEM INFORMATION
        
        switch (strtoupper($type)) {
            case 'HIGHLIGHT':
                $qry = "select item.itemname,
                round(highitems.highamt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(highitems.highamt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                item.uom,ifnull(gallery.img1,'') as picture from frontend_highlightitems as highitems
                left join item on item.itemid = highitems.itemid
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.barcode = '$barcode' and highitems.highid = ".$grpid."";
                $iteminfo = Yii::$app->sbccommon->opentable($qry);
                $price = $iteminfo[0]['amt'];
            break;

            case 'DOD':
                $qry = "select item.itemname,
                round(doditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(doditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                item.uom,ifnull(gallery.img1,'') as picture from frontend_doditems as doditems
                left join item on item.itemid = doditems.itemid
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.barcode = '$barcode' and doditems.dodid = ".$grpid."";
                $iteminfo = Yii::$app->sbccommon->opentable($qry);
                $price = $iteminfo[0]['amt'];
            break;

            case 'FLASHDEAL':
                $qry = "select item.itemname,
                round(fditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(fditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                item.uom,ifnull(gallery.img1,'') as picture from frontend_fdealitems as fditems
                left join item on item.itemid = fditems.itemid
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.barcode = '$barcode' and fditems.flashid = ".$grpid."";
                $iteminfo = Yii::$app->sbccommon->opentable($qry);
                $price = $iteminfo[0]['amt'];
                break;
            
            default:
                $type="DEFAULT";
                $qry = "select item.itemname,
                round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                item.uom,ifnull(gallery.img1,'') as picture from item 
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.barcode = '$barcode'";
                $iteminfo = Yii::$app->sbccommon->opentable($qry);
                //GETS ALL VALUES FROM QUERY

                if($this->checkIfItemisSale($barcode)){
                    $price = $iteminfo[0]['saleprice'];
                }else{
                    $price = $iteminfo[0]['amt'];
                }

                break;
        }//end switch type of add to cart

        $itemname = $iteminfo[0]['itemname'];
        $uom = $iteminfo[0]['uom'];
        $picture = Yii::$app->homeUrl . 'frontendassets/steamlayout/products-images/product1.jpg';
        if($iteminfo[0]['picture'] != ""){
            $picture = $iteminfo[0]['picture'];
        }//end if
        $totprice = $price * $qty;
        $totprice = number_format($totprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency'));
        //FOR ADDING INFORMATION TO OUR CART
        if(empty(Yii::$app->session['cart'])){
              Yii::$app->session['cart'] = [$barcode."_".$type => array('type'=>$type,'picture'=>$picture,'itemname'=>$itemname,'uom'=>$uom,'qty'=>$qty,'price'=>$price,'totprice'=>$totprice)];
              }else{
                //UPDATES EXISTING ITEM WITH SAME BARCODE ON CART
                foreach (Yii::$app->session['cart'] as $cartbarcodes => $cartvalue) {
                    if($barcode.'_'.$type == $cartbarcodes){
                        if($type == $cartvalue['type']){
                            $newqty = Yii::$app->session['cart'][$barcode.'_'.$type]['qty'] + $qty;
                            $newtotprice = Yii::$app->session['cart'][$barcode.'_'.$type]['price'] * $newqty;
                            $addeditem = array('type'=>$type,'picture'=>$picture,'itemname' => $itemname,'uom'=>$uom,'qty' => $newqty,'price' => $price,'totprice' => $newtotprice);
                            Yii::$app->session['cart'] = array_merge(Yii::$app->session['cart'], [$barcode."_".$type=> $addeditem]);
                        }else{
                            $addeditem = array('type'=>$type,'picture'=>$picture,'itemname' => $itemname,'uom'=>$uom,'qty' => $qty,'price' => $price,'totprice' => $totprice);
                            Yii::$app->session['cart'] = array_merge(Yii::$app->session['cart'], [$barcode."_".$type => $addeditem]);
                        }//end if
                    }else{
                        //ADDS NEW ITEM WITH DIFFERENT BARCODE
                        $addeditem = array('type'=>$type,'picture'=>$picture,'itemname' => $itemname,'uom'=>$uom,'qty' => $qty,'price' => $price,'totprice' => $totprice);
                        Yii::$app->session['cart'] = array_merge(Yii::$app->session['cart'], [$barcode."_".$type=> $addeditem]);
                    }//end if
                    
                }//END FOR EACH

                /*if (array_key_exists($barcode, Yii::$app->session['cart'])){
                $newqty = Yii::$app->session['cart'][$barcode]['qty'] + $qty;
                $newtotprice = Yii::$app->session['cart'][$barcode]['price'] * $newqty;
                $addeditem = array('type'=>$type,'picture'=>$picture,'itemname' => $itemname,'uom'=>$uom,'qty' => $newqty,'price' => $price,'totprice' => $newtotprice);
                Yii::$app->session['cart'] = array_merge(Yii::$app->session['cart'], [$barcode => $addeditem]);
                }else{
                //ADDS NEW ITEM WITH DIFFERENT BARCODE
                $addeditem = array('type'=>$type,'picture'=>$picture,'itemname' => $itemname,'uom'=>$uom,'qty' => $qty,'price' => $price,'totprice' => $totprice);
                Yii::$app->session['cart'] = array_merge(Yii::$app->session['cart'], [$barcode => $addeditem]);
                }*/
        }//END IFEMPTY

        return Yii::$app->session['cart'];
    }//END ADDTOCART YOW!

    private function UpdateCart($barcode,$newqty,$type,$grpid){
        $cartbitch = Yii::$app->session['cart'];

        switch (strtoupper($type)) {
            case 'HIGHLIGHT':
                $qry = "select item.itemname,
                round(highitems.highamt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(highitems.highamt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice 
                from frontend_highlightitems as highitems
                left join item on item.itemid = highitems.itemid
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.barcode = '$barcode' and highitems.highid = ".$grpid."";
                $iteminfo = Yii::$app->sbccommon->opentable($qry);
                $price = $iteminfo[0]['amt'];
            break;

            case 'DOD':
                $qry = "select item.itemname,
                round(doditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(doditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                from frontend_doditems as doditems
                left join item on item.itemid = doditems.itemid
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.barcode = '$barcode' and doditems.dodid = ".$grpid."";
                $iteminfo = Yii::$app->sbccommon->opentable($qry);
                $price = $iteminfo[0]['amt'];
            break;

            case 'FLASHDEAL':
                $qry = "select item.itemname,
                round(fditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(fditems.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                from frontend_fdealitems as fditems
                left join item on item.itemid = fditems.itemid
                left join item_gallery as gallery on gallery.itemid = item.itemid
                where item.barcode = '$barcode' and fditems.flashid = ".$grpid."";
                $iteminfo = Yii::$app->sbccommon->opentable($qry);
                $price = $iteminfo[0]['amt'];
                break;

            default:
                $type= "DEFAULT";
                $qry = "select itemname, round(amt,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as amt,
                round(item.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice,
                uom from item where barcode = '$barcode'";
                break;
        }//end switch

        $iteminfo = Yii::$app->sbccommon->opentable($qry);

        if($this->checkIfItemisSale($barcode)){
            $price = $iteminfo[0]['saleprice'];
        }else{
            $price = $iteminfo[0]['amt'];
        }

        $itemname = $iteminfo[0]['itemname'];
        $uom = $iteminfo[0]['uom'];
        
        //UPDATES EXISTING ITEM WITH SAME BARCODE ON CART
        if (array_key_exists($barcode.'_'.$type, Yii::$app->session['cart'])){
            $newtotprice = $cartbitch[$barcode.'_'.$type]['price'] * $newqty;
            $cartbitch[$barcode.'_'.$type]['totprice'] = $newtotprice;
            $cartbitch[$barcode.'_'.$type]['qty'] = intval($newqty);
            Yii::$app->session['cart'] = $cartbitch;
            return array('uqty'=>$cartbitch[$barcode.'_'.$type]['qty'],'utotprice'=>$cartbitch[$barcode.'_'.$type]['totprice'],'type'=>$type);
        }//END EXIST
    }//END UPDATE CART

    public function removeCartitem($barcode){    
        $cartlookalike = Yii::$app->session['cart'];
        unset($cartlookalike[$barcode]);
        Yii::$app->session['cart'] = $cartlookalike;
    }//END REMOVE ITEM

    public function cart($barcode,$qty,$trigger,$type,$grpid){
        switch($trigger) {
            case 1: $this->Addtocart($barcode,$qty,$type,$grpid); break;
            case 2: return $this->UpdateCart($barcode,$qty,$type,$grpid); break;
            default: echo "No match!"; break;
        }
    }

    public function resetCart(){
        unset(Yii::$app->session['cart']);
    }//END RESET CART

    public function countCart(){
        //GET NUMBER OF ITEMS ON CART
        if(isset(Yii::$app->session['cart'])){
        $count = count(Yii::$app->session['cart']);
        return $count;    
        }else{
        return 0;
        }
    }

    public function computeCart(){
        $total = 0;
        //GETS TOTAL AMOUNT OF CART
        foreach(Yii::$app->session['cart'] as $cartitem) {
        $cartitem['totprice'] = str_replace(',', '', $cartitem['totprice']);
        $total = floatval($total)+ floatval($cartitem['totprice']);
        }
        return number_format($total,2,".",","); //THIS LINE SETS FORMAT FOR THE AMOUNT
    }//END COMPUTE CART


    public function generateCustomerCode(){
        $common=new Common();
        $client = 'CL';
        $length=$common->clientlength();//RETURNS ZERO
        $pref=strtoupper($client); 
        $last_client = Client::getlast_client($pref);
        $start=$common->SearchPosition($last_client);
        $seq=substr($last_client, $start) + 1;
        $clseq=$client.$seq; 
        $new_client=$common->PadJ($clseq, $length); //HARDCODED
        return $new_client;
    }//end functin

    public function createCustomer($clientdata){
    //CREATES NEWLY REGISTERED CUSTOMERS
        $customerinfo = new Client;
        $ccode = Yii::$app->frontend->generateCustomerCode();
        $clientexist = Client::checkclient($ccode);
        $customerinfo->IsCustomer = 1;
        $customerinfo->client = $ccode;
        $customerinfo->IsExempt = 0;
        $customerinfo->charge1 = 0;
        $customerinfo->charge2 = 0;
        $customerinfo->isLocation = 0;
        $customerinfo->isVendor = 0;
        $customerinfo->clientname = $clientdata['reg-name'];
        $customerinfo->addr = $clientdata['reg-address'];
        $customerinfo->tel2 = $clientdata['reg-contact'];
        $customerinfo->email = $clientdata['reg-email'];
        $customerinfo->pword = $clientdata['reg-password'];
        $customerinfo->createby = 'E-REGISTRATION';
        $customerinfo->center = '001';
        $customerinfo->category = 0;
        $customerinfo->distributionarea = 0;
        $customerinfo->collectionarea = 0;
        $customerinfo->routeid = 0;
        $customerinfo->sccityid = 0;
        $status = $customerinfo->insertclient($customerinfo);
        
        if($status){
            $clientsession = Yii::$app->frontend->createCustomerSession($ccode);
            $msg = "<b>Registration successfull! Please wait you will be redirected.</b>";
        }else{
            $clientsession = "";
            $msg = "<b>Registration failed. Please try again.</b>";
        }//end if

        $this->recordFrontendLogs('REGISTER_USER',$ccode);
        return array('status'=>$status,'msg'=>$msg);
    }//END CREATE CUSTOMER

    public function getCUstomerinfo($email,$pword){
        $query = "select client,clientname,email,addr,contact,pword from client where iscustomer = 1 and email='$email' and pword = '$pword'";
        $customer=Yii::$app->sbccommon->opentable($query);
        return $customer;
    }//END GET CUSTOMER

    public function createCustomerSession($clientcode){
    $query = "select md5(pword) as customerpword,client,clientname,email,addr,tel2 as contact,clientid from client where iscustomer = 1 and client='$clientcode'"; //GETTING DATA FROM DATABASE
    $userdata=Yii::$app->sbccommon->opentable($query);
        
    //CREATES SESSION FOR LOGGED IN USERS
    Yii::$app->session['customerdata'] = array('customername'=>$userdata[0]['clientname'],
        'customeradd'=>$userdata[0]['addr'],'customercontact'=>$userdata[0]['contact'],
        'email'=>$userdata[0]['email'],'clientcode'=>$userdata[0]['client'],'clid'=>$userdata[0]['clientid'],'customerpword'=>$userdata[0]['customerpword']);

    return Yii::$app->session['customerdata'];
    }



    public function clearClientSession(){
        unset(Yii::$app->session['customerdata']);
    }

    public function placeOrder($params){
    $common = new Common();
    $head = new Pohead();
    $stock = new Postock();
    Yii::$app->systemsettings->setDefaultTimeZone();
        if(isset(Yii::$app->session['ongoingcheckout']['trno']) && !empty(Yii::$app->session['ongoingcheckout']['trno'])){
            
            $qryupdatehead = "update sohead set shipto = '".$params['shipto']."' and dateid = ".date('Y-m-d')."";
            Yii::$app->sbccommon->execqry($qryupdatehead);
            $qryremoveitems = "delete from sostock where trno = ".Yii::$app->session['ongoingcheckout']['trno']."";
            Yii::$app->sbccommon->execqry($qryremoveitems);
           
            $doc = "SO";
            $center = "001";
            $length=$common->clientlength();
            $defualtwh = $common->getdefaultwarehouse();
            $warehouse = $common->PadJ($defualtwh, $length);

            foreach (Yii::$app->session['cart'] as $itembarcode => $iteminfo) {
                $barcodeinfo = explode('_', $itembarcode);
                $stock->barcode = $barcodeinfo[1];
                $stock->itemname = $iteminfo['itemname'];
                $stock->uom = $iteminfo['uom'];
                $stock->wh_= $warehouse;
                $stock->isamt = $iteminfo['price'];
                $stock->amt = $iteminfo['price'];
                $stock->iss= $iteminfo['qty'];
                $stock->isqty= $iteminfo['qty'];
                $stock->ext= $iteminfo['totprice'];
                $stock->void = 0;
                $stock->encodedby = Yii::$app->session['customerdata']['clientcode'];
                $stock->rrqty = 0;
                $stock->rrcost = 0;
                $stock->cost = 0;
                $stock->isecomm = 1;
                $stock->loc = '';
                $stock->expiry = date('Y-m-d');
                Postock::insertstock($doc,Yii::$app->session['ongoingcheckout']['trno'],$stock);  
                $this->recordFrontendLogs('PLACE_ORDER',$itembarcode);
            }//end for each

            $headdata = $head->openhead(Yii::$app->session['ongoingcheckout']['trno'],$doc);
            Yii::$app->session['ongoingcheckout'] = array('trno'=>$headdata[0]['trno'],'docno'=>$headdata[0]['docno']);
            unset(Yii::$app->session['cart']);
        }else{
            if(!isset(Yii::$app->session['ongoingcheckout']) || empty(Yii::$app->session['ongoingcheckout'])){
                $doc = "SO";
                $center = "001";
                $length=$common->clientlength();
                $defualtwh = $common->getdefaultwarehouse();
                $warehouse = $common->PadJ($defualtwh, $length);
                $prefixes = $common->getPrefixes($doc);
                $pref = isset($prefixes[0]) ? $prefixes[0] : $doc;
                $docnolength = $common->doclength();
                $seq = $common->getlastseq($pref,$doc,$center);
                if(empty($seq)){$seq = 1;}
                $poseq = $pref . $seq;
                $newdocno = $common->PadJ($poseq, $docnolength);
                $bref = $common->GetPrefix($newdocno);


                $insertcntnum = $common->insertcntnum($doc, $newdocno, $seq, $bref,$center,1); //INSERTS DATA TO TRANSNUM
                $transnumdata = Cntnum::getTrnodocno($newdocno,$doc,$center); //TO GET TRNO AND DOCNO FROM TRANSNUM
                

                $trno = $transnumdata[0]['trno'];
                $docno = $transnumdata[0]['docno'];

                $head->trno = $trno;
                $head->docno= $docno;
                $head->client = Yii::$app->session['customerdata']['clientcode'];
                $head->clientname = Yii::$app->session['customerdata']['customername'];
                $head->address = Yii::$app->session['customerdata']['customeradd'];
                $head->yourref = "ONLINE ORDER";    
                $head->orderfrom = "ONLINE";
                $head->encodedby = Yii::$app->session['customerdata']['customername'];
                $head->forex = 1.0;
                $head->dateid = date('Y-m-d');
                $head->due = date('Y-m-d'); // same date of dateid if from online order
                $head->modamt = 0.0;
                $head->whid = $warehouse;
                $head->shipto = $params['shipto'];    
                $table=Common::localhead($doc);
                $status = Pohead::insert($newdocno, $doc, $trno,$head,$table);


                foreach (Yii::$app->session['cart'] as $itembarcode => $iteminfo) {
                    $stock->trno = $trno;
                    $barcodeinfo = explode('_', $itembarcode);
                    $stock->barcode = $barcodeinfo[1];
                    $stock->itemname = $iteminfo['itemname'];
                    $stock->uom = $iteminfo['uom'];
                    $stock->wh_= $warehouse;
                    $stock->isamt = $iteminfo['price'];
                    $stock->amt = $iteminfo['price'];
                    $stock->iss= $iteminfo['qty'];
                    $stock->isqty= $iteminfo['qty'];
                    $stock->ext= $iteminfo['totprice'];
                    $stock->void = 0;
                    $stock->encodedby = Yii::$app->session['customerdata']['clientcode'];
                    $stock->rrqty = 0;
                    $stock->rrcost = 0;
                    $stock->cost = 0;
                    $stock->isecomm = 1;
                    $stock->loc = 'ONLINE ORDERS';
                    $stock->expiry = date('Y-m-d');
                    Postock::insertstock($doc,$trno,$stock);  
                    $this->recordFrontendLogs('PLACE_ORDER',$itembarcode);
                }

                Yii::$app->session['ongoingcheckout'] = array('trno'=>$trno,'docno'=>$docno);
                unset(Yii::$app->session['cart']);
            }else{
                $qry = "update sohead set shipto = '".$params['shipto']."' where trno = ".Yii::$app->session['ongoingcheckout']['trno']."";
                Yii::$app->sbccommon->execqry($qry);
            }//end if 
        }//end if isset cart trno
    return true;
    }//END FUNCTION


    public function sendMail($sendto,$subject,$data,$mailtype){
        //TYPES OF MAILTYPE
        //'ECOMMORDERS': -> SENDS ORDER INFORMATION TO CUSTOMER
        //'RECEIVE_CONCERN': -> SENDS CUSTOMER CONCERN ON SET RECEIVING EMAIL
        //'SEND_CONCERN_CONFIRM': -> SEND CONFIRMATION TO SENDER THAT CONCERN IS RECEIVED 
        
        $serveremail = Yii::$app->systemsettings->requestDefaultEmailSender();
        $sendername = Yii::$app->systemsettings->requestDefaultEmailSenderName();

        try {        
        Yii::$app->params['mailtype'] = $mailtype;
        Yii::$app->params['data'] = $data;

        Yii::$app->mailer->compose('@app/mail/html')
            ->setFrom([$serveremail => $sendername])
            ->setTo($sendto)
            ->setSubject($subject)
            ->send();
        
        if(Yii::$app->systemsettings->companyfrontendConfig() != 'XTZ'){
            $this->recordFrontendLogs('EMAIL-'.$mailtype,$sendto);
        }//end if
        
        return true;
        } catch (Exception $e) {
        return false;
        }

    }

    public function checkemailavailability($email){
        $query = "select email from client where email = '$email'";
        $email=Yii::$app->sbccommon->opentable($query);   
        return $email;        
    }//end function

}//END COMPONENTS
?>
