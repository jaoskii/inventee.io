<?php
//WTODO: [KIM][2019.10.09][JB printing layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Printing Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

$c_index = 0;
for ($i=0; $i < 10; $i++) { 
  $c_index += 1;
  if(isset($data[$i]['name'])){
    $color = $data[$i]['name'];
  }else{
    $color = '';
  }//end if
  $colors[$c_index] = $color;
}


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
      Yii::$app->reporter->col('PRINTING REPORT',null,null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('J.O. # : '.$data[0]['docno'],null,null,false,'1px solid ','','R','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Customer : '.$data[0]['clientname'],'540',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Product &nbsp&nbsp&nbsp: '.$data[0]['barcode'].'&nbsp&nbsp&nbsp'.$data[0]['itemname'],'800',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Plastic &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_combi'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Color:' . $data[0]['fg_plasticcolor'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','140',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Date','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('Time','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');

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
      Yii::$app->reporter->col('Size &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$jowidth.'&nbsp&nbspX&nbsp&nbsp'.$jolength.'&nbsp&nbsp&nbsp'.$data[0]['fg_jowidthuom'],'420',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('`SET-UP &nbsp&nbsp`','70',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Start &nbsp&nbsp: ','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->col('','5',null,false,'1px solid ','R','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Thickness &nbsp&nbsp: '.$data[0]['fg_thickness'].'&nbsp&nbsp&nbsp'.$data[0]['fg_thicknessuom'],'420',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('`&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp`','60',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Finish : ','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->col('','5',null,false,'1px solid ','R','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Machine &nbsp&nbsp: ','70',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','350',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('`PRESS &nbsp&nbsp&nbsp`','60',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Start &nbsp&nbsp: ','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->col('','5',null,false,'1px solid ','R','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Solvent Consumed :','130',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','290',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('`RUNNING`','60',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Finish : ','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->col('','5',null,false,'1px solid ','R','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('COLOR','290',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','8px');
      Yii::$app->reporter->col('WT (Kg)','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','8px');
      Yii::$app->reporter->col('RETURNED (Kg)','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','8px');
      Yii::$app->reporter->col('CONSUMED (Kg)','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[1],'290',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[2],'290',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[3],'290',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[4],'290',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[5],'290',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[6],'290',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[7],'290',null,false,'1px dashed ','TLR','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[8],'290',null,false,'1px dashed ','TLR','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[9],'290',null,false,'1px dashed ','TLR','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$colors[10],'290',null,false,'1px dashed ','TLR','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();

  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','460',null,false,'1px dashed ','TLR','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','340',null,false,'1px dashed ','TLR','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','460',null,false,'1px dashed ','LR','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','340',null,false,'1px dashed ','LR','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbspBlowing Reject : ','460',null,false,'1px dashed ','LR','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp&nbspPrinting Reject &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','340',null,false,'1px dashed ','LR','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbspSetup Reject &nbsp&nbsp&nbsp: ','460',null,false,'1px dashed ','LRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp&nbspPrinted Wt Output : ','340',null,false,'1px dashed ','LRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    $qry = "select instruct from jb_processtab where trno = " . $data[0]['trno'] . " limit 1";
    $instruct = Yii::$app->sbccommon->datareader($qry);
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Instructions : ' . $instruct,null,null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('[&nbsp&nbsp] CYLINDER','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('[&nbsp&nbsp] PRINTED SAMPLE','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('[&nbsp&nbsp] INK W/ DOCUMENT','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('[&nbsp&nbsp] PLASTIC MATERIAL','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Operator : ','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($operator,'220',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Leadman : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($leadman,'250',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>