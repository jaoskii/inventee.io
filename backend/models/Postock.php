<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Log;

use yii\base\ErrorException;

use yii\web\Response;

class Postock extends Model
{
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
    public $tsqa;
    public $ref;
    public $encodeddate;
    public $bal;
    public $wh_;
    public $whname;
    public $grandtotal;
    public $itemcount;
    public $field_focus;
    public $iss_;
    public $action;
    public $isqty;
    public $iss;
    public $isamt;
    public $amt;
    public $addremarks;
    public $encodedby;
    public $uomfactor;
    
    public $olddisc;
    
    
    public $sku;
    public $olduom;
    public $loc;
    
    public $comm;
    public $icomm;

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
    public $editisqty;
    public $editiss;

    public $isecomm = 0;
    public $expiry; 
    public $templine;

    // XANDABELS
    public $totaltonnage = 0;
    public $totalcbm = 0;

    public $iscomponent;
    public $outputid;
    // END

    public $itemcomm;
    public $itemhandling;

    public $docno;
    public $customer_name;
    public $customer_code;
    public $agent;
    public $shipfee;
    public $cutoff;
    public $postdate;

    public $rrcost2;
    public $cost2;
    public $ext2;
    public $disc2;
    public $kgs;

    public $handlingfee;

    //WTODO: [KIM][2019.11.28][add item]
    public $item;

    public function rules(){
        
            return array(
            array('void', 'numerical', 'integerOnly'=>true),
            array('refx,line,linex', 'length', 'max'=>10),
            array('barcode,loc', 'length', 'max'=>30),
            array('itemname,wh,keyword,addremarks', 'length', 'max'=>500),
            array('olduom,uom,field_focus,wh_', 'length', 'max'=>15),
            array('disc, rem', 'length', 'max'=>40),
                        array('sku,action', 'length', 'max'=>45),
            array('rrcost, rrqty, cost, qty, ext, qa,tsqa,iss_,isamt,amt,isqty,iss', 'length', 'max'=>19),
                        //array('cost', 'required'),
            array('ref', 'length', 'max'=>50),
            array('encodeddate', 'safe'),
            array('trno, line, barcode, itemname, uom, wh, disc, rem, cost, qty, rrcost, rrqty, ext, void, refx, ref, EncodedDate', 'safe', 'on'=>'search'),
        );
    }
    public function attributeLabels(){

        return array(
            'trno' => 'Tr No',
                        'sku' => 'SKU',
            'line' => 'Line',
            'barcode' => 'Barcode',
            'itemname' => 'Item Name',
        );
    }
        public function getPrimaryKey(){

            return array('TrNo','LINE');
        }




public static function getsummarystock($doc,$trno){
            $table=Common::localstock($doc);
            $htable=Common::localhstock($doc);
            $sql="";

            switch($doc){
                // SALON MODIFICATION
                // JAOPOGI
                case 'TR':{
                    $sql=" select 0 as rrqty, 0 as qty, 0 as amt,htrhead.docno,item.itemid,stock.trno, stock.line,stock.refx,
                    stock.linex, stock.barcode, 
                    stock.itemname, stock.uom, stock.cost, stock.qty as iss,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,stock.disc, stock.void, 
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.ref,
                    stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
                    stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM htrhead left join ".$htable." as stock on stock.trno=htrhead.trno 
                    left join item on item.barcode=stock.barcode 
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh 
                    where stock.trno = '".$trno."' and stock.void <> 1 and stock.qty>stock.qa order by stock.line";
                    return Yii::$app->sbccommon->opentable($sql);                        
                    break;                    
                }
                // END POGI
                case 'PO':{
                    $sql=" select hpohead.docno,item.itemid,stock.trno, stock.line,stock.refx,
                    stock.linex, stock.barcode, 
                    stock.itemname, stock.uom, stock.cost, stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,stock.disc, stock.void, 
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.ref,
                    stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
                    stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM hpohead left join ".$htable." as stock on stock.trno=hpohead.trno 
                    left join item on item.barcode=stock.barcode 
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh 
                    where stock.trno = '".$trno."' and stock.void <> 1 and stock.qty>stock.qa order by stock.line";
                    return Yii::$app->sbccommon->opentable($sql);                        
                    break;                    
                }

                case 'pscheme': case 'PS':{
                    return Yii::$app->sbccommon->opentable("
                    select hpschemehead.docno,item.itemid,stock.trno, stock.line, stock.barcode, stock.itemname, 
                    stock.uom, stock.amt, stock.iss as iss,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, 
                    round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    stock.wh as whcode,warehouse.clientname as wh,stock.loc,case when 
                    ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM hpschemehead left join ".$htable." as stock on stock.trno=hpschemehead.trno left join item on item.barcode=
                    stock.barcode left join uom on uom.itemid=item.itemid and 
                    uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno =
                    '".$trno."' and stock.void <> 1 and stock.iss>stock.qa order by stock.line");
                    break;
                }

                case 'PR':{
                    $sql=" select hprhead.docno,item.itemid,stock.trno, stock.line,stock.refx, stock.linex, 
                    stock.barcode, stock.itemname, stock.uom, stock.cost, stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.ref,
                    stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
                    stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM hprhead 
                    left join ".$htable." as stock on stock.trno=hprhead.trno 
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh
                    where stock.trno = '".$trno."' and stock.void <> 1 and stock.qty>stock.qa order by stock.line";
                    return Yii::$app->sbccommon->opentable($sql);                        
                    break;                    
                }

                case 'QA':{ 
                    return Yii::$app->sbccommon->opentable("
                    select hqahead.docno,item.itemid,stock.trno, stock.line, stock.barcode, stock.itemname, 
                    stock.uom, stock.amt, stock.iss as iss,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, 
                    round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    stock.wh as whcode,warehouse.clientname as wh,stock.loc,case when 
                    ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM hqahead left join ".$htable." as stock on stock.trno=hqahead.trno left join item on item.barcode=
                    stock.barcode left join uom on uom.itemid=item.itemid and 
                    uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno =
                    '".$trno."' and stock.void <> 1 and stock.iss>stock.qa order by stock.line");
                    break;
                }

                case 'SO':{
                    return Yii::$app->sbccommon->opentable("
                    select hsohead.docno,item.itemid,stock.trno, stock.line, stock.barcode, stock.itemname, 
                    stock.uom, stock.amt, stock.iss as iss,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, 
                    round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    stock.wh as whcode,warehouse.clientname as wh,stock.loc,case when 
                    ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM hsohead left join ".$htable." as stock on stock.trno=hsohead.trno left join item on item.barcode=
                    stock.barcode left join uom on uom.itemid=item.itemid and 
                    uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno =
                    '".$trno."' and stock.void <> 1 and stock.iss>stock.qa order by stock.line");
                    break;
                }

                case 'RR':{
                    return Yii::$app->sbccommon->opentable("
                    select head.docno,item.itemid,stock.trno, stock.line, item.barcode, item.itemname, 
                    item.uom, stock.cost, stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, 
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    warehouse.client as whcode,warehouse.clientname as wh,stock.loc,case when 
                    ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=
                    stock.itemid left join uom on uom.itemid=item.itemid and 
                    uom.uom=stock.uom left join client as warehouse on warehouse.clientid=stock.whid where head.doc='RR' 
                    and head.trno ='".$trno."' and stock.qty>stock.qa order by stock.line");
                    break;
                }
                case 'SJ':{
                    return Yii::$app->sbccommon->opentable("
                    select head.docno,item.itemid,stock.trno, stock.line, item.barcode, item.itemname, 
                    item.uom, 
                    stock.amt, stock.iss as iss,
                    round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt, 
                    round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end) * stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                    uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    warehouse.client as whcode,warehouse.clientname as wh,stock.loc,case when 
                    ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor 
                    FROM glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=
                    stock.itemid left join uom on uom.itemid=item.itemid and 
                    uom.uom=stock.uom left join client as warehouse on warehouse.clientid=stock.whid where head.doc='SJ' 
                    and head.trno ='".$trno."' and stock.iss>stock.qa order by stock.line");
                    break;
                }
             }//switch($doc)   
}



        public static function getdetailstock($doc,$trno,$line){
            try {
                $htable=Common::localhstock($doc);
                switch($doc){
                    case 'TR':
                        $amtfield = "isamt";
                        $sql = "
                        select stock.trno,0 as rrqty, 0 as qty, 0 as amt,htrhead.docno,item.itemid,stock.trno as refx, 0 as line, stock.line as linex, stock.barcode, htrhead.docno as ref, 
                        stock.itemname, stock.uom, stock.cost, (stock.qty-stock.qa) as iss,
                        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
                        uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                        left(stock.encodeddate,10) as encodeddate, stock.disc, stock.void,
                        round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        round((stock.qty-stock.qa) / case when ifnull(uom.factor,0) = 0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                        stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
                        stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor,
                        '' as expiry,htrhead.trpricegrp,rmas.route_name as route,rmas.route_id as routeid,
                        tragent.client as agent,tragent.clientname as agentname
                        FROM htrhead 
                        left join ".$htable." as stock on stock.trno=htrhead.trno 
                        left join item on item.barcode=stock.barcode 
                        left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                        left join client as warehouse on warehouse.client=stock.wh
                        left join client as tragent on tragent.client=htrhead.agent
                        left join route_masterfile as rmas on rmas.route_id = htrhead.trroute
                        where stock.trno = '".$trno."' and stock.void <> 1 and stock.line='".$line."' and stock.qty>stock.qa";

                        $data=Yii::$app->sbccommon->opentable($sql);   
                        
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                if(!empty($data)){
                                    $trp = $data[0]['trpricegrp'];
                                    $trr = $data[0]['routeid'];
                                    $trrname = $data[0]['route'];
                                    $trag = $data[0]['agent'];   
                                    $tragname = $data[0]['agentname'];   
                                } else {
                                    $trp = "";
                                    $trr = 0;
                                    $trrname = "";
                                    $trag = "";
                                    $tragname = "";
                                }//end if empty $ss1

                                $data[0]['agent'] = $trag;
                                $data[0]['agentname'] = $tragname;
                                $data[0]['routeid'] = $trr;
                                $data[0]['route'] = $trrname;
                                $data[0]['trpricegrp'] = $trp;
                            break;
                        }
                    break;

                    case 'PO':
                        $amtfield = 'rrcost';
                        $data = Yii::$app->sbccommon->opentable("
                        select hpohead.docno, hpohead.docno as ref,item.itemid,stock.trno, 0 as line, stock.trno as refx, 
                        stock.line as linex, stock.barcode, 
                        stock.itemname, stock.uom, stock.cost,(stock.qty-stock.qa) as qty,
                        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                        round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left(stock.encodeddate,10) as encodeddate, stock.disc, stock.void,
                        round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom
                        .factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
                        stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor , '' as expiry
                        FROM hpohead left join ".$htable." as stock on stock.trno=hpohead.trno left join item on item.barcode=
                        stock.barcode left join uom on uom.itemid=item.itemid and 
                        uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno =
                        '".$trno."' and stock.line='".$line."' and stock.qty>stock.qa");             
                    break;

                    case 'PR':
                        $amtfield = 'rrcost';
                        $data = Yii::$app->sbccommon->opentable("
                        select hprhead.docno, item.itemid,stock.trno, 0 as line,stock.trno as refx, 
                        hprhead.docno as ref, stock.line as linex, stock.barcode, 
                        stock.itemname, stock.uom, stock.cost,(stock.qty-stock.qa) as isqty,
                        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left(stock.encodeddate,10) as encodeddate,
                        stock.disc, stock.void, 
                        round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                        stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
                        stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor , '' as expiry
                        FROM hprhead left join ".$htable." as stock on stock.trno=hprhead.trno left join item on item.barcode=
                        stock.barcode left join uom on uom.itemid=item.itemid and 
                        uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno =
                        '".$trno."' and stock.line='".$line."' and stock.qty>stock.qa");           
                    break;
                     case 'QA':
                        $amtfield = "isamt";
                        $sql = "
                        select hqahead.docno,item.itemid,stock.trno, 0 as line, stock.barcode, stock.itemname, hqahead.docno as ref, 
                        stock.uom, stock.amt,(stock.iss-stock.qa) as iss,
                        round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0) = 0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                        round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left(stock.encodeddate,10) as encodeddate,
                        stock.disc, stock.void, round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                        uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        stock.wh as whcode,warehouse.clientname as wh,stock.loc,case when 
                        ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor ,stock.expiry,stock.rem, stock.trno as refx, stock.line as linex
                        FROM hqahead 
                        left join ".$htable." as stock on stock.trno=hqahead.trno 
                        left join item on item.barcode=
                        stock.barcode left join uom on uom.itemid=item.itemid and 
                        uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno =
                        '".$trno."' and stock.line='".$line."' and stock.iss>stock.qa";
                        
                        $data = Yii::$app->sbccommon->opentable($sql);
                    break;

                    case 'SO': case 'pscheme': case 'PS':
                        $amtfield = "isamt";
                        $sql = "
                        select hsohead.docno,item.itemid,stock.trno, 0 as line, stock.barcode, stock.itemname, hsohead.docno as ref, 
                        stock.uom, stock.amt,(stock.iss-stock.qa) as iss,
                        round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0) = 0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                        round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left(stock.encodeddate,10) as encodeddate,
                        stock.disc, stock.void, round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                        uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        stock.wh as whcode,warehouse.clientname as wh,stock.loc,case when 
                        ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor ,stock.expiry,stock.rem, stock.trno as refx, stock.line as linex
                        FROM hsohead 
                        left join ".$htable." as stock on stock.trno=hsohead.trno 
                        left join item on item.barcode=
                        stock.barcode left join uom on uom.itemid=item.itemid and 
                        uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno =
                        '".$trno."' and stock.line='".$line."' and stock.iss>stock.qa";
                        
                        $data = Yii::$app->sbccommon->opentable($sql);
                    break;

                    case 'RR':
                        $amtfield = "isamt";
                        $data = Yii::$app->sbccommon->opentable("
                        select head.docno, head.docno as ref,item.itemid,stock.trno, stock.trno as refx, 
                        stock.line as linex, 0 as line, item.barcode, stock.itemname,stock.uom, stock.cost as amt,
                        ((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end) as isqty,
                        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                        round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left(stock.encodeddate,10) as encodeddate,
                        stock.disc, stock.void,
                        round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,(stock.qty-stock.qa) as iss,
                        warehouse.client as whcode,warehouse.clientname as wh,stock.loc,case when 
                        ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor ,stock.expiry
                        FROM glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=
                        stock.itemid left join uom on uom.itemid=item.itemid and 
                        uom.uom=stock.uom left join client as warehouse on warehouse.clientid=stock.whid where head.doc='RR' 
                        and stock.trno ='".$trno."' and stock.line='".$line."' and stock.qty>stock.qa");
                    break;
                    
                    case 'SJ':
                        $amtfield = "isamt";
                        $qry = "
                        select head.docno,head.docno as ref, item.itemid,stock.trno, stock.trno as refx, 0 as line, 
                        stock.line as linex, item.barcode, stock.itemname, 
                        stock.uom, round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                        stock.amt,(stock.iss-stock.qa) as qty,
                        round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, stock.cost,
                        left(stock.encodeddate,10) as encodeddate,
                        stock.disc, stock.void, round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else 
                        uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        warehouse.client as whcode,warehouse.clientname as wh,stock.loc,case when 
                        ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor, stock.expiry
                        FROM glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=
                        stock.itemid left join uom on uom.itemid=item.itemid and 
                        uom.uom=stock.uom left join client as warehouse on warehouse.clientid=stock.whid where head.doc='SJ' 
                        and stock.trno ='".$trno."' and stock.line='".$line."' and stock.iss>stock.qa";
                        $data = Yii::$app->sbccommon->opentable($qry);       
                    break;
                 }

                if(!empty($data)){
                    foreach ($data as $key => $value) {
                        $data[$key]['ext'] = Yii::$app->sbccommon->Discount($value[$amtfield],$value['disc']) * $value['qa'];
                    }//end for each
                }//end if ! empty
                
                return $data;
            } catch (ErrorException $e) {
                echo $e;
            }
}//end function

        
    public static function openstock($doc,$trno,$filter){
            $table=Common::localstock($doc);
            $htable=Common::localhstock($doc);
            switch($doc){

                case 'SP':
                    return "select item.brand as brand,mm.model_name as model,
                        '' as tr,item.itemid,$table.trno, $table.line,$table.refx, $table.linex, $table.barcode, $table.itemname,
                        $table.uom, $table.cost, $table.qty as qty,
                        round($table.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round($table.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as rrqty,
                        round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                          round($table.rrcost2,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost2,
                        round($table.cost,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as cost2,
                        round($table.ext2,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext2, 
                        left($table.encodeddate,10) as encodeddate,
                        $table.disc, $table.disc2,$table.void, 
                        round(($table.qty-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $table.ref,$table.wh as whcode,warehouse.clientname as wh,$table.loc,item.brand,$table.rem, ifnull(uom.factor,1) as uomfactor  
                        FROM $table 
                        left join item on item.barcode=$table.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$table.uom left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                        UNION ALL
                        SELECT item.brand as brand,mm.model_name as model,
                            'P' as tr,item.itemid,$htable.trno, $htable.line,$htable.refx, $htable.linex, $htable.barcode, $htable.itemname,
                        $htable.uom, $htable.cost,$htable.qty,
                        round($htable.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round($htable.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                        round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                         round($htable.rrcost2,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost2,
                        round($htable.cost,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as cost2,
                        round($htable.ext2,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext2, 
                        left($htable.encodeddate,10) as encodeddate,
                        $htable.disc,$htable.disc2, $htable.void, round(($htable.qty-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $htable.ref,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,item.brand,$htable.rem, ifnull(uom.factor,1) as uomfactor
                        FROM $htable 
                        left join item on item.barcode=$htable.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'";
                break;

                case 'PO': case 'PI': case 'PD':
                    return "select 
                        item.brand as brand,mm.model_name as model,
                        '' as tr,item.itemid,$table.trno, $table.line,$table.refx, $table.linex, $table.barcode, $table.itemname,
                        $table.uom, $table.cost, $table.qty as qty,
                        round($table.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round($table.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as rrqty,
                        round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left($table.encodeddate,10) as encodeddate,
                        $table.disc, $table.void, 
                        round(($table.qty-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $table.ref,$table.wh as whcode,warehouse.clientname as wh,$table.loc,item.brand,$table.rem, ifnull(uom.factor,1) as uomfactor  
                        FROM $table 
                        left join item on item.barcode=$table.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$table.uom left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                        UNION ALL
                        SELECT 
                            item.brand as brand,mm.model_name as model,
                            'P' as tr,item.itemid,$htable.trno, $htable.line,$htable.refx, $htable.linex, $htable.barcode, $htable.itemname,
                        $htable.uom, $htable.cost,$htable.qty,
                        round($htable.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round($htable.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                        round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                        left($htable.encodeddate,10) as encodeddate,
                        $htable.disc, $htable.void, round(($htable.qty-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $htable.ref,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,item.brand,$htable.rem, ifnull(uom.factor,1) as uomfactor
                        FROM $htable 
                        left join item on item.barcode=$htable.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom 
                        left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'";
                break;

                case 'QT':
                    return Yii::$app->sbccommon->opentable("
                    select 
                    item.brand as brand,mm.model_name as model,
                    $table.trno, $table.line, $table.barcode, $table.itemname, $table.uom, $table.amt,
                    $table.iss as iss,
                    round($table.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt, 
                    round($table.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as isqty,
                    round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left($table.encodeddate,10) as encodeddate,
                    $table.disc, $table.void, round(($table.iss-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,$table.wh as whcode,warehouse.clientname as wh,$table.loc,$table.addremarks
                    FROM $table 
                    left join item on item.barcode=$table.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$table.uom left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                    UNION ALL
                    SELECT 
                    item.brand as brand,mm.model_name as model,
                    $htable.trno, $htable.line, $htable.barcode, $htable.itemname, $htable.uom, $htable.amt,
                    $htable.iss,
                    round($htable.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt, 
                    round($htable.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty, 
                    round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, left($htable.encodeddate,10) as encodeddate,
                    $htable.disc, $htable.void, round(($htable.iss-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,$htable.addremarks
                    FROM $htable 
                    left join item on item.barcode=$htable.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'
                    ");
                break;

                case 'JB':
                case 'QA': case'SO': case 'PS': case 'pscheme':
                    return "select item.brand as brand,mm.model_name as model,
                    '' as tr,item.itemid,$table.trno, $table.line, $table.barcode, 
                        $table.itemname, $table.uom, $table.amt,$table.iss as iss,
                        round($table.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round($table.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as isqty, 
                        round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left($table.encodeddate,10) as encodeddate,
                        $table.disc, $table.void, 
                        round(($table.iss-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $table.wh as whcode,warehouse.clientname as wh,$table.loc,$table.expiry,$table.rem,
                        ifnull(uom.factor,1) as uomfactor
                        FROM $table 
                        left join item on item.barcode=$table.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$table.uom 
                        left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                        UNION ALL
                        SELECT item.brand as brand,mm.model_name as model,
                        'P' as tr,item.itemid,$htable.trno, $htable.line, $htable.barcode, $htable.itemname, $htable.uom, $htable.amt, 
                        $htable.iss,
                        round($htable.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                        round($htable.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty, 
                        round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                        left($htable.encodeddate,10) as encodeddate,$htable.disc, $htable.void, 
                        round(($htable.iss-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $htable.wh as whcode,warehouse.clientname as wh,$htable.loc,$htable.expiry,
                        $htable.rem,ifnull(uom.factor,1) as uomfactor
                        FROM $htable 
                        left join item on item.barcode=$htable.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom 
                        left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'";
                break;

                //WTODO: [KIM][2019.11.27][add case for quotation][update query for item]
                 case 'quotation': 
                    return "select item.brand as brand,mm.model_name as model,
                    '' as tr,item.itemid,$table.trno, $table.line, $table.barcode, 
                        $table.itemname, $table.uom, $table.amt,$table.iss as iss,
                        $table.isamt,
                        $table.isqty,
                        $table.ext,
                        left($table.encodeddate,10) as encodeddate,
                        $table.disc, $table.void, 
                        round(($table.iss-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $table.wh as whcode,warehouse.clientname as wh,$table.loc,$table.expiry,$table.rem,
                        ifnull(uom.factor,1) as uomfactor, $table.item
                        FROM $table 
                        left join item on item.barcode=$table.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$table.uom 
                        left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                        UNION ALL
                        SELECT item.brand as brand,mm.model_name as model,
                        'P' as tr,item.itemid,$htable.trno, $htable.line, $htable.barcode, $htable.itemname, $htable.uom, $htable.amt, 
                        $htable.iss,
                        $htable.isamt,
                        $htable.isqty,
                        $htable.ext,
                        left($htable.encodeddate,10) as encodeddate,$htable.disc, $htable.void, 
                        round(($htable.iss-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $htable.wh as whcode,warehouse.clientname as wh,$htable.loc,$htable.expiry,
                        $htable.rem,ifnull(uom.factor,1) as uomfactor, $htable.item
                        FROM $htable 
                        left join item on item.barcode=$htable.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom 
                        left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'";
                break;

                case 'PR':
                   $sql= "select item.brand as brand,mm.model_name as model,
                   '' as tr,item.itemid,$table.trno, $table.line,$table.refx, $table.linex, $table.barcode, $table.itemname,
                        $table.uom, $table.cost, $table.qty as qty,
                        round($table.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round($table.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as rrqty,
                        round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                        left($table.encodeddate,10) as encodeddate,
                        $table.disc, $table.void, 
                        round(($table.qty-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $table.ref,$table.wh as whcode,warehouse.clientname as wh,$table.loc,item.brand,$table.rem, ifnull(uom.factor,1) as uomfactor  
                        FROM $table 
                        left join item on item.barcode=$table.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$table.uom left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                        UNION ALL
                        SELECT item.brand as brand,mm.model_name as model,
                        'P' as tr,item.itemid,$htable.trno, $htable.line,$htable.refx, $htable.linex, $htable.barcode, $htable.itemname,
                        $htable.uom, $htable.cost,$htable.qty,
                        round($htable.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        round($htable.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                        round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                        left($htable.encodeddate,10) as encodeddate,
                        $htable.disc, $htable.void, round(($htable.qty-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        $htable.ref,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,item.brand,$htable.rem, ifnull(uom.factor,1) as uomfactor
                        FROM $htable 
                        left join item on item.barcode=$htable.barcode 
                        left join model_masterfile as mm on mm.model_id = item.model
                        left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'";
                    return $sql;
                break;

                case 'TR': case 'PC':
                    $qry="select item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno, stock.line, stock.barcode, stock.itemname, stock.uom, stock.cost, 
                    stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate, ifnull(uom.factor,1) as uomfactor,
                    stock.disc, stock.void,
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    stock.wh as whcode,warehouse.clientname as wh,stock.rem,stock.ref,stock.loc,stock.expiry
                    FROM ".$table." as stock 
                    left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh where stock.trno ='".$trno."'
                    UNION ALL
                    SELECT item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno, stock.line, stock.barcode, stock.itemname, stock.uom, stock.cost, 
                    stock.qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate, ifnull(uom.factor,1) as uomfactor,
                    stock.disc, stock.void, 
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    stock.wh as whcode,warehouse.clientname as wh,stock.rem,stock.ref,stock.loc,stock.expiry
                    FROM ".$htable." as stock 
                    left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno ='".$trno."'";
                    return $qry;
                break;
            }
            
        }
        
        public static function openstockline($doc,$trno,$line) {
            $table=Common::localstock($doc);
            $htable=Common::localhstock($doc);
            switch($doc){
                case 'SP':
                    $qry = "
                    select 
                    item.brand as brand,mm.model_name as model,item.itemid,stock.ref,stock.trno, stock.line,stock.refx, stock.linex, stock.barcode, 
                    stock.itemname, stock.uom, stock.cost, stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    round(stock.rrcost2,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost2, 
                    round(stock.cost2,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as cost2, 
                    round(stock.ext2,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as ext2,
                     stock.disc2, 

                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,warehouse.clientname as wh,stock.loc,stock.rem,'' as expiry, ifnull(uom.factor,1) as uomfactor 
                    FROM $table as stock
                    left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh where stock.trno ='$trno' 
                    and stock.line ='$line'
                    UNION ALL
                    SELECT 
                    item.brand as brand,mm.model_name as model,item.itemid,stock.ref,stock.trno, stock.line,stock.refx, stock.linex, stock.barcode,
                    stock.itemname, stock.uom, stock.cost,stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    round(stock.rrcost2,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost2, 
                    round(stock.cost2,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as cost2, 
                    round(stock.ext2,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext2,
                     stock.disc2,
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,warehouse.clientname as wh,stock.loc,stock.rem,'' as expiry, ifnull(uom.factor,1) as uomfactor
                    FROM $htable as stock 
                    left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh where stock.trno ='$trno' 
                    and stock.line ='$line'";
                    return Yii::$app->sbccommon->opentable($qry);
                break; // SP

                case 'PO':
                    $qry = "
                    select 
                    item.brand as brand,mm.model_name as model,item.itemid,stock.ref,stock.trno, stock.line,stock.refx, stock.linex, stock.barcode, 
                    stock.itemname, stock.uom, stock.cost, stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,warehouse.clientname as wh,stock.loc,stock.rem,'' as expiry, ifnull(uom.factor,1) as uomfactor 
                    FROM $table as stock
                    left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh where stock.trno ='$trno' 
                    and stock.line ='$line'
                    UNION ALL
                    SELECT 
                    item.brand as brand,mm.model_name as model,item.itemid,stock.ref,stock.trno, stock.line,stock.refx, stock.linex, stock.barcode,
                    stock.itemname, stock.uom, stock.cost,stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,warehouse.clientname as wh,stock.loc,stock.rem,'' as expiry, ifnull(uom.factor,1) as uomfactor
                    FROM $htable as stock 
                    left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh where stock.trno ='$trno' 
                    and stock.line ='$line'";
                    return Yii::$app->sbccommon->opentable($qry);
                break; // PO

                case 'PI':
                    return Yii::$app->sbccommon->opentable("
                    select 
                    item.brand as brand,mm.model_name as model,
                    item.itemid,stock.ref,stock.trno, stock.line,stock.refx, stock.linex, stock.barcode, stock.itemname, 
                    stock.uom, stock.cost, stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,
                    ".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,
                    warehouse.clientname as wh,stock.loc,stock.rem,'' as expiry, ifnull(uom.factor,1) as uomfactor
                    FROM $table as stock left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh where stock.trno ='$trno' 
                    and stock.line ='$line'
                    UNION ALL
                    SELECT 
                    item.brand as brand,mm.model_name as model,
                    item.itemid,stock.ref,stock.trno, stock.line,stock.refx, stock.linex, stock.barcode,
                    stock.itemname, stock.uom, stock.cost, stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, 
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,
                    ".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,
                    warehouse.clientname as wh,stock.loc,stock.rem,'' as expiry, ifnull(uom.factor,1) as uomfactor
                    FROM $htable as stock left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                    left join client as warehouse on warehouse.client=stock.wh where stock.trno ='$trno' 
                    and stock.line ='$line'");
                break; // PI

                case 'SO': case 'QA': case 'pscheme': case 'PS': case 'JB':
                    return Yii::$app->sbccommon->opentable("
                    select item.brand as brand,mm.model_name as model,
                    item.itemid,$table.trno, $table.line, $table.barcode, $table.itemname, $table.uom, $table.amt, 
                    $table.iss as iss,
                    round($table.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt, 
                    round($table.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty, 
                    round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left($table.encodeddate,10) as encodeddate,
                    $table.disc, $table.void, 
                    round(($table.iss-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    $table.wh as whcode,warehouse.clientname as wh,$table.loc,$table.expiry,$table.rem,case when $table.iss > $table.wh_currentqty then 1 else 0 end insuffqty, ifnull(uom.factor,1) as uomfactor
                    FROM $table 
                    left join item on item.barcode=$table.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$table.uom 
                    left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                    and $table.line ='$line'
                    UNION ALL
                    SELECT item.brand as brand,mm.model_name as model,
                    item.itemid,$htable.trno, $htable.line, $htable.barcode, $htable.itemname, $htable.uom, $htable.amt,
                    $htable.iss,
                    round($htable.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    round($htable.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty, 
                    round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left($htable.encodeddate,10) as encodeddate,
                    $htable.disc, $htable.void, 
                    round(($htable.iss-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,$htable.expiry,$htable.rem,case when $htable.iss > $htable.wh_currentqty then 1 else 0 end insuffqty, ifnull(uom.factor,1) as uomfactor
                    FROM $htable 
                    left join item on item.barcode=$htable.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom 
                    left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'
                        and $htable.line ='$line'");
                break; // SO

                case 'tpshipping':
                    $qry = "select line, trno, docno, customer_name, customer_code, agent, shipfee from tp_shippingfees where trno='".$trno."'";
                    return Yii::$app->sbccommon->opentable($qry);
                break;


                case 'tphandling':
                    $qry = "select line, trno, docno, customer_name, customer_code, agent, handlingfee from tp_handlingfees where trno='".$trno."'";
                    return Yii::$app->sbccommon->opentable($qry);
                break;

                //WTODO: [KIM][11.27.2019][bukod case for quotation][update query - add item]
                case 'quotation': 
                    return Yii::$app->sbccommon->opentable("
                    select item.brand as brand,mm.model_name as model,
                    item.itemid,$table.trno, $table.line, $table.barcode, $table.itemname, $table.uom, $table.amt, 
                    $table.iss as iss,
                    $table.isamt,
                    $table.isqty,
                    $table.ext,
                    left($table.encodeddate,10) as encodeddate,
                    $table.disc, $table.void, 
                    round(($table.iss-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                    $table.wh as whcode,warehouse.clientname as wh,$table.loc,$table.expiry,$table.rem,case when $table.iss > $table.wh_currentqty then 1 else 0 end insuffqty, ifnull(uom.factor,1) as uomfactor, $table.item
                    FROM $table 
                    left join item on item.barcode=$table.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$table.uom 
                    left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                    and $table.line ='$line'
                    UNION ALL
                    SELECT item.brand as brand,mm.model_name as model,
                    item.itemid,$htable.trno, $htable.line, $htable.barcode, $htable.itemname, $htable.uom, $htable.amt,
                    $htable.iss,
                    $htable.isamt,
                    $htable.isqty,
                    $htable.ext,
                    left($htable.encodeddate,10) as encodeddate,
                    $htable.disc, $htable.void, 
                    round(($htable.iss-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,$htable.expiry,$htable.rem,case when $htable.iss > $htable.wh_currentqty then 1 else 0 end insuffqty, ifnull(uom.factor,1) as uomfactor, $htable.item
                    FROM $htable 
                    left join item on item.barcode=$htable.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom 
                    left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'
                        and $htable.line ='$line'");
                break; // SO

                case 'QT':
                    return Yii::$app->sbccommon->opentable("
                    select item.brand as brand,mm.model_name as model,
                    $table.trno, $table.line, $table.barcode, $table.itemname, $table.uom, $table.amt, 
                    $table.iss as iss,
                    round($table.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt, 
                    round($table.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
                    round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left($table.encodeddate,10) as encodeddate,
                    $table.disc, $table.void, round(($table.iss-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,$table.wh as whcode,warehouse.clientname as wh,$table.loc,$table.addremarks
                    FROM $table left join item on item.barcode=$table.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$table.uom left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                    and $table.line ='$line'
                    UNION ALL
                    SELECT item.brand as brand,mm.model_name as model,
                    $htable.trno, $htable.line, $htable.barcode, $htable.itemname, $htable.uom, $htable.amt, 
                    $htable.iss,
                    round($htable.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,
                    round($htable.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty, 
                    round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                    left($htable.encodeddate,10) as encodeddate,
                    $htable.disc, $htable.void, round(($htable.iss-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,$htable.addremarks
                    FROM $htable left join item on item.barcode=$htable.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'
                        and $htable.line ='$line'");
                break; // QT

                case 'PR':
                    return Yii::$app->sbccommon->opentable("
                    select item.brand as brand,mm.model_name as model,
                    $table.trno, $table.refx, $table.linex, $table.line, item.itemid, $table.barcode, $table.itemname, $table.uom, $table.cost, 
                    $table.qty as qty,$table.rem,
                    round($table.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round($table.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round($table.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left($table.encodeddate,10) as encodeddate,
                    $table.disc, $table.void, round(($table.qty-$table.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,round(($table.qty-$table.tsqa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as tsqa,$table.wh as whcode,warehouse.clientname as wh,$table.loc,$table.rem,$table.ref, ifnull(uom.factor,1) as uomfactor
                    FROM $table 
                    left join item on item.barcode=$table.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$table.uom 
                    left join client as warehouse on warehouse.client=$table.wh where $table.trno ='$trno'
                    and $table.line ='$line'
                    UNION ALL
                    SELECT item.brand as brand,mm.model_name as model,
                    $htable.trno, $htable.refx, $htable.linex, item.itemid, $htable.line, $htable.barcode, $htable.itemname, $htable.uom, $htable.cost,
                    $htable.qty,$htable.rem,
                    round($htable.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round($htable.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                    round($htable.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    left($htable.encodeddate,10) as encodeddate,
                    $htable.disc, $htable.void, round(($htable.qty-$htable.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,round(($htable.qty-$htable.tsqa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as tsqa,$htable.wh as whcode,warehouse.clientname as wh,$htable.loc,$htable.rem,$htable.ref, ifnull(uom.factor,1) as uomfactor
                    FROM $htable left join item on item.barcode=$htable.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=$htable.uom left join client as warehouse on warehouse.client=$htable.wh where $htable.trno ='$trno'
                    and $htable.line ='$line' ");
                break; // PR

                case 'TR': case 'PC':
                    return Yii::$app->sbccommon->opentable("
                    select item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno, stock.line, stock.barcode, stock.itemname, stock.uom, stock.cost,
                    stock.qty as qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")  as rrqty,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,warehouse.clientname as wh,stock.rem,stock.ref,stock.loc,stock.expiry, ifnull(uom.factor,1) as uomfactor
                    FROM ".$table." as stock left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno ='".$trno."' and stock.line='".$line."'
                    UNION ALL
                    SELECT item.brand as brand,mm.model_name as model,
                    item.itemid,stock.trno, stock.line, stock.barcode, stock.itemname, stock.uom, stock.cost, 
                    stock.qty,
                    round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost, 
                    round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty, 
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext, 
                    left(stock.encodeddate,10) as encodeddate,
                    stock.disc, stock.void, round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,stock.wh as whcode,warehouse.clientname as wh,stock.rem,stock.ref,stock.loc,stock.expiry, ifnull(uom.factor,1) as uomfactor
                    FROM ".$htable." as stock left join item on item.barcode=stock.barcode 
                    left join model_masterfile as mm on mm.model_id = item.model
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom left join client as warehouse on warehouse.client=stock.wh where stock.trno ='".$trno."' and stock.line='".$line."'
                    ");
                break; // TR, PC
            }
        }
        
        public static function checkstock($doc,$trno,$barcode)
        {
            $table=Common::localstock($doc);
            $stock=Yii::$app->sbccommon->opentable("select ifnull(count(trno),0) as trno from $table where trno='$trno' and barcode='$barcode'");
            if($stock!=null){
                return $stock[0]['trno'];
            }else{ return 0;}
            
        }
        
        public static function insertstockaccept($doc,$trno,$data){
            $data->itemname=preg_replace( "/'/", "`", $data->itemname );
            $data->disc=preg_replace( "/'/", "`", $data->disc );
            $data->rem=preg_replace( "/'/", "`", $data->rem );
            $data->cost=preg_replace( "/'/", "`", $data->cost );
            $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
            $data->rrcost=preg_replace( "/'/", "`", $data->rrcost );
            $user=Yii::$app->session['loggeduser']['username'];
            $table=Common::localstock($doc);
                $last_line = Postock::getLastLine($doc,$trno) + 1;
                //$last_line = $last_line + 1;
            switch($doc){
                case 'PO':{
                    Yii::$app->sbccommon->execqry("INSERT into $table
                    (line, trno, itemname, barcode, uom, wh,loc, disc, rem, rrcost, rrqty, cost, qty, ext,void, encodedby,refx,linex,ref)
                    values (
                            '$last_line', '$trno', '$data->itemname', '$data->barcode',
                            '$data->uom', '$data->wh_','$data->loc', '$data->disc', '$data->rem',
                            '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty',
                            '$data->ext', '$data->void','$user','$data->refx','$data->linex','$data->ref'
                    )");

                    if(strlen($data->refx)!=0 && $data->refx!=0){
                    if(!Postock::setserveditems($data->linex,$data->refx,$doc)){
                        Postock::resetQuantity($last_line, $trno, $doc);
                        Postock::setserveditems($data->linex, $data->refx,$doc);
                        return 0;
                    }
                    }

                    break;
                }
            }            
        }
        
        public static function insertstock($doc,$trno,$data){

            $data->itemname=preg_replace( "/'/", "`", $data->itemname);
            $data->disc=preg_replace( "/'/", "`", $data->disc );
            $data->rem=preg_replace( "/'/", "`", $data->rem );
            $data->cost=preg_replace( "/'/", "`", $data->cost );
            $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
            $data->rrcost=preg_replace( "/'/", "`", $data->rrcost );
            $user=Yii::$app->session['loggeduser']['username']; //replaced with $data->encodeby so it can be set inside the model
            $table=Common::localstock($doc);
            $last_line = Postock::getLastLine($doc,$trno) + 1;
            $message='';
                
            switch($doc){
                case 'SP':
                    $insertqry = "insert into $table
                        (line, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty, cost, qty, ext,void, encodedby)
                        values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                        '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                        '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty',
                        '$data->ext', '$data->void','$user')";
                    $insertstatus = Yii::$app->sbccommon->execqry($insertqry);

                    if($insertstatus){
                        $qry_prevcost = 'select stock.rrcost,stock.disc,stock.ext from hspchead as head
                                        left join hspcstock as stock on stock.trno = head.trno
                                        where stock.barcode = "'.$data->barcode.'" and stock.uom = "'.$data->uom.'"
                                        order by head.due desc limit 1';
                        $prevdata = Yii::$app->sbccommon->opentable($qry_prevcost);

                        if(!empty($prevdata)){
                            $prevcost = $prevdata[0]['rrcost'];
                            $prevdisc = $prevdata[0]['disc'];
                            $prevext = $prevdata[0]['ext'];

                            $updaterqry = 'update '.$table.' as stock set stock.rrcost2 = '.$prevcost.',stock.disc2 = "'.$prevdisc.'",
                            stock.ext2 = '.$prevext.' where stock.trno = '.$trno.' 
                            and stock.barcode = "'.$data->barcode.'" and stock.line = '.$last_line;
                            
                            Yii::$app->sbccommon->execqry($updaterqry);
                        }//end if
                    }else{

                    }//end if
                break; // SP

                case 'PO':
                    $insertqry = "insert into $table
                        (line, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty, cost, qty, ext,void, encodedby,loc,ref,refx,linex)
                        values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                            '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                            '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty',
                            '$data->ext', '$data->void','$user','$data->loc','$data->ref','$data->refx','$data->linex')";
                    $insertstatus = Yii::$app->sbccommon->execqry($insertqry);
                    if(strlen($data->refx)!=0 && $data->refx!=0) {
                        if(!Postock::setserveditems($data->linex,$data->refx,$doc)) {
                            Postock::resetQuantity($last_line, $trno, $doc);
                            Postock::setserveditems($data->linex, $data->refx,$doc);
                            Yii::$app->sbccommon->execqry("update $table set rrqty=0,qty=0,ext=0, editby='COMPUTER',editdate=CURRENT_TIMESTAMP where  trno=$trno and line=$last_line" );
                                $message = $message . '<br /> Quantity more than ordered.';
                                $message = $message.'<br />';
                        }
                    }
                break; // PO

                case 'PI':
                    $insertqry = "insert into $table
                    (line, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty, cost, qty, ext,void, encodedby,loc,expiry,ref,refx,linex)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                            '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                            '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty',
                            '$data->ext', '$data->void','$user','$data->loc','$data->expiry','$data->ref','$data->refx','$data->linex')";
                    $insertstatus = Yii::$app->sbccommon->execqry($insertqry);
                break; // PI
                
                case 'tpshipping':             
                    $query = "insert into tp_shippingfees (trno,docno,customer_name, customer_code,agent, shipfee) values('".$data->trno."','".$data->docno."','".$data->customer_name."','".$data->customer_code."','".$data->agent."','".$data->shipfee."')";
                    Yii::$app->sbccommon->execqry($query);
                    $qryup ="update cntnum set sbill=1 where trno='".$data->trno."'";
                    $insertstatus = Yii::$app->sbccommon->execqry($qryup);
                break;


                case 'tphandling':             
                    $query = "insert into tp_handlingfees (trno,docno,customer_name, customer_code,agent, handlingfee) values('".$data->trno."','".$data->docno."','".$data->customer_name."','".$data->customer_code."','".$data->agent."','".$data->handlingfee."')";
                    Yii::$app->sbccommon->execqry($query);
                    $qryup ="update cntnum set shandling=1 where trno='".$data->trno."'";
                    $insertstatus = Yii::$app->sbccommon->execqry($qryup);
                break;                

                case 'PR':
                    $insertqry = "insert into $table
                    (line, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty, cost, qty, ext,void, encodedby,loc)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                            '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                            '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty',
                            '$data->ext', '$data->void','$user','$data->loc')";
                    $insertstatus = Yii::$app->sbccommon->execqry($insertqry);
                break; // PR

                case 'TR': case 'PC':
                    $insertqry = "insert into $table
                    (line, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty, cost, qty, ext,void, encodedby,loc,expiry)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                            '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                            '$data->rrcost', '$data->rrqty', '$data->cost', '$data->qty',
                            '$data->ext', '$data->void','$user','$data->loc','$data->expiry')";
                    $insertstatus = Yii::$app->sbccommon->execqry($insertqry);
                break; // TR, PC

                case 'SO': case 'QT': case 'QA': case 'pscheme': case 'PS': case 'JB': 
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                            if($doc == "SO") {
                                $currentwhqty = Yii::$app->backend->requestWarehouseItemInventory($data->barcode,$data->wh_);
                            } else {
                                $currentwhqty = 0;
                            }//end if
                        break;
                        default:
                            $currentwhqty = 0;
                        break;
                    }//END SWITCH

                    $insertqry = "insert into $table
                    (line, trno, itemname, barcode, uom, wh, disc, rem, isamt, isqty, amt, iss, ext,void, encodedby,loc,expiry,wh_currentqty)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                    '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                    '$data->isamt', '$data->isqty', '$data->amt', '$data->iss',
                    '$data->ext', '$data->void','$user','$data->loc','$data->expiry','$currentwhqty')";

                    $insertstatus = Yii::$app->sbccommon->execqry($insertqry);
                break; // SO, QT

                //WTODO: [KIM][2019.11.28][bukod na case for quotation]
                case 'quotation': 
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                            if($doc == "SO") {
                                $currentwhqty = Yii::$app->backend->requestWarehouseItemInventory($data->barcode,$data->wh_);
                            } else {
                                $currentwhqty = 0;
                            }//end if
                        break;
                        //WTODO: [KIM][2019.11.27][add case for mlcp]
                        case 'MLCP':
                            if($doc == "quotation"){
                                $currentwhqty = "";
                            }
                        break;

                        default:
                            $currentwhqty = 0;
                        break;
                    }//END SWITCH
                    
                    if($data->isamt==0){
                        $data->isamt='';
                    }
                    if($data->amt==0){
                        $data->amt='';
                    }
                    if($data->isqty==0){
                        $data->isqty='';
                    }
                    if($data->iss==0){
                        $data->iss='';
                    }
                    if($data->ext==0){
                        $data->ext='';
                    }

                    //WTODO: [KIM][2019.11.28][update query]
                    $insertqry = "insert into $table
                    (line, trno, itemname, barcode, uom, wh, disc, rem, isamt, isqty, amt, iss, ext,void, encodedby,loc,expiry,wh_currentqty,item)
                    values ('$last_line', '$trno', '$data->itemname', '$data->barcode',
                    '$data->uom', '$data->wh_', '$data->disc', '$data->rem',
                    '$data->isamt', '$data->isqty', '$data->amt', '$data->iss',
                    '$data->ext', '$data->void','$user','$data->loc','$data->expiry','$currentwhqty','$data->item')";

                    $insertstatus = Yii::$app->sbccommon->execqry($insertqry);
                break; // QT
            }//END SWITCH

            if($insertstatus) {
                Log::writelog($doc,$trno,'ADDED ITEM','['.$data->barcode.'] '.$data->itemname,Yii::$app->session['loggeduser']['username']);

                switch ($doc) {
                    case 'JB':
                        $getcounters = "select count(barcode) as count from jbstock where trno = " . $trno;
                        $count = Yii::$app->sbccommon->datareader($getcounters);
                        if($count == 1){
                            $qrygetprocess = "select ".$trno." as trno,fgi_process.line,code, process,
                                              instructions from fgi_process
                                              left join item on item.itemid = fgi_process.itemid
                                              where item.barcode = '".$data->barcode."'";

                            $getprocess = Yii::$app->sbccommon->opentable($qrygetprocess);

                            $getlastlineqry = "select line from jb_processtab where trno = '".$trno."' order by line desc limit 1";
                            $liner = Yii::$app->sbccommon->datareader($getlastlineqry);

                            if(empty($liner)){
                                $liner = 1;
                            }else{
                                $liner += 1;
                            }//end if

                            if(!empty($getprocess)){
                                foreach ($getprocess as $key => $value) {
                                    $qryinsertprocess = "insert into jb_processtab (trno,line,code,process,instruct,barcode)
                                                        values (".$value['trno'].",".$liner.",'".$value['code']."','".$value['process']."',
                                                        '".$value['instructions']."','".$data->barcode."')";
                                    Yii::$app->sbccommon->execqry($qryinsertprocess);
                                    $liner += 1;
                                }//end for each
                            }//end if
                        }//end if
                    break;
                }//END SWITCH
            } else {
                Log::writelog($doc,$trno,'ERROR ATTEMPT (ADDING ITEM)','['.$data->barcode.'] '.$data->itemname,Yii::$app->session['loggeduser']['username']);
            }//end if


            $newdata = Postock::openstockline($doc,$trno, $last_line);
            
            if($doc!='tpshipping' && $doc != 'tphandling'){
                $grandtotal = Postock::getgrandtotal($trno, $doc);    
            }//end if

            if(!empty($newdata)) {
                if($doc!='tpshipping' && $doc != 'tphandling'){

                    switch($doc){
                        case 'quotation':
                            $warehousename = $newdata[0]['wh'];
                        break;
                        default:
                            $wh_ = $newdata[0]['whcode'];            
                            $warehousename = $newdata[0]['wh'];
                        break;
                    }//end switch

                    $barcode = $newdata[0]['barcode'];
                    $itemname = $newdata[0]['itemname'];
                    $uom = $newdata[0]['uom'];
                    $wh_ = $newdata[0]['whcode'];            
                    $warehousename = $newdata[0]['wh'];
                    $pending = $newdata[0]['qa'];    

                    if($doc=='quotation'){
                      $ext = $newdata[0]['ext'];
                    }else{
                      $ext = number_format($newdata[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency'));    
                    }//end if

                    $disc = $newdata[0]['disc'];
                    $loc = $newdata[0]['loc'];
                    $rem = $newdata[0]['rem'];
                    $uomfactor = $newdata[0]['uomfactor'];
                    $itemcount = $grandtotal[0]['itemcount'];
                    $totalbill = $grandtotal[0]['grandtotal'];
                    $totalkilo = $grandtotal[0]['kilototal'];
                    $model = $newdata[0]['model'];
                    $brand = $newdata[0]['brand'];
                }//end if

                switch (Yii::$app->systemsettings->companyConfig()) { // XANDABELS
                    case 'SOUTHCENTRAL':
                        if($doc == 'SO' || $doc == 'QA') {
                            $totalcbm = number_format($grandtotal[0]['totalcbm'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                            $totaltonnage = $grandtotal[0]['totaltonnage'];
                        }//end if
                    break;
                    default:
                        $totalcbm = 0;
                    break;
                } // END XANDA

                if($doc!='tpshipping' && $doc != 'tphandling'){
                    $itemid = Yii::$app->backend->requestItemid($barcode);
                }//end if

                if($data->isecomm == 0) { //EDITING BY JAO (ORDERS FROM FRONT END WILL BE SAVE BUT WOULD NOT RETURN ANY JSON)
                    switch ($doc) {
                        case 'SP':
                            $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                            $qty = $newdata[0]['qty'];
                            $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));

                           
                            $rrcost2 = number_format($newdata[0]['rrcost2'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                            $cost2 =$newdata[0]['cost2'];
                            $ext2 =$newdata[0]['ext2'];

                             $disc2 = $newdata[0]['disc2'];

                            $cost =$newdata[0]['cost'];
                            $ref = $newdata[0]['ref'];
                            $loc = $newdata[0]['loc'];
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                'itemid'=>$itemid,'barcode' => $barcode, 'rrqty' => $rrqty,
                                'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 'whcode' => $wh_,
                                'rrcost'=>$rrcost, 'cost' => $cost,'qty'=>$qty,'total' => $ext ,
                                'ext' => $ext, 'disc' => $disc, 'ref' => $ref, 'rem' => $rem,
                                'refx'=>$data->refx,'linex'=>$data->linex,'itemcount'=>$itemcount,
                                'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'loc'=>$loc,
                                'rrcost2'=>$rrcost2,'cost2'=>$cost2,'ext2'=>$ext2,'disc2'=>$disc2,
                                'expiry'=>'','status'=>$message,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                'brand'=>$brand,'model'=>$model);
                            return $passjson;
                        break; // SP

                        case 'PO':
                            $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                            $qty = $newdata[0]['qty'];
                            $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                            $cost =$newdata[0]['cost'];
                            $ref = $newdata[0]['ref'];
                            $loc = $newdata[0]['loc'];
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                'itemid'=>$itemid,'barcode' => $barcode, 'rrqty' => $rrqty,
                                'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 'whcode' => $wh_,
                                'rrcost'=>$rrcost, 'cost' => $cost,'qty'=>$qty,'total' => $ext ,
                                'ext' => $ext, 'disc' => $disc, 'ref' => $ref, 'rem' => $rem,
                                'refx'=>$data->refx,'linex'=>$data->linex,'itemcount'=>$itemcount,
                                'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'loc'=>$loc,
                                'expiry'=>'','status'=>$message,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                'brand'=>$brand,'model'=>$model);
                            return $passjson;
                        break; // PO

                        case 'PI':
                            $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                            $qty = $newdata[0]['qty'];
                            $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                            $cost =$newdata[0]['cost'];
                            $ref = $newdata[0]['ref'];
                            $loc = $newdata[0]['loc'];
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                'itemid'=>$itemid,'barcode' => $barcode, 'rrqty' => $rrqty,
                                'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 'whcode' => $wh_,
                                'rrcost'=>$rrcost, 'cost' => $cost,'qty'=>$qty,'total' => $ext ,
                                'ext' => $ext, 'disc' => $disc, 'ref' => $ref, 'rem' => $rem,
                                'refx'=>$data->refx,'linex'=>$data->linex,'itemcount'=>$itemcount,
                                'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,
                                'loc'=>$loc,'expiry'=>'','status'=>$message,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                'brand'=>$brand,'model'=>$model);
                            return $passjson;
                        break; // PI

                        case 'PR':
                            $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                            $qty = $newdata[0]['qty'];
                            $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                            $cost = $newdata[0]['cost'];
                            $ref = $newdata[0]['ref'];
                            $loc = $newdata[0]['loc'];
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                'itemid'=>$itemid,'barcode' => $barcode, 'rrqty' => $rrqty,
                                'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 'whcode' => $wh_,
                                'rrcost'=>$rrcost, 'cost' => $cost,'qty'=>$qty,'total' => $ext ,
                                'ext' => $ext, 'disc' => $disc, 'ref' => $ref, 'rem' => $rem,'itemcount'=>$itemcount,
                                'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,
                                'loc'=>$loc,'expiry'=>'','status'=>'','templine'=>$data->templine,'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                'brand'=>$brand,'model'=>$model);
                            return $passjson;
                        break; // PR
                    
                        case 'TR': case 'PC':
                            $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                            $qty = $newdata[0]['qty'];
                            $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                            $cost = $newdata[0]['cost'];
                            $ref = $newdata[0]['ref'];
                            $loc = $newdata[0]['loc'];
                            $expiry = $newdata[0]['expiry'];
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                'itemid'=>$itemid,'barcode' => $barcode, 'rrqty' => $rrqty,
                                'itemname' => $itemname, 'uom' => $uom,'wh'=>$warehousename, 'whcode' => $wh_,
                                'rrcost'=>$rrcost, 'cost' => $cost,'qty'=>$qty,'total' => $ext ,
                                'ext' => $ext, 'disc' => $disc, 'ref' => $ref, 'rem' => $rem,'itemcount'=>$itemcount,
                                'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'loc'=>$loc,
                                'status'=>'','expiry'=>$expiry,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                'brand'=>$brand,'model'=>$model);
                            return $passjson;
                        break; // TR, PC

                        case 'QT':
                            $isqty = number_format($newdata[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                            $iss = $newdata[0]['iss'];
                            $isamt = number_format($newdata[0]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                            $amt = $newdata[0]['amt'];
                            $loc = $newdata[0]['loc'];
                            $expiry = $newdata[0]['expiry'];
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                'itemid'=>$itemid,'barcode' => $barcode, 'isqty' => $isqty,
                                'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 'whcode' => $wh_,
                                'isamt'=>$isamt,'amt'=>$amt,'iss'=>$iss,'total' => $ext ,'totalcbm'=>$totalcbm,
                                'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry'=>$expiry,'rem' => $rem,'itemcount'=>$itemcount,
                                'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'status'=>'','templine'=>$data->templine,
                                'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                'brand'=>$brand,'model'=>$model);
                            
                            return $passjson;
                        break; // QT


                        case 'quotation': 
                            $isqty = $newdata[0]['isqty'];
                            $iss = $newdata[0]['iss'];
                            $isamt = $newdata[0]['isamt'];
                            $amt = $newdata[0]['amt'];
                            $loc = $newdata[0]['loc'];
                            $expiry = $newdata[0]['expiry'];
                            $insuffqty = $newdata[0]['insuffqty'];
                            
                           
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                        'itemid'=>$itemid,'barcode' => $barcode, 'isqty' => $isqty,
                                        'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 
                                        'isamt'=>$isamt,'amt'=>$amt,'iss'=>$iss,'total' => $ext ,'totalcbm'=>$totalcbm,
                                        'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry'=>$expiry,'rem' => $rem,'itemcount'=>$itemcount,
                                        'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'status'=>'','templine'=>$data->templine,
                                        'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                        'brand'=>$brand,'model'=>$model);
                               
                            return $passjson;
                        break;

                        case'SO': case 'pscheme': case 'PS': case 'QA': case 'JB':
                            $isqty = number_format($newdata[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                            $iss = $newdata[0]['iss'];
                            $isamt = number_format($newdata[0]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                            $amt = $newdata[0]['amt'];
                            $loc = $newdata[0]['loc'];
                            $expiry = $newdata[0]['expiry'];
                            $insuffqty = $newdata[0]['insuffqty'];
                            
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'SOUTHCENTRAL':
                                    $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                        'itemid'=>$itemid,'barcode' => $barcode, 'isqty' => $isqty,
                                        'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 'whcode' => $wh_,
                                        'isamt'=>$isamt,'amt'=>$amt,'iss'=>$iss,'total' => $ext ,'totaltonnage'=>$totaltonnage,'totalcbm'=>$totalcbm,
                                        'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry'=>$expiry,'rem' => $rem,'itemcount'=>$itemcount,
                                        'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'insuffqty'=>$insuffqty,'status'=>'','templine'=>$data->templine,'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                        'brand'=>$brand,'model'=>$model);
                                break;
                                default:
                                    $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$last_line,
                                        'itemid'=>$itemid,'barcode' => $barcode, 'isqty' => $isqty,
                                        'itemname' => $itemname, 'uom' => $uom,'whname'=>$warehousename, 'whcode' => $wh_,
                                        'isamt'=>$isamt,'amt'=>$amt,'iss'=>$iss,'total' => $ext ,'totalcbm'=>$totalcbm,
                                        'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry'=>$expiry,'rem' => $rem,'itemcount'=>$itemcount,
                                        'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'status'=>'','templine'=>$data->templine,
                                        'istransposted'=>false,'msg'=>'','uomfactor'=>$uomfactor,
                                        'brand'=>$brand,'model'=>$model);
                                break;
                            }
                            return $passjson;
                        break; // SO

                        case 'tpshipping':              
                            if (!empty($newdata)) {
                              $line = $newdata[0]['line'];
                              $docno = $newdata[0]['docno'];
                              $client = $newdata[0]['customer_code'];
                              $clientname = $newdata[0]['customer_name'];
                              $agent = $newdata[0]['agent'];
                              $shipfee = $newdata[0]['shipfee'];
                            }//end if
                         
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$line,'docno'=> $docno, 
                                              'client'=> $client, 'clientname'=> $clientname,'agent'=>$agent,'shipfee'=>$shipfee,'msg'=>'','status'=>true,
                                            'brand'=>'','model'=>'');
                            return $passjson;
                        break; // TPSHIPPING


                        case 'tphandling':              
                            if (!empty($newdata)) {
                              $line = $newdata[0]['line'];
                              $docno = $newdata[0]['docno'];
                              $client = $newdata[0]['customer_code'];
                              $clientname = $newdata[0]['customer_name'];
                              $agent = $newdata[0]['agent'];
                              $handlingfee = $newdata[0]['handlingfee'];
                            }//end if
                         
                            $passjson = array('savingtype'=>'add','trno'=>$trno,'line'=>$line,'docno'=> $docno, 
                                              'client'=> $client, 'clientname'=> $clientname,'agent'=>$agent,'handlingfee'=>$handlingfee,'msg'=>'','status'=>true,
                                            'brand'=>'','model'=>'');
                            return $passjson;
                        break; // TPHANDLING
                    }//end switch
                }//END IF ISECOMM
            }//end new data
        }//END FUNCTION INSERT STOCK
        


        public static function updatestock($doc,$line, $trno, $data){
       
            $user=Yii::$app->session['loggeduser']['username'];
            $table=Common::localstock($doc);
            $date=date("Y-m-d H:i:s");
            $data->itemname=preg_replace( "/'/", "`", $data->itemname );
            $data->disc=preg_replace( "/'/", "`", $data->disc );
            $data->rem=preg_replace( "/'/", "`", $data->rem );
            $data->cost=preg_replace( "/'/", "`", $data->cost );
            $data->rrqty=preg_replace( "/'/", "`", $data->rrqty );
            $data->rrcost=preg_replace( "/'/", "`", $data->rrcost );
            $msg='';

            if($doc == 'tpshipping'){
                $trno = $data->trno;         
                $docno= $data->docno;
                $client = $data->customer_code;
                $clientname = $data->customer_name;
                $agent = $data->agent;
                $shipfee = $data->shipfee;
                $cutoff = $data->cutoff;
            }//end if


            if($doc == 'tphandling'){
                $trno = $data->trno;         
                $docno= $data->docno;
                $client = $data->customer_code;
                $clientname = $data->customer_name;
                $agent = $data->agent;
                $handlingfee = $data->handlingfee;
                $cutoff = $data->cutoff;
            }//end if

            switch ($doc){
                case 'SP':
                    $qry = "update $table SET
                        itemname='$data->itemname', uom='$data->uom', wh='$data->wh_',
                        disc='$data->disc', rem='$data->rem', rrcost='$data->rrcost',
                        rrqty='$data->rrqty', cost='$data->cost', qty='$data->qty',
                        ext='$data->ext', void='$data->void',editby='$user',
                        editdate=CURRENT_TIMESTAMP,loc='$data->loc' where trno='$trno' and line='$line'";
                    Yii::$app->sbccommon->execqry($qry);
                    if(strlen($data->refx)!=0 && $data->refx!=0) {
                        if(!Postock::setserveditems($data->linex,$data->refx,$doc)) {
                             Postock::resetQuantity($line, $trno, $doc);
                             Postock::setserveditems($data->linex, $data->refx,$doc);
                             Yii::$app->sbccommon->execqry("update $table set rrqty=0,qty=0,ext=0, editby='COMPUTER',editdate=CURRENT_TIMESTAMP where  trno=$trno and line=$line" );
                             $msg='Quantity more than ordered.';
                        }
                    }
                break; // PO

                case 'PO':
                    $qry = "update $table SET
                        itemname='$data->itemname', uom='$data->uom', wh='$data->wh_',
                        disc='$data->disc', rem='$data->rem', rrcost='$data->rrcost',
                        rrqty='$data->rrqty', cost='$data->cost', qty='$data->qty',
                        ext='$data->ext', void='$data->void',editby='$user',
                        editdate=CURRENT_TIMESTAMP,loc='$data->loc' where trno='$trno' and line='$line'";
                    Yii::$app->sbccommon->execqry($qry);
                    if(strlen($data->refx)!=0 && $data->refx!=0) {
                        if(!Postock::setserveditems($data->linex,$data->refx,$doc)) {
                             Postock::resetQuantity($line, $trno, $doc);
                             Postock::setserveditems($data->linex, $data->refx,$doc);
                             Yii::$app->sbccommon->execqry("update $table set rrqty=0,qty=0,ext=0, editby='COMPUTER',editdate=CURRENT_TIMESTAMP where  trno=$trno and line=$line" );
                             $msg='Quantity more than ordered.';
                        }
                    }
                break; // PO

                case 'PI':
                    Yii::$app->sbccommon->execqry("update $table
                        SET itemname='$data->itemname', uom='$data->uom', wh='$data->wh_',
                        disc='$data->disc', rem='$data->rem', rrcost='$data->rrcost',
                        rrqty='$data->rrqty', cost='$data->cost', qty='$data->qty',
                        ext='$data->ext', void='$data->void',editby='$user',
                        editdate=CURRENT_TIMESTAMP,loc='$data->loc' where trno='$trno' and line='$line'");
                break; // PI

                case 'tpshipping':
                    Yii::$app->sbccommon->execqry("update $table
                    SET docno='$docno', customer_name='$clientname', customer_code='$client',
                    agent='$agent', shipfee='$shipfee',cutoff = '".$cutoff."' where trno='$trno' and line='$line'");
                break;


                case 'tphandling':
                    Yii::$app->sbccommon->execqry("update $table
                    SET docno='$docno', customer_name='$clientname', customer_code='$client',
                    agent='$agent', handlingfee='$handlingfee',cutoff = '".$cutoff."' where trno='$trno' and line='$line'");
                break;
                
                case 'TR': case 'PC':
                     Yii::$app->sbccommon->execqry("update $table SET
                        itemname='$data->itemname', uom='$data->uom', wh='$data->wh_',
                        disc='$data->disc', rem='$data->rem', rrcost='$data->rrcost',
                        rrqty='$data->rrqty', cost='$data->cost', qty='$data->qty',
                        ext='$data->ext', void='$data->void',editby='$user',
                        editdate=CURRENT_TIMESTAMP,loc='$data->loc',expiry= '$data->expiry' where trno='$trno' and line='$line'");
                break; // TR, PC

                case 'PR':
                    $qry = "update $table SET
                    itemname='$data->itemname', uom='$data->uom', wh='$data->wh_',
                    disc='$data->disc', rem='$data->rem', rrcost='$data->rrcost',
                    rrqty='$data->rrqty', cost='$data->cost', qty='$data->qty',
                    ext='$data->ext', void='$data->void',editby='$user',
                    editdate=CURRENT_TIMESTAMP,loc='$data->loc' where trno='$trno' and line='$line'";
                    Yii::$app->sbccommon->execqry($qry);
                break; // PR

                case 'JB': case 'SO': case 'QT': case 'QA': case 'pscheme': case 'PS': case 'QT': 
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                            if($doc == "SO") {
                                $currentwhqty = Yii::$app->backend->requestWarehouseItemInventory($data->barcode,$data->wh_);
                            } else {
                                $currentwhqty = 0;
                            }//end if
                        break;
                        default:
                            $currentwhqty = 0;
                        break;
                    }//END SWITCH

                    Yii::$app->sbccommon->execqry("update $table
                    SET barcode ='$data->barcode',
                    itemname='$data->itemname', uom='$data->uom', wh='$data->wh_',
                    disc='$data->disc', rem='$data->rem', isamt='$data->isamt',
                    isqty='$data->isqty', amt='$data->amt', iss='$data->iss',
                    ext='$data->ext', void='$data->void',editby='$user',loc='$data->loc',expiry='$data->expiry',
                    editdate=CURRENT_TIMESTAMP,loc='$data->loc',rem = '$data->rem',wh_currentqty='$currentwhqty' 
                    where trno='$trno' and line='$line'");
                break; // SO, QT

                case 'quotation':
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        //WTODO: [KIM][2019.11.27][add case for mlcp]
                        case 'MLCP':
                            if($doc == "quotation"){
                                $currentwhqty = "";
                            }
                        break;

                        default:
                            $currentwhqty = 0;
                        break;
                    }//END SWITCH
                    
                    if($data->isamt==0){
                        $data->isamt='';
                    }
                    if($data->amt==0){
                        $data->amt='';
                    }
                    if($data->isqty==0){
                        $data->isqty='';
                    }
                    if($data->iss==0){
                        $data->iss='';
                    }
                    if($data->ext==0){
                        $data->ext='';
                    }
                    
                    //WTODO: [KIM][2019.11.28][update query for quotation updatestock ]
                    Yii::$app->sbccommon->execqry("update $table
                    SET barcode ='$data->barcode',
                    itemname='$data->itemname', uom='$data->uom', wh='$data->wh_',
                    disc='$data->disc', rem='$data->rem', isamt='$data->isamt',
                    isqty='$data->isqty', amt='$data->amt', iss='$data->iss',
                    ext='$data->ext', void='$data->void',editby='$user',loc='$data->loc',expiry='$data->expiry',
                    editdate=CURRENT_TIMESTAMP,loc='$data->loc',rem = '$data->rem',wh_currentqty='$currentwhqty', item ='$data->item'
                    where trno='$trno' and line='$line'");
                break; // SO, QT
            } // end switch doc


                switch ($doc){
                    case 'tpshipping':
                        $newdata = Postock::openstockline($doc,$trno, $line);
               
                        if (!empty($newdata)){
                          $docno = $newdata[0]['docno'];
                          $client = $newdata[0]['customer_code'];
                          $clientname = $newdata[0]['customer_name'];
                          $agent = $newdata[0]['agent'];
                          $shipfee = $newdata[0]['shipfee'];
                        }//end if
             
                        $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'docno'=> $docno, 
                        'customer_code'=> $client, 'customer_name'=> $clientname,'agent'=>$agent,
                        'shipfee'=>$shipfee,'msg'=>'','status'=>true);
               
                        return $passjson;
                    break;


                    case 'tphandling':
                        $newdata = Postock::openstockline($doc,$trno, $line);
               
                        if (!empty($newdata)){
                          $docno = $newdata[0]['docno'];
                          $client = $newdata[0]['customer_code'];
                          $clientname = $newdata[0]['customer_name'];
                          $agent = $newdata[0]['agent'];
                          $handlingfee = $newdata[0]['handlingfee'];
                        }//end if
             
                        $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'docno'=> $docno, 
                        'customer_code'=> $client, 'customer_name'=> $clientname,'agent'=>$agent,
                        'handlingfee'=>$handlingfee,'msg'=>'','status'=>true);

                        return $passjson;
                    break;

                    default:
                        $newdata = Postock::openstockline($doc,$trno, $line);
                        $grandtotal = Postock::getgrandtotal($trno, $doc);
                        
                        if(!empty($newdata)) {
                            $barcode = $newdata[0]['barcode'];
                            $itemname = $newdata[0]['itemname'];
                            $uom = $newdata[0]['uom'];
                            $wh_ = $newdata[0]['whcode'];            
                            $warehousename = $newdata[0]['wh'];
                            
                            if($doc=='quotation'){
                                $ext = $newdata[0]['ext'];
                            }else{
                                $ext = number_format($newdata[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency'));    
                            }

                            $disc = $newdata[0]['disc'];
                            $uomfactor = $data->uomfactor;
                            $itemcount = $grandtotal[0]['itemcount'];
                            $totalbill = $grandtotal[0]['grandtotal'];
                            $totalkilo = $grandtotal[0]['kilototal'];
                            $pending = $newdata[0]['qa'];
                            $brand = $newdata[0]['brand'];
                            $model = $newdata[0]['model'];

                            switch ($doc) {
                                case 'SP':
                                    $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                                    $qty = $newdata[0]['qty'];
                                    $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));

                           
                                    $rrcost2 = number_format($newdata[0]['rrcost2'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                                    $cost2 =$newdata[0]['cost2'];
                                    $ext2 =$newdata[0]['ext2'];

                                    $disc2 = $newdata[0]['disc2'];
                                    $loc = $newdata[0]['loc'];
                                    $ref = $newdata[0]['ref'];
                                    $cost = $newdata[0]['cost'];
                                    $qty = $newdata[0]['qty'];
                                    $rem = $newdata[0]['rem'];
                                    
                                    $itemid = Yii::$app->backend->requestItemid($barcode);
                                    $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'itemid'=> $itemid,
                                     'barcode' => $barcode, 'rrqty' => $rrqty, 'itemname' => $itemname, 'uom' => $uom,
                                     'whname'=>$warehousename, 'wh' => $wh_,'rrcost'=>$rrcost, 'cost'=>$cost,'qty'=>$qty,
                                     'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'ref' => $ref,
                                     'itemcount'=>$itemcount,'refx'=>$data->refx,'linex'=>$data->linex,
                                     'rem'=>$rem,'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,
                                     'uomfactor'=>$uomfactor,'loc'=>$loc,'expiry'=>'','status'=>$msg,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                     'brand'=>$brand,'model'=>$model);
                                    return $passjson;
                                break; // SP

                                case 'PO':
                                    $loc = $newdata[0]['loc'];
                                    $ref = $newdata[0]['ref'];
                                    $cost = $newdata[0]['cost'];
                                    $qty = $newdata[0]['qty'];
                                    $rem = $newdata[0]['rem'];
                                    $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                                    $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                                    $itemid = Yii::$app->backend->requestItemid($barcode);
                                    $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'itemid'=> $itemid,
                                     'barcode' => $barcode, 'rrqty' => $rrqty, 'itemname' => $itemname, 'uom' => $uom,
                                     'whname'=>$warehousename, 'wh' => $wh_,'rrcost'=>$rrcost, 'cost'=>$cost,'qty'=>$qty,
                                     'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'ref' => $ref,
                                     'itemcount'=>$itemcount,'refx'=>$data->refx,'linex'=>$data->linex,
                                     'rem'=>$rem,'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,
                                     'uomfactor'=>$uomfactor,'loc'=>$loc,'expiry'=>'','status'=>$msg,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                    'brand'=>$brand,'model'=>$model);
                                    return $passjson;
                                break; // PO

                                case 'PI':
                                    $loc = $newdata[0]['loc'];
                                    $ref = $newdata[0]['ref'];
                                    $cost = $newdata[0]['cost'];
                                    $qty = $newdata[0]['qty'];
                                    $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                                    $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                                    $itemid = Yii::$app->backend->requestItemid($barcode);
                                    $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'itemid'=> $itemid,
                                     'barcode' => $barcode, 'rrqty' => $rrqty, 'itemname' => $itemname, 'uom' => $uom,
                                     'whname'=>$warehousename, 'wh' => $wh_,'rrcost'=>$rrcost, 'cost'=>$cost,'qty'=>$qty,
                                     'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'ref' => $ref,'itemcount'=>$itemcount,
                                     'refx'=>$data->refx,'linex'=>$data->linex,
                                     'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'uomfactor'=>$uomfactor,
                                     'loc'=>$loc,'expiry'=>'','status'=>$msg,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                    'brand'=>$brand,'model'=>$model);
                                    return $passjson;
                                break; // PI

                                case 'TR': case 'PC':
                                    $loc = $newdata[0]['loc'];
                                    $cost = $newdata[0]['cost'];
                                    $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                                    $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                                    $rem = $newdata[0]['rem'];
                                    $ref = $newdata[0]['ref'];
                                    $qty = $newdata[0]['qty'];
                                    $expiry = $newdata[0]['expiry'];
                                    $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'barcode' => $barcode, 'rrqty' => $rrqty,
                                        'itemname' => $itemname, 'uom' => $uom, 'whcode' => $wh_, 'wh'=>$data->whname,'rrcost'=>$rrcost, 'cost' => $cost,
                                        'total' => $ext , 'ext' => $ext, 'disc' => $disc,'rem'=>$rem, 'itemcount'=>$itemcount,
                                        'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'loc'=>$loc,
                                        'expiry'=>$expiry,'messages'=>'','status'=>'','ref'=>$ref,
                                        'qty'=>$qty,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                        'brand'=>$brand,'model'=>$model);
                                    return $passjson;
                                break; // TR, PC

                                case 'PR':
                                    $loc = $newdata[0]['loc'];
                                    $cost = $newdata[0]['cost'];
                                    $rrqty = number_format($newdata[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                                    $rrcost = number_format($newdata[0]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                                    $rem = $newdata[0]['rem'];
                                    $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'barcode' => $barcode, 'rrqty' => $rrqty,
                                        'itemname' => $itemname, 'uom' => $uom, 'wh' => $wh_,'rrcost'=>$rrcost, 'cost' => $cost,
                                        'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry'=>'','rem'=>$rem,
                                        'itemcount'=>$itemcount,
                                        'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'messages'=>'',
                                        'status'=>'','templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                        'brand'=>$brand,'model'=>$model);
                                    return $passjson;
                                break; // PR

                                case 'QT':
                                    $loc = $newdata[0]['loc'];
                                    $isqty = number_format($newdata[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                                    $isamt = number_format($newdata[0]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                                    $amt = $newdata[0]['amt'];
                                    $iss=  $newdata[0]['iss'];
                                    $rem = $newdata[0]['rem'];
                                    $itemid = Yii::$app->backend->requestItemid($barcode);
                                    $expiry = $newdata[0]['expiry'];
                                    $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'itemid'=> $itemid,
                                         'barcode' => $barcode, 'isqty' => $isqty, 'itemname' => $itemname, 'uom' => $uom,
                                         'whname'=>$warehousename, 'wh' => $wh_,'isamt'=>$isamt, 'amt'=>$amt,'iss'=>$iss,
                                         'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry' => $expiry,
                                         'itemcount'=>$itemcount,
                                         'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'uomfactor'=>$uomfactor,
                                         'status'=>'','rem'=>$rem,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                        'brand'=>$brand,'model'=>$model);
                                    return $passjson;
                                break; // QT

                                case 'JB':
                                case 'SO': case 'QA': case 'pscheme': case 'PS': case 'quotation': 
                                    $loc = $newdata[0]['loc'];

                                    if($doc=='quotation'){
                                        $isqty = $newdata[0]['isqty'];
                                        $isamt = $newdata[0]['isamt'];
                                    }else{
                                        $isqty = number_format($newdata[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
                                        $isamt = number_format($newdata[0]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('unitprice'));
                                    }//end if

                                    $amt = $newdata[0]['amt'];
                                    $iss=  $newdata[0]['iss'];
                                    $rem = $newdata[0]['rem'];
                                    $itemid = Yii::$app->backend->requestItemid($barcode);
                                    $expiry = $newdata[0]['expiry'];
                                    $insuffqty = $newdata[0]['insuffqty'];
                                    switch (Yii::$app->systemsettings->companyConfig()) { // XANDABELS
                                        case 'SOUTHCENTRAL':
                                            $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'itemid'=> $itemid,
                                             'barcode' => $barcode, 'isqty' => $isqty, 'itemname' => $itemname, 'uom' => $uom,
                                             'whname'=>$warehousename, 'wh' => $wh_,'isamt'=>$isamt, 'amt'=>$amt,'iss'=>$iss,
                                             'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry' => $expiry,
                                             'itemcount'=>$itemcount,'totalcbm'=>$totalcbm,'totaltonnage'=>$totaltonnage,
                                             'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'uomfactor'=>$uomfactor,
                                             'status'=>'','rem'=>$rem,'insuffqty'=>$insuffqty,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                            'brand'=>$brand,'model'=>$model);
                                        break;
                                        default:
                                            $passjson = array('savingtype'=>'edit','trno'=>$trno,'line'=>$line,'itemid'=> $itemid,
                                                 'barcode' => $barcode, 'isqty' => $isqty, 'itemname' => $itemname, 'uom' => $uom,
                                                 'whname'=>$warehousename, 'wh' => $wh_,'isamt'=>$isamt, 'amt'=>$amt,'iss'=>$iss,
                                                 'total' => $ext , 'ext' => $ext, 'disc' => $disc, 'loc' => $loc,'expiry' => $expiry,
                                                 'itemcount'=>$itemcount,
                                                 'grandtotal'=>$totalbill,'totalkilo'=>$totalkilo,'qa'=> $pending,'uomfactor'=>$uomfactor,
                                                 'status'=>'','rem'=>$rem,'templine'=>$data->templine,'istransposted'=>false,'msg'=>'',
                                                'brand'=>$brand,'model'=>$model);
                                        break;
                                    } // XANDABELS
                                    return $passjson;
                                break;
                            } // end switch
                        } // end if new data
                    break;
                }//end switch
        } // end function

        public static function getLastLine($doc,$trno){
            $table=Common::localstock($doc);
            $stocks=Yii::$app->sbccommon->opentable("select line FROM $table where trno ='$trno' order by line desc limit 1");
            
            if ($stocks==null){
                return 0;
            }else{
                return $stocks[0]['line'];
            }
        }

        
        public static function deletestock($doc,$trno, $line){
            $table=Common::localstock($doc);
            
            switch ($doc) {
                case 'tpshipping':
                    $openstockdata = Yii::$app->sbccommon->opentable("select trno, docno,customer_code,customer_name,agent,shipfee from ".$table." where line=".$line);
                break;
                

                case 'tphandling':
                    $openstockdata = Yii::$app->sbccommon->opentable("select trno, docno,customer_code,customer_name, agent,handlingfee from ".$table." where line=".$line);
                break;                

                default:
                   $openstockdata = Yii::$app->sbccommon->opentable("select barcode,itemname from ".$table." where trno=".$trno." and line=".$line);
                break;
            }//end switch

            if($doc == 'PO'){
                $stockdata=Yii::$app->sbccommon->opentable("select refx,linex from ".$table." where trno =".$trno." and line=".$line); 
            }else{
                $stockdata= "";
            }//end if

            switch ($doc) {
                case 'tpshipping':
                    Yii::$app->sbccommon->execqry("update cntnum set sbill=0 where trno=".$trno."");
                    $removestatus = Yii::$app->sbccommon->execqry("delete from $table where trno=".$trno."");
                break;
                

                case 'tphandling':
                    Yii::$app->sbccommon->execqry("update cntnum set shandling=0 where trno=".$trno."");
                    $removestatus = Yii::$app->sbccommon->execqry("delete from $table where trno=".$trno."");
                break;

                default:
                    $removestatus = Yii::$app->sbccommon->execqry("delete from $table where trno='$trno' and line='$line'");
                break;
            }//end switch
            
            if(!empty($openstockdata)) {
                if($removestatus){
                    switch ($doc) {
                        case 'tpshipping':
                            Log::writelog($doc,$trno,'REMOVED ITEM','['.$openstockdata[0]['docno'].'] [Line: '.$line.'] ' . $openstockdata[0]['customer_code'] . $openstockdata[0]['customer_name']. $openstockdata[0]['agent']. $openstockdata[0]['shipfee'],Yii::$app->session['loggeduser']['username']);
                        break;
                        

                        case 'tphandling':
                            Log::writelog($doc,$trno,'REMOVED ITEM','['.$openstockdata[0]['docno'].'] [Line: '.$line.'] ' . $openstockdata[0]['customer_code'] . $openstockdata[0]['customer_name']. $openstockdata[0]['agent']. $openstockdata[0]['handlingfee'],Yii::$app->session['loggeduser']['username']);
                        break;

                        default:
                            Log::writelog($doc,$trno,'REMOVED ITEM','['.$openstockdata[0]['barcode'].'] [Line: '.$line.'] ' . $openstockdata[0]['itemname'],Yii::$app->session['loggeduser']['username']);
                        break;
                    }//end switch
                }else{
                    Log::writelog($doc,$trno,'ERROR REMOVING ITEM','['.$openstockdata[0]['barcode'].'] [Line: '.$line.'] ' . $openstockdata[0]['itemname'],Yii::$app->session['loggeduser']['username']);
                }//end if
            }//end if

            if(!empty($stockdata)){
                if($stockdata[0]['refx']!=0){
                    Postock::setserveditems($stockdata[0]['linex'], $stockdata[0]['refx'],$doc);
                }
            }
        }//end delete


        public static function getpreviousTrans_($module,$barcode, $client){
        switch($module){
                    case 'SO': case 'QT':{
                        $doc="SJ";
                        $base='isamt';
                        $qty='isqty';
                        break;
                    }

                    case 'pscheme': case 'PS':
                        $doc="PS";
                        $base='isamt';
                        $qty='isqty';
                    break;

                    case 'SJ': case 'CH':{
                        $doc="SJ";
                        $base='isamt';
                        $qty='isqty';
                        break;
                    }
                    case 'CM':{
                        $doc="SJ";
                        $base='isamt';
                        $qty='rrqty';
                        break;
                    }

                    case 'PR':{
                        $doc="PR";
                        $base='rrcost';
                        $qty='rrqty';                        
                     break;   
                    }      
                    // SALON MODIFICATION
                    case 'TR':
                    // END SALON                    
                    case 'PO':case 'PC':{
                        $doc="RR";
                        $base='rrcost';
                        $qty='rrqty';
                        break;
                    }
                    case 'RR':case 'CA':{
                        $doc="RR";
                        $base='rrcost';
                        $qty='rrqty';
                        break;
                    }
                    case 'DM':{
                        $doc="SJ";
                        $base='isamt';
                        $qty='isqty';
                        break;
                    }
                    case 'TS':case 'PU':{
                        $doc="SJ";
                        $base='isamt';
                        $qty='isqty';
                        break;
                    }
                    case 'AJ':
                    case 'MI':
                    case 'IS':{
                        $doc=$module;
                        $base='rrcost';
                        $qty='rrqty';
                        break;
                    }

                }
            $tablehead=Common::localhead($doc); // to get 5 previous data from receiving module
            $tablestock=Common::localstock($doc); // to get 5 previous data from receiving module
            
            switch ($doc) {
                case 'PR':{
                 $glhead=Common::localhhead($doc);
                 $glstock=Common::localhstock($doc);
    
                $trans= Yii::$app->sbccommon->opentable("
                    select left(head.dateid,10) as dateid,head.docno,
                    round(stock.$base,2) as $base,
                    stock.cost,stock.disc as disc,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    stock.$qty as qty,
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as qa,
                    round((stock.qty-stock.tsqa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as tsqa 
                    from $tablehead as head
                    left join $tablestock as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode 
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom    
                    where head.doc='$doc' and head.client='$client' and stock.barcode='$barcode' limit 5
                    UNION ALL
                    select left(head.dateid,10) as dateid,head.docno,round(stock.$base,2) as rrcost,
                    stock.cost as cost,stock.disc as disc,
                    round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    stock.$qty as qty,
                    round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as qa,
                    round((stock.qty-stock.tsqa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as tsqa
                    from $glhead as head
                    left join $glstock as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode 
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom                            
                    where head.doc='$doc' and head.client='$client' and stock.barcode='$barcode'
                    order by dateid desc limit 5
                ");


                    break;}

                default:{
                 $glhead=Common::glhead();
                 $glstock=Common::glstock();

                $trans= Yii::$app->sbccommon->opentable("
                    select left(head.dateid,10) as dateid,head.docno,round(stock.$base,2) as $base,
                    stock.cost as cost,
                    stock.disc as disc,round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
                    stock.amt as amt, stock.$qty as qty
                    from $tablehead as head
                    left join $tablestock as stock on stock.trno=head.trno
                    where head.doc='$doc' and head.client='$client' and stock.barcode='$barcode'  limit 5
                    UNION ALL
                    select left(head.dateid,10) as dateid,head.docno,round(stock.$base,2) as rrcost,
                    round(stock.cost,2) as cost,
                    stock.disc as disc,round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.amt as amt,stock.$qty as qty
                    from $glhead as head
                    left join $glstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid
                    left join item on item.itemid=stock.itemid
                    where head.doc='$doc' and client.client='$client' and item.barcode='$barcode'
                    order by dateid desc limit 5
                ");                    
                    break;}
            }
            return $trans;
        }
        
        public static function voiditem($line,$trno,$module){
            switch($module){
                case 'RR':case 'CA':{
                    $table=Common::localhstock('PO');
                    return Yii::$app->sbccommon->execqry("update $table set void=1 where trno='$trno' and line='$line'");
                    break;
                }
                case 'SJ':{
                    $table=Common::localhstock('SO');
                    return Yii::$app->sbccommon->execqry("update $table set void=1 where trno='$trno' and line='$line'");
                    break;
                }
            }
        }

        // XANDABELS
        public static function getgrandtotal($trno,$doc){
            $table=Common::localstock($doc);
            $htable=Common::localhstock($doc);

            //to determine what to sum up for total kilo
            switch ($doc) {
                // SALON MODIFICATION
                case 'TR':
                // END SALON  
                case 'PO': case 'PR': case 'PC': case 'PD': case 'PI': case 'SP':
                    $qty = 'rrqty';
                break;

                case 'SO': case 'QA': case 'pscheme': case 'PS': case 'quotation': case 'QT': 
                case 'JB':
                    $qty = 'isqty';
                break;
            }//end switch case doc

            switch ($doc) {
                case 'KR': case 'RF': case 'TX':
                    return Yii::$app->sbccommon->opentable("
                        select round(0,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                        count(trno) as itemcount,
                        round(0,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                        FROM $table where trno ='$trno' group by trno
                        union all
                        SELECT round(0,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                        count(trno) as itemcount,
                        round(0,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                        FROM $htable where trno ='$trno' group by trno");
                    break;
                
                default:
                    switch ($doc) {
                        case 'SO': case 'TX': case 'QA':
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'SOUTHCENTRAL':
                                    $garray = Yii::$app->sbccommon->opentable("
                                            select round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                                            count(trno) as itemcount,
                                            round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                                            FROM $table where trno ='$trno' group by trno
                                            union all
                                            SELECT round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                                            count(trno) as itemcount,
                                            round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                                            FROM $htable where trno ='$trno' group by trno");

                                    if(!empty($garray)){
                                        $garray[0]['totalcbm'] = Yii::$app->backend->getGrandTotalCBM($doc,$trno);
                                        $garray[0]['totaltonnage'] = Yii::$app->backend->getGrandTotalTons($doc,$trno);
                                    }//end if !empty garray - JAOSKI POGI

                                    return $garray;
                                break;

                                default:
                                    $garray = Yii::$app->sbccommon->opentable("
                                            select round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                                            count(trno) as itemcount,
                                            round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                                            FROM $table where trno ='$trno' group by trno
                                            union all
                                            SELECT round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                                            count(trno) as itemcount,
                                            round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                                            FROM $htable where trno ='$trno' group by trno");

                                    return $garray;

                                break;

                            } // end switch companyid    


                        break;
                        
                        default:
                            $garray = Yii::$app->sbccommon->opentable("
                                    select round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                                    count(trno) as itemcount,
                                    round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                                    FROM $table where trno ='$trno' group by trno
                                    union all
                                    SELECT round(sum(".$qty."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as kilototal,
                                    count(trno) as itemcount,
                                    round(sum(ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal
                                    FROM $htable where trno ='$trno' group by trno");

                        return $garray;
                            break;

                    } // end switch doc
                    break;
            }//END SWITCH
        }

        // END XANDABELS


        public static function resetQuantity($line,$trno,$module){
            $localheadtable=Common::localhead($module);
            $localstocktable=Common::localstock($module);
            $user=Yii::$app->session['loggeduser']['username'];
            switch($module){
                case 'RR':case 'CM':case 'CA':case 'PO':{
                    Yii::$app->sbccommon->execqry("update ".$localstocktable." set  rrqty=0,qty=0,ext=0, editby='COMPUTER', editdate=CURRENT_TIMESTAMP where trno='".$trno."' and line='".$line."'");
                    break;
                }
                case 'SJ': case 'DM':{
                    Yii::$app->sbccommon->execqry("update ".$localstocktable." set  isqty=0,iss=0,ext=0, editby='COMPUTER', editdate=CURRENT_TIMESTAMP where trno='".$trno."' and line='".$line."'");
                    break;
                }//end switch sj

                case 'SJ2':{
                    Yii::$app->sbccommon->execqry("update ".$localstocktable." set  isqty2=0,iss2=0,ext=0, editby='COMPUTER', editdate=CURRENT_TIMESTAMP where trno='".$trno."' and line='".$line."'");
                    break;
                }//end switch sj2


            }//end module
        }

        public static function recomputeServedItems($line,$trno,$module){
            $localheadtable=Common::localhead($module);
            $localstocktable=Common::localstock($module);
             switch($module){
                case 'SJ':{
                    Yii::$app->sbccommon->execqry("update ".$localstocktable." set  isqty=0,iss=0,ext=0, editby='COMPUTER', editdate=CURRENT_TIMESTAMP where trno='".$trno."' and line='".$line."'");
                    break;
                }
            }
        }




        public static function setserveditems($linex,$refx,$module){
            if($refx!=0){
                $user=Yii::$app->session['loggeduser']['username'];
                $date=date("Y-m-d H:i:s");
                $localheadtable=Common::localhead($module);
                $localstocktable=Common::localstock($module);

                if($module == 'SJ2'){
                    $iss = 'ifnull(sum(iss2),0) as iss';
                }else{
                    $iss = 'ifnull(sum(iss),0) as iss';
                }//end if
                $qty = 'ifnull(sum(qty),0) as qty';


                switch($module){
                    case 'RR': case 'SJ': case 'DM': case 'CM':  {
                       $qry ="select stock.iss,stock.qty from ".$localheadtable." as head left join ".$localstocktable." as 
                       stock on stock.trno=head.trno where head.doc='".$module."' and stock.refx=".$refx." and stock.linex=".$linex;
                       
                       $qry = $qry." union all select glstock.iss,glstock.qty from glhead left join glstock on glstock.trno=
                       glhead.trno where glhead.doc='".$module."' and glstock.refx=".$refx." and glstock.linex=".$linex;
                       
                       $qry = $qry." union all select hglstock.iss,hglstock.qty from hglhead left join hglstock on 
                       hglstock.trno=hglhead.trno where hglhead.doc='".$module."' and hglstock.refx=".$refx." and 
                       hglstock.linex=".$linex; 
                        break;
                    }//end rr sj sj2

                    case 'SJ2':  {
                       $module2 = 'SJ';
                       $qry ="select stock.iss2,stock.qty from ".$localheadtable." as head left join ".$localstocktable." as 
                       stock on stock.trno=head.trno where head.doc='".$module2."' and stock.refx=".$refx." and stock.linex=".$linex;
                       
                       $qry = $qry." union all select glstock.iss2,glstock.qty from glhead left join glstock on glstock.trno=
                       glhead.trno where glhead.doc='".$module2."' and glstock.refx=".$refx." and glstock.linex=".$linex;
                       
                       $qry = $qry." union all select hglstock.iss2,hglstock.qty from hglhead left join hglstock on 
                       hglstock.trno=hglhead.trno where hglhead.doc='".$module2."' and hglstock.refx=".$refx." and 
                       hglstock.linex=".$linex; 
                        break;
                    }//end rr sj sj2

                    case 'PO': {
                       $qry ='select stock.qty from pohead as head left join postock as stock on stock.trno=head.trno where stock.refx='.$refx.' and stock.linex='.$linex;
                       $qry = $qry.' union all select stock.qty from hpohead as head left join hpostock as stock on stock.trno=head.trno where stock.refx='.$refx.' and stock.linex='.$linex;
                        break;
                    }

                    // JAOPOGI
                    case 'TS': {
                       $qry ="select stock.iss ,stock.qty from ".$localheadtable." as head left join ".$localstocktable." as 
                       stock on stock.trno=head.trno where head.doc='".$module."' and stock.refx=".$refx." and stock.linex=".$linex;
                       
                       $qry = $qry." union all select glstock.iss ,glstock.qty from glhead left join glstock on glstock.trno=
                       glhead.trno where glhead.doc='".$module."' and glstock.refx=".$refx." and glstock.linex=".$linex;
                       
                       $qry = $qry." union all select hglstock.iss ,hglstock.qty from hglhead left join hglstock on 
                       hglstock.trno=hglhead.trno where hglhead.doc='".$module."' and hglstock.refx=".$refx." and 
                       hglstock.linex=".$linex; 
                     
                        break;
                    }
                    // END POGI
                }//switch($module)


                switch($module){
                    case 'SO':
                       $doc='QA';
                    break;
                    
                    case 'PO':
                            $doc='PR';
                            break;
                    case 'RR':case 'CA':{
                            $doc='PO';
                            break;
                              }
                    case 'SJ': case 'SJ2': {
                            $doc='SO';
                            break;
                              }
                    case 'CM':{
                            $doc='SJ';
                              break;
                               }
                    // JAOPOGI           
                    case 'TS':{
                            $doc='TR';
                              break;
                      } 
                    // END POGI            

                    case 'DM':{
                            $doc='RR';
                            break;
                    }
                }//switch($module)
                $updatetable=Common::localhstock($doc);

                switch($module){
                    case 'PO': case 'RR':case 'CA': case 'CM': {
                        $tqty=Yii::$app->sbccommon->datareader("select ".$qty." from (".$qry.") as T");
                    break;
                    }//end case
                    case 'SJ': case 'TS':case 'PU': case 'DM': case 'SJ2': {
                        $tqty=Yii::$app->sbccommon->datareader("select ".$iss." from (".$qry.") as T");
                    break;
                    }//end case 
                }//switch($module)



                if ($tqty==null){
                    $tqty=0;
                }//END IF $TQTY == NUll


                //echo "select ".$iss." from (".$qry.") as T";

                switch($module){
                    case 'PO': case 'RR': case 'CA':{
                        if(Yii::$app->sbccommon->execqry("update ".$updatetable." set qa='$tqty' where trno='".$refx."' and line='".$linex."'")!=1){
                            return false;
                        }else{
                            return true;
                        }//end if
                        break;
                      }
                    case 'TS':case 'PU':{
                        if(Yii::$app->sbccommon->execqry("UPDATE $updatetable SET qa='$tqty' where trno='$refx' and line='$linex'")!=1){
                            return false;
                        }else{
                            return true;
                        }//end if
                    break;                   
                    }//end case    

                    case 'DM': case 'CM': case 'SJ': case 'SJ2':{
                        if(Yii::$app->sbccommon->execqry("update ".$updatetable." set qa='".$tqty."' where trno='".$refx."' and line='".$linex."'") !=1){
                              return false;
                        }else{
                            if(Yii::$app->sbccommon->execqry("update hglstock set qa='".$tqty."'  where trno='".$refx."' and line='".$linex."'")!=1){
                                return false;
                            }else{
                                return true;
                            }//end if
                        }//end else
                    break;
                    }//end case 
                    
                    default:{
                        return true;
                    break;
                    }//end case 
                  }//switch($module)
          } // if($refx!=0)          
}//setserveditems




        
        public static function getmaxQuantity($module,$refx,$linex,$trno, $line)
        {
            switch($module){
                case 'RR':case 'CA':{
                    $localtable=Common::localstock('RR');
                    $stock=Common::localhstock('PO');
                    return Yii::$app->sbccommon->opentable("
                    select  po.qty as rrqty, po.qty-po.qa as pending, la.qty as oldqty
                    from $localtable as la
                    left join $stock as po on po.trno=la.refx and po.line=la.linex
                    where po.trno='$refx' and po.line='$linex' and la.trno='$trno' and la.line='$line'");
                    break;
                }
                case 'SJ':{
                    $localtable=Common::localstock('SJ');
                    $stock=Common::localhstock('SO');
                    return Yii::$app->sbccommon->opentable("
                    select  so.iss as rrqty, so.iss-so.qa as pending, la.iss as oldqty
                    from $localtable as la
                    left join $stock as so on so.trno=la.refx and so.line=la.linex
                    where so.trno='$refx' and so.line='$linex' and la.trno='$trno' and la.line='$line'");
                    break;
                }
                case 'CM':{
                    $localtable=Common::localstock('SJ');
                    $stock=Common::localhstock('SO');
                    return Yii::$app->sbccommon->opentable("
                    select  so.iss as rrqty, so.iss-so.qa as pending, la.iss as oldqty
                    from $localtable as la
                    left join $stock as so on so.trno=la.refx and so.line=la.linex
                    where so.trno='$refx' and so.line='$linex' and la.trno='$trno' and la.line='$line'");
                    break;
                }
            }
            
            
        }
        
        public static function updateremarks($model,$trno,$line){
           $model->addremarks= str_replace("'","`",$model->addremarks);
          // $sql="update qtstock set addremarks = '$model->addremarks' where trno = '$trno' and line ='$line'";
           return Yii::$app->sbccommon->execqry("update qtstock set addremarks = '$model->addremarks' where trno = '$trno' and line ='$line'");
          
          
}




}