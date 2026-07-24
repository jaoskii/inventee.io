<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Withdrawal Form';
//WTODO: [KIM][2019.11.13][withdrawal slip layout]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;
Yii::$app->reporter->beginreport();
    Yii::$app->reporter->begintable('800');
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['username']).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],null,null,false,'1px solid ','','C','Century Gothic','13','B','','').'<br />';
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('WITHDRAWAL FORM',null,null,false,'1px solid ','','C','Century Gothic','13','B','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  


    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('','520',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('DOC NO : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'160',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('','520',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('DATE : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

   

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Notes','70',null,false,'1px dashed ','TB','L','Century Gothic','12','B','','2px');
            Yii::$app->reporter->col('Ref No','50',null,false,'1px dashed ','TB','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Barcode','100',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Description','300',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Unit','50',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Qty','70',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            
            Yii::$app->reporter->col('Warehouse','80',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Location','70',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Chk','10',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');

   
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
            Yii::$app->reporter->col($data[$i]['srem'],'70',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['ref'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'70',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['whname'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['loc'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col('[&nbsp&nbsp]','50px',null,false,'1px solid ','','C','Century Gothic','11','','','');
      
        
    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();


   Yii::$app->reporter->begintable('800');
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['username']).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],null,null,false,'1px solid ','','C','Century Gothic','13','B','','').'<br />';
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('WITHDRAWAL FORM',null,null,false,'1px solid ','','C','Century Gothic','13','B','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  


    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('','520',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('DOC NO : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'160',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('','520',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('DATE : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Notes','70',null,false,'1px dashed ','TB','L','Century Gothic','12','B','','2px');
            Yii::$app->reporter->col('Ref No','50',null,false,'1px dashed ','TB','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Barcode','100',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Description','300',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Unit','50',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Qty','70',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            
            Yii::$app->reporter->col('Warehouse','100',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Location','50',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Chk','10',null,false,'1px dashed ','TB','C','Century Gothic','12','B','','');

   
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->printline();
    $page=$page + $count;
    }
}   
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp','800',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';

    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Checked By : ','400',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('Approved By :','400',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($checked,'200',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    
    Yii::$app->reporter->col($approved,'200',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    
   
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>