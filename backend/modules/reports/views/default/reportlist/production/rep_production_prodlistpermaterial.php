<?php
//WTODO: [KIM][2019.09.17][Product Listing per material layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Product Listing per Material';
?>


<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=55;
Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PRODUCT LISTING PER MATERIAL',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','30px','5px');
        if($params['prodtypeid']==''){
        Yii::$app->reporter->col('Product Type : ALL',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Product Type : ' .strtoupper($params['prodtypeid']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        if($params['materialid']==''){
        Yii::$app->reporter->col('Material : ALL',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Material : ' .strtoupper($params['materialid']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Code','100',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
        Yii::$app->reporter->col('Description','200',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
        Yii::$app->reporter->col('Customer Name','200',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
        Yii::$app->reporter->col('Type','50',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
        Yii::$app->reporter->col('Material','100',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
        Yii::$app->reporter->col('Width','75',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
        Yii::$app->reporter->col('Thickness','75',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');

    for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['fg_prodtype'],'50',null,false,'1px solid ','','C','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['fg_combi'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['fg_jowidth'],'75',null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['fg_thickness'],'75',null,false,'1px solid ','','R','Century Gothic','10','','','');
        
        Yii::$app->reporter->endrow();

        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
            Yii::$app->reporter->begintable('1000');
            
              $header=Yii::$app->reporter->letterhead();
            Yii::$app->reporter->endtable();
            echo '<br/><br/>';
            Yii::$app->reporter->begintable('1000');
              Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('PRODUCT LISTING PER MATERIAL',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
              Yii::$app->reporter->endrow();
              Yii::$app->reporter->startrow();
       
              Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','30px','5px');
              if($params['prodtypeid']==''){
                Yii::$app->reporter->col('Product Type : ALL',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
              } else {
                Yii::$app->reporter->col('Product Type : ' .strtoupper($params['prodtypeid']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
              }
              if($params['materialid']==''){
                Yii::$app->reporter->col('Material : ALL',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
              } else {
                Yii::$app->reporter->col('Material : ' .strtoupper($params['materialid']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
              }
              Yii::$app->reporter->pagenumber('Page');
              Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();

            Yii::$app->reporter->printline();
            Yii::$app->reporter->begintable('1000');
              Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Code','100',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
                Yii::$app->reporter->col('Description','200',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
                Yii::$app->reporter->col('Customer Name','200',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
                Yii::$app->reporter->col('Type','50',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
                Yii::$app->reporter->col('Material','100',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
                Yii::$app->reporter->col('Width','75',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
                Yii::$app->reporter->col('Thickness','75',null,false,'1px solid ','B','C','Century Gothic','12','B','','6px');
              Yii::$app->reporter->endrow();
              Yii::$app->reporter->printline();
              $page=$page + $count;
        } 
    }//END FOR LOOKP
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
?>