<div id="print_btn" class="btn_a">
    <?php
    echo CHtml::link(CHtml::image('images/print.png','print',array( 'class'=>'btn_icon')).'Print','#',array('onClick'=>"window.print();"));
    ?>
</div>

 <?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('application.report.css_reports.*');
$count=55;
$page=54;
$rep= new sbcpdf();
$header=$rep->letterhead();
$rep->beginreport();
$rep->header($header);


    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;&nbsp;&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Century Gothic','13','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('STOCKCARD LEDGER  ',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        $rep->endrow();

$rep->endtable();
$rep->printline();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','1px');
        $rep->col('','200',null,false,'1px solid ','','C','Century Gothic','11','B','','1px');
        $rep->col('IN','200',null,false,'1px solid ','','C','Century Gothic','11','B','','1px');
        $rep->col('OUT','200',null,false,'1px solid ','','C','Century Gothic','11','B','','1px');
        $rep->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','1px');


$rep->begintable('800');
    $rep->startrow();
    $rep->col('DATE','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','','1px');
    $rep->col('PARTICULARS','200',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','','1px');
    $rep->col('DOCUMENT #','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','','1px');
    $rep->col('QTY ','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','','1px');
    $rep->col('DOCUMENT #','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','','1px');
    $rep->col('QTY','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','','1px');
    $rep->col('BALANCE','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','','1px');
    
    $bal=0;
    
for($i=0;$i<count($data);$i++){
    $qty=number_format($data[$i]['qty'],2);
            if ($qty<1)
            {
            $qty='-';
            }
             $iss=number_format($data[$i]['iss'],2);
            if ($iss<1)
            {
            $iss='-';
            }

    $bal=$bal+($data[$i]['qty']-$data[$i]['iss']);
    $tobal=$bal;
            if ($tobal<1)
            {
            $tobal='-';
            }
    $rep->startrow();
    $rep->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
    $rep->col($data[$i]['rem'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
    if(($data[$i]['qty']!=0)){
    $rep->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    }else{
    $rep->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    }
    $rep->col($qty,'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
    if($data[$i]['iss']!=0){
    $rep->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    }else{
    $rep->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    }
    $rep->col($iss,'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
    $rep->col($tobal,'100',null,false,'1px solid ','','R','Century Gothic','11','','','');

    $rep->endrow();
}

$rep->endtable();


echo '<br/><br/>';
    $rep->begintable('800');
        $rep->startrow();
        $rep->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->col('Received By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        $rep->col('Approved By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        $rep->endrow();
    $rep->endtable();

    echo '<br/>';
    $rep->begintable('800');
        $rep->startrow();
        $rep->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        $rep->col($received,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        $rep->col($approved,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();

$rep->endtable();


//var_dump($data);
//var_dump($params);
$rep->endreport();


?>
