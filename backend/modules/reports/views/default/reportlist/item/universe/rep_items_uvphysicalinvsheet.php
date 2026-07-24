<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Physical Inventory Sheet';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=32;
$page=32;

Yii::$app->reporter->beginreport('800');
Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->startrow();
  	echo '<br/>';
  	Yii::$app->reporter->col('PHYSICAL INVENTORY SHEET',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
// echo '<br/><br/>';
    Yii::$app->reporter->pagenumber('Page');
Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
  	
  	if($params['classid'] == ""){
  		Yii::$app->reporter->col('CLASS : ALL','200',null,false,'1px solid','','','Helvetica','12','','','');
  	}else{
  		Yii::$app->reporter->col('CLASS : '.$params['class'],'200',null,false,'1px solid','','','Helvetica','12','','','');
  	}

  	if($params['categoryid'] == ""){
  		Yii::$app->reporter->col('CATEGORY : ALL','200',null,false,'1px solid','','','Helvetica','12','','','');
  	}else{
  		Yii::$app->reporter->col('CATEGORY : '.$params['category'],'200',null,false,'1px solid','','','Helvetica','12','','','');
  	}

    if($params['genericid'] == ""){
  		Yii::$app->reporter->col('GENERIC : ALL','200',null,false,'1px solid','','','Helvetica','12','','','');
  	}else{
  		Yii::$app->reporter->col('GENERIC : '.$params['generic'],'200',null,false,'1px solid','','','Helvetica','12','','','');
  	}

  	if($params['unit'] == 'retail'){
      Yii::$app->reporter->col('Unit : RETAIL','200',null,false,'1px solid','','','Helvetica','12','','','');
    }else{
      Yii::$app->reporter->col('Unit : PURCHASING','200',null,false,'1px solid','','','Helvetica','12','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
  	if($params['principalid'] == ""){
  	  Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Helvetica','12','','','');
  	}else{
  	  Yii::$app->reporter->col('PRINCIPAL : '.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','12','','','');
  	}
    if($params['divisionid'] == ""){
      Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Helvetica','12','','','');
    }else{
      Yii::$app->reporter->col('DIVISION : '.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','12','','','');
    }
  Yii::$app->reporter->endrow();

  // Yii::$app->reporter->startrow();
  //   Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','17','','','');
  // 	if($params['uvcategoryid'] == ""){
  // 	  Yii::$app->reporter->col('CATEGORY : ALL','350',null,false,'1px solid','','','Helvetica','17','','','');
  // 	}else{
  // 	  Yii::$app->reporter->col('CATEGORY : '.$params['uvcategoryid'],'350',null,false,'1px solid','','','Helvetica','17','','','');
  // 	}
  	

  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
// Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    // Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid','B','C','Helvetica','17','B','','8px');
    Yii::$app->reporter->col('D E S C R I P T I O N','300',null,false,'1px solid','B','L','Helvetica','17','B','','8px');
    Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','L','Helvetica','17','B','','8px');
    Yii::$app->reporter->col('QTY','50',null,false,'1px solid','B','C','Helvetica','17','B','','8px');
    Yii::$app->reporter->col('','20',null,false,'1px solid','B','C','Helvetica','17','B','','8px');
    Yii::$app->reporter->col('REMARKS','20',null,false,'1px solid','B','C','Helvetica','17','B','','8px');
    Yii::$app->reporter->endrow();

    for($i=0;$i<count($data);$i++){
      Yii::$app->reporter->addline();
      Yii::$app->reporter->startrow();
          // Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid','','L','Helvetica','17','','','');
          Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid','','L','Helvetica','17','','','');
          Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid','','L','Helvetica','17','','','');
          Yii::$app->reporter->col('','50',null,false,'1px solid','B','C','Helvetica','17','','','');
          Yii::$app->reporter->col('','20',null,false,'1px solid','','C','Helvetica','17','','','');
          Yii::$app->reporter->col('','20',null,false,'1px solid','B','C','Helvetica','17','','','');          
      Yii::$app->reporter->endrow();

      if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
      	Yii::$app->reporter->page_break();

      	Yii::$app->reporter->begintable('800');
      	  $header=Yii::$app->reporter->letterhead();
      	  Yii::$app->reporter->startrow();
            echo '<br/>';
            Yii::$app->reporter->col('PHYSICAL INVENTORY SHEET',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
      	  Yii::$app->reporter->endrow();
      	Yii::$app->reporter->endtable();
      	// echo '<br/><br/>';
            Yii::$app->reporter->pagenumber('Page');

      	Yii::$app->reporter->begintable('800');
  		  Yii::$app->reporter->startrow();
          
          if($params['classid'] == ""){
            Yii::$app->reporter->col('CLASS : ALL','200',null,false,'1px solid','','','Helvetica','12','','','');
          }else{
            Yii::$app->reporter->col('CLASS : '.$params['class'],'200',null,false,'1px solid','','','Helvetica','12','','','');
          }

          if($params['categoryid'] == ""){
            Yii::$app->reporter->col('CATEGORY : ALL','200',null,false,'1px solid','','','Helvetica','12','','','');
          }else{
            Yii::$app->reporter->col('CATEGORY : '.$params['category'],'200',null,false,'1px solid','','','Helvetica','12','','','');
          }

          if($params['genericid'] == ""){
            Yii::$app->reporter->col('GENERIC : ALL','200',null,false,'1px solid','','','Helvetica','12','','','');
          }else{
            Yii::$app->reporter->col('GENERIC : '.$params['generic'],'200',null,false,'1px solid','','','Helvetica','12','','','');
          }

          if($params['unit'] == 'retail'){
            Yii::$app->reporter->col('Unit : RETAIL','200',null,false,'1px solid','','','Helvetica','12','','','');
          }else{
            Yii::$app->reporter->col('Unit : PURCHASING','200',null,false,'1px solid','','','Helvetica','12','','','');
          }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['principalid'] == ""){
            Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Helvetica','12','','','');
          }else{
            Yii::$app->reporter->col('PRINCIPAL : '.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','12','','','');
          }
          if($params['divisionid'] == ""){
            Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Helvetica','12','','','');
          }else{
            Yii::$app->reporter->col('DIVISION : '.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','12','','','');
          }
        Yii::$app->reporter->endrow();

  		  // Yii::$app->reporter->startrow();

      //         Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','17','','','');
  		  // 	if($params['uvcategoryid'] == ""){
  	  	// 	  Yii::$app->reporter->col('CATEGORY : ALL','350',null,false,'1px solid','','','Helvetica','17','','','');
  	   //      }else{
  	   //        Yii::$app->reporter->col('CATEGORY : '.$params['uvcategoryid'],'350',null,false,'1px solid','','','Helvetica','17','','','');
  	   //      }
  		  //   Yii::$app->reporter->pagenumber('Page');
  		  // Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            // Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid','B','L','Helvetica','17','B','','8px');
    		Yii::$app->reporter->col('D E S C R I P T I O N','300',null,false,'1px solid','B','L','Helvetica','17','B','','8px');
    		Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','L','Helvetica','17','B','','8px');
    		Yii::$app->reporter->col('QTY','50',null,false,'1px solid','B','C','Helvetica','17','B','','8px');
        Yii::$app->reporter->col('','20',null,false,'1px solid','B','C','Helvetica','17','B','','8px');
        Yii::$app->reporter->col('REMARKS','20',null,false,'1px solid','B','C','Helvetica','17','B','','8px');
          Yii::$app->reporter->endrow();
        // Yii::$app->reporter->printline();
        $page=$page + $count;

      }
    }

  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->endreport();
?>