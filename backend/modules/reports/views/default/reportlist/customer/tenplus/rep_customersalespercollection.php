


<?php
use Yii\base\ErrorException;

date_default_timezone_set('Asia/Manila');
$this->title = 'Customer Sales Per Collection';

function ColumnHeader(){
Yii::$app->reporter->begintable('1200');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1200');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('ORDER DATE','80',null,false,'1px solid ','TBLR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('ORDER NUMBER','150',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('ORDER DELIVERED','100',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('BARCODE','120',null,false,'1px solid ','TBLR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('ITEM DESCRIPTION','200',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('TOTAL SRP','100',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('HANDLING','100',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('SHIP.FEE','100',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('CUTOFF','100',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','TBR','C','Century Gothic','11','B','','');
       Yii::$app->reporter->endtable();
}

function ColumnDetail($dateid,$yourref,$due,$isqty,$barcode,$itemname,$ext2,$handling,$ext,$shipfee,$cutoff,$bold=false){
       Yii::$app->reporter->col($dateid,'80',null,false,'1px solid ','TBLR','C','Century Gothic','11','','','');
       Yii::$app->reporter->col($yourref,'150',null,false,'1px solid ','TBR','C','Century Gothic','11','','','');
       Yii::$app->reporter->col($due,'100',null,false,'1px solid ','TBR','C','Century Gothic','11','','','');
       Yii::$app->reporter->col($isqty,'100',null,false,'1px solid ','TBR','C','Century Gothic','11','','','');
       Yii::$app->reporter->col($barcode,'120',null,false,'1px solid ','TBLR','C','Century Gothic','11','B','','');
       
       if($bold){
         Yii::$app->reporter->col($itemname,'200',null,false,'1px solid ','TBR','C','Century Gothic','19','B','','');
       }else{
         Yii::$app->reporter->col($itemname,'200',null,false,'1px solid ','TBR','C','Century Gothic','11','','','');
       }
       
       Yii::$app->reporter->col($ext2,'100',null,false,'1px solid ','TBR','R','Century Gothic','11','','','');
       Yii::$app->reporter->col($handling,'100',null,false,'1px solid ','TBR','R','Century Gothic','11','','','');
       Yii::$app->reporter->col($shipfee,'100',null,false,'1px solid ','TBR','R','Century Gothic','11','','','');
       Yii::$app->reporter->col($cutoff,'100',null,false,'1px solid ','TBR','R','Century Gothic','11','','','');
       if($bold){
         Yii::$app->reporter->col($ext,'100',null,false,'1px solid ','TBR','R','Century Gothic','18','B','','');
       }else{
         Yii::$app->reporter->col($ext,'100',null,false,'1px solid ','TBR','R','Century Gothic','11','','','');

       }
}




  

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
try {
  
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();

Yii::$app->reporter->beginreport('1200');

ColumnHeader();

Yii::$app->reporter->begintable('1200');

$subtot = 0.0;

for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();

        $ext = $data[$i]['ext'] + $data[$i]['handling'];
        ColumnDetail(date('m-d-Y', strtotime($data[$i]['dateid'])),$data[$i]['yourref'],date('m-d-Y', strtotime($data[$i]['due'])),number_format($data[$i]['isqty'],0),$data[$i]['barcode'],$data[$i]['itemname'],number_format($ext,2),number_format($data[$i]['handling'],2),number_format($data[$i]['ext'],2),$data[$i]['shipfee'],$data[$i]['cutoff']);

        $subtot = $subtot + round(floatval($data[$i]['ext']),2);
       Yii::$app->reporter->endrow();

        if(Yii::$app->reporter->linecounter==$page){

        ColumnDetail('','','','','','SUB TOTAL','','',number_format($subtot,2),'','');

            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
            ColumnHeader();
            Yii::$app->reporter->begintable('1200');
            $page=$page + $count;
        }
}//for($i=0;$i<count($data);$i++){

        ColumnDetail('','','','','','TOTAL','','',number_format($subtot,2),'','',true);


Yii::$app->reporter->endtable();

$Tot=0;
$amt=0;
//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


} catch (ErrorException $e) {
  echo $e;
}
?>



