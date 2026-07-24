<?php
//WTODO: [KIM][2019.10.09][JB cutting and reject layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Cutting and Reject Report';
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
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    // $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_companyname'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('CUTTING AND REJECT REPORT',null,null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Job Order # &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['docno'],null,null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Customer &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['clientname'],'540',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Job Description &nbsp&nbsp&nbsp: '.$data[0]['barcode'].'&nbsp&nbsp&nbsp'.$data[0]['itemname'],'800',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Plastic &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_plasticcolor'],'340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Printing Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Materials &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_combi'],'340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Cutting Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Sealing &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_sealing'],'340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Cutting Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    if($data[0]['fg_jolength'] == ''){
      $jolength = 0;
    }else{
      $jolength = number_format($data[0]['fg_jolength'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
    }//end if

    if($data[0]['fg_jowidth'] == ''){
      $jowidth = 0;
    }else{
      $jowidth = number_format($data[0]['fg_jowidth'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
    }//end if

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Size &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$jowidth.'&nbsp&nbspX&nbsp&nbsp'.$jolength.'&nbsp&nbsp&nbsp'.$data[0]['fg_jowidthuom'],'340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Cutting Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Thickness &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_thickness'].'&nbsp&nbsp&nbsp'.$data[0]['fg_thicknessuom'],'340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Cutting Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Transform &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_transform'],'340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Handle Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Folding Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Lamination Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','340',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Trimmings Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Blown Film Yield &nbsp&nbsp&nbsp&nbsp&nbsp: ','120',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','140',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Sideslit Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Reject Percentage : ','120',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','140',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Others Rej.','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','135',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('kgs','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Operator','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br></br></br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Checked by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($checked,'260',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Prepared by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($prepared,'260',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>