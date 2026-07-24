<?php
//WTODO: [KIM][2019.09.20][item list for mlcp layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Item List';

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=50;
$page=50;


Yii::$app->reporter->beginreport('1000');

  Yii::$app->reporter->begintable('1000');
    $header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('ITEM LIST',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
      Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('1000'); 
    Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
      if($params['item']==''){
        Yii::$app->reporter->col('Item : ALL','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
      } else {
        Yii::$app->reporter->col('Item : '.$params['item'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','');
      }
      if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
      } else {
        Yii::$app->reporter->col('Group :'. $params['group'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
      }
      if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
      } else {
        Yii::$app->reporter->col('Brand : '. $params['brand'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
      }
      if($params['class']==''){
        Yii::$app->reporter->col('Classification : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
      } else {
        Yii::$app->reporter->col('Classification : '.$params['class'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
      }
        
      switch (Yii::$app->systemsettings->companyConfig()) {
        case 'UNIVERSE':
          if($params['status'] == '0,1'){
            Yii::$app->reporter->col('Status : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
          }else {
            if($params['status'] == 0){
              $status = 'ACTIVE';
            }
            if($params['status'] == 1){
              $status = 'INACTIVE';
            }
            Yii::$app->reporter->col('Status : '.$status,null,null,'','1px solid ','','L','Century Gothic','10','','','');
          }
        break;
      }//END SWITCH

    Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();
  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('ITEM CODE','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
      Yii::$app->reporter->col('ITEM DESCRIPTION','400',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
      Yii::$app->reporter->col('GROUP / CATEGORY','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
      Yii::$app->reporter->col('PRICE','200',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
      Yii::$app->reporter->col('STATUS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
     
    
    $itemname="";
    $docno="";

    $iitem="";
    

    for($i=0;$i<count($data);$i++){
      
      $display=$data[$i]['cl_name'];
      $docno=$data[$i]['barcode'];
      
      if ($itemname==""){
        Yii::$app->reporter->begintable('1000');
          Yii::$app->reporter->startrow();
          Yii::$app->reporter->col($data[$i]['cl_name'],'110',null,false,'1px solid ','','L','Century Gothic','12','B','','');
          Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();
      }

      if (strtoupper($itemname)==strtoupper($data[$i]['cl_name'])){
        $itemname="";
            
        if (strtoupper($docno)==strtoupper($data[$i]['cl_name'])){
          $docno="";
        }else{
          
          $itemname=strtoupper($data[$i]['cl_name']);  
        }
               
      }
      else{
        if ($docno!=''){}
        

        if ($itemname!=''){     
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->printline();
            Yii::$app->reporter->col($data[$i]['cl_name'],'150',null,false,'1px solid ','','L','Century Gothic','11','B','','');
            Yii::$app->reporter->col('','400',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col('','200',null,false,'1px solid ','','C','Century Gothic','11','','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','','','');

        }  
         
        
        $docno=$data[$i]['cl_name'];
        if (strtoupper($docno)==strtoupper($data[$i]['cl_name'])){
          $docno="";  
        }else {
          $docno=strtoupper($data[$i]['cl_name']);  
        }
      }

      if ($iitem==$data[$i]['cl_name']){
        $iitem="";
      }else{
        $iitem=$data[$i]['cl_name'];
      }
      



      $price=number_format($data[$i]['price'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
      if ($price==0){
        $price='-';
      }
           
      Yii::$app->reporter->startrow();
      Yii::$app->reporter->addline();
        if($data[$i]['isinactive']) {
            $isinactive = 'INACTIVE';
        }else{
            $isinactive = 'ACTIVE';
        }//end if

       
        
        Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','0px');
        Yii::$app->reporter->col($data[$i]['itemname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','0px');
        Yii::$app->reporter->col($data[$i]['groupid'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','0px');
        Yii::$app->reporter->col($price,'200',null,false,'1px solid ','','R','Century Gothic','11','','','0px');
        Yii::$app->reporter->col($isinactive,'100',null,false,'1px solid ','','C','Century Gothic','11','','','0px');

        
        
      Yii::$app->reporter->endrow();

        
        $itemname=strtoupper($data[$i]['cl_name']);
        $docno=$data[$i]['cl_name'];
        $iitem=$data[$i]['cl_name'];



      // }
      if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('1000');
        $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';

    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM LIST',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800'); 
      Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        if($params['item']==''){
          Yii::$app->reporter->col('Item : ALL','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        }else {
          Yii::$app->reporter->col('Item : '.$params['item'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['group']==''){
          Yii::$app->reporter->col('Group : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        }else {
          Yii::$app->reporter->col('Group :'. $params['group'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['brand']==''){
          Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        }else {
          Yii::$app->reporter->col('Brand : '. $params['brand'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['class']==''){
          Yii::$app->reporter->col('Classification : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
        }else {
          Yii::$app->reporter->col('Classification : '.$params['class'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        }
      Yii::$app->reporter->pagenumber('Page');
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM CODE','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','400',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('GROUP / CATEGORY','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','200',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('STATUS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
      $page=$page + $count;
    } 
  }

  Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

?>