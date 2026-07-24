<?php
// WTODO JAD 06-03-2019
date_default_timezone_set('Asia/Manila');
$this->title = 'Event Listing Summary';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count = $page = 55;

Yii::$app->reporter->beginreport('800');
  Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->endtable();

  echo '<br/><br/>';

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('EVENT LISTING SUMMARY',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
  
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','','5px');
      if($params['user']==''){
        Yii::$app->reporter->col('USER : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
      }else {
        Yii::$app->reporter->col('USER : ' .strtoupper($params['user']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');    
      }
      
      if($params['client']==''){
        Yii::$app->reporter->col('CLIENT : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
      }else {
        Yii::$app->reporter->col('CLIENT : ' .strtoupper($params['client']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');    
      }
      
      if($params['project']==''){
        Yii::$app->reporter->col('Project : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
      } else {
        Yii::$app->reporter->col('Project : ' .strtoupper($params['project']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
      }


      if($params['schedtype']==''){
        Yii::$app->reporter->col('Schedule Type : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
      } else {
        Yii::$app->reporter->col('Schedule Type : ' .strtoupper($params['schedtype']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
      }
      Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('U S E R','400',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
      Yii::$app->reporter->col('# of S C H E D U L E','400',null,false,'1px solid ','B','L','Century Gothic','12','B','','');

      for($i = 0; $i < count($data); $i++) {
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['username'],'800',null,false,'1px solid ','B','L','Century Gothic','10','','','');
          Yii::$app->reporter->col(number_format($data[$i]['totsched'],0),'800',null,false,'1px solid ','B','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        if(Yii::$app->reporter->linecounter == $page) {
          Yii::$app->reporter->endtable();
          Yii::$app->reporter->page_break();
          
          Yii::$app->reporter->begintable('800');
            $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->endtable();
        
          echo '<br/><br/>';
            
          Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
              Yii::$app->reporter->col('EVENT LISTING',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
            Yii::$app->reporter->endrow();
        
            Yii::$app->reporter->startrow();
              if($params['user']==''){
                Yii::$app->reporter->col('USER : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
              }else {
                Yii::$app->reporter->col('USER : ' .strtoupper($params['user']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');    
              }
      
              if($params['client']==''){
                Yii::$app->reporter->col('CLIENT : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
              }else {
                Yii::$app->reporter->col('CLIENT : ' .strtoupper($params['client']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');    
              }
      
              if($params['project']==''){
                Yii::$app->reporter->col('PROJECT : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
              } else {
                Yii::$app->reporter->col('PROJECT : ' .strtoupper($params['project']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
              }
              if($params['schedtype']==''){
                Yii::$app->reporter->col('Schedule Type : ',NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
              } else {
                Yii::$app->reporter->col('Schedule Type : ' .strtoupper($params['schedtype']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','','5px');
              }
              Yii::$app->reporter->pagenumber('Page');
            Yii::$app->reporter->endrow();
          Yii::$app->reporter->endtable();

          Yii::$app->reporter->printline();
      
          Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
              Yii::$app->reporter->col('U S E R','400',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
              Yii::$app->reporter->col('# of S C H E D U L E','400',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->printline();
            $page=$page + $count;
        } 
      }//END FOR LOOKP
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

?>