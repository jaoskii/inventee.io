<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Commission Detail';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;


Yii::$app->reporter->beginreport('1100');
Yii::$app->reporter->begintable('1100');
$header=Yii::$app->reporter->letterhead();

$totalext=0;

for($i=0;$i<count($data);$i++){
    $totalext=$totalext+$data[$i]['ext'];
}



    Yii::$app->reporter->begintable('1100');
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','18','B','','');
                    Yii::$app->reporter->col('COMMISSION DETAIL','200',null,false,'1px solid ','','C','Century Gothic','15','','','5px');
                    Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','13','','','');
                Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
 
    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('DOCNO : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','4px');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'500',null,false,'1px solid ','B','L','Century Gothic','12','','','4px');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Century Gothic','12','B','','4px');
            Yii::$app->reporter->col('TOTAL : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'500',null,false,'1px solid ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('SALESMAN : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'500',null,false,'1px solid ','B','L','Century Gothic','12','','','4px');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Century Gothic','12','B','','4px');
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','','','');
          
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
   
    Yii::$app->reporter->printline();

    Yii::$app->reporter->begintable('1100');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CODE','100px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','200px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QUANTITY','100px',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('COMMISSION','100px',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','100px',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DOCNO','100px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DATE','100px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('PR NO.','100px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DATE','100px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
       
       $totalext=0;
        for($i=0;$i<count($data);$i++){
          Yii::$app->reporter->startrow();
          Yii::$app->reporter->addline();
         Yii::$app->reporter->col($data[$i]['barcode'],'100px',null,false,'1px dotted ','T','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'200px',null,false,'1px dotted ','T','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($data[$i]['qty'],'100px',null,false,'1px dotted ','T','R','Century Gothic','12','','','');
        Yii::$app->reporter->col(number_format($data[$i]['commamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100px',null,false,'1px dotted ','T','R','Century Gothic','12','','','');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100px',null,false,'1px dotted ','T','R','Century Gothic','12','','','');
       
        Yii::$app->reporter->col($data[$i]['cdocno'],'100px',null,false,'1px dotted ','T','R','Century Gothic','12','','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'100px',null,false,'1px dotted ','T','R','Century Gothic','12','','','');
        Yii::$app->reporter->col($data[$i]['prdocno'],'100px',null,false,'1px dotted ','T','R','Century Gothic','12','','','');
        Yii::$app->reporter->col($data[$i]['prdate'],'100px',null,false,'1px dotted ','T','R','Century Gothic','12','','','');
       

          $totalext=$totalext+$data[$i]['ext'];
   

}   

      
    // Yii::$app->reporter->startrow();
    //   Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    //   Yii::$app->reporter->col('','100px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    //   Yii::$app->reporter->col('','100px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    //   Yii::$app->reporter->col('','10px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    //   Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    //   Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    //   Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
      
     
    //   Yii::$app->reporter->col('GRAND TOTAL :','150px',null,false,'1px dotted ','T','L','Century Gothic','12','B','','8px');
    //   Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    //   Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    // Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','8px');
    // Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();

   
    // Yii::$app->reporter->printline();
    // echo '<br/>';
    // Yii::$app->reporter->begintable('800');
    // Yii::$app->reporter->startrow();
    // Yii::$app->reporter->col('NOTE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    // Yii::$app->reporter->col('','160',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
    // Yii::$app->reporter->endrow();
    // Yii::$app->reporter->endtable();
    // echo '<br/><br/>';
    // Yii::$app->reporter->begintable('800');
    //     Yii::$app->reporter->startrow();
    //     Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
    //     Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
    //     Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
    //     Yii::$app->reporter->endrow();
    // Yii::$app->reporter->endtable();
    
    // echo '<br/>';
    // Yii::$app->reporter->begintable('800');
    //     Yii::$app->reporter->startrow();
    //     Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    //     Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
    //     Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
    //     Yii::$app->reporter->endrow();
    // Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endreport();


?>