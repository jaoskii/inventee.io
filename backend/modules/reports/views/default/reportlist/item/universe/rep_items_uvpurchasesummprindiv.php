<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Summary Per Principal/Division';
//WTODO: [KIM][2019.10.30][update layout for purchase summary per principal/division]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;

Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->startrow();
    echo '<br/>';
    Yii::$app->reporter->col('PURCHASE SUMMARY PER PRINCIPAL/DIVISION',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Purchase : '.$params['start'].'-'.$params['end'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    Yii::$app->reporter->col('','350',null,false,'1px solid','','','Century Gothic','11','','','');
    Yii::$app->reporter->pagenumber('Page');
    
  Yii::$app->reporter->endrow();

  
Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('P R I N C I P A L','300',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
      Yii::$app->reporter->col('D I V I S I O N','300',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
      Yii::$app->reporter->col('','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
      Yii::$app->reporter->col('A M O U N T','200',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
      Yii::$app->reporter->endrow();

    $name="";
    $gsubtotalext=0;
    $totalext=0;
    $docno="";
    
    $subtotalext=0;
    $subtotalpv=0;
    $subtotaltons=0;
    $gsubtotalqty=0;
    
    $gsubtotalpv=0;
    $member="";
    $grandtotalpv=0;
    $grandtotalqty=0;
    $gsubtotaltons=0;
    $iitem="";

    for($i=0;$i<count($data);$i++){
      $display=$data[$i]['name'];
  
      if ($name==""){
      
        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['name'],'300',null,false,'1px dotted ','B','L','Century Gothic','11','B','','5px');
            Yii::$app->reporter->col('','300',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','200',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','200',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
          Yii::$app->reporter->endrow();
      }
      if (strtoupper($name)==strtoupper($data[$i]['name']))
      {
        $name="";    
        
      }
      else 
      {
       
        if ($name!=''){  
          Yii::$app->reporter->startrow();

            Yii::$app->reporter->col('','300',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');

            Yii::$app->reporter->col('TOTAL :','200',null,false,'1px dotted ','T','R','Century Gothic','11','B','','4px');
            Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','T','R','Century Gothic','11','B','','4px');
          Yii::$app->reporter->endrow();
        }    

        if ($name!=''){     
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['name'],'300',null,false,'1px dotted ','B','L','Century Gothic','11','B','','5px');
            Yii::$app->reporter->col('','300',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
            Yii::$app->reporter->col('','200',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
            Yii::$app->reporter->col('','200',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
        }  
        $subtotalext=0;
        $gsubtotalext=0;
        $docno=$data[$i]['name'];
        
        if (strtoupper($docno)==strtoupper($data[$i]['name'])){
          $docno="";  
        } else 
        {
          $docno=strtoupper($data[$i]['name']);  
        }
      }
                      
      if ($iitem==$data[$i]['name']){
        $iitem="";
      }else{
        $iitem=$data[$i]['name'];
      }

      Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['stockgrp_name'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Century Gothic','11','','','');
      Yii::$app->reporter->endrow();
      
       $gsubtotalext=$gsubtotalext+$data[$i]['ext'];

       $totalext=$totalext+$data[$i]['ext'];
       $name=strtoupper($data[$i]['name']);
       $docno=$data[$i]['name'];
       $iitem=$data[$i]['name'];

    }
   
    Yii::$app->reporter->startrow();

        Yii::$app->reporter->col('','300',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');

        Yii::$app->reporter->col('TOTAL :','200',null,false,'1px dotted ','T','R','Century Gothic','11','B','','4px');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','T','R','Century Gothic','11','B','','4px');

    Yii::$app->reporter->endrow();
    echo '<br/>';
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
  echo '<br/>';
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col('GRAND TOTAL :','200',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
      Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>
