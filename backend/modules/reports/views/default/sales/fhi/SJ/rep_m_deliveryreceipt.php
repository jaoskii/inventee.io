<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Delivery Receipt';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
// echo '<div style="margin-top:-15px;">';
//WTODO: [JLY][FHI][11.25.2019][SJ reps]
Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Customer : '.$data[0]['clientname'],'650',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->col('DR No : '.$data[0]['docno'],'150',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Address  &nbsp&nbsp: '.$data[0]['address'],'650',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->col('Date : '.$data[0]['dateid'],'150',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Del to &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:'.$data[0]['shipto'],'650',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->col('Inv No : '.$data[0]['yourref'],'150',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Code','100',null,false,'1px dotted','TB','L','Verdana','11','B','','');
        Yii::$app->reporter->col('Description','400',null,false,'1px dotted','TB','L','Verdana','11','B','','');
        Yii::$app->reporter->col('Unit','100',null,false,'1px dotted','TB','L','Verdana','11','B','','');
        Yii::$app->reporter->col('Quantity','100',null,false,'1px dotted','TB','L','Verdana','11','B','','');
        Yii::$app->reporter->col('Loc','100',null,false,'1px dotted','TB','C','Verdana','11','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    $total=0;
    $counter=0;
    Yii::$app->reporter->begintable('800');
    for ($i=0; $i <count($data) ; $i++) { 
        $counter++;
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px dotted','','L','Verdana','11','B','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'400',null,false,'1px dotted','','L','Verdana','11','B','','');
        Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px dotted','','L','Verdana','11','B','','');
        Yii::$app->reporter->col($data[$i]['qty'],'100',null,false,'1px dotted','','L','Verdana','11','B','','');

        $series = str_replace('WH','', $data[$i]['whcode']);
        $series = $series + 0;
        if(strlen($series) == 1){
            $series = '0'.$series;
        }//end if
        
        Yii::$app->reporter->col($series,'100',null,false,'1px dotted','','C','Verdana','11','B','','');

    }
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br>';
    
    Yii::$app->reporter->begintable('800');
    
    if($counter < 15){
        while ($counter <= 15) {
            $counter += 1;
            Yii::$app->reporter->startrow();
                 Yii::$app->reporter->col('&nbsp','40',null,false,'1px solid ','','C','Century Gothic','10','','','2px');
                 Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','10','','','2px');
                 Yii::$app->reporter->col('&nbsp','20',null,false,'1px solid ','','L','Century Gothic','10','','','2px');
                 Yii::$app->reporter->col('&nbsp','285',null,false,'1px solid ','','L','Century Gothic','10','','','2px');
                 Yii::$app->reporter->col('&nbsp','145',null,false,'1px solid ','','R','Century Gothic','10','','','2px');
                 Yii::$app->reporter->col('&nbsp','30',null,false,'1px solid ','','R','Century Gothic','10','','','2px');
                 Yii::$app->reporter->col('&nbsp','30',null,false,'1px solid ','','R','Century Gothic','10','','','2px');
            Yii::$app->reporter->endrow();
        }//end while
    }//end if

    Yii::$app->reporter->endtable();

     Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Received above merchandise in good order and condition.','800',null,false,'1px dotted','T','R','Verdana','14','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared by : ','200',null,false,'1px dotted','','C','Verdana','11','B','','');
        Yii::$app->reporter->col($prepared,'200',null,false,'1px solid','B','C','Verdana','11','B','','');
        Yii::$app->reporter->col('','20',null,false,'1px dotted','','R','Verdana','11','B','','');
        Yii::$app->reporter->col('Received by : ','180',null,false,'1px dotted','','C','Verdana','11','B','','');
        Yii::$app->reporter->col($received,'200',null,false,'1px solid','B','C','Verdana','11','B','','');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','200',null,false,'1px dotted','','C','Verdana','11','B','','');
        Yii::$app->reporter->col('','200',null,false,'1px solid','','C','Verdana','11','B','','');
        Yii::$app->reporter->col('','20',null,false,'1px dotted','','R','Verdana','11','B','','');
        Yii::$app->reporter->col('','180',null,false,'1px dotted','','C','Verdana','11','B','','');
        Yii::$app->reporter->col('Signature over printed name','200',null,false,'1px solid','','C','Verdana','11','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
// echo '</div>';
echo '</div>';

?>