<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Apledger;
use app\models\Common;
use app\models\Log;

use yii\web\Response;

class Ladetail extends Model
{
        public $alias;
        public $trno;
        public $line;
        public $docno;
        public $dateid;
        public $acno;
        public $acnoid;
        public $acnoname;
        public $client;
        // WTODO JAD 06-03-2019
        public $client2;
        public $ref;
        public $rem;
        public $refx;
        public $linex;
        public $clientname;
        public $db;
        public $cr;
        public $runningdb;
        public $runningcr;
        public $fdb;
        public $fcr;

        public $depodate;
        public $checkdate;
        public $checkno;
        public $postdate;
        public $field_focus;
        public $action;
        
        public $editacno;
        public $editacnoname;
        public $editref;
        public $editrem;
        public $editdb;
        public $editcr;
        public $editfdb;
        public $editpostdate;
        public $editfcr;
        public $editcheckno;
        public $editrefx;
        public $editlinex;
        public $pdcline;
        public $templine;
        
        public $costcenter;

        public $ewtcode;
        public $ewtrate;
        public $isewt;
        public $isvat;
    public function rules()
    {
        return array(
                        array('line','numerical', 'integerOnly'=>true),
                        array('acno', 'required'),
                        array('field_focus', 'length', 'max'=>15),
                        array('acnoname,postdate,rem,ref', 'safe'),
        );
    }


        public static function deletedetail($doc,$trno)         //delete all details   used before inserting newly computed details
        {   
            $table=Common::localdetail($doc);
            return Yii::$app->sbccommon->execqry("delete from $table where trno=$trno");
        }



        public static function getLastLine($trno,$doc){
            $table=Common::localdetail($doc);
            $stocks=Yii::$app->sbccommon->opentable("SELECT ifnull(line,0) as line FROM $table where trno ='$trno' order by line 
                desc limit 1");
            if(count($stocks)==0)
            {
                return 0;
            }
            else
            {
                return $stocks[0]['line'];
            }
        }

       public static function getstockMI($doc,$trno,$tax){
            $table=Common::localstock($doc);
            $head=Common::localhead($doc);

            $tax1=1 + ($tax/100);
            $tax_=$tax/100;
            
            switch($doc){
                case 'RR':
                    $qry = "select head.client,item.asset,item.expense,head.wh,0 as discount,
                    (round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').")) * case when ifnull(head.forex,0)=0 then 1 else head.forex end as inventory,
                    (((sum(stock.ext))/$tax1)*$tax_ *case when 
                    ifnull(head.forex,0)=0 then 1 else head.forex end) as vat
                    from $head as head 
                    left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno 
                    group by head.client,item.asset,head.wh";

                    $inventory=Yii::$app->sbccommon->opentable($qry);
                break;

                case 'SV':
                    $qry = "select head.client,item.asset,item.expense,head.wh,0 as discount,
                    (sum(stock.ext)) * case when ifnull(head.forex,0)=0 then 1 else head.forex end as inventory,
                    (((sum(stock.ext))/$tax1)*$tax_ *case when 
                    ifnull(head.forex,0)=0 then 1 else head.forex end) as vat
                    from $head as head 
                    left join spstock as stock on stock.sptrno=head.trno
                    left join item on item.barcode=stock.barcode 
                    where stock.sptrno=$trno 
                    group by head.client,item.asset,head.wh";

                    $inventory=Yii::$app->sbccommon->opentable($qry);
                break;
                
                case 'AJ':case 'IS':
                    $qry = "select head.client,head.contra,item.asset,item.expense,stock.wh,sum(stock.ext) as inventory
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,head.contra,item.asset,stock.wh";

                    $inventory=Yii::$app->sbccommon->opentable($qry);
                break;
                
                case 'SJ': case 'DM': case 'CH': case 'MI':
                    //JAODIST
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'UNIVERSE':
                            $qryvattype = "select vattype from lahead where trno =" . $trno;
                            $vattype = Yii::$app->sbccommon->datareader($qryvattype);
                            
                            if($vattype == ""){
                                //QUERY IS BASED ON ITEMS - LOOPED THEN HIJACKED THE ARRAY
                                $qry = "select item.isvat,head.client,item.asset,item.revenue,item.expense,
                                        head.wh,(stock.isamt*stock.isqty)-stock.ext as discount,
                                        stock.isamt*stock.isqty as sales,
                                        stock.cost*stock.iss as inventory ,stock.cost*stock.iss as costofgood,
                                        ifnull((stock.ext/1.12)*0.12,0) as vat 
                                        from $head as head left join $table as stock on stock.trno=head.trno
                                        left join item on item.barcode=stock.barcode where stock.trno=$trno";

                                $inventory=Yii::$app->sbccommon->opentable($qry);
                               
                                $discamt = 0;
                                $salesamt = 0;
                                $invamt = 0;
                                $cogamt = 0;
                                $vatamt = 0;

                                $client = $inventory[0]['client'];
                                $asset = $inventory[0]['asset'];
                                $revenue = $inventory[0]['revenue'];
                                $expense = $inventory[0]['expense'];
                                $wh = $inventory[0]['wh'];

                                foreach ($inventory as $key => $value) {
                                    $discamt += $value['discount'];
                                    $salesamt += $value['sales'];
                                    $invamt += $value['inventory'];
                                    $cogamt += $value['costofgood'];

                                    if($value['isvat'] == 1){
                                        $vatamt += $value['vat'];
                                    }//endif
                                }//end 

                                $revised_inventory[0]['client'] = $client;
                                $revised_inventory[0]['asset'] = $asset;
                                $revised_inventory[0]['revenue'] = $revenue;
                                $revised_inventory[0]['expense'] = $expense;
                                $revised_inventory[0]['wh'] = $wh;
                                $revised_inventory[0]['discount'] = $discamt;
                                $revised_inventory[0]['sales'] = $salesamt;
                                $revised_inventory[0]['inventory'] = $invamt;
                                $revised_inventory[0]['costofgood'] = $cogamt;
                                $revised_inventory[0]['vat'] = $vatamt;

                                $inventory = $revised_inventory;
                            }else{
                                //SAME QUERY AS DEFAULT
                                $qry = "select head.client,item.asset,item.revenue,item.expense,
                                head.wh,sum((stock.isamt*stock.isqty)-stock.ext) as discount,
                                round(sum(stock.isamt*stock.isqty),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as sales,
                                sum(stock.cost*stock.iss) as inventory ,
                                sum(stock.cost*stock.iss) as costofgood,
                                round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat 
                                from $head as head left join $table as stock on stock.trno=head.trno
                                left join item on item.barcode=stock.barcode where stock.trno=$trno
                                group by head.client,item.asset,head.wh,item.revenue";

                                $inventory=Yii::$app->sbccommon->opentable($qry);
                            }//end if
                        break;

                        case 'KINGGEORGE':
                            //SAME QUERY AS DEFAULT
                            $qry = "select head.client,item.asset,item.revenue,item.expense,
                                    head.wh,sum((stock.isamt*stock.isqty * stock.kgs)-stock.ext) as discount,
                                    round(sum(stock.isamt*stock.isqty*stock.kgs),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as sales,
                                    sum(stock.cost*stock.iss) as inventory ,sum(stock.cost*stock.iss)  as costofgood,
                                    round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat 
                                    from $head as head left join $table as stock on stock.trno=head.trno
                                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                                    group by head.client,item.asset,head.wh,item.revenue";

                            $inventory=Yii::$app->sbccommon->opentable($qry);
                        break;
                        
                        default:
                            //SAME QUERY AS DEFAULT
                            $qry = "select head.client,item.asset,item.revenue,item.expense,
                                    head.wh,sum((stock.isamt*stock.isqty)-stock.ext) as discount,
                                    round(sum(stock.isamt*stock.isqty),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as sales,
                                    sum(stock.cost*stock.iss) as inventory ,sum(stock.cost*stock.iss) as costofgood,
                                    round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat,
                                    round(sum(round(ifnull(((stock.ext)/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').")),".Yii::$app->systemsettings->setDecimaldisplay('currency').")
                                    from $head as head 
                                    left join $table as stock on stock.trno=head.trno
                                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                                    group by head.client,item.asset,head.wh,item.revenue";
                            //OLD VAT COMPUTATION 
                            //round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat 
                            $inventory=Yii::$app->sbccommon->opentable($qry);
                        break;
                    }//END SWITCH
                break;
                

                case 'SJ2':
                    $qry = "select head.client,item.asset,item.revenue,item.expense,head.wh,sum((stock.isamt*stock.isqty2)-stock.ext) as discount,
                    round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as sales,
                    sum(stock.cost*stock.iss)  as inventory ,sum(stock.cost*stock.iss)  as costofgood,
                    round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat 
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,head.wh";

                    $inventory=Yii::$app->sbccommon->opentable($qry);
                break;

                
                case 'CM':
                    $qry = "select head.client,item.asset,item.expense,head.wh,sum((stock.isamt*stock.rrqty)-stock.ext) as discount,sum(stock.ext) as sales,
                    sum(stock.cost*stock.qty)  as inventory ,sum(stock.cost*stock.qty)  as costofgood,
                    sum(stock.ext) as ar,((sum(stock.ext))/$tax1)*$tax_ as vat
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,head.wh";

                    $inventory=Yii::$app->sbccommon->opentable($qry);
                break;

                default:
                    $qry = "select head.client,item.asset,item.expense,head.wh,
                    sum((stock.rrcost*stock.rrqty)-stock.ext) as discount,(sum(stock.ext)/$tax1)*$tax_) as inventory
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,head.wh";

                    $inventory=Yii::$app->sbccommon->opentable($qry);
                break;
            }//end switch

            return $inventory;
        }//end function




        public static function computeDistributions($doc,$trno,$tax)       //return  Purchase discount, accounts payable, vat
        {
            $table=Common::localstock($doc);
            $head=Common::localhead($doc);

            $tax1= 1 + ($tax/100);
            $tax_=$tax/100;

             switch($doc){
                
                case 'RR':{
                $inventory=Yii::$app->sbccommon->opentable("select sum(stock.rrcost*stock.rrqty) as total,0 as pd,
                round(sum(stock.ext),2) *case when ifnull(head.forex,0)=0 then 1 else head.forex end as ap,
                ((sum(stock.ext))/$tax1)*$tax_  *case when ifnull(head.forex,0)=0 then 1 else head.forex end as vat 
                from $head as head left join $table as stock on stock.trno=head.trno 
                left join item on item.barcode=stock.barcode where stock.trno=$trno");
                break;
                }

                case 'SV':{
                $inventory=Yii::$app->sbccommon->opentable("select sum(stock.rrcost*stock.rrqty) as total,0 as pd,
                (sum(stock.ext)) *case when ifnull(head.forex,0)=0 then 1 else head.forex end as ap,
                ((sum(stock.ext))/$tax1)*$tax_*case when ifnull(head.forex,0)=0 then 1 else head.forex end as vat 
                from $head as head left join spstock as stock on stock.sptrno=head.trno 
                left join item on item.barcode=stock.barcode where stock.sptrno=$trno");
                break;
                }

                case 'SJ': case 'DM': case 'CH': case 'MI':{
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'UNIVERSE':
                            $qryvattype = "select vattype from lahead where trno =" . $trno;
                            $vattype = Yii::$app->sbccommon->datareader($qryvattype);
                            
                            if($vattype == ""){
                                $inventory=Yii::$app->sbccommon->opentable("select item.isvat,
                                round(ifnull(stock.isamt*stock.isqty,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as total,
                                round(ifnull((stock.isamt*stock.isqty)-stock.ext,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as pd,
                                round(ifnull(stock.ext,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ar,
                                round(ifnull((stock.ext/1.12)*0.12,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat
                                from $table as stock
                                left join item on item.barcode=stock.barcode where stock.trno=$trno");

                                $totalamt = 0;
                                $pdamt = 0;
                                $aramt = 0;
                                $vatamt = 0;

                                foreach ($inventory as $key => $value) {
                                    $totalamt += $value['total'];
                                    $pdamt += $value['pd'];
                                    $aramt += $value['ar'];

                                    if($value['isvat'] == 1){
                                        $vatamt += $value['vat'];
                                    }//endif
                                }//end 

                                $revised_inventory[0]['total'] = $totalamt;
                                $revised_inventory[0]['pd'] = $pdamt;
                                $revised_inventory[0]['ar'] = $aramt;
                                $revised_inventory[0]['vat'] = $vatamt;

                                $inventory = $revised_inventory;
                            }else{
                                //SAME AS DEFAULT
                                $inventory=Yii::$app->sbccommon->opentable("select
                                round(ifnull(sum(stock.isamt*stock.isqty),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as total,
                                round(ifnull(sum((stock.isamt*stock.isqty)-stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').")as pd,
                                round(ifnull(sum(stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ar,
                                round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat
                                from $table as stock
                                left join item on item.barcode=stock.barcode where stock.trno=$trno");
                            }//end if
                        break;
                        
                        case 'KINGGEORGE':
                            //TODO: RETURN AFTER UPDATING IN HOUSEGEM
                            
                            /*$inventory=Yii::$app->sbccommon->opentable("select
                            round(ifnull(sum(stock.isamt*stock.isqty),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as total,
                            round(ifnull(sum(((stock.isamt*stock.kgs) * stock.isqty)-stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').")as pd,
                            round(ifnull(sum(stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ar,
                            round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat
                            from $table as stock
                            left join item on item.barcode=stock.barcode where stock.trno=$trno");*/

                            $inventory=Yii::$app->sbccommon->opentable("select
                            round(ifnull(sum(stock.isamt*stock.isqty),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as total,
                            round(ifnull(sum(stock.ext-stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').")as pd,
                            round(ifnull(sum(stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ar,
                            round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat
                            from $table as stock
                            left join item on item.barcode=stock.barcode where stock.trno=$trno");
                        break;

                        default:
                        //SAME AS DEFAULT
                        $inventory=Yii::$app->sbccommon->opentable("select
                        round(ifnull(sum(stock.isamt*stock.isqty),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as total,
                        round(ifnull(sum((stock.isamt*stock.isqty)-stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').")as pd,
                        round(ifnull(sum(stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ar,
                        round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat
                        from $table as stock
                        left join item on item.barcode=stock.barcode where stock.trno=$trno");
                        break;
                    }//END SWITCH
                break;
                }//end case

                case 'SJ2':{
                   
                   $inventory=Yii::$app->sbccommon->opentable("
                    select
                    round(ifnull(sum(stock.isamt*stock.isqty2),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as total,
                    round(ifnull(sum((stock.isamt*stock.isqty2)-stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as pd,
                    round(ifnull(sum(stock.ext),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ar,
                    round(ifnull(((sum(stock.ext))/$tax1)*$tax_,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as vat
                    from $table as stock
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    ");
                    break;

                }
                case 'CM':{
                    $inventory=Yii::$app->sbccommon->opentable("
                    select
                    sum(stock.isamt*stock.rrqty) as total,
                    sum((stock.isamt*stock.rrqty)-stock.ext) as pd,
                    sum(stock.ext) as ar,((sum(stock.ext))/$tax1)*$tax_ as vat
                    from $table as stock
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    ");
                    break;
                }

                default:{
                    $inventory=Yii::$app->sbccommon->opentable("
                    select
                    sum(stock.rrcost*stock.rrqty) as total,
                    sum((stock.rrcost*stock.rrqty)-stock.ext) as pd,
                    sum(stock.ext) as ap,
                    ((sum(stock.ext))/$tax1)*$tax_ as vat
                    from $table as stock
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    ");
                    break;
                }
                
            }//end swtich case
            return $inventory[0];
        }//end function



        public static function getacnoname($acno){
            $acnoname= Yii::$app->sbccommon->datareader("select acnoname from coa where acno='$acno'");
            return $acnoname;
        }//end if

        public static function getacnoid($acno){
            $acnoid= Yii::$app->sbccommon->datareader("select acnoid from coa where acno='$acno'");
            return $acnoid;
        }//end f

        public static function getacno($alias){
            $acno= Yii::$app->sbccommon->datareader("select acno from coa where alias='$alias' limit 1");
            return $acno;
        }//end f

        public static function getacno_($acnoid){
            $acno= Yii::$app->sbccommon->datareader("select acno from coa where acnoid='$acnoid'");
            return $acno;
        }//end f





        public static function deletedetail_($doc,$trno,$line){
           $table=Common::localdetail($doc);
            $datatoremove = Yii::$app->sbccommon->opentable("select acno,acnoname from $table where trno = $trno and line =$line");
            $removestatus = Yii::$app->sbccommon->execqry("delete from $table where trno=$trno and line=$line");

            if($removestatus){
                Log::writelog($doc,$trno,'REMOVED ACCOUNT','[\\'.$datatoremove[0]['acno'].'] [Line: '.$line.'] '.$datatoremove[0]['acnoname'],Yii::$app->session['loggeduser']['username']);
            }else{
                Log::writelog($doc,$trno,'FAILED REMOVING ACCOUNT','[\\'.$datatoremove[0]['acno'].'] [Line: '.$line.'] '.$datatoremove[0]['acnoname'],Yii::$app->session['loggeduser']['username']);
            }//end if

            $gettotal = Ladetail::getgrandtotal($trno,$doc);
            $isbalance = Common::isBalanced($trno,$table);
            
            if (!empty($gettotal)){                
                $runningdb = $gettotal[0]['totaldb'];
                $runningcr = $gettotal[0]['totalcr'];
            }else{
                $runningdb = 0;
                $runningcr = 0;
            }
               
            $passjson = array('runningdb'=>$runningdb,'runningcr'=>$runningcr,'isbalance'=>$isbalance,'messages'=>'');
            //Yii::$app->response->format = Response::FORMAT_JSON; 
            return $passjson;
            
        }
        
        
        public static function insertgl($doc,$trno,$client,$acno,$db,$cr,$date){
            $table=Common::localdetail($doc);
            $user=Yii::$app->session['loggeduser']['username'];
            $line=Ladetail::getLastLine($trno) + 1;
            $acnoname=Ladetail::getacnoname($acno);
                   return  Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$acno','$acnoname','$client',round('$db',2),round('$cr',2),0,0,0,0,'$date','$user')
                     ");
        }
  


    public static function distributeRR($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
        //for inventory merchandise - debit side
        $supplier='';
        $acno='';
        $amt = 0.0;

        $vat=$distributions['vat'];
        $ap=$distributions['ap'];
        
        $runn = 0.0;
        $c = count($inventory)-1;

        for ($i=0; $i<count($inventory);$i++){
            $acno=$inventory[$i]['asset'];

            if(strlen($acno)==0){
               $acno='\\\\'. Ladetail::getacno('IN1');
            }else{
               $acno='\\\\'.$acno;
            }//end nf

            $acnoname=Ladetail::getacnoname($acno);
            $whid=$inventory[$i]['wh'];
            $supplier=$inventory[$i]['client'];

            if($vat == 0){
                $amt = $merchandise_inventory = $inventory[$i]['inventory'];

            }else{
                switch (Yii::$app->systemsettings->resellerConfig()) {
                    case 'JOYCEBU':
                        $merchandise_inventory = $inventory[$i]['inventory'];
                        $amt = $inventory[$i]['inventory'];      

                        if($c==$i){
                            if($i==0){
                                $amt = round($ap - round($inventory[$i]['vat'],2),2);
                            }else{
                                $amt = round($ap - round(($runn + $vat),2),2);
                            }//end if
                        }else{
                            $amt= round($inventory[$i]['inventory'] - $inventory[$i]['vat'],2);      
                            $runn += round($inventory[$i]['inventory'] - $inventory[$i]['vat'],2);              
                        }//end if   
                    break;

                    default:
                        if($c==$i){
                            if($i==0){
                                $merchandise_inventory = round($ap - round($inventory[$i]['vat'],2),2);
                                $amt = round($ap - round($inventory[$i]['vat'],2),2);
                            }else{
                                $merchandise_inventory = round($ap - round(($runn + $vat),2),2);  
                                $amt = round($ap - round(($runn + $vat),2),2);  
                            }//end if
                        }else{
                            $merchandise_inventory=round($inventory[$i]['inventory'] - $inventory[$i]['vat'],2);      
                            $amt=round($inventory[$i]['inventory'] - $inventory[$i]['vat'],2);      
                            $runn += round($inventory[$i]['inventory'] - $inventory[$i]['vat'],2);              
                        }//end if      
                    break;
                }//end switch
            }//end if                    

            if($merchandise_inventory!=0){                    
                Yii::$app->sbccommon->execqry("insert into $table
                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                values ('$trno','$line','$acno','$acnoname','$whid',
                '$merchandise_inventory',0,0,0,0,0,'$dateid','$user')");
                $line++;
            }//end if
        }//end for inventory merchandise - debit side

        switch (Yii::$app->systemsettings->resellerConfig()) {
            case 'JOYCEBU':
                if($amt != 0){
                    $acno='\\\\'. Ladetail::getacno('CG1');
                    $acnoname=Ladetail::getacnoname($acno);
                    Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$acno','$acnoname','$whid',
                    round('$merchandise_inventory',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0,0,0,0,0,'$dateid','$user')");
                    $line++;

                    $acno='\\\\'. Ladetail::getacno('PR1');
                    $acnoname=Ladetail::getacnoname($acno);
                    Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$acno','$acnoname','$whid',
                    round('$amt',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0,0,0,0,0,'$dateid','$user')");
                    $line++;
                }//end if

                //for vat - debit side
                if ($tax>0){
                    //$line=Ladetail::getLastLine($trno,$doc)+1;
                    $taxcontra='\\\\'.Ladetail::getacno('TX1');
                    $acnoname=Ladetail::getacnoname($taxcontra);
                    $vat = round($vat,2);
                    Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$taxcontra','$acnoname','$supplier',$vat,
                    0,'$vat',0,0,0,'$dateid','$user')");
                    $line++;
                }// end for vat - debit side
            break;
        }//end 

        $discount=0;

        if($ap>0){
            //$line=Ladetail::getLastLine($trno,$doc) + 1;
            if(strlen($contra)==0){
                $contra='\\\\'.Ladetail::getacno('AP1');
            }else{
                $contra="\\\\".$contra;
            }//end if
            $acnoname=Ladetail::getacnoname($contra);

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'UNIVERSE':
                    $rr_refqry = "select yourref from lahead where trno = ". $trno;
                    $rr_ref = Yii::$app->sbccommon->datareader($rr_refqry);

                    $qryap = "insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby,rem) 
                    values ('$trno','$line','$contra','$acnoname','$supplier',0,
                    round('$ap',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                    0,0,0,0,'$dateid','$user','$rr_ref')";
                break;

                default:
                    $qryap = "insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby) 
                    values ('$trno','$line','$contra','$acnoname','$supplier',0,
                    round('$ap',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                    0,0,0,0,'$dateid','$user')";
                break;
            }//end swithc
            
            Yii::$app->sbccommon->execqry($qryap);
        }// end for AP - credit side                

        return 'ok';            
    }//end distribute




      public static function distributeDM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - credit side
            $pd=0;
            $merchandise_inventory=0;
            $tax=0;

           for ($i=0; $i<count($inventory);$i++)
           {
               $acno=$inventory[$i]['asset'];
               if(strlen($acno)==0)
                   {
                   $acno='\\\\'.Ladetail::getacno('IN1');
                   }
               else
                   {
                   $acno='\\\\'.$acno;
                   }
               $acnoname=Ladetail::getacnoname($acno);
               $whid=$inventory[$i]['wh'];
               $supplier=$inventory[$i]['client'];               
               $merchandise_inventory=$inventory[$i]['inventory']; // - $inventory[$i]['discount']
               if($merchandise_inventory!=0){
                   Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$acno','$acnoname','$whid',0,round('$merchandise_inventory',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                     0,0,0,0,'$dateid','$user')
                     ");
             $line++;
               }
           }//end for inventory merchandise - credit side

           //for vat - debit side
           if ($tax>0)
               {
               //$line=Ladetail::getLastLine($trno,$doc) + 1;
               $taxcontra='\\\\'.Ladetail::getacno('TX1');
               $acnoname=Ladetail::getacnoname($taxcontra);
               $vat=$distributions['vat'];
               Yii::$app->sbccommon->execqry("insert into $table
                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                 values ('$trno','$line','$taxcontra','$acnoname','$supplier',round($vat,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                 0,0,0,0,0,'$dateid','$user')");
                $line++;
               }//end for vat - debit side

             //for vat - credit side
               $discount=0;
            if ($distributions['pd']>0)
                {
                $discount=$distributions['pd'];
                //$line=Ladetail::getLastLine($trno,$doc) + 1;
                $pdcontra='\\\\'.Ladetail::getacno('PD1');
                $acnoname=Ladetail::getacnoname($pdcontra);
                $pd=$distributions['pd'];
               Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$pdcontra','$acnoname','$whid',round($pd,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                     0,0,0,0,0,'$dateid','$user')");
                 $line++;
                }//end for vat - credit side

               //for AP - debit side
                $ap=$distributions['ar']; // - $discount
                if($ap>0){
                    if(strlen($contra)==0)
                        {
                        $contra='\\\\'.Ladetail::getacno('AP1');
                        }
                    else
                        {
                        $contra="\\\\".$contra;
                        }
                    $acnoname=Ladetail::getacnoname($contra);
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$contra','$acnoname','$supplier',round($ap,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                         0,0,0,0,0,'$dateid','$user')");
                   $line++;
                } //end for AP - debit side

                //Balancing account 
                $balance_total = ($ap+$pd)-$merchandise_inventory;
                $pdcontra='\\\\'.Ladetail::getacno('GLC');
                $acnoname=Ladetail::getacnoname($pdcontra);

                if($balance_total>0){                    
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$whid',0,round('$balance_total',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                         0,0,0,0,'$dateid','$user')");
                }elseif($balance_total<0){
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$whid',0,'".round(abs($balance_total),Yii::$app->systemsettings->setDecimaldisplay('currency'))."',
                         0,0,0,0,'$dateid','$user')");                    
                }
                //Balancing account only
                return 'ok';

      }



          public static function distributeSJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions,$android){
            //for inventory merchandise - credit side
                $vat=0;

                /*if ($distributions['vat']>0){
                    $vat=$distributions['vat'];
                }//END IF*/
                $supplier=$inventory[0]['client'];                   
               for ($i=0; $i<count($inventory);$i++){
                   $acno=$inventory[$i]['asset'];
                    if(strlen($acno)==0){
                        $acno='\\\\'.Ladetail::getacno('IN1');
                    }else{
                        $acno='\\\\'.$acno;
                    }
                       
                   $whid=$inventory[$i]['wh'];
                   $merchandise_inventory=$inventory[$i]['inventory'];
                   $merchandise_cost=$inventory[$i]['costofgood'];
                   
                   if($merchandise_cost!=0){
                            $acnoname=Ladetail::getacnoname($acno);
                            Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                            values ('$trno','$line','$acno','$acnoname','$whid',0,round($merchandise_cost,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                            0,0,0,0,'$dateid','$user')");
                            $line++;
                   }

                    //for cost of good sold 
                    if($merchandise_cost!=0){
                        $acno='\\\\'.Ladetail::getacno('CG1');
                        $acnoname=Ladetail::getacnoname($acno);                    
                        Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$acno','$acnoname','$whid',round($merchandise_cost,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                        0,0,0,0,0,'$dateid','$user')");
                        $line++;
                    }// end for cost of good sol
               }//end for inventory merchandise - credit side
              
               //for vat - debit side


               switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        $qryvattype = "select vattype from lahead where trno =" . $trno;
                        $vattype = Yii::$app->sbccommon->datareader($qryvattype);
                        
                        if($vattype == ""){
                            $vat=$distributions['vat'];
                            if($vat>0){
                                $taxcontra='\\\\'.Ladetail::getacno('TX2');
                                $acnoname=Ladetail::getacnoname($taxcontra);
                                Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                values ('$trno','$line','$taxcontra','$acnoname','$supplier',
                                0,round($vat,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                                0,0,0,0,'$dateid','$user')");
                                $line++;
                            }//end if
                        }else{
                           if($tax>0){
                               $taxcontra='\\\\'.Ladetail::getacno('TX2');
                               $acnoname=Ladetail::getacnoname($taxcontra);
                               $vat=$distributions['vat'];
                               Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                 values ('$trno','$line','$taxcontra','$acnoname','$supplier',0,round($vat,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                                 0,0,0,0,'$dateid','$user')");
                                $line++;
                            }//end for vat - debit side
                        }//end if
                    break;
                    
                    default:
                        if($tax>0){
                           $taxcontra='\\\\'.Ladetail::getacno('TX2');
                           $acnoname=Ladetail::getacnoname($taxcontra);
                           $vat=$distributions['vat'];
                           Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                             values ('$trno','$line','$taxcontra','$acnoname','$supplier',0,round($vat,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                             0,0,0,0,'$dateid','$user')");
                            $line++;
                        }//end for vat - debit side
                    break;
                }//END SWITCH

                
                //for discount - credit side
                $discount=0;
                $pd=0;
                if ($distributions['pd']!=0){
                    $discount=$distributions['pd'];
                    $pdcontra='\\\\'.Ladetail::getacno('SD1');
                    $acnoname=Ladetail::getacnoname($pdcontra);
                    $pd=$distributions['pd'];
                    //echo $pd;
                    if($pd<0){
                       // echo 'abs';
                       Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                             values ('$trno','$line','$pdcontra','$acnoname','$supplier',0,abs($pd),0,0,0,0,'$dateid','$user')
                            ");

                    }elseif($pd>0){
                       // echo 'aa';
                       Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$pdcontra','$acnoname','$supplier',$pd,0,0,0,0,0,'$dateid','$user')");
                    }//END IF

                   $line++;
                }//END FOR PD


               //for AR - debit side
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'MLCP':
                        $ar=$distributions['ar'];
                        $qrygetfreight = "select mlcp_freight from lahead where trno =" . $trno;
                        $freight = Yii::$app->sbccommon->datareader($qrygetfreight);
                        $freight = str_replace(',', '', $freight);

                        if(!is_numeric($freight)){
                            $freight = 0;
                        }//end if

                        $ar += floatval(round($freight,Yii::$app->systemsettings->setDecimaldisplay('currency')));
                    break;
                    
                    default:
                        $ar=$distributions['ar'];
                    break;
                }//end switch

                if($ar>0){
                    if(strlen($contra)==0){
                        $contra='\\\\'.Ladetail::getacno('AR1');
                    }else{
                        $contra="\\\\".$contra;
                    }
                    $acnoname=Ladetail::getacnoname($contra); 
                    Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$contra','$acnoname','$supplier',round($ar,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                     0,0,0,0,0,'$dateid','$user')");
                    $line++;
                    Yii::$app->sbccommon->execqry("update ladetail left join lahead on lahead.trno=ladetail.trno left join coa on coa.acno=ladetail.acno set ladetail.checkno=lahead.Checked where ladetail.trno=".$trno." and left(coa.alias,2)='CR'");
                } //end for AR - debit side


                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'MLCP':
                           if($freight > 0){
                                $contra='\\\\'.Ladetail::getacno('FH1');
                                $acnoname=Ladetail::getacnoname($contra); 
                                
                                Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                values ('$trno','$line','$contra','$acnoname','$supplier',0,
                                round($freight,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0,0,0,0,'$dateid','$user')");

                                $line++;
                            } //end for AR - debit side

                            $ar=$distributions['ar'];
                        break;
                    }//end switch

                    //FOR SALES  [CREDIT SIDE]
                    $inventoryvat = $distributions['vat'];
                    $merchandise_sales= ($pd + $ar) - round($vat,Yii::$app->systemsettings->setDecimaldisplay('currency'));
                    if($merchandise_sales!=0){
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                if($android==1){
                                    $acno=Ladetail::getacno('SA2');           
                                }else{
                                    $acno =Yii::$app->sbccommon->datareader("select rev from client where client='".$supplier."'");
                                }                                    
                            break;

                            default:
                                   $acno='';
                            break;
                    } //end switch 

                        
                    if(strlen(stripslashes($acno))==0){
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'UNIVERSE':
                                $qrytranstype = "select uv_transtype from lahead where trno =" . $trno;
                                $transtype = Yii::$app->sbccommon->datareader($qrytranstype);

                                if($transtype == 'SENIOR'){
                                    $acno='\\\\'.Ladetail::getacno('SA6');
                                }else{
                                    $acno='\\\\'.Ladetail::getacno('SA1');    
                                }//end if
                            break;
                            
                            case 'MLCP':
                                $qrytranstype = "select uv_transtype from lahead where trno =" . $trno;
                                $transtype = Yii::$app->sbccommon->datareader($qrytranstype);

                                switch ($transtype) {
                                    case 'LAMINATED':
                                        $acno='\\\\'.Ladetail::getacno('SA3');
                                    break;
                                    
                                    case 'PLAIN':
                                        $acno='\\\\'.Ladetail::getacno('SA1');
                                    break;

                                    case 'SURFACE PRINTED':
                                        $acno='\\\\'.Ladetail::getacno('SA2');
                                    break;

                                    default:
                                        $acno='\\\\'.Ladetail::getacno('SA4');
                                    break;
                                }//end switcvh
                            break;

                            default:
                                $acno='\\\\'.Ladetail::getacno('SA1');    
                            break;
                        }//END SWITCH   
                    }else{
                        $acno='\\\\'.$acno;
                    }//end if

                        
                    $acnoname=Ladetail::getacnoname($acno);                    
                    Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$acno','$acnoname','$supplier',0,
                   $merchandise_sales,
                    0,0,0,0,'$dateid','$user')");
                    $line++;
                    }   //end for sales


                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'MEGASTEEL':
                            $qry = "select ms_arastre,ms_freight,ms_wharffage from lahead where trno = ".$trno;
                            $data = Yii::$app->sbccommon->opentable($qry);
                            
                            if(!empty($data)){
                                $arastre = $data[0]['ms_arastre'];
                                $freight = $data[0]['ms_freight'];
                                $wharffage = $data[0]['ms_wharffage'];
                                $ms_charges = floatval($arastre) + floatval($freight) + floatval($wharffage);
                            }else{
                                $arastre = 0;
                                $freight = 0;
                                $wharffage = 0;
                                $ms_charges = 0;
                            }//end if


                            if($arastre != 0){
                                //NEEDS ALIAS AR13
                                $acno='\\\\'.Ladetail::getacno('AR13');    
                                $acnoname=Ladetail::getacnoname($acno);  

                                Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                values ('$trno','$line','$acno','$acnoname','$supplier',round($arastre,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0,
                                0,0,0,0,'$dateid','$user')");
                                $line++;
                            }//end if

                            if($freight != 0){
                                //NEEDS ALIAS AR14
                                $acno='\\\\'.Ladetail::getacno('AR14');    
                                $acnoname=Ladetail::getacnoname($acno);  

                                Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                values ('$trno','$line','$acno','$acnoname','$supplier',round($freight,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0,
                                0,0,0,0,'$dateid','$user')");
                                $line++;
                            }//end if

                            if($wharffage != 0){
                                //NEEDS ALIAS AR15
                                $acno='\\\\'.Ladetail::getacno('AR15');    
                                $acnoname=Ladetail::getacnoname($acno);  

                                Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                values ('$trno','$line','$acno','$acnoname','$supplier',round($wharffage,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0,
                                0,0,0,0,'$dateid','$user')");
                                $line++;
                            }//end if

                            if($ms_charges != 0){
                                $acno='\\\\'.Ladetail::getacno('MS1');    
                                $acnoname=Ladetail::getacnoname($acno);  

                                Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                values ('$trno','$line','$acno','$acnoname','$supplier',0,round($ms_charges,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                                0,0,0,0,'$dateid','$user')");
                                $line++;
                            }//end if
                        break;
                    }//END SWITCH

                return 'ok';
      }




          public static function distributeMI($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions,$android){
            //for inventory merchandise - credit side

               $qrycostcenter = "select project from lahead as head where trno = ".$trno."";
               $costcenter = Yii::$app->sbccommon->datareader($qrycostcenter);

               for ($i=0; $i<count($inventory);$i++){
                   $whid=$inventory[$i]['wh'];
                   $merchandise_inventory=$inventory[$i]['inventory'];
                   $supplier=$inventory[$i]['client'];                   
                   $merchandise_cost=$inventory[$i]['costofgood'];
                   
                   //for cost of good sold 
                    if($merchandise_cost!=0){
                        $acno='\\\\'.$contra;
                        $acnoname=Ladetail::getacnoname($acno);                    
                        Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby,project)
                        values ('$trno','$line','$acno','$acnoname','$whid',round($merchandise_cost,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                        0,0,0,0,0,'$dateid','$user','".$costcenter."')");
                        $line++;
                    }// end for cost of good sold

                    //for MERCH
                    $acno=$inventory[$i]['asset'];
                    if(strlen($acno)==0){
                        $acno='\\\\'.Ladetail::getacno('IN1');
                    }else{
                        $acno='\\\\'.$acno;
                    }//END IF
                    
                    if($merchandise_cost!=0){
                            $acnoname=Ladetail::getacnoname($acno);
                            Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby,project)
                            values ('$trno','$line','$acno','$acnoname','$whid',0,round($merchandise_cost,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                            0,0,0,0,'$dateid','$user','".$costcenter."')");
                            $line++;
                    }//end for merchandise_cost
            

               }//end for each inventory merchandise - credit side
                return 'ok';
      }//end DISTRIBUTE MI



      public static function distributeCM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - debit side
            $vat=0;
            /*if ($distributions['vat']>0)
                {
                $vat=$distributions['vat'];
                }*/

                for ($i=0; $i<count($inventory);$i++){
                    $acno=$inventory[$i]['asset'];
                    if(strlen($acno)==0){
                       $acno='\\\\'.Ladetail::getacno('IN1');
                    }else{
                       $acno='\\\\'.$acno;
                    }//END IF

                    $whid=$inventory[$i]['wh'];
                    $merchandise_inventory=$inventory[$i]['inventory'];
                    $supplier=$inventory[$i]['client'];                   
                    $merchandise_cost=$inventory[$i]['costofgood'];

                    
                    if ($merchandise_inventory>0){
                      $acnoname=Ladetail::getacnoname($acno);
                      Yii::$app->sbccommon->execqry("insert into $table
                       (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$acno','$acnoname','$whid',round($merchandise_inventory,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                        0,0,0,0,0,'$dateid','$user')");
                      $line++;
                    }//END IF
                    
                    if ($merchandise_cost>0){
                            $acno='\\\\'.Ladetail::getacno('CG1');
                            $acnoname=Ladetail::getacnoname($acno);
                            Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                            values ('$trno','$line','$acno','$acnoname','$whid',0,round($merchandise_cost,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                            0,0,0,0,'$dateid','$user')");
                            $line++;
                    }//end if

                    //for Accounts receivables
                    $inventoryvat = $inventory[$i]['vat'];
                    $merchandise_sales=$inventory[$i]['sales'] - $inventoryvat;
                    if($merchandise_sales!=0){
                        $acno='\\\\'.Ladetail::getacno('SR1');
                        $acnoname=Ladetail::getacnoname($acno);                                
                        Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$acno','$acnoname','$supplier',round($merchandise_sales,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                        0,0,0,0,0,'$dateid','$user')");
                        $line++;
                    }//end if
                           
               }

               //for vat - debit side
               if ($tax>0)
                {
                   $taxcontra='\\\\'.Ladetail::getacno('TX2');
                   $acnoname=Ladetail::getacnoname($taxcontra);
                   $vat=$distributions['vat'];
                   Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$taxcontra','$acnoname','$supplier',0,round($vat,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                    0,0,0,0,'$dateid','$user')");
                   $line++;
                }

                //for vat - credit side
/*                $discount=0;
                $pd=$distributions['pd'];                
                if ($pd>0)
                  {
                    $discount=$distributions['pd'];
                    $pdcontra='\\\\'.Ladetail::getacno('SD1');
                    $acnoname=Ladetail::getacnoname($pdcontra);
                    Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$supplier',0,$pd,0,0,0,0,'$dateid','$user')
                        ");
                    $line++;
                  }//end for vat - credit side
*/
               //for AR - credit side
                $ar=$distributions['ar'];
                if($ar>0){
                    if(strlen($contra)==0)
                        {
                        $contra='\\\\'.Ladetail::getacno('AR1');
                        }
                    else
                        {
                        $contra="\\\\".$contra;
                        }
                   $acnoname=Ladetail::getacnoname($contra);
                  Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$contra','$acnoname','$supplier',0,round($ar,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                    0,0,0,0,'$dateid','$user')");
                    $line++;
                } //end for AR - credit side
                return 'ok';
      }



      public static function distributeAJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - debit side
                $capital = 0;
               for ($i=0; $i<count($inventory);$i++){
                   $acno=$inventory[$i]['asset'];
                   $contra=$inventory[$i]['contra'];
                   
                   if(strlen($acno)==0)
                       {
                       $acno='\\\\'. Ladetail::getacno('IN1');
                       }
                   else
                       {
                       $acno='\\\\'.$acno;
                       }
                   $whid=$inventory[$i]['wh'];
                   $merchandise_inventory=$inventory[$i]['inventory']; // - $inventory[$i]['discount']

                    if($merchandise_inventory>0){                        
                        $acnoname=Ladetail::getacnoname($acno);                       
                        Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$acno','$acnoname','$whid','0',
                        round($merchandise_inventory,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                        0,0,0,0,'$dateid','$user')");
                        $line++;
                    }elseif($merchandise_inventory<0){
                        $acnoname=Ladetail::getacnoname($acno);                       
                        $qry="insert into ".$table."
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('".$trno."','".$line."','".$acno."','".$acnoname."',
                        '".$whid."','0',round(abs(".$merchandise_inventory."),".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                        0,0,0,0,'".$dateid."','".$user."')";
                        Yii::$app->sbccommon->execqry($qry);                        
                       
                        $line++;
                    }//elseif($merchandise_inventory<0)

                    $capital += $merchandise_inventory;
               }

               if($merchandise_inventory>0){    
                    //REWRITE CONTRA ENTRY FOR INVENTORY SETUP TO SUM UP ALL - Jaoski 11/15/2019 6:17:37 PM
                    $contraacno='\\\\'.$contra;        //Ladetail::getacno('IS1');
                    $acnoname=Ladetail::getacnoname($contraacno);
                    Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$contraacno','$acnoname','$whid',
                    '0',round(abs($capital),".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                    0,0,0,0,'$dateid','$user')");
                }else{
                    //REWRITE CONTRA ENTRY FOR INVENTORY SETUP TO SUM UP ALL - Jaoski 11/15/2019 6:17:37 PM
                    $contraacno='\\\\'.$contra;        //Ladetail::getacno('IS1');
                    $acnoname=Ladetail::getacnoname($contraacno);
                    Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                    values ('$trno','$line','$contraacno','$acnoname','$whid',
                    '0',round(abs($capital),".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                    0,0,0,0,'$dateid','$user')");
                }//end if

               return 'ok';
      }




        public static function autoinsertdetail($doc,$trno,$contra,$tax,$dateid,$android=0){
            $table=Common::localdetail($doc);
            $user=Yii::$app->session['loggeduser']['username'];
            $line=Ladetail::getLastLine($trno,$doc) + 1;
            
            $inventory=Ladetail::getstockMI($doc,$trno, $tax);
            $distributions=Ladetail::computeDistributions($doc,$trno,$tax);
            $whid='';

            switch($doc){
                case 'RR': case 'SV':{
                    return Ladetail::distributeRR($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                break;
                }
                
                case 'DM':{
                  return Ladetail::distributeDM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;
                }

                case 'SJ':case 'SJ2':{
                    //JAODIST
                    return Ladetail::distributeSJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions,$android);
                break;                 
                }

                case 'MI':{
                  return Ladetail::distributeMI($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions,$android);
                  break;  
                }
                
                case 'CH':{
                  return Ladetail::distributeSJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;                                  
                }
                
                case 'CM':{
                  return Ladetail::distributeCM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;
                }
                
                case 'AJ':case 'IS':{
                  return Ladetail::distributeAJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                break;
                }
            }//end switch
        }//end function autoinsert detial





        //manage details
        public static function insertdetail($trno,$data,$table,$module){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $line=Ladetail::getLastLine($trno,$module) + 1;
            $supplier=$data->client;

            $postdate=isset($data->postdate) && ($data->postdate!=null) && strlen($data->postdate)!=0 ? "'".date('Y-m-d H:i:s',strtotime($data->postdate))."'" : 'null';
            $user=Yii::$app->session['loggeduser']['username'];
            $acno="\\".$data->acno;
            
            // $acnoname=Ladetail::getacnoname($acno);//use this if editing of account title is NOT ALLOWED
            $acnoname=$data->acnoname;//use this if editing of account title is ALLOWED

            if($module == 'CR'){
                $insertqry="insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,checkno,rem,ref,encodedby,pdcline)
                            values ('$trno','$line','$acno','$acnoname','$supplier',round('$data->db',
                            ".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                            round('$data->cr',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                            '0','0','$data->refx','$data->linex',$postdate,'$data->checkno','$data->rem','$data->ref','$user','$data->pdcline')";
                $insert = Yii::$app->sbccommon->execqry($insertqry);
            }else{
                $insertqry = "insert into $table
                              (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,checkno,rem,ref,encodedby,project,isewt,isvat,ewtcode,ewtrate)
                              values ('$trno','$line','$acno','$acnoname','$supplier',round('$data->db',
                              ".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                              round('$data->cr',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                              '0','0','$data->refx','$data->linex',$postdate,'$data->checkno','$data->rem','$data->ref','$user','$data->costcenter',
                              '$data->isewt','$data->isvat','$data->ewtcode','$data->ewtrate')";
                //echo $insertqry . '<br><br>';
                $insert = Yii::$app->sbccommon->execqry($insertqry);
            }//end insertion on detail                        

            $msg="";
            $status = true;

                if($insert==1){ //update success
                    Log::writelog($module,$trno,'ADDED ACCOUNT','['.$acno.'] '.$acnoname,Yii::$app->session['loggeduser']['username']);
                    
                    if($module=='CR' && $data->pdcline !=0){
                        Yii::$app->sbccommon->execqry("update hpostdatedchecks set refx= $trno,linex = $line where line = $data->pdcline");
                    }//end fn

                    if(!empty($data->refx)){
                        if(Apledger::updatebal($data->refx, $data->linex, $data->acno, $module,0)==1){                        
                            //$status = '';
                            //$msg = '';
                        }else{//update failed
                            Apledger::resetdb($trno, $line, $module);//set CV db to 0
                            Apledger::updatebal($data->refx, $data->linex, $data->acno, $module,1); //update the bal in ap/arledger
                            $status = false;
                            $msg = 'Values were bigger than your original data.';
                        }//end if
                    } //if(strlen($data->refx)!=0 && $data->refx!=''){
                    else {
                        if(Ladetail::validatecheckno($acno,$data->checkno,$module)==1){    
                            //IF VALIDATION OF CHECK IS TRUE
                            //$status = '';
                            //$msg = '';
                        }else{
                            //validation of check no is false
                            Yii::$app->sbccommon->execqry("delete from $table where trno = $trno and line = $line");
                            $status = false;
                            $msg = "Bank Entries should have check numbers! Please kindly check your entries!";
                        }//end if check no validation
                    }//end if

                    if($module == "DS" || $module == "PV"){
                        if($module == 'DS'){
                            $acnoselector = "select contra,clientname,left(dateid,10) as dateid from lahead as head where head.trno = ".$trno;
                            $headaccnt = Yii::$app->sbccommon->opentable($acnoselector);
                        }else{
                            $headaccnt[0]['dateid'] = Yii::$app->sbccommon->datareader("select left(dateid,10) as dateid from lahead as head where head.trno =".$trno);
                            $headaccnt2 = Yii::$app->sbccommon->opentable("select acno as contra,acnoname as clientname from coa where alias = 'AP2'");
                            $headaccnt[0]['contra'] = $headaccnt2[0]['contra'];
                            $headaccnt[0]['clientname'] = $headaccnt2[0]['clientname'];
                        }//end if
                        
                        $aliner = Ladetail::getLastLine($trno,$module) + 1;


                        $deleter = "delete from ladetail where trno = ".$trno." and acno = '\\".$headaccnt[0]['contra']."'";
                        Yii::$app->sbccommon->execqry($deleter);
                        $dbvalqry = "select sum(db-cr) as db from ladetail where trno = ".$trno;
                        $dbval = Yii::$app->sbccommon->datareader($dbvalqry);


                        $autoinsertqry = "insert into ladetail (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,
                                          postdate,checkno,rem,ref,encodedby,project,isewt,isvat,ewtcode,ewtrate)
                                          values(".$trno.",".$aliner.",'\\".$headaccnt[0]['contra']."','".$headaccnt[0]['clientname']."','".$supplier."',
                                          0,".$dbval.",0,0,0,0,'".$headaccnt[0]['dateid']."','','AUTO ENTRY','','AUTO','',0,0,'','')";
                        Yii::$app->sbccommon->execqry($autoinsertqry);

                        $linecheck = "select line from ladetail where trno = ".$trno." and line = ".$line;
                        $checkline = Yii::$app->sbccommon->opentable($linecheck);
                        
                        if(empty($checkline)){
                            $lineqry = "select rem from ladetail where trno = ".$trno." and acno = '\\".$headaccnt[0]['contra']."'";
                            $lineget = Yii::$app->sbccommon->opentable($lineqry);
                            
                            if($lineget[0]['rem']=='AUTO ENTRY'){
                                $line=$line+1;
                            }//end if lvl 2    
                        }//end if lvl 1
                    }//END IF

                }else{ //insert failed
                    Log::writelog($module,$trno,'ERROR ADDING ACCOUNT','['.$acno.'] '.$acnoname,Yii::$app->session['loggeduser']['username']);
                    $msg="";
                    Yii::$app->sbccommon->execqry("delete from $table where trno = $trno and line = $line");
                    $status = false;//$trno."-".$line."-".$acno."-".$acnoname."-".$supplier."-".$postdate."-".$user;
                    $msg = "Error Encountered in insert of accounts...";
                }

                if($status == false) {
                    $passjson = array('savingtype'=>'add','msg'=>$msg,'status'=>$status,'line'=>$line);
                } else {
                    $detail = Ladetail::opendetailline($trno,$line,$module);
                    $gettotal = Ladetail::getgrandtotal($trno,$module);
                    $isbalance = Common::isBalanced($trno,$table);
                    $acno = $detail[0]['acno'];
                    $acnoname = $detail[0]['acnoname'];
                    $db = $detail[0]['db'];
                    $cr= $detail[0]['cr'];
                    $postdate = $detail[0]['postdate'];
                    $checkno = $detail[0]['checkno'];
                    $rem = $detail[0]['rem'];
                    $ref = $detail[0]['ref'];
                    $client = $detail[0]['client'];
                    $refx = $detail[0]['refx'];
                    $linex = $detail[0]['linex'];
                    $costcenter = $detail[0]['costcenter1'] . '~' . $detail[0]['costcenter2'];
                    
                    $runningdb = $gettotal[0]['totaldb'];
                    $runningcr = $gettotal[0]['totalcr'];

                    $ewtcode = $detail[0]['ewtcode'];
                    $ewtrate = $detail[0]['ewtrate'];

                    $passjson = array('savingtype'=>'add','status'=>$status,'trno'=>$trno,'line'=>$line,'acno'=>$acno,
                                    'acnoname'=>$acnoname,'db'=>number_format($db,Yii::$app->systemsettings->setDecimaldisplay('currency')),
                                    'cr'=>number_format($cr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'postdate'=>$postdate,
                                    'checkno'=>$checkno,'rem'=>$rem,'ref'=>$ref,'runningdb'=>$runningdb,'runningcr'=>$runningcr,
                                    'results'=>'','isbalance'=>$isbalance,'client'=>$client,'refx'=>$refx,'linex'=>$linex,
                                    'msg'=>$msg,'istransposted'=>false,'costcenter'=>$costcenter,
                                    'ewtcode'=>$ewtcode,'ewtrate'=>$ewtrate);
                }

                return $passjson;



        }//end function   

        public static function insert($trno,$data,$module){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $table=Common::localdetail($module);
            $line=Ladetail::getLastLine($trno,$module) + 1;
            switch($module){
                case 'PV':
                case 'CV':
                case 'CR':
                case 'GJ':
                case 'DS':{
                    $supplier=$data->client;
                    if(strlen($supplier)==0 || $supplier==null){
                        $supplier=Yii::$app->session['supplier'.$module];
                    }
                    break;
                }
                default:{
                        $supplier=Yii::$app->session['supplier'.$module];
                    break;
                }
            }

            $postdate=isset($data->postdate) && ($data->postdate!=null) && strlen($data->postdate)!=0 ? "'".date('Y-m-d H:i:s',strtotime($data->postdate))."'" : 'null';
            $user=Yii::$app->session['loggeduser']['username'];
            $acno="\\".$data->acno;
            $acnoname=$data->acnoname;                                          
            if (($data->db+$data->cr)!=0){
            
            $query="insert into $table (trno,line,acno,acnoname,client,db,cr,fdb,fcr,ref,refx,linex,postdate,encodedby,checkno)
                    values ('$trno','$line','$acno','$acnoname','$supplier',round('$data->db',2),round('$data->cr',2),'0.00','0.00',
                    '$data->ref','$data->refx','$data->linex',$postdate,'$user','$data->checkno')";
            $insert=Yii::$app->sbccommon->execqry($query);
                
                if($insert==1){ //update success
                    if(Apledger::updatebal($data->refx, $data->linex, $data, $module,0)==1){
                        return true;
                    }else{//update failed
                        Apledger::resetdb($trno, $line, $module);//set CV db to 0
                        Apledger::updatebal($data->refx, $data->linex, $data, $module,1); //update the bal in ap/arledger
                        return false;
                    }
                    
                }
                else{//insert failed
                    return false;//$trno."-".$line."-".$acno."-".$acnoname."-".$supplier."-".$postdate."-".$user;
                }
            }else{return false;}
        }

        public static function getdetailbank($trno,$acno){
            $acno = "\\".$acno;
           return $data =  Yii::$app->sbccommon->opentable("select trno,line from ladetail where trno = $trno and acno = '$acno'");           
           
       }

        public static function getapdetail($trno,$module)                                       //this can be used to get ap detail upon posting
        {
            $table=Common::localdetail($module);
            $ap=Yii::$app->sbccommon->opentable("
                    select trno,d.acno,d.acnoname,alias,client,round(db,2) as db,round(cr,2) as cr from $table as d
                    left join coa on coa.acno=d.acno
                    where alias='AP1' and trno=$trno
                    ");
            if ($ap!=null)
                {
                return $ap;
                }
            else
                {
                return false;
                }
        }

        public static function getapLastLine($trno,$table)
        {
            $stocks=Yii::$app->sbccommon->opentable("SELECT line FROM $table where trno ='$trno' order by line desc limit 1");
            if ($stocks==null)
            {
                return 0;
            }
            else
            {
                return $stocks[0]['line'];
            }
        }

        public static function insertapdetail($trno,$line,$data,$table){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $supplier=Yii::$app->session['supplier'.Yii::$app->session['RR']];
            $user=Yii::$app->session['loggeduser']['username'];
            $clientid=Client::checkclient($supplier);
            $date=date("Y-m-d H:i:s");
            Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acnoid,clientid,db,cr,docno,dateid)
                     values ('$trno','$line','$data->acnoid','$clientid',round('$data->db',2),round('$data->cr',2),'$data->docno','$date')
                     ");
        }

        public static function updatedetail($trno,$line,$data,$doc){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $date=date("Y-m-d H:i:s");
            $table=Common::localdetail($doc);
            $supplier=$data->client;
            $msg = "";
            
            $user=Yii::$app->session['loggeduser']['username'];
            $acno = explode('\\', $data->acno);
            $acno="\\\\".$acno[1];
            
            if (Ladetail::validatecheckno($acno,$data->checkno,$doc)==1){    
                goto updating;
            }else{                
                $msg = "Pls encode check Details...";
                goto view;
            }


            updating: 
            $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
            $sql="update $table set acno = '$acno', acnoname = '$data->acnoname', 
            client='$data->client',checkno='$data->checkno',postdate='$data->postdate',rem='$data->rem',
            ref='$data->ref',db=round('$data->db',2), cr=round('$data->cr',2),editby='$user',
            editdate='".$timeupdate."',project='$data->costcenter',
            
            ewtrate='".$data->ewtrate."',ewtcode='".$data->ewtcode."',
            isewt='".$data->isewt."',isvat='".$data->isvat."' 

            where trno='$trno' and line='$line'";

            Yii::$app->sbccommon->execqry($sql);
             
            if($data->refx!=0){
                    if(Apledger::updatebal($data->refx, $data->linex, $data->acno, $doc)==1){                       
                        goto view;
                    }else{//update failed
                        Apledger::resetdb($trno, $line, $doc);//set CV db to 0
                        Apledger::updatebal($data->refx, $data->linex, $data->acno, $doc,1); //update the bal in ap/arledger
                         $msg = "Values were bigger than your original data.";
                        goto view;
                    }
            }
           

            view:    
                if($doc == "DS" || $doc == "PV"){
                    if($doc == 'DS'){
                        $acnoselector = "select contra,clientname,left(dateid,10) as dateid from lahead as head where head.trno = ".$trno;
                        $headaccnt = Yii::$app->sbccommon->opentable($acnoselector);
                    }else{
                        $headaccnt[0]['dateid'] = Yii::$app->sbccommon->datareader("select left(dateid,10) as dateid from lahead as head where head.trno =".$trno);
                        $headaccnt2 = Yii::$app->sbccommon->opentable("select acno as contra,acnoname as clientname from coa where alias = 'AP2'");
                        $headaccnt[0]['contra'] = $headaccnt2[0]['contra'];
                        $headaccnt[0]['clientname'] = $headaccnt2[0]['clientname'];
                    }//end if
                    
                    $aliner = Ladetail::getLastLine($trno,$doc) + 1;

                    if($acno != '\\'.$headaccnt[0]['contra']){
                        $deleter = "delete from ladetail where trno = ".$trno." and acno = '\\".$headaccnt[0]['contra']."'";

                        Yii::$app->sbccommon->execqry($deleter);

                        $dbvalqry = "select sum(db-cr) as db from ladetail where trno = ".$trno;
                        $dbval = Yii::$app->sbccommon->datareader($dbvalqry);


                        $autoinsertqry = "insert into ladetail (trno,line,acno,acnoname,client,db,cr,
                        fdb,fcr,refx,linex,postdate,checkno,rem,ref,encodedby,project,isewt,isvat,ewtcode,ewtrate)
                        values(".$trno.",".$aliner.",'\\".$headaccnt[0]['contra']."','".$headaccnt[0]['clientname']."','".$data->client."',
                        0,".$dbval.",0,0,0,0,'".$headaccnt[0]['dateid']."','','AUTO ENTRY','','AUTO','',0,0,'','')";
                        Yii::$app->sbccommon->execqry($autoinsertqry);
                    }//end if
                }//END IF

               $detail = Ladetail::opendetailline($trno, $line,$doc);
               $gettotal = Ladetail::getgrandtotal($trno,$doc);
               $isbalance = Common::isBalanced($trno,$table);
               if (!empty($detail)) {
                    // $acno = $detail[0]['acno'];
                    $acno=$detail[0]['acno'];
                    $acnoname = $detail[0]['acnoname'];
                    $db = $detail[0]['db'];
                    $cr= $detail[0]['cr'];
                    $postdate = $detail[0]['postdate'];
                    $checkno = $detail[0]['checkno'];
                    $rem = $detail[0]['rem'];
                    $ref = $detail[0]['ref'];
                    $linex = $detail[0]['linex'];
                    $refx = $detail[0]['refx'];
                    $client = $detail[0]['client'];
                    $runningdb = $gettotal[0]['totaldb'];
                    $runningcr = $gettotal[0]['totalcr'];
                    $pdcline = $detail[0]['pdcline'];
                    $costcenter = $detail[0]['costcenter1'] . '~' . $detail[0]['costcenter2'];
                    $passjson = array('status'=>'','savingtype'=>'edit','trno'=>$trno,'line'=>$line,'acno'=>$acno,'acnoname'=>$acnoname,'db'=>number_format($db,2),'cr'=>number_format($cr,2),'postdate'=>$postdate,'checkno'=>$checkno,'rem'=>$rem,'ref'=>$ref,'linex'=>$linex,'refx'=>$refx,'runningdb'=>$runningdb,'runningcr'=>$runningcr,'result'=>1,'isbalance'=>$isbalance,'client'=>$client ,'msg'=>$msg,'pdcline'=>$pdcline,'istransposted'=>false,'costcenter'=>$costcenter);
                    return $passjson;
                }
        }

     public static function opendetailline($trno,$line,$doc)
        {
            $detail=Common::localdetail($doc);
            $gldetail=Common::gldetail();
            $hgldetail=Common::hgldetail();
            $qry = "
                select head.trno,dateid,ref,d.line,d.acno,d.acnoname,d.client,client.clientname,d.rem,db,cr,
                fdb,fcr,refx,linex,left(d.postdate,10) as postdate,d.checkno,coa.alias,d.pdcline,
                d.project as costcenter1,ifnull(proj.name,'') as costcenter2,
                ifnull(concat(ifnull(d.project,''),'~',ifnull(proj.name,'')),'') as costcenter,d.ewtcode,d.ewtrate from $detail as d
                left join lahead as head on head.trno=d.trno
                left join client on d.client=client.client
                left join projectmasterfile as proj on proj.code = d.project
                left join coa on d.acno=coa.acno
                where d.trno=$trno and d.line=$line
                union all
                select head.trno,dateid,ref,d.line,coa.acno,d.acnoname,client.client,client.clientname,
                d.rem,db,cr,fdb,fcr,refx,linex,left(d.postdate,10) as postdate,d.checkno,coa.alias,
                d.pdcline,d.project as costcenter1,ifnull(proj.name,'') as costcenter2,
                ifnull(concat(ifnull(d.project,''),'~',ifnull(proj.name,'')),'') as costcenter,d.ewtcode,d.ewtrate from $gldetail as d
                left join lahead as head on head.trno=d.trno
                left join client on d.clientid=client.clientid
                left join projectmasterfile as proj on proj.code = d.project
                left join coa on d.acnoid=coa.acnoid
                where d.trno=$trno and d.line=$line
                union all
                select head.trno,dateid,ref,line,coa.acno,coa.acnoname,client.client,client.clientname,
                d.rem,db,cr,fdb,fcr,refx,linex,left(d.postdate,10) as postdate,d.checkno,coa.alias,
                d.pdcline,'' as costcenter1,'' as costcenter2,
                '' as costcenter,d.ewtcode,d.ewtrate from $hgldetail as d
                left join lahead as head on head.trno=d.trno
                left join client on d.clientid=client.clientid
                left join coa on d.acnoid=coa.acnoid
                where d.trno=$trno and d.line=$line";
            $detail=Yii::$app->sbccommon->opentable($qry);
            return $detail;
        }

        
        public static function opendetail($trno,$doc){
            $detail=Common::localdetail($doc);
            $gldetail=Common::gldetail();
            $hgldetail=Common::hgldetail();
            
            switch($doc){
                case 'PV':
                    $addedfields = 'd.isvat,d.isewt,d.ewtcode,d.ewtrate,';
                break;

                default:
                    $addedfields = '';
                break;
            }//end switch

            $sql="select ".$addedfields."head.trno,dateid,ref,d.line,d.acno,d.acnoname,d.client,client.clientname,d.rem,
                round(db,2) as db,round(cr,2) as cr,fdb,fcr,refx,linex,left(d.postdate,10) as postdate,d.checkno,coa.alias,
                d.pdcline,d.project as costcenter1,ifnull(proj.name,'') as costcenter2,
                ifnull(concat(ifnull(d.project,''),'~',ifnull(proj.name,'')),'') as costcenter 
                from $detail as d
                left join lahead as head on head.trno=d.trno
                left join client on d.client=client.client
                left join projectmasterfile as proj on proj.code = d.project
                left join coa on d.acno=coa.acno
                where d.trno=$trno
                union all
                select ".$addedfields."head.trno,dateid,ref,d.line,coa.acno,d.acnoname,client.client,client.clientname,d.rem,round(db,2) as db,round(cr,2) as cr,fdb,fcr,refx,linex,left(d.postdate,10) as postdate,d.checkno,coa.alias,d.pdcline,d.project as costcenter1,
                ifnull(proj.name,'') as costcenter2,ifnull(concat(ifnull(d.project,''),'~',ifnull(proj.name,'')),'') as costcenter from $gldetail as d
                left join lahead as head on head.trno=d.trno
                left join client on d.clientid=client.clientid
                left join projectmasterfile as proj on proj.code = d.project
                left join coa on d.acnoid=coa.acnoid
                where d.trno=$trno
                union all
                select ".$addedfields."head.trno,dateid,ref,d.line,coa.acno,coa.acnoname,client.client,client.clientname,d.rem,round(db,2) as db,round(cr,2) as cr,fdb,fcr,refx,linex,left(d.postdate,10) as postdate,d.checkno,coa.alias,d.pdcline,'' as costcenter1,'' as costcenter2,
                '' as cosstcenter from $hgldetail as d
                left join lahead as head on head.trno=d.trno
                left join client on d.clientid=client.clientid
                left join coa on d.acnoid=coa.acnoid
                where d.trno=$trno";
            return $sql;
        }
        
        
        public static function openkrdetail($trno){
            $detail=Yii::$app->sbccommon->opentable("
                select 'AR' as alias_,ar.trno,ar.line,left(dateid,10) as dateid,ar.acnoid,coa.alias,coa.acno,coa.acnoname,client.clientname,ar.db,ar.cr,ar.bal,ar.docno,ar.kr,detail.rem,client.client

                from arledger as ar
                left join gldetail as detail on detail.trno = ar.trno and detail.line = ar.line
                left join coa on coa.acnoid=ar.acnoid
                left join client on client.clientid=ar.clientid
                where ar.kr='$trno'");
            return $detail;
        }
        
        public static function getdstotal($trno){            
            return Yii::$app->sbccommon->opentable("
            SELECT round(sum(ladetail.db),2) as totaldb,round(sum(ladetail.cr),2) as totalcr
            FROM ladetail left join coa on coa.acno = ladetail.acno  where left(coa.alias,2)<>'CB' and  ladetail.trno
             ='$trno'");
        }
        
        public static function getgrandtotal($trno,$doc){
            $table=Common::localdetail($doc);
            switch($doc){
                case 'KR': {
                    return Yii::$app->sbccommon->opentable("
                    SELECT trno,count(*) as itemcount,round(sum(db),2) as totaldb,round(sum(cr),2) as totalcr
                    FROM arledger where kr ='$trno' group by kr
                    ");
                    break;
                }

                case 'TW': {
                    return Yii::$app->sbccommon->opentable("
                    SELECT trno,count(*) as itemcount,trno,count(*) as totaldb,round(sum(wheld),2) as totalcr
                    FROM taxdetail where trno ='$trno' group by trno
                    union all
                    SELECT trno,count(*) as itemcount,trno,count(*) as totaldb,round(sum(wheld),2) as totalcr
                    FROM htaxdetail where trno ='$trno' group by trno
                    ");
                    break;
                }
                
                default:{
                    return Yii::$app->sbccommon->opentable("
                    SELECT trno,count(*) as itemcount,round(sum(db),2) as totaldb,round(sum(cr),2) as totalcr
                    FROM $table where trno ='$trno' group by trno
                    union all
                    SELECT trno,count(*) as itemcount,round(sum(db),2) as totaldb,round(sum(cr),2) as totalcr
                    FROM gldetail where trno ='$trno' group by trno
                    ");
                    break;
                }//end if
            }
            
        }
        public static function getContralist($doc) {

            switch($doc){
                case'AP':{ $condition=" left(alias,2)='IS' "; break; }
                case'AR':{ $condition=" left(alias,2)='IS' "; break; }
                case'CV':{ $condition=" left(alias,2)='CB' "; break; }
                case'CR':{ $condition=" left(alias,2)='CR' or left(alias,2)='CA' "; break; }
                case'DS':{ $condition=" left(alias,2)='CB' "; break; }
                case'PV':{ $condition=" alias='AP2' "; break; }
                default:{ $condition =" left(alias,2)='AP' or left(alias,2)='AR' or left(alias,2)='CB' or left(alias,2)='CR' "; break; }
            }
        $data = Yii::$app->sbccommon->opentable("SELECT  acnoid, acno, acnoname from coa where $condition ");
        if (!empty($data)) {
            if ($data[0]['acno'] != null) {
                $acno = array();
                foreach ($data as $key => $data_) {

                   $acno1 = array('acnoid' => strtoupper($data_['acnoid']), 'acno' => strtoupper($data_['acno']), 'acnoname' => $data_['acnoname']);
                    array_push($acno, $acno1);
                }
                return $acno;
            } 
        } else {
            return $data;
        }
    }
    
    public static function validatecheckno($acno,$checkno,$module) {
        $validate = 1;
        switch ($module) {
            case 'GJ': case 'DS':
            break;
            default:
                if(!empty($acno)){
                    $sql = "select alias from coa where acno = '".$acno."'";
                    $alias = Yii::$app->sbccommon->opentable($sql);
                    if(!empty($alias)) {
                        if (substr($alias[0]['alias'],0,2)=='CB' || substr($alias[0]['alias'],0,2)=='CR'){
                            if ($checkno==""){
                                $validate = 0;
                            }else{
                                $validate = 1;
                            }
                        }
                    }
                }
            break;
        }//end switch
        return $validate;
    }




}
