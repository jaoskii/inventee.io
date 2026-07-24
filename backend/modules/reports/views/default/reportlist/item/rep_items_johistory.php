<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Job Order History';
//WTODO: [KIM][2019.10.03][partial served job order layout]
//WTODO: [KIM][2019.11.28][update layout for job order history]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php




$joqry = Yii::$app->sbccommon->opentable("select head.dateid, head.docno, head.client, head.clientname, head.mat_barcode, item.itemname,
                 item.fg_combi, item.fg_plasticcolor, item.fg_jowidth, item.fg_jowidthuom, item.fg_jolength,
                 item.fg_jolengthuom, stock.isqty, stock.iss, stock.uom
          from jbhead as head
          left join jbstock as stock on head.trno = stock.trno
          left join item on head.mat_barcode = item.barcode
          where head.docno = '".$params['jobno']."'
          union all
          select head.dateid, head.docno, head.client, head.clientname, head.mat_barcode, item.itemname,
                 item.fg_combi, item.fg_plasticcolor, item.fg_jowidth, item.fg_jowidthuom, item.fg_jolength,
                 item.fg_jolengthuom, stock.isqty, stock.iss, stock.uom
          from hjbhead as head
          left join hjbstock as stock on head.trno = stock.trno
          left join item on head.mat_barcode = item.barcode
          where head.docno = '".$params['jobno']."'");


$count=55;
$page=55;
Yii::$app->reporter->beginreport('800');

  Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER HISTORY',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        if($params['jobno']==''){
          Yii::$app->reporter->col('J.O. # &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ALL',null,null,false,'1px solid ','','L','Century Gothic','12','B','','');
        }else {
          Yii::$app->reporter->col('J.O. # &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '. $params['jobno'],null,null,false,'1px solid ','','L','Century Gothic','12','B','','');    
        }
        
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$joqry[0]['clientname'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$joqry[0]['mat_barcode'].' &nbsp&nbsp&nbsp '.$joqry[0]['itemname'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('COMBINATION : '.$joqry[0]['fg_combi'],'200',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('PLASTIC COLOR &nbsp&nbsp&nbsp: '.$joqry[0]['fg_plasticcolor'],'600',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SIZE &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$joqry[0]['fg_jowidth'].' &nbsp'.$joqry[0]['fg_jowidthuom'].' &nbspX&nbsp '.$joqry[0]['fg_jolength'].' &nbsp'.$joqry[0]['fg_jolengthuom'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ORDER &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.number_format($joqry[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')).' &nbsp'.$joqry[0]['uom'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        // Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      
        Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();


    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('S J &nbsp D A T E','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('S J &nbsp N O','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Q T Y','150',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
       

      $total=0;

      for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['dateid'],'200',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['docno'],'200',null,false,'1px solid ','','C','Century Gothic','11','','','');
          
          Yii::$app->reporter->col(number_format($data[$i]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Century Gothic','11','','','');
         
          Yii::$app->reporter->endrow();
          $total = $total + $data[$i]['iss'];

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();
   Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER HISTORY',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(); 
      Yii::$app->reporter->col(''.$start.' - '.$end,null,null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        if($params['jobno']==''){
          Yii::$app->reporter->col('J.O. # &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ALL',null,null,false,'1px solid ','','L','Century Gothic','12','B','','');
        }else {
          Yii::$app->reporter->col('J.O. # &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '. $params['jobno'],null,null,false,'1px solid ','','L','Century Gothic','12','B','','');    
        }
        
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$joqry[0]['clientname'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$joqry[0]['mat_barcode'].' &nbsp&nbsp&nbsp '.$joqry[0]['itemname'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('COMBINATION : '.$joqry[0]['fg_combi'],'200',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('PLASTIC COLOR &nbsp&nbsp&nbsp: '.$joqry[0]['fg_plasticcolor'],'600',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SIZE &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.$joqry[0]['fg_jowidth'].' &nbsp'.$joqry[0]['fg_jowidthuom'].' &nbspX&nbsp '.$joqry[0]['fg_jolength'].' &nbsp'.$joqry[0]['fg_jolengthuom'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ORDER &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: '.number_format($joqry[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')).' &nbsp'.$joqry[0]['uom'],'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        // Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      
        Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('S J &nbsp D A T E','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('S J &nbsp N O','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Q T Y','150',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
       

      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
      $page=$page + $count;
    } 
    

  }//END FOR LOOKP

    Yii::$app->reporter->col('','200',null,false,'1px solid ','TB','C','Century Gothic','11','','','');
    Yii::$app->reporter->col('GRAND TOTAL :','200',null,false,'1px solid ','TB','L','Century Gothic','11','B','30px','2px');
    Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','TB','R','Century Gothic','11','B','','');



Yii::$app->reporter->endtable();
// Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


?>