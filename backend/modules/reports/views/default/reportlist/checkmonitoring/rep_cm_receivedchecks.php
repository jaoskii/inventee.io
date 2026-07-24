<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Received Checks';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=40;
$page=40;

$col=array(
        array(  '350', '', false, '1px solid','','l', 'Century Gothic', '',  '', '', '', '' ,'20'),
        array(  '150', '', false, '1px solid','','c', 'Century Gothic', '',  '', '', '', '' ,'20'),
        array(  '200', '', false, '1px solid','','c', 'Century Gothic', '',  '', '', '', '' ,'20'),
        array(  '200', '', false, '1px solid','','c', 'Century Gothic', '',  '', '', '', '' ,'20'),
        array(  '200', '', false, '1px solid','','c', 'Century Gothic', '',  '', '', '', '' ,'20'),
        array(  '200', '', false, '1px solid','','r', 'Century Gothic', '',  '', '', '', '' ,'20'),
);
$group='';
$c = 0;
$total =0;
Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('RECEIVED CHECKS',null,null,false,'1px solid ','','','Century Gothic','15','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Date Base on : '.strtoupper($params['reporttransaction']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
   Yii::$app->reporter->printline();
                  Yii::$app->reporter->begintable();
                    
                  Yii::$app->reporter->col('Customer Name', '350', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'600');
                  Yii::$app->reporter->col('Document #', '150', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Trans. Date', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Check Info', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Check Date', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Amount', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
  Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable();
if ($data==null){
} else {
foreach($data as $key => $data_){
    
        if(($group=='' || ($group!=$data_['clientname'] && $data_['clientname']!=''))) {
        if ($data_['clientname']=='') {
            $group='NO GROUP';
        }
        else {
               Yii::$app->reporter->col('', '350', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '180', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '200', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '200', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '200', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
              if($c==0){
               Yii::$app->reporter->col('', '', false, '1px dashed','T','r', 'Century Gothic', '',  'i', '', '', '' ,'20');
              }else{
                   Yii::$app->reporter->col('Sub Total: '.number_format($c,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200', '', false, '1px dashed','T','r', 'Century Gothic', '',  'i', '', '', '' ,'20');
              }
           
            $c=0;
            $group=$data_['clientname'];
        }
      
 Yii::$app->reporter->startrow();
 Yii::$app->reporter->col($group, '350', '', false, '1px solid','','l', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '180', '', false, '1px solid','','l', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '200', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '200', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
               Yii::$app->reporter->col('', '200', '', false, '1px solid','','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
             
                 if($c==0){
               Yii::$app->reporter->col('', '', false, '1px dashed','T','r', 'Century Gothic', '',  'i', '', '', '' ,'20');
              }else{
                   Yii::$app->reporter->col('Sub Total: '.number_format($c,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200', '', false, '1px dashed','T','r', 'Century Gothic', '',  'i', '', '', '' ,'20');
              }
Yii::$app->reporter->endrow();
    }
    
    
    Yii::$app->reporter->startrow();
    //$txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
     Yii::$app->reporter->addline();
     $value=array('',$data_['docno'],date('M-d-Y', strtotime($data_['pridate'])),$data_['chkinfo'],date('M-d-Y', strtotime($data_['suppdate'])),number_format($data_['amount'],Yii::$app->systemsettings->setDecimaldisplay('currency')));
    $c=$c+$data_['amount'];
     $total = $total + $c;
    Yii::$app->reporter->row($col,$value);
    Yii::$app->reporter->endrow();
    
    if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';


        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('RECEIVED CHECKS',null,null,false,'1px solid ','','','Century Gothic','','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Date Base on : '.strtoupper($params['reporttransaction']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->printline();


Yii::$app->reporter->endtable();

   Yii::$app->reporter->printline();
                  Yii::$app->reporter->begintable();
                    
                  Yii::$app->reporter->col('Customer Name', '350', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'600');
                  Yii::$app->reporter->col('Document #', '150', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Trans. Date', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Check Info', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Check Date', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
                  Yii::$app->reporter->col('Amount', '200', '', false, '1px dashed','B','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
  Yii::$app->reporter->endtable();
  
        Yii::$app->reporter->begintable();
        $page=$page + $count;
    }
}
}
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Grand Total: ', '350', '', false, '1px dashed','T','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
    Yii::$app->reporter->col('', '180', '', false, '1px dashed','T','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
    Yii::$app->reporter->col('', '200', '', false, '1px dashed','T','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
    Yii::$app->reporter->col('', '200', '', false, '1px dashed','T','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
    Yii::$app->reporter->col('', '200', '', false, '1px dashed','T','c', 'Century Gothic', '',  'b', '', '', '' ,'20');
    //$txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
    Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')), '200', '', false, '1px dashed','T','r', 'Century Gothic', '',  'b', '', '', '' ,'20');

  Yii::$app->reporter->endrow();
  
Yii::$app->reporter->endtable();
 Yii::$app->reporter->printline();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>