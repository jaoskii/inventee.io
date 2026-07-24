<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Comparative Report - Inventory per Location';
use yii\base\ErrorException;

try {
	
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=36;
$page=36;

//var_dump($params);

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(strtoupper('Comparative Report - Inventory per Location'),null,null,false,'1px solid ','','','Helvetica','18','B','','');
 Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';

Yii::$app->reporter->begintable('1000'); 
Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');

if($params['principalid'] != ''){
	$principal = $params['principalid'];
}else{
	$principal = 'All';
}//end if

if($params['divisionid'] != ''){
	$division = $params['divisionid'];
}else{
	$division = 'All';
}//end if

$docout = $params['viewout'];
if($params['viewout'] == 'SJ'){
	$docout_title = 'SALES QTY';
}else{
	$docout_title = 'TS OUT';
}//end if


$docout2 = $params['viewout2'];
if($params['viewout2'] == 'SJ'){
	$docout_title2 = 'SALES QTY';
}else{
	$docout_title2 = 'TS OUT';
}//end if


if($params['wh1'] != ''){
	$wh_filterview = $params['wh1'];
}else{
	$wh_filterview = 'All';
}//end if


Yii::$app->reporter->col('Principal: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $principal,null,null,'','1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('Balance as of: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$params['asof'],'250',null,false,'1px solid ','','L','Helvetica','11','B','','');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
	Yii::$app->reporter->col('Division '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $division,null,null,'','1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('Sales Date Range: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$params['startdate'].' to '.$params['enddate'].'','450',null,false,'1px solid ','','L','Helvetica','11','B','','');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
	Yii::$app->reporter->col('Month Factor: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['nomonths'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');
	Yii::$app->reporter->col('Unit:' . strtoupper($params['unit']),'250',null,false,'1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('Warehouse: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['wh1'] . ' - ' . $params['wh2'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');

	Yii::$app->reporter->pagenumber('Page');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('ITEM DESCRIPTION','250',null,false,'1px solid ','TB','L','Helvetica','17','B','','6px');
Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
Yii::$app->reporter->col('QoH L1','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
// Yii::$app->reporter->col('PACK','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
Yii::$app->reporter->col('TO GO L1','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
/*Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');*/
Yii::$app->reporter->col($docout_title . ' L1','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->col('QoH L2','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
// Yii::$app->reporter->col('PACK','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
Yii::$app->reporter->col('TO GO L2','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
/*Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');*/
Yii::$app->reporter->col($docout_title. ' L2','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->col('AVE.MOVE','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->endrow();

$rowbarcode = '';
for ($i=0; $i < count($data); $i++) { 
	$filter = "";
    $filter2 = "";
    $filter_loc1 = "";
    $filter_loc2 = "";

    //GENERIC WHERE CLAUSE STRINGS
    if($params['unit'] == 'retail'){
		$uomleftstr = " uom.uom = item.uom ";
	}else{
		$uomleftstr = " uom.uom = item.purchase_uom ";
	}//END IF

	if($params['wh1'] != ""){
		$whfilter_loc1 = " and wh.client = '".$params['wh1']."' ";
	}else{
		$whfilter_loc1 = "";
	}//end if

	if($params['wh2'] != ""){
		$whfilter_loc2 = " and wh.client = '".$params['wh2']."' ";
	}else{
		$whfilter_loc2 = "";
	}//end if

    if($params['principalid']!=""){
        $filter=  $filter." and item.uv_principal='".$params['stockprincipalid']."' ";
        $filter2=  $filter2." and item.uv_principal='".$params['stockprincipalid']."' ";
    }//end if

    if($params['stockdivisionid']!=""){
        $filter= $filter. " and item.groupid='".$params['stockdivisionid']."' ";
        $filter2= $filter2. " and item.groupid='".$params['stockdivisionid']."' ";
    }//end if

    if($params['unit'] == 'retail'){
		$uomleftstr = " uom.uom = item.uom ";
	}else{
		$uomleftstr = " uom.uom = item.purchase_uom ";
	}//END IF

	if($params['wh1'] != ""){
		$whfilter_loc1 = " and wh.client = '".$params['wh1']."' ";
	}else{
		$whfilter_loc1 = "";
	}//end if

	//SPECIFIC LOC WHERE CLAUSE STRINGS

    if($params['wh1']!=""){
        $filter_loc1= $filter_loc1. " and wh.client = '".$params['wh1']."' ";
        $groupby = " group by item.barcode,rrstatus.whid ";
    }else{
        $groupby = " group by item.barcode";
    }//end if

    if($params['unit'] == 'retail'){
        $uom = "item.uom";
    }else{
        $uom = "item.purchase_uom";
    }//end if

    $query = "select item.itemname,round((sum(rrstatus.bal)/uom.factor),2) as balance,".$uom.",round(uom.factor) as factor from rrstatus
		    left join item on item.itemid = rrstatus.itemid and item.itemid = ".$data[$i]['itemid']."
		    left join uom on uom.uom = ".$uom." and uom.itemid = item.itemid
		    left join client as wh on wh.clientid = rrstatus.whid
		    where rrstatus.bal <> 0 ".$filter." ".$filter_loc1." and rrstatus.itemid =  ".$data[$i]['itemid']." ".$groupby;

	$itemBalance = Yii::$app->sbccommon->opentable($query);
	$qtyhand_loc1 = "";

	if(!empty($itemBalance)){
		$qtyhand_loc1 = $itemBalance[0]['balance'];
		number_format($qtyhand_loc1,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
	}else{
		//NO BALANCE
		$qtyhand_loc1 = '---';
	}//end if

	Yii::$app->reporter->addline();
	Yii::$app->reporter->startrow();
	Yii::$app->reporter->col($data[$i]['itemname'].'&nbsp-'.number_format($data[$i]['factor']).'\'s','750',null,false,'1px solid ','','L','Helvetica','17','','','');
	Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','c','Helvetica','17','','','');
	Yii::$app->reporter->col($qtyhand_loc1,'50',null,false,'1px solid ','','R','Helvetica','17','','','');

	$qry = "select round(sum(qty), 2) as qty from (
          select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
          left join lastock as stock on stock.trno = head.trno
          left join item on item.barcode = stock.barcode
          left join client as wh on wh.client = stock.wh
          left join uom on uom.itemid = item.itemid and ".$uomleftstr."
          where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
          and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter_loc1."
          group by item.barcode
          UNION ALL
          select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
          left join glstock as stock on stock.trno = head.trno
          left join item on item.itemid = stock.itemid
          left join client as wh on wh.clientid = stock.whid
          left join uom on uom.itemid = item.itemid and ".$uomleftstr."
          where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
          and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter_loc1."
          group by item.barcode) as tbl";

	$qty_loc1 = Yii::$app->sbccommon->datareader($qry);

	if($params['nomonths'] != ""){
		if($qty_loc1 <= 0){
			$movemonth_loc1 = 0;
			$months_to_go_loc1 = 0;
		}else{
			$movemonth_loc1 = $qty_loc1 / $params['nomonths']; //denominator needs to be month factor (parameters)
			$months_to_go_loc1 = $qtyhand_loc1 / $movemonth_loc1; //denominator needs to be # of months (parameters)
		}//end if
	}else{
		$movemonth_loc1 = 0;
		$months_to_go_loc1 = 0;
	}//end if

	if($months_to_go_loc1  == 0){
		$months_to_go_loc1 = '';
		Yii::$app->reporter->col($months_to_go_loc1,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}else{
		Yii::$app->reporter->col(number_format($months_to_go_loc1,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}//END IF
	
	Yii::$app->reporter->col($qty_loc1,'50',null,false,'1px solid ','','R','Helvetica','17','','','');

	/*if($movemonth_loc1  == 0){
		$movemonth_loc1 = '';
		Yii::$app->reporter->col($movemonth_loc1,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}else{
		Yii::$app->reporter->col(number_format($movemonth_loc1,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}//ENND IF*/

	//FOR LOC 2
	if($params['wh1']!=""){
        $filter_loc2 = $filter_loc2. " and wh.client = '".$params['wh2']."' ";
        $groupby = " group by item.barcode,rrstatus.whid ";
    }else{
        $groupby = " group by item.barcode";
    }//end if

	$query = "select item.itemname,round((sum(rrstatus.bal)/uom.factor),2) as balance,".$uom.",round(uom.factor) as factor from rrstatus
		    left join item on item.itemid = rrstatus.itemid and item.itemid = ".$data[$i]['itemid']."
		    left join uom on uom.uom = ".$uom." and uom.itemid = item.itemid
		    left join client as wh on wh.clientid = rrstatus.whid
		    where rrstatus.bal <> 0 ".$filter." ".$filter_loc2." and rrstatus.itemid =  ".$data[$i]['itemid']." ".$groupby;

	$itemBalance2 = Yii::$app->sbccommon->opentable($query);
	$qtyhand_loc2 = "";

	if(!empty($itemBalance2)){
		$qtyhand_loc2 = $itemBalance2[0]['balance'];
		number_format($qtyhand_loc2,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
	}else{
		//NO BALANCE
		$qtyhand_loc2 = '---';
	}//end if

	Yii::$app->reporter->col($qtyhand_loc2,'50',null,false,'1px solid ','','R','Helvetica','17','','','');

	$qry = "select round(sum(qty), 2) as qty from (
          select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
          left join lastock as stock on stock.trno = head.trno
          left join item on item.barcode = stock.barcode
          left join client as wh on wh.client = stock.wh
          left join uom on uom.itemid = item.itemid and ".$uomleftstr."
          where head.doc = '".$docout2."' and item.barcode = '".$data[$i]['barcode']."'
          and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter_loc2."
          group by item.barcode
          UNION ALL
          select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
          left join glstock as stock on stock.trno = head.trno
          left join item on item.itemid = stock.itemid
          left join client as wh on wh.clientid = stock.whid
          left join uom on uom.itemid = item.itemid and ".$uomleftstr."
          where head.doc = '".$docout2."' and item.barcode = '".$data[$i]['barcode']."'
          and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter_loc2."
          group by item.barcode) as tbl";

	$qty_loc2 = Yii::$app->sbccommon->datareader($qry);

	if($params['nomonths'] != ""){
		if($qty_loc2 <= 0){
			$movemonth_loc2 = 0;
			$months_to_go_loc2 = 0;
		}else{
			$movemonth_loc2 = $qty_loc2 / $params['nomonths']; //denominator needs to be month factor (parameters)
			$months_to_go_loc2 = $qtyhand_loc2 / $movemonth_loc2; //denominator needs to be # of months (parameters)
		}//end if
	}else{
		$movemonth_loc2 = 0;
		$months_to_go_loc2 = 0;
	}//end if

	if($months_to_go_loc2  == 0){
		$months_to_go_loc2 = '';
		Yii::$app->reporter->col($months_to_go_loc2,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}else{
		Yii::$app->reporter->col(number_format($months_to_go_loc2,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}//END IF
	
	Yii::$app->reporter->col($qty_loc2,'50',null,false,'1px solid ','','R','Helvetica','17','','','');

	//FOR THE AVERAGE MOVE MONTH (WH1 MOVE MONTH + WH2 MOVE MONTH THEN DIVIDE BY 2)
	$ave_movemonth = ($movemonth_loc1 + $movemonth_loc2) / 2;

	if($ave_movemonth  == 0){
		$ave_movemonth = '';
		Yii::$app->reporter->col($ave_movemonth,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}else{
		Yii::$app->reporter->col(number_format($ave_movemonth,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}//ENND IF

	if(Yii::$app->reporter->linecounter==$page){
    	Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('1000');
		$header=Yii::$app->reporter->letterhead();
		Yii::$app->reporter->endtable();
		echo '<br/><br/>';

    	Yii::$app->reporter->begintable('1000'); 
		Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');

		if($params['principalid'] != ''){
			$principal = $params['principalid'];
		}else{
			$principal = 'All';
		}//end if

		if($params['divisionid'] != ''){
			$division = $params['divisionid'];
		}else{
			$division = 'All';
		}//end if


		Yii::$app->reporter->col('Principal: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $principal,null,null,'','1px solid ','','L','Helvetica','11','B','','');

		Yii::$app->reporter->endrow();

		Yii::$app->reporter->startrow();
			Yii::$app->reporter->col('Division '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $division,null,null,'','1px solid ','','L','Helvetica','11','B','','');

			Yii::$app->reporter->col('Sales Date Range: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$params['startdate'].' - '.$params['enddate'].'','450',null,false,'1px solid ','','L','Helvetica','11','B','','');
		Yii::$app->reporter->endrow();

		Yii::$app->reporter->startrow();
			Yii::$app->reporter->col('Month Factor: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['nomonths'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');
			Yii::$app->reporter->col('Unit:' . strtoupper($params['unit']),'250',null,false,'1px solid ','','L','Helvetica','11','B','','');
			Yii::$app->reporter->col('Warehouses: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['wh1'] . ' - ' . $params['wh2'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');

			Yii::$app->reporter->pagenumber('Page');
		Yii::$app->reporter->endrow();
		Yii::$app->reporter->endtable();

		Yii::$app->reporter->begintable('1000');
		Yii::$app->reporter->startrow();
		Yii::$app->reporter->col('ITEM DESCRIPTION','250',null,false,'1px solid ','TB','L','Helvetica','17','B','','6px');
		Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
		Yii::$app->reporter->col('QoH L1','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		// Yii::$app->reporter->col('PACK','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
		Yii::$app->reporter->col('TO GO L1','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		/*Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');*/
		Yii::$app->reporter->col($docout_title . ' L1','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('QoH L2','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		// Yii::$app->reporter->col('PACK','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
		Yii::$app->reporter->col('TO GO L2','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		/*Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');*/
		Yii::$app->reporter->col($docout_title. ' L2','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('AVE.MOVE','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->endrow();

		$page=$page + $count;
	}//end if header 2

/*	if($params['wh1'] != ""){
		$whfilter = " and wh.client = '".$params['wh1']."' ";
	}else{
		$whfilter = "";
	}//end if

	if($params['unit'] == 'retail'){
		$uomleftstr = " uom.uom = item.uom ";
	}else{
		$uomleftstr = " uom.uom = item.purchase_uom ";
	}//END IF

	if($data[$i]['nobal']){
		$qtyhand = '---';
	}else{
		$qryonhand = "select 
        round(ifnull((sum(bal)/uom.factor),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal from rrstatus
        left join client as wh on wh.clientid = rrstatus.whid
        left join item on item.itemid = rrstatus.itemid
        left join uom on uom.itemid = item.itemid and ".$uomleftstr."
        where rrstatus.itemid = ".$data[$i]['itemid']." ".$whfilter." group by rrstatus.itemid";

		$qtyhand = Yii::$app->sbccommon->datareader($qryonhand);

		if($qtyhand > 0){
			number_format($qtyhand,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
		}else{
			$qtyhand = '---';
		}//end uf
	}//end if
	
	Yii::$app->reporter->addline();
	Yii::$app->reporter->startrow();
	Yii::$app->reporter->col($data[$i]['itemname'].'&nbsp-'.$data[$i]['factor'].'\'s','750',null,false,'1px solid ','','L','Helvetica','17','','','');
	Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','c','Helvetica','17','','','');
	Yii::$app->reporter->col($qtyhand,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	// Yii::$app->reporter->col($data[$i]['factor'],'50',null,false,'1px solid ','','c','Helvetica','17','','','');

		$qry = "select round(sum(qty), 2) as qty from (
          select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
          left join lastock as stock on stock.trno = head.trno
          left join item on item.barcode = stock.barcode
          left join client as wh on wh.client = stock.wh
          left join uom on uom.itemid = item.itemid and ".$uomleftstr."
          where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
          and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
          group by item.barcode
          UNION ALL
          select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
          left join glstock as stock on stock.trno = head.trno
          left join item on item.itemid = stock.itemid
          left join client as wh on wh.clientid = stock.whid
          left join uom on uom.itemid = item.itemid and ".$uomleftstr."
          where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
          and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
          group by item.barcode) as tbl";

	$qty = Yii::$app->sbccommon->datareader($qry);


	if($params['nomonths'] != ""){
		if($qty <= 0){
			$movemonth = 0;
			$months_to_go = 0;
		}else{
			$movemonth = $qty / $params['nomonths']; //denominator needs to be month factor (parameters)
			$months_to_go = $qtyhand / $movemonth; //denominator needs to be # of months (parameters)
		}//end if
	}else{
		$movemonth = 0;
		$months_to_go = 0;
	}//end if

	
	if($months_to_go  == 0){
		$months_to_go = '';
		Yii::$app->reporter->col($months_to_go,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}else{
		Yii::$app->reporter->col(number_format($months_to_go,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}//END IF
	
	if($data[$i]['balance'] == 0){
		$balance = '---';
		$expiry = "";
	}else{
		$balance = $data[$i]['balance'];
		$balance = number_format($balance,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
	}//end if

	//Yii::$app->reporter->col($balance,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	Yii::$app->reporter->col($qty,'50',null,false,'1px solid ','','R','Helvetica','17','','','');

	if($movemonth  == 0){
		$movemonth = '';
		Yii::$app->reporter->col($movemonth,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}else{
		Yii::$app->reporter->col(number_format($movemonth,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
	}//ENND IF

    if(Yii::$app->reporter->linecounter==$page){
    	Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('1000');
		$header=Yii::$app->reporter->letterhead();
		Yii::$app->reporter->endtable();
		echo '<br/><br/>';

    	Yii::$app->reporter->begintable('1000'); 
		Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');

		if($params['principalid'] != ''){
			$principal = $params['principalid'];
		}else{
			$principal = 'All';
		}//end if

		if($params['divisionid'] != ''){
			$division = $params['divisionid'];
		}else{
			$division = 'All';
		}//end if


		Yii::$app->reporter->col('Principal: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $principal,null,null,'','1px solid ','','L','Helvetica','11','B','','');

		Yii::$app->reporter->endrow();

		Yii::$app->reporter->startrow();
			Yii::$app->reporter->col('Division '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $division,null,null,'','1px solid ','','L','Helvetica','11','B','','');

			Yii::$app->reporter->col('Sales Date Range: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$params['startdate'].' - '.$params['enddate'].'','450',null,false,'1px solid ','','L','Helvetica','11','B','','');
		Yii::$app->reporter->endrow();

		Yii::$app->reporter->startrow();
			Yii::$app->reporter->col('Month Factor: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['nomonths'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');

			Yii::$app->reporter->col('Warehouse: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['wh1'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');

			Yii::$app->reporter->pagenumber('Page');
		Yii::$app->reporter->endrow();
		Yii::$app->reporter->endtable();

		Yii::$app->reporter->begintable('1000');
		Yii::$app->reporter->startrow();
		Yii::$app->reporter->col('ITEM DESCRIPTION','750',null,false,'1px solid ','TB','L','Helvetica','17','B','','6px');
		Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','TB','c','Helvetica','17','B','','');
		Yii::$app->reporter->col('L1 QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		// Yii::$app->reporter->col('PACK','50',null,false,'1px solid ','TB','c','Helvetica','17','B','','');
		Yii::$app->reporter->col('TO GO','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		//Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col($docout_title,'50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('MOVE','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->endrow();

		$page=$page + $count;
	}//end if header 2 */

}//end for each

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
} catch (ErrorException $e) {
	echo $e;
}
?>
