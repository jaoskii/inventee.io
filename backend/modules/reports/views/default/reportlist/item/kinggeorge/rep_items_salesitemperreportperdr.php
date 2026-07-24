<?php
use yii\base\ErrorException;
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Item Per Report Per DR';
try {
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>


<?php
Yii::$app->reporter->beginreport('1000');
    Yii::$app->reporter->begintable('1000');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Sales Item Per Report Per DR',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow()
        ;
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('1000'); 
            Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
            Yii::$app->reporter->col('Start : ' . $params['start'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
            Yii::$app->reporter->col('End : ' . $params['end'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');        
            Yii::$app->reporter->pagenumber('Page');
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->printline();


    Yii::$app->reporter->begintable('1000'); 
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('SALES','200',null,false,'1px solid ','LT','C','Century Gothic','9','B','','');    
            Yii::$app->reporter->col('RETURN','200',null,false,'1px solid ','RT','C','Century Gothic','9','B','','');        
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('DR DATE','50',null,false,'1px solid ','LTB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('DR #','50',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('CUSTOMER','100',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('UOM','30',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('ITEMNAME','100',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('PRICE','50',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','50',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('SR DATE','50',null,false,'1px solid ','TLB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('SR DOC','50',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('UOM','30',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('PRICE','50',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('SR TOTAL','50',null,false,'1px solid ','TB','C','Century Gothic','9','B','30px','8px');
        Yii::$app->reporter->col('NET SALES','50',null,false,'1px solid ','RTB','C','Century Gothic','9','B','30px','8px');
    Yii::$app->reporter->endrow();

    $gtotal = 0;
    foreach ($data as $key => $value) {
        $qry = "select left(head.dateid,10) as dateid,head.docno,stock.rrqty,stock.uom,
        stock.isamt,stock.ext from lahead as head
        left join lastock as stock on stock.trno = head.trno
        where head.doc = 'CM' and stock.linex = ".$value['line']." and stock.refx = ".$value['trno']."
        UNION ALL
        select left(head.dateid,10) as dateid,head.docno,stock.rrqty,stock.uom,stock.isamt,
        stock.ext from glhead as head
        left join glstock as stock on stock.trno = head.trno
        where head.doc = 'CM' and stock.linex = ".$value['line']." and stock.refx = ".$value['trno']."";

        $return = Yii::$app->sbccommon->opentable($qry);
        if(sizeof($return) != 0){
            if(sizeof($return) > 1){
                $returntotal = 0;

                foreach ($return as $key2 => $value2) {
                    $returntotal += $value2['ext'];
                }//end fn

                foreach ($return as $key2 => $value2) {
                    $netamt = $value['ext'] - $returntotal;

                    if($key2 == 0){
                        Yii::$app->reporter->addline();
                        Yii::$app->reporter->startrow();
                            Yii::$app->reporter->col($value['dateid'],'50',null,false,'1px dotted ','LB','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($value['docno'],'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($value['clientname'],'100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($value['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','B','R','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($value['uom'],'30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($value['itemname'],'100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($value['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($value['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($return[$key2]['dateid'],'50',null,false,'1px dotted ','BL','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($return[$key2]['docno'],'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($return[$key2]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($return[$key2]['uom'],'30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($return[$key2]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($return[$key2]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($netamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','RB','C','Century Gothic','9','B','30px','8px');
                            $gtotal += $netamt;
                        Yii::$app->reporter->endrow();
                    }else{
                        Yii::$app->reporter->addline();
                        Yii::$app->reporter->startrow();
                            Yii::$app->reporter->col('','50',null,false,'1px dotted ','LB','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','R','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($return[$key2]['dateid'],'50',null,false,'1px dotted ','BL','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($return[$key2]['docno'],'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($return[$key2]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col($return[$key2]['uom'],'30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($return[$key2]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col(number_format($return[$key2]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                            Yii::$app->reporter->col('','50',null,false,'1px dotted ','R','C','Century Gothic','9','','30px','8px');
                        Yii::$app->reporter->endrow();
                    }//end if
                }//end for each
            }else{
                $netamt = $value['ext'] - $return[0]['ext'];
                Yii::$app->reporter->addline();
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col($value['dateid'],'50',null,false,'1px dotted ','LB','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col($value['docno'],'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col($value['clientname'],'100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col(number_format($value['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','B','R','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col($value['uom'],'30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col($value['itemname'],'100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col(number_format($value['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col(number_format($value['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col($return[0]['dateid'],'50',null,false,'1px dotted ','BL','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col($return[0]['docno'],'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col(number_format($return[0]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col($return[0]['uom'],'30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col(number_format($return[0]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col(number_format($return[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                    Yii::$app->reporter->col(number_format($netamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','RB','C','Century Gothic','9','B','30px','8px');
                    $gtotal += $netamt;
                Yii::$app->reporter->endrow();
            }//end if
        }else{
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($value['dateid'],'50',null,false,'1px dotted ','LB','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col($value['docno'],'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col($value['clientname'],'100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col(number_format($value['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','B','R','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col($value['uom'],'30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col($value['itemname'],'100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col(number_format($value['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col(number_format($value['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col('','50',null,false,'1px dotted ','BL','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col('','30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
                Yii::$app->reporter->col(number_format($value['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','BR','C','Century Gothic','9','B','30px','8px');
                $gtotal += $value['ext'];
            Yii::$app->reporter->endrow();
        }//end if 
    }//end for each
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','LB','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','R','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','30',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col('GRANDTOTAL:','50',null,false,'1px dotted ','B','C','Century Gothic','9','','30px','8px');
    Yii::$app->reporter->col(number_format($gtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','BR','C','Century Gothic','9','B','30px','8px');
    $gtotal += $value['ext'];
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

    
} catch (ErrorException $e) {
    echo $e;
}
?>