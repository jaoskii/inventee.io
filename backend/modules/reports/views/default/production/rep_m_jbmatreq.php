<?php
//WTODO: [KIM][2019.09.20][JB material request layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Material Request';
//WTODO: [KIM][2019.11.13][update layout][material request]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;


Yii::$app->reporter->beginreport();

  Yii::$app->reporter->begintable('800');
    // $header=Yii::$app->reporter->letterhead();
    // 
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['username']).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('MATERIAL REQUEST',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '</br></br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Date &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['dateid'],'350',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('WITHDRAWAL # &nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['withdrawal'],'125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JO No &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['docno'].'&nbsp&nbsp&nbsp'.$data[0]['clientname'],'550',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Job &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['barcode'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$data[0]['itemname'],'350',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Plastic Kind &nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_combi'],'350',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    $qry = "select instruct from jb_processtab where trno = " . $data[0]['trno'] . " limit 1";
    $instruct = Yii::$app->sbccommon->datareader($qry);

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Instructions &nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$instruct,'350',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','125',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();



  Yii::$app->reporter->begintable('800');
    
    
    // Yii::$app->reporter->pagenumber('Page');
 
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','B','','');
      Yii::$app->reporter->col('Code','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
      Yii::$app->reporter->col('Description','400',null,false,'1px solid ','','C','Century Gothic','12','B','','');
      Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','','C','Century Gothic','12','B','','');
      Yii::$app->reporter->col('Qty','150',null,false,'1px solid ','','R','Century Gothic','12','B','','');
      Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','B','','');

    
    for($i=0;$i<count($data);$i++){
      

      Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','13','','','');
          Yii::$app->reporter->col($data[$i]['matbar'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['matitem'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->endrow();

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();
    Yii::$app->reporter->begintable('800');
    // $header=Yii::$app->reporter->letterhead();
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('MATERIAL REQUEST',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';

    // Yii::$app->reporter->pagenumber('Page');


    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Code','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Description','400',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Qty','150',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','B','','');
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
      $page=$page + $count;
    } 
    
  }//END FOR LOOKP

  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Prepared by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','B','','4px');
      Yii::$app->reporter->col('Released by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col($released,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Received by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col($received,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','B','','4px');
      Yii::$app->reporter->col('Approved by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col($approved,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','4px');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','','','4px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>