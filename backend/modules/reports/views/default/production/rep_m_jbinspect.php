<?php
//WTODO: [KIM][2019.09.20][JB job order layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Inspection / Equipment Release';
//WTODO: [KIM][2019.10.30][update layout]
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
      Yii::$app->reporter->col('INSPECTION & REWIND REPORT',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Customer : '.$data[0]['clientname'],'500',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('J.O. # : '.$data[0]['docno'],'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Roll Width :','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Job Desc &nbsp: '.$data[0]['barcode'].'&nbsp&nbsp&nbsp'.$data[0]['itemname'],'500',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Operator','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('Date','100',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('Time','100',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('Roll Length','100',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('Roll Wt','100',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('Reject Wt','100',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('Remarks','100',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','200',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('TOTAL','200',null,false,'1px dashed ','TLRB','C','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
      Yii::$app->reporter->col('&nbsp','100',null,false,'1px dashed ','TLRB','L','Century Gothic','12','','','2px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  echo '</br></br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Checked by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($checked,'260',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Leadman : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($leadman,'260',null,false,'1px solid ','B','L','Century Gothic','12','','','');
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
      Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_companyname'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('EQUIPMENT RELEASE SLIP',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JO No &nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['docno'].'&nbsp&nbsp&nbsp'.$data[0]['clientname'],'500',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('To &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['wh3'].' - '.$data[0]['wh3name'],'500',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Job Desc : '.$data[0]['barcode'].'&nbsp&nbsp&nbsp'.$data[0]['itemname'],'500',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','150',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();




  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'1px dashed ','TLB','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('CYL S#','80',null,false,'1px dashed ','TRB','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px dashed ','TLB','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('DESCRIPTION','280',null,false,'1px dashed ','TRB','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('No. of Cyl','50',null,false,'1px dashed ','TRB','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px dashed ','TB','R','Century Gothic','12','','','');
      Yii::$app->reporter->col('Qty','90',null,false,'1px dashed ','TRB','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','10',null,false,'1px dashed ','TB','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('FROM WHSE','160',null,false,'1px dashed ','TRB','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('LOCATION','100',null,false,'1px dashed ','TRB','C','Century Gothic','12','','','');
       

      $stat = '';
      for($i=0;$i<count($data);$i++){
        if($data[$i]['stat'] == '1'){ 
          $stat = '';
        }else{
          $stat = '*';
        }
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->addline();
          Yii::$app->reporter->col('','10',null,false,'1px dashed ','L','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['cylbar'],'80',null,false,'1px dashed ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col('','10',null,false,'1px dashed ','L','L','Century Gothic','12','','','');
          Yii::$app->reporter->col($data[$i]['cylinder'],'280',null,false,'1px dashed ','R','L','Century Gothic','11','','','');
          Yii::$app->reporter->col('1','50',null,false,'1px dashed ','R','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($stat,'10',null,false,'1px dashed ','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col('1','90',null,false,'1px dashed ','R','C','Century Gothic','11','','','');
          Yii::$app->reporter->col('','10',null,false,'1px dashed ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col(substr($data[$i]['whid'], 0,2).ltrim(str_replace('WH', '',$data[$i]['whid']), '0').'&nbsp&nbsp&nbsp'.$data[$i]['whname'],'160',null,false,'1px dashed ','R','L','Century Gothic','11','','','');
          Yii::$app->reporter->col('','100',null,false,'1px dashed ','R','L','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();

    
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','10',null,false,'1px dashed ','TB','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('CYL S#','80',null,false,'1px dashed ','TRB','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','10',null,false,'1px dashed ','TLB','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('DESCRIPTION','280',null,false,'1px dashed ','TRB','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('No. of Cyl','50',null,false,'1px dashed ','TRB','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','10',null,false,'1px dashed ','TB','R','Century Gothic','12','','','');
        Yii::$app->reporter->col('Qty','90',null,false,'1px dashed ','TRB','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','10',null,false,'1px dashed ','TB','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('FROM WHSE','160',null,false,'1px dashed ','TRB','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('LOCATION','100',null,false,'1px dashed ','TRB','C','Century Gothic','12','','','');
      
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
    } 
  }

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Remarks : ',null,null,false,'1px dashed ','T','L','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  echo '</br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Released by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($released,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Received by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($received,'250',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>