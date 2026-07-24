<?php
//WTODO: [KIM][2019.10.09][JB slitting and lamination layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Slitting and Lamination';
//WTODO: [KIM][2019.10.30][updated lamination layout]
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
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('SLITTING REPORT',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JO No &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['docno'].'&nbsp&nbsp&nbsp&nbsp'.$data[0]['clientname'],null,null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Product &nbsp&nbsp&nbsp&nbsp: '.$data[0]['barcode'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$data[0]['itemname'],null,null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('SLITTING/REWIND','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('CENTER SEAL/REWIND','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('DATE','80',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('TIME SUMMARY','170',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('NO. OF HRS','150',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Blowing Reject : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('Center Seal Output : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','80',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','150',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Lamination Reject : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('Printing Reject : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','80',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','150',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Slitting Reject : ','200',null,false,'1px dashed ','TLR','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Gusset width : ','200',null,false,'1px dashed ','TLR','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','80',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','150',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Slitted Output : ','200',null,false,'1px dashed ','LR','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','200',null,false,'1px dashed ','LRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','80',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','150',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Final Width : ','200',null,false,'1px dashed ','LRB','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Folded Output :','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','80',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','150',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('No. of rolls : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('Cntr seal reject : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','80',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','170',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','150',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Trimming : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('Folding reject : ','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','80',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('TOTAL TIME','170',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','150',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();

  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');

    $qry = "select instruct from jb_processtab where code in ('1S','2S','3S','4S','5S') and trno = " . $data[0]['trno'] . "";
    $instruct = Yii::$app->sbccommon->datareader($qry);

    $c_index = 0;
    for ($i=0; $i < 10; $i++) {
      $c_index += 1;
      if(isset($instruct[$i]['instruct'])){
        $pack = $instruct[$i]['instruct'];
      }else{
        $pack = '';
      }//end if
      $process[$c_index] = $pack;
    }

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Slitting Instructions : ' .$process[1],null,null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Operators : ','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($operator,'220',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Reported by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($reported,'250',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['username']).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    // $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_companyname'],'800',null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  

  Yii::$app->reporter->begintable('800');
    // $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','350',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('LAMINATION','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('JO # : '.$data[0]['docno'],'250',null,false,'1px solid ','','R','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Customer : '.$data[0]['clientname'],'540',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Date','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('Time','130',null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Product &nbsp&nbsp&nbsp: '.$data[0]['barcode'].'&nbsp&nbsp&nbsp'.$data[0]['itemname'],'800',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Plastic &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_combi'].'&nbsp&nbsp&nbsp'.$data[0]['fg_plasticcolor'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','208',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','11',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('SET-UP','60',null,false,'1px solid ','LR','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','9',null,false,'1px solid ','','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->col('Start &nbsp&nbsp: ','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->col('','5',null,false,'1px solid ','R','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
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
      Yii::$app->reporter->col('Size &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$jolength.'&nbsp&nbspX&nbsp&nbsp'.$jowidth.' '.$data[0]['fg_jowidthuom'].' ' . $data[0]['fg_thickness'] . ' ' .$data[0]['fg_thicknessuom'],'420',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','L','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp','50',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','R','L','Century Gothic','12','','','');
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
      Yii::$app->reporter->col('','300',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('PRESS','60',null,false,'1px solid ','LR','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Start &nbsp: ','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->col('','5',null,false,'1px solid ','R','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','70',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','344',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','6',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('RUNNING','60',null,false,'1px solid ','LR','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
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
      Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','8px');
      Yii::$app->reporter->col('CONTENTS (WEIGHT)','400',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','8px');
      Yii::$app->reporter->col('TOTAL','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','8px');
      
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','400',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','400',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','400',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','400',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
     Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','400',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
     Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','400',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Excess PE or CPP or OTHER : ','400',null,false,'1px dashed ','LB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('Lamination Reject : ','400',null,false,'1px dashed ','RB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Blowing Reject : ','400',null,false,'1px dashed ','LB','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('Total Wt. after 1am : ','400',null,false,'1px dashed ','RB','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

    $qry = "select instruct from jb_processtab where code = 'PACK' and trno = " . $data[0]['trno'] . "";
    $instruct = Yii::$app->sbccommon->opentable($qry);

    $c_index = 0;
    for ($i=0; $i < 10; $i++) {
      $c_index += 1;
      if(isset($instruct[$i]['instruct'])){
        $pack = $instruct[$i]['instruct'];
      }else{
        $pack = '';
      }//end if
      $process[$c_index] = $pack;
    }

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Instructions : ' . $process[1],null,null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br>';
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