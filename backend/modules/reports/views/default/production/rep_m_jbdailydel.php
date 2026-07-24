<?php
//WTODO: [KIM][2019.10.09][JB daily delivery report layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Daily Delivery Report';
//WTODO: [KIM][2019.10.30][updated daily delivery layout]
//WTODO: [KIM][2019.11.13][update layout for daily delivery]
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
      Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['username']).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],'400',null,false,'1px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],'400',null,false,'1px solid ','','C','Century Gothic','11','','','');//Yii::$app->session['sysconfig']['report_companyname']
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('DAILY DELIVERY REPORT','400',null,false,'1px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('DAILY DELIVERY REPORT','400',null,false,'1px solid ','','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JO No &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['docno'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Date : ','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','80',null,false,'1px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('JO No &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['docno'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Date : ','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','80',null,false,'1px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Customer : '.$data[0]['clientname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Customer : '.$data[0]['clientname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Order Qty : '.number_format($data[0]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity')).'&nbsp&nbsp'.$data[0]['uom'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Order Qty : '.number_format($data[0]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity')).'&nbsp&nbsp'.$data[0]['uom'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Material &nbsp&nbsp&nbsp: '.$data[0]['fg_combi'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Material &nbsp&nbsp&nbsp: '.$data[0]['fg_combi'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Plastic &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_plasticcolor'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Plastic &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_plasticcolor'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Product &nbsp&nbsp&nbsp: '.$data[0]['barcode'].'&nbsp&nbsp&nbsp'.$data[0]['itemname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Product &nbsp&nbsp&nbsp: '.$data[0]['barcode'].'&nbsp&nbsp&nbsp'.$data[0]['itemname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('No. of Printing Color : ' .$data[0]['fg_colornum'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('No. of Printing Color : ','300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
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
      Yii::$app->reporter->col('Size &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$jowidth.'&nbsp&nbspX&nbsp&nbsp'.$jolength . ' ' . $data[0]['fg_jolengthuom'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Size &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$jowidth.'&nbsp&nbspX&nbsp&nbsp'.$jolength . ' ' .$data[0]['fg_jolengthuom'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Thickness &nbsp&nbsp: '.$data[0]['fg_thickness'].'&nbsp&nbsp'.$data[0]['fg_thicknessuom'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Thickness &nbsp&nbsp: '.$data[0]['fg_thickness'].'&nbsp&nbsp'.$data[0]['fg_thicknessuom'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('G/PC: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_gramppiece1'].' - '.$data[0]['fg_gramppiece2'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('G:PC: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$data[0]['fg_gramppiece1'].' - '.$data[0]['fg_gramppiece2'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Packing &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Packing &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();

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

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Instruction&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$process[1],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Instruction&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$process[1],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$process[2],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$process[2],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('QC','50',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Cutter','75',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Bndls','50',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Pcs','50',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Weight','125',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','');

      Yii::$app->reporter->col('QC','50',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Cutter','75',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Bndls','50',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Pcs','50',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Weight','125',null,false,'1px solid ','TLRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');

      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','75',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','LRB','C','Century Gothic','11','','','8px');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','8px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Total : ','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Total : ','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('Total : ','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Total : ','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Complete &nbsp[&nbsp&nbsp]','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Partial &nbsp[&nbsp&nbsp]','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('Complete &nbsp[&nbsp&nbsp]','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('Partial &nbsp[&nbsp&nbsp]','125',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Prepared by : ','80',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col($prepared,'220',null,false,'1px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('Prepared by : ','80',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col($prepared,'220',null,false,'1px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
Yii::$app->reporter->endreport();

?>