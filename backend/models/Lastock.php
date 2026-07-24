<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Postock;
use app\models\Log;

use yii\web\Response;

class Lastock extends Model{

        public $action;
        public $keyword;
        public $quickadd;
        public $line;
        public $trno;
        public $barcode;
        public $itemname;
        public $void;
        public $refx;
        public $linex;
        public $uom;
        public $wh;
        public $disc;
        public $rem;
        public $cost;
        public $rrcost;
        public $rrqty;
        public $qty;
        public $ext;
        public $qa;
        public $ref;
        public $encodeddate;
        public $bal;
        public $wh_;
        public $whname;
        public $grandtotal;
        public $itemcount;
        public $whid;
        public $isamt;
        public $amt;
        public $isqty;
        public $iss;
        public $iss_;
        public $sku;
        public $olduom;
        public $olddisc;
        public $field_focus;
        public $loc;
        public $loc2;
        public $tstrno;
        public $tsline;
        public $locname;
        public $comm;
        public $icomm;
        public $forex;
        public $serial;
        public $chassis;
        public $uomfactor;

        public $editbarcode;
        public $editname;
        public $editrrcost;
        public $editcost;
        public $editrrqty;
        public $editqty;
        public $edituom;
        public $editdisc;
        public $editext;
        public $editwh;
        public $editloc;
        public $editrem;
        public $editisamt;
        public $editamt;
        public $editiss;
        public $editisqty;
        public $markup;
        public $editmarkup;
        public $editcomm;
        public $editicomm;
        public $expiry;
        public $iss2;
        public $isqty2;
        public $templine;
        
        public $iscomponent;
        public $outputid;

        public $msako;
        public $tsako;

        public $itemcomm;
        public $itemhandling;

        public $docno;
        public $client;
        public $clientname;
        public $shipfee;
        public $agent;

        public $kgs;
        public $original_qty = '';
        
       public function rules(){
            return array(
            array('barcode','required'),
            array('line,linex,refx,tstrno,tsline','numerical'),
			array('void', 'numerical', 'integerOnly'=>true),
			array('refx,linex', 'length', 'max'=>10),
			array('barcode,loc', 'length', 'max'=>30),
			array('itemname,wh,keyword,locname', 'length', 'max'=>500),
			array('uom,olduom,field_focus', 'length', 'max'=>15),
			array('disc, rem', 'length', 'max'=>40),
                        array('sku', 'length', 'max'=>45),
			array('rrcost, rrqty, cost, qty, ext, qa,iss,iss_,isamt,isqty,amt,comm,icomm', 'length', 'max'=>19),
                      //  array('wh_', 'required'),
			array('ref', 'length', 'max'=>50),
			array('encodeddate,wh_', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('trno, line, barcode, itemname, uom, wh, disc, rem, cost, qty, rrcost, rrqty,isamt,amt,isqty,iss, ext, void, refx, ref', 'safe', 'on'=>'search'),
		);
	}
	public function attributeLabels(){

		return array(
			'trno' => 'Tr No',
			'line' => 'Line',
			'barcode' => 'Barcode',
			'itemname' => 'Item Name',
		);
	}
        public function getPrimaryKey(){

            return array('TrNo','LINE');
        }
        
        
        public static function openstock($trno,$module,$filter){
            $table=Common::localstock($module);
            $glstock=Common::glstock();

            switch($module){
                case 'TS': case 'PU':
                    $stocks = "select item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno, stock.wh as whcode, client.clientname as wh, stock.line, stock.barcode, 
                    stock.itemname, stock.uom, stock.cost as cost,
                    stock.qty as qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    stock.disc, stock.void, round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, 
                    stock.refx,stock.linex,stock.ref,stock.loc,stock.loc2,stock.tstrno,
                    stock.tsline,item.brand,stock.rem,stock.expiry,stock.iss2,stock.isqty2, ifnull(uom.factor,1) as uomfactor
                    FROM $table as stock
                    left join client on client.client=stock.wh 
                    left join item on item.barcode=stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid = item.itemid and uom.uom=stock.uom
                    where stock.trno ='$trno' and stock.tstrno=0
                    union all
                    SELECT item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno,client.client as whcode,client.clientname as wh,
                    stock.line,  item.barcode as barcode, stock.itemname, stock.uom,
                    stock.cost,stock.qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,stock.iss,
                    stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    stock.disc, stock.void, round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, 
                    stock.refx,stock.linex,stock.ref,stock.loc,stock.loc2,stock.tstrno,
                    stock.tsline,item.brand,stock.rem ,stock.expiry,stock.iss2,stock.isqty2, ifnull(uom.factor,1) as uomfactor
                    FROM $glstock as stock
                    left join client on client.clientid=stock.whid
                    left join item on item.itemid=stock.itemid 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid = item.itemid and uom.uom=stock.uom
                    where stock.trno ='$trno' and stock.tstrno=0 order by line";
                break;
                
                case 'SV':
                    $stocks = "select item.brand as brand,mm.model_name as model,
                    item.itemid,stock.sptrno as trno,stock.wh as whcode,head.client,wh.clientname as wh,stock.line,
                    stock.barcode,stock.itemname,stock.uom,stock.cost,stock.qty,stock.sku,round(stock.rrcost,2) as rrcost,
                    round(stock.rrqty,2) as rrqty, round(stock.ext,2) as ext, left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,2) as isqty, stock.iss,stock.amt, round(stock.isamt,2) as isamt,stock.disc,
                    stock.void, round(stock.qa,2) as qa, 0 as refx,0 as linex,stock.ref, ((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100 as markup,
                    stock.rem,stock.loc,stock.comm, stock.icomm,item.brand,stock.expiry,stock.iss2,stock.isqty2 from spstock as stock
                    left join lahead as head on head.trno = stock.sptrno
                    left join item on item.barcode = stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join client as wh on wh.client = stock.wh
                    where stock.sptrno = ".$trno."
                    UNION ALL
                    select item.brand as brand,mm.model_name as model,
                    item.itemid,stock.sptrno as trno,stock.wh as whcode,head.client,wh.clientname as wh,stock.line,
                    stock.barcode,stock.itemname,stock.uom,stock.cost,stock.qty,stock.sku,round(stock.rrcost,2) as rrcost,
                    round(stock.rrqty,2) as rrqty, round(stock.ext,2) as ext, left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,2) as isqty, stock.iss,stock.amt, round(stock.isamt,2) as isamt,stock.disc,
                    stock.void, round(stock.qa,2) as qa, 0 as refx,0 as linex,stock.ref, ((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100 as markup,
                    stock.rem,stock.loc,stock.comm, stock.icomm,item.brand,stock.expiry,stock.iss2,stock.isqty2 from hspstock as stock
                    left join lahead as head on head.trno = stock.sptrno
                    left join item on item.barcode = stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join client as wh on wh.client = stock.wh
                    where stock.sptrno = ".$trno;
                break;

                default:
                    $stocks = "select stock.original_qty,isfromjo,'<b>CLICK HERE TO VIEW NOTES</b>' as mlcpstockrem,
                    item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno, stock.wh as whcode,client.clientname as wh, stock.line, stock.barcode, 
                    stock.itemname, stock.uom, stock.cost,stock.kgs,
                    stock.qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc, stock.void,
                    round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, stock.refx,stock.linex,stock.ref,
                    ((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100 as markup,stock.rem,stock.loc,stock.comm,
                    stock.icomm,item.brand,stock.expiry,stock.iss2,stock.isqty2, ifnull(uom.factor,1) as uomfactor,stock.tsako,stock.msako,
                    stock.itemhandling,stock.itemcomm,stock.agent
                    FROM $table as stock
                    left join client on client.client=stock.wh
                    left join item on item.barcode=stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where stock.trno ='$trno'
                    union all
                    SELECT stock.original_qty,isfromjo,'<b>CLICK HERE TO VIEW NOTES</b>' as mlcpstockrem,
                    item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno,client.client as whcode,client.clientname as wh, stock.line,  
                    item.barcode as barcode, stock.itemname, stock.uom,
                    stock.cost,stock.kgs,
                    stock.qty,
                    stock.sku,round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc, stock.void,
                    round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, stock.refx,stock.linex,stock.ref,
                    ((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100 as markup,stock.rem,stock.loc,stock.comm,
                    stock.icomm,item.brand,stock.expiry,stock.iss2,stock.isqty2, ifnull(uom.factor,1) as uomfactor,stock.tsako,stock.msako,
                    stock.itemhandling,stock.itemcomm,ag.client as agent
                    FROM $glstock as stock
                    left join client on client.clientid=stock.whid
                    left join item on item.itemid=stock.itemid
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    left join client as ag on ag.clientid=stock.agentid
                    where stock.trno ='$trno' order by line";
                break;
            }
            return $stocks;
    }//end fn

        
     public static function openstockline($module,$trno,$line){
            $table=Common::localstock($module);
            $glstock=Common::glstock();
            switch($module){
                case 'TS': case 'PU': {
                    $stocks=Yii::$app->sbccommon->opentable("
                    select 
                    item.brand as brand,mm.model_name as model,stock.kgs,
                    stock.trno, stock.wh as whcode, client.clientname as wh, stock.line, stock.barcode, stock.itemname,
                    stock.uom, stock.cost,
                    stock.qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
                    round(stock.rrqty,2)  as rrqty, stock.ext as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,
                    stock.rem,stock.comm,stock.icomm,
                    stock.disc, stock.void, round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, 
                    stock.refx,stock.linex,stock.ref,stock.loc,stock.loc2,stock.tstrno,stock.tsline,
                    stock.loc as locname,0 as markup,item.itemid,stock.expiry,stock.iss2,stock.isqty2, ifnull(uom.factor,1) as uomfactor
                    FROM $table as stock
                    left join client on client.client=stock.wh left join item on item.barcode=stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid = item.itemid and uom.uom=stock.uom
                    where stock.trno ='$trno' and stock.line='$line' and stock.tstrno=0
                    UNION ALL
                    SELECT 
                    item.brand as brand,mm.model_name as model,stock.kgs,
                    stock.trno,client.client as whcode,client.clientname as wh, stock.line, 
                    item.barcode as barcode, stock.itemname, stock.uom,
                    stock.cost,stock.qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as rrqty, 
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,
                    stock.rem,stock.comm,stock.icomm,
                    stock.disc, stock.void, round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    stock.refx,stock.linex,stock.ref,stock.loc,stock.loc2,stock.tstrno,
                    stock.tsline,stock.loc as locname,0 as markup,item.itemid ,stock.expiry,stock.iss2,stock.isqty2, ifnull(uom.factor,1) as uomfactor
                    FROM $glstock as stock
                    left join client on client.clientid=stock.whid
                    left join item on item.itemid=stock.itemid
                    left join model_masterfile as mm on mm.model_id = item.model 
                    left join uom on uom.itemid = item.itemid and uom.uom=stock.uom
                    where stock.trno ='$trno' and stock.line='$line' and stock.tstrno=0 order by line
                    ");
                    break;
                }
                
                case 'SP':
                    $qry = "select 
                    item.brand as brand,mm.model_name as model,
                    stock.sptrno as trno,stock.wh as whcode,wh.clientname as wh,stock.line,
                    stock.barcode,stock.itemname,item.body,stock.uom,stock.cost,stock.qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,
                    stock.disc, stock.void, 
                    round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, stock.refx,stock.linex,stock.ref,
                    ifnull(((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100,0) as markup,stock.rem,stock.loc,stock.comm
                    ,stock.icomm,item.itemid,stock.expiry,stock.iss2,
                    round(stock.isqty2,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty2 from spstock as stock
                    left join client as wh on wh.client = stock.wh
                    left join item on item.barcode = stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    where stock.sptrno = '$trno' and stock.line = '$line'
                    UNION ALL
                    select 
                    item.brand as brand,mm.model_name as model,
                    stock.sptrno as trno,stock.wh as whcode,wh.clientname as wh,stock.line,
                    stock.barcode,stock.itemname,item.body,stock.uom,stock.cost,stock.qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,
                    stock.disc, stock.void, 
                    round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, stock.refx,stock.linex,stock.ref,
                    ifnull(((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100,0) as markup,stock.rem,stock.loc,stock.comm
                    ,stock.icomm,item.itemid,stock.expiry,stock.iss2,
                    round(stock.isqty2,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty2 from hspstock as stock
                    left join client as wh on wh.client = stock.wh
                    left join item on item.barcode = stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    where stock.sptrno = '$trno' and stock.line = '$line'";
                    $stocks=Yii::$app->sbccommon->opentable($qry);
                break;

                default:
                    $qry = " select 
                    item.brand as brand,mm.model_name as model,stock.kgs,
                    stock.trno, stock.wh as whcode, client.clientname as wh, stock.line, stock.barcode,
                    stock.itemname,item.body, stock.uom,stock.cost,stock.qty,stock.sku,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    stock.disc, stock.void, 
                    round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, stock.refx,stock.linex,stock.ref,
                    ifnull(((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100,0) as markup,stock.rem,stock.loc,stock.comm
                    ,stock.icomm,item.itemid,stock.expiry,stock.iss2,
                    round(stock.isqty2,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty2, ifnull(uom.factor,1) as uomfactor,
                    stock.tsako,stock.msako,stock.itemcomm,stock.itemhandling,stock.agent
                    FROM $table as stock
                    left join client on client.client=stock.wh
                    left join item on item.barcode=stock.barcode
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid = item.itemid and uom.uom=stock.uom
                    where stock.trno ='$trno' and stock.line='$line'
                    UNION ALL
                    SELECT 
                    item.brand as brand,mm.model_name as model,stock.kgs,
                    stock.trno,client.client as whcode,client.clientname as wh, stock.line,  item.barcode as barcode,
                    stock.itemname,item.body, stock.uom,
                    stock.cost,stock.qty,sku,
                    round(rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, left(encodeddate,10) as encodeddate,
                    round(isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    stock.iss,stock.amt,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    stock.disc, stock.void, round(stock.qa,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, 
                    stock.refx,stock.linex,stock.ref,
                    ifnull(((stock.ext-(stock.cost*stock.isqty))/stock.ext) * 100,0) as markup,stock.rem,stock.loc,
                    stock.comm,stock.icomm,item.itemid,stock.expiry,stock.iss2,
                    round(isqty2,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty2, ifnull(uom.factor,1) as uomfactor,
                    stock.tsako , stock.msako,stock.itemcomm,stock.itemhandling,ag.client as agent
                    FROM $glstock as stock
                    left join client on client.clientid=stock.whid
                    left join item on item.itemid=stock.itemid
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join client as ag on ag.clientid=stock.agentid
                    left join uom on uom.itemid = item.itemid and uom.uom=stock.uom
                    where stock.trno ='$trno' and stock.line='$line' order by line";
                    $stocks=Yii::$app->sbccommon->opentable($qry);
                break;
            }
            return $stocks;
                     // return Yii::$app->sbccommon->opentable($stocks);
        }

        public static function checkstock($trno,$barcode,$doc){
            $table=Common::localstock($doc);
            $stock=Yii::$app->sbccommon->datareader("select ifnull(count(trno),0) as trno from $table where trno='$trno' and barcode='$barcode'");
            return $stock;
        }//end checkstock
        
        
        
        public static function insertstock($doc,$trno,$data,$display){
            $data->itemname=preg_replace( "/'/", "`", $data->itemname);
            $user=Yii::$app->session['loggeduser']['username'];
            $table=Common::localstock($doc);
            $last_line = Lastock::getLastLine($doc,$trno)+1;
            $strbarcode =  $data->barcode;
            $wh = $data->wh_;
            $sql='';
            $message = "";

            //jr add maximum & minimum
            $message = Yii::$app->backend->checkMinimumMaximumBalance($data->barcode,$wh);       
            //end maximum & minimum                  
            
            switch($doc){
                //############## FOR RR AND MI AND CA
                case 'RR': case "CA":{
                         
                  $data->disc=preg_replace( "/'/", "`", $data->disc);
                  $data->rem=preg_replace( "/'/", "`", $data->rem);
                  $data->cost=preg_replace( "/',/", "`", $data->cost);
                  $data->rrqty=preg_replace( "/',/", "`", $data->rrqty);
                  $data->rrcost=preg_replace( "/',/", "`", $data->rrcost);
                  if(strlen($data->void)==0){
                      $data->void=0;
                  }//ednd if

                  if(strlen($data->refx)==0){
                    $data->refx=0;
                    $data->linex=0;
                  }//end if
                 

                    $sql="insert into $table (line, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty, cost, qty, 
                    ext,void,encodedby,editby,ref,refx,linex,loc,expiry,msako,tsako,kgs)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                    '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                    '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty',
                    '$data->ext', '0', '$user','',
                    '$data->ref','$data->refx','$data->linex','$data->loc','$data->expiry','$data->msako', '$data->tsako','$data->kgs')"; 
                  
                    $insertstatus = Yii::$app->sbccommon->execqry($sql);

                    if(strlen($data->refx)!=0 && ($data->refx!=0)){
                        if(!Postock::setserveditems($data->linex,$data->refx,$doc)){                            
                            Postock::resetQuantity($last_line, $trno, $doc);
                            Postock::setserveditems($data->linex, $data->refx,$doc);
                            $message = $message . '<br /> Quantity more than ordered.';
                            $message = $message.'<br />';

                            Log::writelog($doc,$trno,'QUANTITY MORE THAN ORDERED','['.$data->barcode.'] [Line: '.$last_line.']',Yii::$app->session['loggeduser']['username']); 
                        }//end if
                    }//end if
                                            
                    //echo json_encode(array("asd"=>"kkulapoo"));
                  break;
                }//end case

                //############## FOR CM
                case 'CM':{
                  $data->disc=preg_replace( "/'/", "`", $data->disc );
                  $data->rem=preg_replace( "/'/", "`", $data->rem );
                  $data->amt=preg_replace( "/',/", "`", $data->amt );
                  $data->rrqty=preg_replace( "/',/", "`", $data->rrqty );
                  $data->isamt=preg_replace( "/',/", "`", $data->isamt );
                  if(strlen($data->void)==0){
                      $data->void=0;
                  }
                  if(strlen($data->refx)==0){
                    $data->refx=0;
                    $data->linex=0;
                  }

                  if(strlen($data->cost)==0){$data->cost=0;}
                    $sql="INSERT into $table (line, trno, itemname, barcode, uom, wh, disc, rem, isamt, rrqty, amt, qty, ext,void,
                    qa, encodedby,editby,ref,refx,linex,loc,expiry,cost,kgs)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                    '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                    '$data->isamt', '$data->rrqty', '$data->amt', '$data->qty',
                    '$data->ext', '0', '0','$user','',
                    '$data->ref','$data->refx','$data->linex','$data->loc','$data->expiry','$data->cost','$data->kgs')";
                    
                    $insertstatus = Yii::$app->sbccommon->execqry($sql);

                  if(strlen($data->refx)!=0 && $data->refx!=0){

                    if(!Postock::setserveditems($data->linex,$data->refx,$doc)){
                        Postock::resetQuantity($last_line, $trno, $doc);
                        Postock::setserveditems($data->linex, $data->refx,$doc);
                        $message = $message . 'Quantity more than ordered.';

                        Log::writelog($doc,$trno,'QUANTITY MORE THAN ORDERED','['.$data->barcode.'] [Line: '.$last_line.']',Yii::$app->session['loggeduser']['username']); 
                    }
                  }//end strlen($data->refx)!=0 && $data->refx!=0

                       break;
                }


                //############## FOR SJ AND DM AND CH
                case 'MI': case 'SJ':case 'DM': case 'CH': case 'SJ2': case 'MX':{
                  $data->disc=preg_replace( "/'/", "`", $data->disc );
                  $data->rem=preg_replace( "/'/", "`", $data->rem );
                  $data->amt=preg_replace( "/',/", "`", $data->amt );
                  //$data->isqty=preg_replace( "/',/", "`", $data->isqty);
                  $data->isamt=preg_replace( "/',/", "`", $data->isamt);
                  
                  if(strlen($data->void)==0){
                      $data->void=0;
                  }

                  if(strlen($data->comm)==0){
                      $data->comm=0;
                  }

                  if(strlen($data->icomm)==0){
                      $data->icomm=0;
                  }

                  if(strlen($data->refx)==0){
                    $data->refx=0;
                    $data->linex=0;
                  }

                    if($doc == 'SJ2'){
                        $sql="INSERT into $table
                        (line, trno, itemname, barcode, uom, wh, disc, rem, isamt, isqty, amt, iss, ext,void,
                        encodedby,editby,ref,refx,
                        linex,loc,expiry,iss2,isqty2)
                        values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                        '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                        '$data->isamt', '$data->isqty', '$data->amt', '$data->iss',
                        '$data->ext', '$data->void','$user','',
                        '$data->ref','$data->refx','$data->linex','$data->loc','$data->expiry',
                        '$data->iss2','$data->isqty2')";
                    }else{
                        $sql="INSERT into $table
                        (line, trno, itemname, barcode, uom, wh, disc, rem, isamt, isqty, amt, iss, ext,void,
                        encodedby,editby,
                        ref,refx,linex,loc,expiry,iscomponent,outputid,itemcomm,itemhandling,agent,kgs)
                        values (
                        '$last_line', '$trno', '$data->itemname', '$data->barcode',
                        '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                        '$data->isamt', '$data->isqty', '$data->amt', '$data->iss',
                        '$data->ext', '$data->void','$user','',
                        '$data->ref','$data->refx','$data->linex','$data->loc','$data->expiry',
                        '$data->iscomponent','$data->outputid','$data->itemcomm',
                        '$data->itemhandling','$data->agent','$data->kgs')";
                    }//end if sj2

                    $insertstatus = Yii::$app->sbccommon->execqry($sql);
                    break;
                }//end  case


                //############## FOR AJ AND IS
                case "AJ": case "IS": case 'PK':{
                    
                  if ($message !=''){
                  $title='WARNING!';
                  $message= $message;
                  }                    
                    
                  $data->disc=preg_replace( "/'/", "`", $data->disc );
                  $data->rem=preg_replace( "/'/", "`", $data->rem );
                  $data->cost=preg_replace( "/',/", "`", $data->cost );
                  $data->rrqty=preg_replace( "/',/", "`", $data->rrqty );
                  $data->rrcost=preg_replace( "/',/", "`", $data->rrcost );
                  $data->iss=preg_replace( "/',/", "`", $data->iss );
                  if(strlen($data->void)==0){
                      $data->void=0;
                  }

                  if($data->ref==null)
                  {
                      $data->ref="";
                  }

                $sql="INSERT into $table
                (line, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty, cost, qty,iss, ext,void, qa, encodedby
                ,editby,ref,refx,linex,loc,expiry,kgs)
                values (
                '$last_line', '$trno', '$data->itemname', '$data->barcode','$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty','$data->iss','$data->ext', '0', '0','$user','',
                '$data->ref','0','0','$data->loc','$data->expiry','$data->kgs')"; 

                $insertstatus = Yii::$app->sbccommon->execqry($sql);

                  if($doc == 'PK'){
                    $docno = Yii::$app->sbccommon->datareader("select docno from lahead where trno=".$trno." and doc = 'PK'");
                    $updating = "update hpdhead set prc = '".$docno."' where docno = '".$data->ref."'";
                    Yii::$app->sbccommon->execqry($updating);
                  }//end if PKX

                  break;
                }//END AJ AND IS

                
                
                //############## FOR TS AND PU
                case "TS": case "PU":{

                  $data->disc=preg_replace( "/'/", "`", $data->disc );
                  $data->rem=preg_replace( "/'/", "`", $data->rem );
                  $data->cost=preg_replace( "/',/", "`", $data->cost );
                  $data->isqty=preg_replace( "/',/", "`", $data->isqty );
                  $data->isamt=preg_replace( "/',/", "`", $data->isamt );
                  $data->iss=preg_replace( "/',/", "`", $data->iss );
                  if(strlen($data->void)==0){
                      $data->void=0;
                  }

                  if($data->ref==null)
                  {
                      $data->ref="";
                  }

                  $sql="INSERT into $table(line, trno, itemname, barcode,uom, wh, disc, rem,isamt,amt, isqty, qty,iss,
                    ext,void,  encodedby,editby,ref,refx,linex,loc,loc2,expiry,kgs)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode','$data->uom', '$data->wh_', 
                    '$data->disc', '$data->rem','$data->isamt','$data->amt','$data->isqty', '$data->qty','$data->iss',
                    '$data->ext', '0','$user','','$data->ref','$data->refx','$data->linex','$data->loc','$data->loc2','$data->expiry','$data->kgs')";
                  $insertstatus = Yii::$app->sbccommon->execqry($sql);
                  break;
                }
                
            }

            $overorderlimit = false;
            
            if($insertstatus){
                $status2 = '';
                Log::writelog($doc,$trno,'ADDED ITEM','['.$data->barcode.'] '.$data->itemname,Yii::$app->session['loggeduser']['username']);
            }else{
                $status = false;
                Log::writelog($doc,$trno,'ERROR ATTEMPT (ADDING ITEM)','['.$data->barcode.'] '.$data->itemname,Yii::$app->session['loggeduser']['username']);
            }//end if


            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'SOUTHCENTRAL':
                //EXECUTE NOTHING   
                break;
                
                default:
                    if($doc=='SJ' || $doc == 'SJ2'){
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'KINGGEORGE':
                                $qrytermgetter = "select terms from lahead where trno = " . $trno;
                                $terms = Yii::$app->sbccommon->datareader($qrytermgetter);

                                if($terms != 'COD'){
                                    $head_client = Lastock::getheadclient($trno, 'SJ');
                                    $strCRlimitMsg = Client::GetCRLimit($head_client['client']);
                                    if($strCRlimitMsg!=''){
                                        Yii::$app->sbccommon->execqry("update $table set isqty=0,iss=0,ext=0,editby='EXCEED_CRLT',
                                        editdate=CURRENT_TIMESTAMP where trno=$trno and line=$last_line" );
                                        $data->iss=0;
                                        Yii::$app->session['warning'] = Yii::$app->session['warning'].'</br>'.$strCRlimitMsg;
                                        Log::writelog($doc,$trno,'CREDIT LIMIT EXCEED','Transaction Error Exceed Credit Limit',Yii::$app->session['loggeduser']['username']);
                                    }//end if
                                }//end if
                            break;

                            default:
                                $head_client = Lastock::getheadclient($trno, 'SJ');
                                $strCRlimitMsg = Client::GetCRLimit($head_client['client']);
                                if($strCRlimitMsg!=''){
                                    Yii::$app->sbccommon->execqry("update $table set isqty=0,iss=0,ext=0,editby='EXCEED_CRLT',
                                    editdate=CURRENT_TIMESTAMP where trno=$trno and line=$last_line" );
                                    $data->iss=0;
                                    Yii::$app->session['warning'] = Yii::$app->session['warning'].'</br>'.$strCRlimitMsg;
                                    Log::writelog($doc,$trno,'CREDIT LIMIT EXCEED','Transaction Error Exceed Credit Limit',Yii::$app->session['loggeduser']['username']);
                                }//end if
                            break;
                        }//end switch
                    }//end if doc == SJ 
                break;
            }//end swtich case



            
            if($data->iss!=0){
                if(Common::getcompanyid()==3){
                    $cost="0";
                }else{
                  $cost=Lastock::computecosting($data->barcode, $data->wh_,$data->loc,$data->expiry, $trno, $last_line, $data->iss, $doc);
                }
                        if ($cost!=-1){
                           if(Yii::$app->sbccommon->execqry("update $table set cost=$cost where trno=$trno and line=$last_line")==1){
                               if(strlen($data->refx)!=0 && $data->refx!=0){

                                    if(!Postock::setserveditems($data->linex,$data->refx,$doc)){
                                        Postock::resetQuantity($last_line, $trno, $doc);
                                        Postock::setserveditems($data->linex, $data->refx,$doc);
                                        Lastock::deletecosting($trno, $last_line);
                                        Yii::$app->sbccommon->execqry("update $table set isqty=0,iss=0,ext=0,editby='ODR_EXCEED',
                                        editdate=CURRENT_TIMESTAMP where trno=$trno and line=$last_line" );
                                        $message = $message . 'Quantity more than ordered.';

                                        Log::writelog($doc,$trno,'QUANTITY MORE THAN ORDERED','['.$data->barcode.'] [Line: '.$last_line.']',Yii::$app->session['loggeduser']['username']);  
                                    }//end !Postock::setserveditems($data->linex,$data->refx,$doc)
                               }//end strlen($data->refx)!=0 && $data->refx!=0
                           }//end if update table
                       }elseif ($cost==-1){
                            switch ($doc) {
                                case 'TS':
                                   Yii::$app->sbccommon->execqry("update $table set
                                   rrqty=0,isqty=0,qty=0,iss=0,ext=0,editby='OUT_STOCK',editdate=CURRENT_TIMESTAMP 
                                   where trno=".$trno." and line=".$last_line);
                                   $message = $message . 'Out of Stock. Pls check your quantity...';
                                break;

                                case 'PU':
                                  Yii::$app->sbccommon->execqry("update $table set
                                  rrqty=0,qty=0,ext=0,editby='OUT_STOCK',editdate=CURRENT_TIMESTAMP 
                                  where trno=$trno and tstrno=$trno  and tsline=$last_line" );
                                  $message = $message . 'Out of Stock. Pls check your quantity...';
                                    break;
                                
                                case 'PK': case 'AJ':
                                  Yii::$app->sbccommon->execqry("update $table set 
                                  rrqty=0,iss=0,qty=0,ext=0,editby='OUT_STOCK',editdate=CURRENT_TIMESTAMP 
                                  where trno=$trno and line=$last_line");
                                  $message = $message . 'Out of Stock. Pls check your quantity...';
                                    break;
                                
                                case 'SJ2':
                                   Yii::$app->sbccommon->execqry("update $table set
                                   isqty=0,isqty2=0,iss2=0,iss=0,ext=0,editby='OUT_STOCK',editdate=CURRENT_TIMESTAMP 
                                   where trno=$trno and line=$last_line" );
                                   $message = $message . 'Out of Stock. Pls check your quantity...';
                                    break;                                

                                default:
                                   Yii::$app->sbccommon->execqry("update $table set
                                   isqty=0,iss=0,ext=0,editby='OUT_STOCK',editdate=CURRENT_TIMESTAMP 
                                   where trno=$trno and line=$last_line" );
                                   $message = $message . 'Out of Stock. Pls check your quantity...';
                                    break;
                            }//END SWITCH CASE

                            Log::writelog($doc,$trno,'OUT OF STOCK','['.$data->barcode.'] [Line: '.$last_line.']',Yii::$app->session['loggeduser']['username']);  
                        } //end if cost -1               
            }  //end if data->iss != 0
            else{
               if($doc=='SJ2'){
                 if($data->iss2!=0){
                   if(strlen($data->refx)!=0 && $data->refx!=0){

                        ##### CHECKING FOR YULICK SJ MODIFIED
                        switch (Yii::$app->systemsettings->companyConfig($refx,$linex,$customerqty)) {
                            case 'YULICK':
                                if(Yii::$app->backend->customerQTYOrderChecker($data->refx,$data->linex,$data->isqty2)){
                                    $overorderlimit = true;
                                    $message = $message . 'Quantity more than ordered.';
                                }else{
                                    $overorderlimit = false;
                                }//end if
                            break;
                        }//end switch case
                        ##### CHECKING FOR YULICK SJ MODIFIED

                        if(!Postock::setserveditems($data->linex,$data->refx,$doc)){
                            Postock::resetQuantity($last_line, $trno, $doc);
                            Postock::setserveditems($data->linex, $data->refx,$doc);
                            Lastock::deletecosting($trno, $last_line);
                            Yii::$app->sbccommon->execqry("update $table set isqty=0,iss=0,ext=0,editby='OUT_STOCK',
                            editdate=CURRENT_TIMESTAMP where trno=$trno and line=$last_line" );
                            $message = $message . 'Quantity more than ordered.';

                            Log::writelog($doc,$trno,'QUANTITY MORE THAN ORDERED','['.$data->barcode.'] [Line: '.$last_line.']',Yii::$app->session['loggeduser']['username']); 
                        }//end !Postock::setserveditems($data->linex,$data->refx,$doc)
                   }//end strlen($data->refx)!=0 && $data->refx!=0                    
                 }//END IF ISS2
               }//END IF SJ2
            }// end else{}

            if ($display){
            $newdata = Lastock::openstockline($doc,$trno, $last_line);
             
            $grandtotal = Lastock::getgrandtotal($trno, $doc);
                if(!empty($newdata)){
                $barcode = $newdata[0]['barcode'];  //error
                $itemid = $newdata[0]['itemid'];
                $brand = $newdata[0]['brand'];
                $model = $newdata[0]['model'];
                $rrqty = number_format($newdata[0]['rrqty'], Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $isqty = number_format($newdata[0]['isqty'], Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $isqty2 = number_format($newdata[0]['isqty2'], Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $itemname = $newdata[0]['itemname'];
                $uom = $newdata[0]['uom'];
                $wh_ = $newdata[0]['whcode'];
                $whname = $newdata[0]['wh'];
                $qty = $newdata[0]['qty'];
                $iss = $newdata[0]['iss'];
                $iss2 = $newdata[0]['iss2'];
                $rrcost = number_format($newdata[0]['rrcost'], Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $isamt = number_format($newdata[0]['isamt'], Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $cost = number_format($newdata[0]['cost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $amt = number_format($newdata[0]['amt'], Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $ext = $newdata[0]['ext'];
                $disc = $newdata[0]['disc'];
                $loc = $newdata[0]['loc'];
                if($doc == "TS"){
                    $loc2 = $newdata[0]['loc2'];
                }else{
                    $loc2 = "";
                }
                $rem = $newdata[0]['rem'];
                $ref = $newdata[0]['ref'];
                $comm = $newdata[0]['comm'];
                $icomm = $newdata[0]['icomm'];
                $markup = $newdata[0]['markup'];
                $expiry = $newdata[0]['expiry'];
                $refx = $newdata[0]['refx'];
                $linex = $newdata[0]['linex'];
                $uomfactor = $newdata[0]['uomfactor'];
                $itemcount = $grandtotal[0]['itemcount'];
                $totalbill = $grandtotal[0]['grandtotal'];
                $totalkilo = $grandtotal[0]['kilototal'];

                //added if
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'CANUMAY':
                        if($doc == "RR"){
                            $msako = $newdata[0]['msako'];
                            $tsako = $newdata[0]['tsako'];
                        }else{
                            $msako = "";
                            $tsako = "";
                        }//end if
                    break;

                    default:
                        $msako = "";
                        $tsako = "";
                    break;
                }//end switch

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        if($doc == "SJ"){
                            $agent = $newdata[0]['agent'];
                            }else{
                                 $agent = '';
                            }
                    break;

                    default:
                        $agent = '';
                    break;
                }//end switch

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'TENPLUS':
                        $itemhandling = $newdata[0]['itemhandling'];
                        $itemcomm = $newdata[0]['itemcomm'];
                    break;
                    
                    default:
                        $itemhandling = '';
                        $itemcomm = '';
                    break;
                }//END SWITCH

                if($doc=='SJ'){

                    //will check below cost with kinggeorge setting or default setting
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'KINGGEORGE':
                            $isamt2 = str_replace(',','', $isamt);
                            $kgs = str_replace(',','', $newdata[0]['kgs']);
                            $isamt2 = floatval($isamt2) * floatval($kgs);

                            $pasa = Yii::$app->backend->isbelowcost($isamt2,$cost,$last_line,$barcode);

                            if($pasa['status']) {
                                $message = $message.' '.$pasa['msg'];
                                Log::writelog($doc,$trno,'ITEM BELOW COST','['.$barcode.'] [Line: '.$last_line.'] [Amount: '.$isamt2.', Cost: '.$cost.']',Yii::$app->session['loggeduser']['username']);
                            }//end if
                        break;
                        
                        default:
                            $isamt = str_replace(',','', $isamt);
                            $pasa = Yii::$app->backend->isbelowcost($isamt,$cost,$last_line,$barcode);

                            if($pasa['status']) {
                                $message = $message.' '.$pasa['msg'];
                                Log::writelog($doc,$trno,'ITEM BELOW COST','['.$barcode.'] [Line: '.$last_line.'] [Amount: '.$isamt.', Cost: '.$cost.']',Yii::$app->session['loggeduser']['username']);
                            }//end if
                        break;
                    }//END SWITCH

                    if($pasa['status']) {
                        $message = $message.' '.$pasa['msg'];
                        Log::writelog($doc,$trno,'ITEM BELOW COST','['.$barcode.'] [Line: '.$last_line.'] [Amount: '.$isamt.', Cost: '.$cost.']',Yii::$app->session['loggeduser']['username']);
                    }//end if
                }//end SJ


                if($doc == 'RR') {
                    $totalforex = $grandtotal[0]['forexgrandtotal'];
                } else {
                    $totalforex = 0;
                }

                Yii::$app->session['warning']=Yii::$app->session['warning'].$message;
                $status = Yii::$app->session['warning'];
                Yii::$app->session['warning']='';                
                $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,'barcode' => $barcode, 'rrqty' => $rrqty,
                            'isqty'=>$isqty, 'itemname' => $itemname, 'uom' => $uom, 'whcode' => $wh_,'wh' => $whname,
                            'rrcost'=>$rrcost, 'isamt'=>$isamt,'qty'=>$qty,'cost' => $cost,'amt'=>$amt,'total' => $ext ,
                            'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'loc2' => $loc2, 'rem' => $rem,'ref' => $ref,'comm' => $comm,
                            'icomm' => $icomm,'markup'=>$markup,'itemid'=>$itemid,'expiry'=>$expiry,
                            'itemcount'=>$itemcount,'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'msg'=>$status,'refx'=>$refx,'linex'=>$linex,
                            'iss'=>$iss,'iss2'=>$iss2,'isqty2'=>$isqty2,'templine'=>$data->templine,
                            'orderlimitstatus'=>$overorderlimit,
                            'odrisqty'=>$data->isqty,'odrisqty2'=>$data->isqty2,'odriss'=>$data->iss,'odriss2'=>$data->iss2,
                            'istransposted'=>false,
                            'status'=>$status2,
                            'totalforex'=>$totalforex,'msako'=>$msako,'tsako'=>$tsako,'uomfactor'=>$uomfactor,
                            'itemhandling'=>$itemhandling,'itemcomm'=>$itemcomm,'agent'=>$agent,'brand'=>$brand,'model'=>$model);
                return $passjson;
                }else{
                    Yii::$app->response->format = Response::FORMAT_JSON;                    
                    return ['msg'=>"Error saving stock data.",'status'=>false];
                    //echo json_encode(array('msg'=>"Error saving stock data.",'status'=>false));
                    //echo json_encode(array("error"=>$sql)); //UNCOMMENT THIS LINE IF YOU THINK , ERROR IS THE INSERTION QUERY
                }//end else
            }  
      }//END INSERT STOCK
        
        
  
        public static function computecosting($barcode, $wh,$loc,$expiry, $trno, $line, $qty, $doc){
            $itemid = Yii::$app->sbccommon->datareader("select itemid from item where barcode='".$barcode."'");
            $whid = Yii::$app->sbccommon->datareader("select clientid from client where client='".$wh."'");
          

            if($itemid!=0 and $whid!=0){
               $ret = lastock::computecostingactual($itemid, $whid,$loc,$expiry, $trno, $line, abs($qty), $doc);

                if ($ret==-1){
                     $ret = lastock::computecostingactual($itemid, $whid,$loc,$expiry, $trno, $line, abs($qty), $doc);
                }

                return $ret;
            }           
        }//end computecosting


        public static function deletecosting_ ($barcode, $trno, $line){
            //$itemid = Yii::$app->sbccommon->datareader("select itemid from item where barcode='".$barcode."'");
            //Yii::$app->sbccommon->execqry("delete from costing where itemid=".$itemid." and trno=".$trno." and line=".$line);
            Yii::$app->sbccommon->execqry("delete from costing where trno=".$trno." and line=".$line);
        }


        public static function computecostingactualxx($itemid, $whid,$loc,$trno, $line, $qty, $doc){
            
           $origqty = $qty;
           $aveqty = 1;
           $costvalue=0;
           Yii::$app->sbccommon->execqry("delete from costing where itemid=".$itemid." and trno=".$trno." and line=".$line);
           $strRRStatus ="select trno, line, cost, ifnull(bal,0) as bal, itemID, whID from rrstatus where itemid=".$itemid." and whid=".$whid." and loc='".$loc."' and bal<>0 order by encoded";
           $data = Yii::$app->sbccommon->opentable($strRRStatus);
           
           if ($data!=null){
                for ($i=0;$i<count($data);$i++){
                    $bal =$data[$i]['bal'];
                     if ($origqty>$bal){
                        if(Yii::$app->sbccommon->execqry("INSERT INTO costing (trno, line, refx, linex, served, itemID, whID,bal, doc, IsPosted) SELECT ".$trno.",".$line.", ".$data[$i]['trno'].",".$data[$i]['line'].",".$data[$i]['bal'].",".$itemid.",".$whid.", 0,'".$doc."',(select (case when IfNull(postdate, '') = '' then 0 else 1 end) FROM cntnum WHERE trno = ".$trno.")")==1){
                            $costvalue = $costvalue + $data[$i]['cost'] * $data[$i]['bal'];
                            $aveqty = $qty;
                            $origqty = $origqty - $data[$i]['bal'];
                        }else{
                            return -1;
                            exit();
                        }
                         
                    }elseif ($origqty<=$bal){
                           if (Yii::$app->sbccommon->execqry("INSERT INTO costing (trno, line, refx, linex, served, itemID, whID,bal, doc, IsPosted) SELECT ".$trno.",".$line.", ".$data[$i]['trno'].",".$data[$i]['line'].",".$origqty.",".$itemid.",".$whid.", 0,'".$doc."',(select (case when IfNull(postdate, '') = '' then 0 else 1 end) FROM cntnum WHERE trno = ".$trno.")")==1)
                            {
                                    $costvalue = $costvalue + $data[$i]['cost'] ;
                                    $origqty = 0;
                                   // echo $origqty .'<br />';
                                    return  $costvalue/$aveqty;
                                    exit();
                            }else{
                                return -1;
                                exit();
                            }
                    }
                }

                if ($origqty>0){
                    Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
                    $message=$message.'Out of Stock Please check your Quantity';
                    $message = $message.'<br />';
                    Yii::$app->session['warning']=Yii::$app->session['warning'].'<br/>'.$message;
                    return -1;
                    exit();
                }//end if

                $strsql="DELETE FROM costing WHERE refx = 0 AND linex = 0 AND served = 0 AND bal = 0";
                Yii::$app->sbccommon->execqry($strsql);
                if ($costvalue<>0 and $aveqty<>0){
                    return $costvalue/$aveqty;
                }//end if
               }else{
                    Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
                    $message=$message.'Out of Stock Please check your Quantity';
                    $message = $message.'<br />';
                    Yii::$app->session['warning']=Yii::$app->session['warning'].'<br/>'.$message;
                    return -1;

                }//end if else
    }//end fn
    
    
        public static function computecostingactual($itemid, $whid,$loc,$expiry,$trno, $line, $qty, $doc){
           $origqty = $qty;
           $aveqty = 0;
           $costvalue=0;
           $sumbal = 0 ;
           $message = '';
           $bal=0;

           Yii::$app->sbccommon->execqry("delete from costing where trno=".$trno." and line=".$line);

            $strRRStatus ="select rrstatus.trno, rrstatus.line, rrstatus.cost, ifnull(rrstatus.bal,0) as bal,
            rrstatus.itemID, rrstatus.whID,item.minimum,item.maximum,client.client as whcode,
            client.clientname as whname from rrstatus 
            left join client on client.clientid=rrstatus.whid 
            left join item on item.itemid=rrstatus.itemid 
            where rrstatus.itemid=".$itemid." and rrstatus.whid=".$whid." and rrstatus.loc='".$loc."'";

            if($expiry=='1900-01-01' || $expiry ==''){
                $strRRStatus =  $strRRStatus." and (rrstatus.expiry='1900-01-01' or rrstatus.expiry='0000-0-0' or rrstatus.expiry='') ";  
            }else{
                $strRRStatus =  $strRRStatus." and rrstatus.expiry='".$expiry."'"; 
            }  

            $strRRStatus =  $strRRStatus." and rrstatus.bal<>0 order by rrstatus.encoded";  
            
            $data = Yii::$app->sbccommon->opentable($strRRStatus);
            
            
            if($data!=null){
                for ($i=0;$i<count($data);$i++){
                    $bal =$data[$i]['bal'];
                       
                        if(round($origqty,Yii::$app->systemsettings->setDecimaldisplay('quantity'))>round($bal,Yii::$app->systemsettings->setDecimaldisplay('quantity')) && $origqty<>0){

                           if (Yii::$app->sbccommon->execqry("INSERT INTO costing (trno, line, refx, linex, served, itemID, whID,bal, doc, IsPosted) 
                                SELECT ".$trno.",".$line.", ".$data[$i]['trno'].",".$data[$i]['line'].",".$data[$i]['bal'].",".$itemid.",".$whid.", 0,'".$doc."',
                                (select (case when IfNull(postdate, '') = '' then 0 else 1 end) FROM cntnum WHERE trno = ".$trno.")")==1){
                                $costvalue = $costvalue + $data[$i]['cost'] * $data[$i]['bal'];
                                //$aveqty = $qty; //original by lysa
                                $aveqty = $aveqty + $data[$i]['bal'];
                               // echo 'A  '.$origqty;
                                $origqty = $origqty - $data[$i]['bal'];

                            }else{
                                $message=$message.'Error in ComputeStock function...';
                                Yii::$app->session['warning']=Yii::$app->session['warning'].$message;
                                return -1;
                                //exit();
                            }
                        }elseif(round($origqty,Yii::$app->systemsettings->setDecimaldisplay('quantity'))<=round($bal,Yii::$app->systemsettings->setDecimaldisplay('quantity')) && $origqty<>0){
                            if(Yii::$app->sbccommon->execqry("INSERT INTO costing (trno, line, refx, linex, served, itemID, whID,bal, doc, IsPosted) 
                                SELECT ".$trno.",".$line.",".$data[$i]['trno'].",".$data[$i]['line'].",".$origqty.",".$itemid.",".$whid.", 0,'".$doc."',
                                (select (case when IfNull(postdate, '') = '' then 0 else 1 end) FROM cntnum WHERE trno = ".$trno.")")==1){
                                    $costvalue = $costvalue + $data[$i]['cost'] * $origqty;
                                    $aveqty = $aveqty + $origqty;
                                    $origqty = 0;
                                   
                            }else{
                                $message=$message.'Error in ComputeStock function...';
                                Yii::$app->session['warning']=Yii::$app->session['warning'].'<br/>'.$message;
                                return -1;
                                //exit();
                            }
                        }//$origqty>$bal && $origqty<>0
                    //echo $origqty . 'running subtration';
                }// for ($i=0;$i<count($data);$i++){
                    
                    //echo $origqty . 'LAST origqty';
                    if (round($origqty,Yii::$app->systemsettings->setDecimaldisplay('quantity'))>0){
                        Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
                        return -1;
                        //exit();
                    }

                    $strsql="DELETE FROM costing WHERE refx = 0 AND linex = 0 AND served = 0 AND bal = 0";
                    Yii::$app->sbccommon->execqry($strsql);
                     if ($costvalue<>0 and round($aveqty,Yii::$app->systemsettings->setDecimaldisplay('quantity'))<>0){
                         return $costvalue/$aveqty;
                     }else{
                         return 0;
                     }
                }else{
                    Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
                    return -1;
                }
            }
    
    
        public static function updatestocks($doc,$line, $trno, $data){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $user=Yii::$app->session['loggeduser']['username'];
            $date=date("Y-m-d H:i:s");
            $data->itemname=preg_replace( "/'/", "`", $data->itemname);
            $table=Common::localstock($doc);
            $message='';
            $title='';


             switch($doc){
                case 'RR':case 'CA':{
                    $data->disc=preg_replace( "/'/", "`", $data->disc );
                    $data->rem=preg_replace( "/'/", "`", $data->rem );
                    $data->cost=preg_replace( "/'/", "`", $data->cost );
                    $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
                    $data->rrcost=preg_replace( "/'/", "`", $data->rrcost );
                    if($data->void==''){$data->void=0;}
                    
                    $qry = "update ".$table."
                    set itemname='".$data->itemname."',barcode='".$data->barcode."', uom='".$data->uom."',
                    wh='".$data->wh_."', disc='".$data->disc."', rem='".$data->rem."',
                    rrcost='".$data->rrcost."', rrqty='".$data->rrqty."',
                    cost='".$data->cost."', qty='".$data->qty."', ext='".$data->ext."',
                    void='".$data->void."',editby='".$user."',loc='".$data->loc."',expiry='".$data->expiry."',
                    ref='".$data->ref."',msako='".$data->msako."',tsako='".$data->tsako."',kgs='$data->kgs',
                    editdate=CURRENT_TIMESTAMP where trno='".$trno."' and line='".$line."'";

                    Yii::$app->sbccommon->execqry($qry);
                break;                         
                }//end case

                case 'SP':{
                    $data->disc=preg_replace( "/'/", "`", $data->disc );
                    $data->rem=preg_replace( "/'/", "`", $data->rem );
                    $data->cost=preg_replace( "/'/", "`", $data->cost );
                    $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
                    $data->rrcost=preg_replace( "/'/", "`", $data->rrcost );
                    if($data->void==''){$data->void=0;}
                    $qry = "update spstock
                    set itemname='".$data->itemname."',barcode='".$data->barcode."', uom='".$data->uom."',
                    wh='".$data->wh_."', disc='".$data->disc."', rem='".$data->rem."',
                    rrcost='".$data->rrcost."',rrqty='".$data->rrqty."',
                    cost='".$data->cost."',qty='".$data->qty."', ext='".$data->ext."',
                    void='".$data->void."',editby='".$user."',loc='".$data->loc."',expiry='".$data->expiry."',
                    ref='".$data->ref."',editdate=CURRENT_TIMESTAMP where sptrno='".$trno."' and line='".$line."'";
                    Yii::$app->sbccommon->execqry($qry);                        
                     break;                         
                }//end case

                case 'SJ': case 'DM': case 'CH': case 'MI': case 'MX':  case 'SJ2':{
                    $data->disc=preg_replace( "/'/", "`", $data->disc );
                    $data->rem=preg_replace( "/'/", "`", $data->rem );
                    $data->cost=preg_replace( "/'/", "`", $data->cost );
                    $data->isqty=preg_replace( "/'/", "`", $data->isqty );
                    $data->isamt=preg_replace( "/'/", "`", $data->isamt );
                    
                    if($doc =='SJ2') {
                        Yii::$app->sbccommon->execqry("UPDATE 
                        $table SET itemname='$data->itemname',barcode='$data->barcode', uom='$data->uom',
                        wh='$data->wh_', disc='$data->disc', rem='$data->rem',
                        isamt='$data->isamt', isqty='$data->isqty',
                        amt='$data->amt',iss='$data->iss', ext='$data->ext',
                        void='$data->void',editby='$user',loc='$data->loc',expiry='$data->expiry',
                        editdate=CURRENT_TIMESTAMP,iss2='$data->iss2',isqty2='$data->isqty2' where trno=$trno and line=$line");
                    } else {
                        
                        $qry = "UPDATE $table 
                        SET itemname='$data->itemname',barcode='$data->barcode',
                        uom='$data->uom',wh='$data->wh_', disc='$data->disc',rem='".$data->rem."',
                        isamt='$data->isamt', isqty='$data->isqty',amt='$data->amt',iss='$data->iss',
                        ext='$data->ext',void='$data->void',editby='$user',loc='$data->loc',kgs='$data->kgs',
                        expiry='$data->expiry',editdate=CURRENT_TIMESTAMP,itemcomm='$data->itemcomm',
                        itemhandling='$data->itemhandling',
                        agent='$data->agent' 
                        where trno=$trno and line=$line";

                        Yii::$app->sbccommon->execqry($qry);
                    }//end if

                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL': break;
                        default:
                            if($doc=='SJ' || $doc == 'SJ2'){
                                $head_client = Lastock::getheadclient($trno, 'SJ');
                                $strCRlimitMsg = Client::GetCRLimit($head_client['client']);
                                if($strCRlimitMsg!=''){
                                    Yii::$app->sbccommon->execqry("update $table set isqty=0,iss=0,ext=0,editby='EXCEED_CRLT',
                                    editdate=CURRENT_TIMESTAMP where trno=$trno and line=$line" );
                                    $data->iss=0;
                                    Yii::$app->session['warning'] = Yii::$app->session['warning'].'</br>'.$strCRlimitMsg;
                                }
                            }
                        break;
                    }

                break;
                }

                case 'CM':{
                        $data->disc=preg_replace( "/'/", "`", $data->disc );
                        $data->rem=preg_replace( "/'/", "`", $data->rem );
                        $data->cost=preg_replace( "/'/", "`", $data->cost );
                        $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
                        $data->isamt=preg_replace( "/'/", "`", $data->isamt );
                        Yii::$app->sbccommon->execqry("UPDATE $table
                        SET itemname='$data->itemname',barcode='$data->barcode',
                        uom='$data->uom',wh='$data->wh_', disc='$data->disc',
                        rem='$data->rem',isamt='$data->isamt', rrqty='$data->rrqty',
                        amt='$data->amt',cost='$data->cost', qty='$data->qty', ext='$data->ext',
                        void='0',editby='$user',loc='$data->loc',expiry='$data->expiry',kgs='$data->kgs',
                        editdate=CURRENT_TIMESTAMP where trno='$trno' and line='$line'");
                         break;
                     }

                case 'AJ': case "IS": case 'PK':{
                        $data->disc=preg_replace( "/'/", "`", $data->disc );
                        $data->rem=preg_replace( "/'/", "`", $data->rem );
                        $data->cost=preg_replace( "/'/", "`", $data->cost );
                        $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
                        $data->rrcost=preg_replace( "/'/", "`", $data->rrcost );
                        $data->iss=preg_replace( "/'/", "`", $data->iss );

                        Yii::$app->sbccommon->execqry("UPDATE $table 
                        SET itemname='$data->itemname',barcode='$data->barcode',
                        uom='$data->uom', wh='$data->wh_', disc='$data->disc',
                        rem='$data->rem',rrcost='$data->rrcost', rrqty='$data->rrqty',
                        iss='$data->iss',cost='$data->cost', qty='$data->qty',
                        ext='$data->ext',void='$data->void',editby='$user',
                        loc='$data->loc',expiry='$data->expiry',ref='$data->ref',kgs='$data->kgs',
                        editdate=CURRENT_TIMESTAMP where trno='$trno' and line='$line'");
                        break;
                }//end PK

                case 'TS':case 'PU':{  
                    $data->disc=preg_replace( "/'/", "`", $data->disc );
                    $data->rem=preg_replace( "/'/", "`", $data->rem );
                    $data->cost=preg_replace( "/'/", "`", $data->cost );
                    $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
                    $data->rrcost=preg_replace( "/'/", "`", $data->rrcost );
                    $data->iss=preg_replace( "/'/", "`", $data->iss );

                    Yii::$app->sbccommon->execqry("UPDATE $table
                    SET itemname='$data->itemname',barcode='$data->barcode',
                    uom='$data->uom',wh='$data->wh_', disc='$data->disc', rem='$data->rem',
                    isamt='$data->isamt',isqty='$data->isqty',iss='$data->iss',amt = '$data->amt',
                    ext='$data->ext',loc='$data->loc',loc2='$data->loc2',kgs='$data->kgs',
                    expiry='$data->expiry',void='$data->void',editby='$user',
                    editdate=CURRENT_TIMESTAMP where trno='$trno' and line='$line'");
                break;
                }
             }            
               

            if($data->iss != 0){
                Lastock::deletecosting_($data->barcode, $trno, $line);
                   if(Common::getcompanyid()==3){
                       $cost="0";
                   } else {
                      $cost=Lastock::computecosting($data->barcode, $data->wh_,$data->loc,$data->expiry, $trno, $line, $data->iss, $doc);
                   }//end if

                    if($cost!=-1){
                        Yii::$app->sbccommon->execqry("update $table set cost=$cost where trno=$trno and line=$line");
                    }elseif ($cost==-1){

                             Yii::$app->sbccommon->execqry("update $table set rrqty=0,isqty=0,iss=0,ext=0, 
                                editby='OUT_STOCK',editdate=CURRENT_TIMESTAMP where  trno=$trno and line=$line");
                                $message=$message.'Out of Stock. Pls check your quantity...';

                            $data->rrqty=0;
                            $data->isqty=0;
                            $data->isqty2=0;
                            $data->qty=0;
                            $data->iss=0;
                            $data->iss2=0;
                            $data->ext=0;

                            Log::writelog($doc,$trno,'OUT OF STOCK','['.$data->barcode.'] [Line: '.$line.']',Yii::$app->session['loggeduser']['username']);
                    }//end if
                }else{
                    switch ($doc) {
                        case 'SJ':case 'DM':case 'AJ':case 'TS':case 'PU':case "MI": case 'SJ2':
                             Lastock::deletecosting_($data->barcode, $trno, $line);
                        break;
                    }//end if
                }//end if

                if(strlen($data->refx)!=0 && $data->refx!=0){
                    if(!Postock::setserveditems($data->linex,$data->refx,$doc)){
                        Postock::resetQuantity($line, $trno, $doc);
                        Postock::setserveditems($data->linex, $data->refx,$doc);
                        Lastock::deletecosting($trno, $line);

                        Yii::$app->sbccommon->execqry("update $table set rrqty=0,isqty=0,qty=0,iss=0,ext=0, editby='ODR_EXCEED',
                        editdate=CURRENT_TIMESTAMP where  trno=$trno and line=$line" );
                        $message = $message . 'Quantity more than ordered.';

                        Log::writelog($doc,$trno,'QUANTITY MORE THAN ORDERED','['.$data->barcode.'] [Line: '.$line.']',Yii::$app->session['loggeduser']['username']); 
                    }//end if                               
                }//end if

            $newdata = Lastock::openstockline($doc,$trno, $line);
            $grandtotal = Lastock::getgrandtotal($trno, $doc);
            if(!empty($newdata)){
                $barcode = $newdata[0]['barcode'];
                $itemid = $newdata[0]['itemid'];
                $brand = $newdata[0]['brand'];
                $model = $newdata[0]['model'];
                $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $isqty = number_format($newdata[0]['isqty'], Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $isqty2 = number_format($newdata[0]['isqty2'], Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $itemname = $newdata[0]['itemname'];
                $uom = $newdata[0]['uom'];
                $wh_ = $newdata[0]['whcode'];
                $whname = $newdata[0]['wh'];
                $qty = number_format($newdata[0]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $iss = number_format($newdata[0]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $iss2 = number_format($newdata[0]['iss2'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                $rrcost = number_format($newdata[0]['rrcost'], Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $isamt = number_format($newdata[0]['isamt'], Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $cost = number_format($newdata[0]['cost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $amt = number_format($newdata[0]['amt'], Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                $ext = number_format($newdata[0]['ext'], Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $disc = $newdata[0]['disc'];
                $loc = $newdata[0]['loc'];
                if($doc == "TS"){
                    $loc2 = $newdata[0]['loc2'];
                }else{
                    $loc2 = "";
                }
                $expiry = $newdata[0]['expiry'];
                $rem = $newdata[0]['rem'];
                $ref = $newdata[0]['ref'];
                $refx = $newdata[0]['refx'];
                $linex = $newdata[0]['linex'];
                $comm = number_format($newdata[0]['comm'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $icomm = number_format($newdata[0]['icomm'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $markup = number_format($newdata[0]['markup'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $itemcount = $grandtotal[0]['itemcount'];

                $totalbill = $grandtotal[0]['grandtotal'];
                $totalkilo = $grandtotal[0]['kilototal'];

                if($doc == 'RR') {
                    $totalforex = $grandtotal[0]['forexgrandtotal'];
                } else {
                    $totalforex = 0;
                }

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'CANUMAY':
                        if($doc == "RR"){
                            $msako = $newdata[0]['msako'];
                            $tsako = $newdata[0]['tsako'];
                        }else{
                            $msako = "";
                            $tsako = "";
                        }//end if
                    break;

                    default:
                        $msako = "";
                        $tsako = "";
                    break;
                }//end switch

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        if($doc == "SJ"){
                            $agent = $newdata[0]['agent'];
                            
                        }else{
                            $agent ='';
                        }//end if
                    break;

                    default:
                         $agent ='';
                    break;
                }//end switch

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'TENPLUS':
                        $itemhandling = $newdata[0]['itemhandling'];
                        $itemcomm = $newdata[0]['itemcomm'];
                    break;
                    
                    default:
                        $itemhandling = '';
                        $itemcomm = '';
                    break;
                }//END SWITCH

                if($doc=='SJ'){
                    //will check below cost with kinggeorge setting or default setting
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'KINGGEORGE':
                            $isamt2 = str_replace(',','', $isamt);
                            $kgs = str_replace(',','', $newdata[0]['kgs']);
                            $isamt2 = floatval($isamt2) * floatval($kgs);

                            $pasa = Yii::$app->backend->isbelowcost($isamt2,$cost,$line,$barcode);

                            if($pasa['status']) {
                                $message = $message.' '.$pasa['msg'];
                                Log::writelog($doc,$trno,'ITEM BELOW COST','['.$barcode.'] [Line: '.$line.'] [Amount: '.$isamt2.', Cost: '.$cost.']',Yii::$app->session['loggeduser']['username']);
                            }//end if
                        break;
                        
                        default:
                            $isamt = str_replace(',','', $isamt);
                            $pasa = Yii::$app->backend->isbelowcost($isamt,$cost,$line,$barcode);

                            if($pasa['status']) {
                                $message = $message.' '.$pasa['msg'];
                                Log::writelog($doc,$trno,'ITEM BELOW COST','['.$barcode.'] [Line: '.$line.'] [Amount: '.$isamt.', Cost: '.$cost.']',Yii::$app->session['loggeduser']['username']);
                            }//end if
                        break;
                    }//END SWITCH

                    if($pasa['status']) {
                        $message = $message.' '.$pasa['msg'];
                        Log::writelog($doc,$trno,'ITEM BELOW COST','['.$barcode.'] [Line: '.$line.'] [Amount: '.$isamt.', Cost: '.$cost.']',Yii::$app->session['loggeduser']['username']);
                    }
                }

                Yii::$app->session['warning']=Yii::$app->session['warning'].$message;
                $status = Yii::$app->session['warning'];
                Yii::$app->session['warning']='';                

                $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'barcode' => $barcode, 'rrqty' => $rrqty,'isqty'=>$isqty,
                'itemname' => $itemname, 'uom' => $uom, 'whcode' => $wh_,'wh' => $whname,'rrcost'=>$rrcost, 'isamt'=>$isamt,'qty' => $qty,
                'iss' => $iss,'cost' => $cost,'amt'=>$amt,'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'loc' => $loc,
                'loc2' => $loc2,'expiry' => $expiry, 'rem' => $rem,'ref' => $ref,'comm' => $comm,'icomm' => $icomm,
                'messages'=>Yii::$app->session['message' . $doc],'refx'=>$refx,'linex'=>$linex,'itemcount'=>$itemcount,
                'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'msg'=>$status,'itemid'=>$itemid,'iss2'=>$iss2,
                'isqty2'=>$isqty2,'templine'=>$data->templine,'istransposted'=>false,'status'=>'','totalforex'=>$totalforex,'msako'=>$msako,'tsako'=>$tsako,
                'itemhandling'=>$itemhandling,'itemcomm'=>$itemcomm,'agent'=>$agent,'brand'=>$brand,'model'=>$model);
                
                return $passjson;
            }else{
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ["msg"=>"ERROR RETRIEVAL",'status'=>false];
                //echo json_encode(array("msg"=>"ERROR RETRIEVAL",'status'=>false));
            }//end else

        }//END UPDATE


        
        public static function deletecosting($trno,$line){
            Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
        }//end delete costing

        public static function getLastLine($doc,$trno){
            $table=Common::localstock($doc);
            $stocks=Yii::$app->sbccommon->opentable("SELECT line FROM $table where trno ='$trno' order by line desc limit 1");
            if ($stocks==null){
                return 0;
            }else{
                return $stocks[0]['line'];
            }
        }//END UPDATE STOCK 

        public static function deletestocks($doc,$trno, $line){
            $table=Common::localstock($doc);
            switch ($doc){
                case 'RR': case 'SJ': case 'DM': case 'CM': case 'PO': case 'TS': case 'SP':
                    $openstockdata = Yii::$app->sbccommon->opentable("select barcode,itemname from ".$table." where trno=".$trno." and line=".$line);
                    
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'MLCP':
                            if($doc == 'SJ'){
                                $qrygettervalue = "select iss from lastock where trno = " . $trno . " and line = " . $line;
                                $iss = Yii::$app->sbccommon->datareader($qrygettervalue);
                            }else{
                                $iss = 0;
                            }//end if
                        break;

                        default:
                            $iss = 0;
                        break;
                    }//end switch
                    
                    $stocks=Yii::$app->sbccommon->opentable("select refx,linex,isfromjo from ".$table." where trno =".$trno." and line=".$line);                     
                    $removestatus = Yii::$app->sbccommon->execqry("delete from ".$table." where trno=".$trno." and line=".$line);

                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'MLCP':
                            switch ($doc) {
                                case 'SJ':
                                    if($stocks[0]['isfromjo']){
                                        $servedupdater = "update hjbstock set qa = qa - " .$iss . " where trno = " . $stocks[0]['refx'] . " and line = " . $stocks[0]['linex'];
                                        $status = Yii::$app->sbccommon->execqry($servedupdater);
                                    }else{
                                        if(!empty($stocks)){
                                            if($stocks[0]['refx']!=0){
                                               Postock::setserveditems($stocks[0]['linex'], $stocks[0]['refx'],$doc);
                                            }//END IF $STOCK[0]
                                        } //END IF EMPTY                 
                                    }//end if
                                break;

                                default:
                                    if(!empty($stocks)){
                                        if($stocks[0]['refx']!=0){
                                           Postock::setserveditems($stocks[0]['linex'], $stocks[0]['refx'],$doc);
                                        }//END IF $STOCK[0]
                                    } //END IF EMPTY                 
                                break;
                            }//END SWITHC
                        break;
                        
                        default:
                            if(!empty($stocks)){
                                if($stocks[0]['refx']!=0){
                                   Postock::setserveditems($stocks[0]['linex'], $stocks[0]['refx'],$doc);
                                }//END IF $STOCK[0]
                            } //END IF EMPTY                 
                        break;
                    }//END if
                break;

                case 'SP':
                    $openstockdata = Yii::$app->sbccommon->opentable("select barcode,itemname from spstock where trno=".$trno." and line=".$line);
                    $removestatus = Yii::$app->sbccommon->execqry("delete from spstock where sptrno=".$trno." and line=".$line);
                break;
                
                default:
                    $openstockdata = Yii::$app->sbccommon->opentable("select barcode,itemname from ".$table." where trno=".$trno." and line=".$line);
                    $removestatus = Yii::$app->sbccommon->execqry("delete from ".$table." where trno=".$trno." and line=".$line);
                break;
            }//END SWITCH DOC

            if(!empty($openstockdata)) {
                if($removestatus){
                    Log::writelog($doc,$trno,'REMOVED ITEM','['.$openstockdata[0]['barcode'].'] [Line: '.$line.'] ' . $openstockdata[0]['itemname'],Yii::$app->session['loggeduser']['username']);
                }else{
                    Log::writelog($doc,$trno,'ERROR REMOVING ITEM','['.$openstockdata[0]['barcode'].'] [Line: '.$line.'] ' . $openstockdata[0]['itemname'],Yii::$app->session['loggeduser']['username']);
                }//end if
            }//end if for logging


            switch ($doc){
                case 'DM':
                case 'AJ':
                case 'MI':    
                case 'CA':
                case 'RR':
                case 'SJ':{
                    Yii::$app->sbccommon->execqry("DELETE from costing where trno='$trno' and line='$line'");
                    break;
                }
                case 'TS': case 'PU':{
                    $thisline=$line+1;
                    Yii::$app->sbccommon->execqry("DELETE from $table where tstrno='$trno' and tsline='$line'");
                    Yii::$app->sbccommon->execqry("DELETE from costing where trno='$trno' and line='$line'");
                    break;
                }
            }          
            
        }//END DELETE STOCKS


        public static function getgrandtotal($trno,$doc){
            $table=Common::localstock($doc);
            switch($doc){
                case 'AR':case'AP':case 'PV':case'CV':case'CR':case'GJ':case'DS':
                    return Yii::$app->sbccommon->opentable("
                    select count(trno) as itemcount,
                    round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                    FROM ladetail where trno ='$trno' group by trno
                    UNION ALL
                    SELECT count(trno) as itemcount,
                    round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                    FROM gldetail where trno ='$trno' group by trno
                    UNION ALL
                    SELECT count(trno) as itemcount,
                    round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                    FROM hgldetail where trno ='$trno' group by trno");
                break;

                case'TS':case'PU':
                    return Yii::$app->sbccommon->opentable("
                    select trno, barcode,sum(isqty) as kilototal,count(*) as itemcount,
                    round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                    FROM $table where trno ='$trno' and tstrno=0 group by trno
                    UNION ALL
                    SELECT trno, itemid,sum(isqty) as kilototal,count(*) as itemcount,
                    round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                    FROM glstock where trno ='$trno' and tstrno=0 group by trno");
                break;

                default:
                    switch ($doc) { //to determine what to sum up for total kilo
                        case 'IS': case 'RR': case 'CM': case 'AJ': case 'PK': case 'SV':
                            $qty = 'rrqty';
                        break;
                        case 'MI': case 'MX': case 'DM': case 'SJ': case 'TS': case 'SJ2': case 'SJ3': case 'SI':
                            $qty = 'isqty';
                        break;
                    }//end switch case doc
                    
                    switch ($doc) {
                        case 'SI':
                            $qry = "select head.invtagging as trno,stock.itemid,
                            round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                            count(*) as itemcount,round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                            FROM glstock as stock 
                            left join glhead as head on head.trno = stock.trno 
                            where head.invtagging ='$trno'";
                        break;

                        case 'SV':
                            $qry = "select stock.sptrno as trno,stock.barcode,
                            round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                            count(*) as itemcount,
                            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                            FROM spstock as stock where stock.sptrno ='$trno' group by sptrno
                            UNION ALL
                            select stock.sptrno as trno,stock.barcode,
                            round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                            count(*) as itemcount,
                            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                            FROM hspstock as stock where stock.sptrno ='$trno' group by sptrno";
                        break;

                        default:
                            $qry = "select trno,barcode,
                            round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                            count(*) as itemcount,
                            round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                            FROM $table where trno ='$trno' group by trno
                            UNION ALL
                            SELECT trno, itemid,
                            round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                            count(*) as itemcount,
                            round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                            FROM glstock where trno ='$trno' group by trno";
                        break;
                    }//end switch case doc

                    $garray =  Yii::$app->sbccommon->opentable($qry);
                    
                    if(!empty($garray)){
                        switch ($doc) {
                            case 'RR':
                                if(empty($garray)){
                                    $garray[0]['forexgrandtotal'] = 0;
                                } else {
                                    $qryforex = "select forex from lahead where trno = ".$trno." union all 
                                                 select forex from glhead where trno = ".$trno."";
                                    $forex = Yii::$app->sbccommon->datareader($qryforex);
                                    $forextgtotal = Yii::$app->backend->convertForex($forex,$garray[0]['grandtotal'],1);
                                    $gtotal = $garray[0]['grandtotal'];
                                    $garray[0]['grandtotal'] = $forextgtotal;
                                    $garray[0]['forexgrandtotal'] = $gtotal;
                                }//end if
                            break;
                            default:
                                $garray[0]['forexgrandtotal'] = 0;
                            break;
                        }//END SWITCH CASE

                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                switch ($doc) {
                                    case 'SJ':
                                        if(!empty($garray)){
                                            $garray[0]['totalcbm'] = Yii::$app->backend->getGrandTotalCBM($doc,$trno);
                                            $garray[0]['totaltonnage'] = Yii::$app->backend->getGrandTotalTons($doc,$trno);
                                        }//end if !empty garray - JAOSKI POGI
                                    break;
                                }//END SWITCH CASE
                            break;
                        }//end switch
                    }//end if
                    return $garray;
                break;
            }
        }
        

        public static function getheadclient($trno,$doc){
            $lhead=Common::localhead($doc);
            //$glhead=Common::glhead();
            //$hglhead=Common::hglhead();
            $data= Yii::$app->sbccommon->opentable("
                    select head.client as client,head.clientname as clientname from ".$lhead." as head
                    where head.trno=$trno and head.doc='".$doc."'
                    union all
                    select client.client,client.clientname from glhead
                    left join client on client.clientid=glhead.clientid where glhead.trno=".$trno." and glhead.doc='".$doc."'
                    union all
                    select client.client,client.clientname from hglhead
                    left join client on client.clientid=hglhead.clientid where hglhead.trno=".$trno." and hglhead.doc='".$doc."'
                    ");
            if($data!=null)
                {
                return $data[0];
                }
            else
                {
                return array('client'=>"",'clientname'=>"");
                }
        }
        
        public static function getheadwarehouse($trno,$doc){
            $lhead=Common::localhead($doc);
            //$glhead=Common::glhead();
            //$hglhead=Common::hglhead();
            $data= Yii::$app->sbccommon->opentable("
                    select $lhead.wh as whcode,client.clientname as wh from $lhead
                    left join client on client.client=$lhead.wh where $lhead.trno=$trno and $lhead.doc='$doc'
                    union all
                    select client.client as whcode,client.clientname as wh from glhead
                    left join client on client.clientid=glhead.whid where glhead.trno=$trno and glhead.doc='$doc'
                    union all
                    select client.client as whcode,client.clientname as wh from hglhead
                    left join client on client.clientid=hglhead.whid where hglhead.trno=$trno and hglhead.doc='$doc'
                    ");
            if($data!=null)
                {
                return $data[0];
                }
            else
                {
                return array('whcode'=>"",'wh'=>"");
                }
        }
        
}