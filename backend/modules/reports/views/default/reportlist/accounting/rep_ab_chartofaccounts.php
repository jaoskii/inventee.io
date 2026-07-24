<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Chart of Accounts';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=50;
$page=50;
Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CHART OF ACCOUNTS',null,null,false,'10px solid ','','','Century Gothic','24','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','11','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        
        Yii::$app->reporter->printline();

        
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CODE', '70px',null,false,'1px solid ','TB','','Century Gothic','11','B','','','');
        Yii::$app->reporter->col('ACCOUNT NAME', '100px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ALIAS', '800px',null,false,'1px solid ','TB','','Century Gothic','11','B','','','');
        Yii::$app->reporter->col('TYPE', '300px',null,false,'1px solid ','TB','','Century Gothic','11','B','','','');
        Yii::$app->reporter->endrow();
                
        for($i=0;$i<count($data);$i++){

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        $indent='5' * ($data[$i]['levelid'] * 3);
        
        Yii::$app->reporter->col($data[$i]['acno'],'200px',null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['acnoname'],'300',null,false,'1px solid ','','','Century Gothic','10','','','0px 0px 0px '. $indent.'px');
        Yii::$app->reporter->col($data[$i]['alias'],'100px',null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['type'],'100px',null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();


        if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CHART OF ACCOUNTS',null,null,false,'10px solid ','','','Century Gothic','24','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','11','','','');
       // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->printline();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CODE', '70px',null,false,'1px solid ','TB','','Century Gothic','11','B','','','');
        Yii::$app->reporter->col('ACCOUNT NAME', '100px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ALIAS', '800px',null,false,'1px solid ','TB','','Century Gothic','11','B','','','');
        Yii::$app->reporter->col('TYPE', '300px',null,false,'1px solid ','TB','','Century Gothic','11','B','','','');
        Yii::$app->reporter->endrow();
        $page=$page + $count;
    }


}
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>