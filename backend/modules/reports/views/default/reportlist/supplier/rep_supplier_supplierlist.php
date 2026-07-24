<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Supplier List';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=55;
// $header=Yii::$app->reporter->letterhead();

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER  LIST',null,null,false,'10px solid ','','','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','30px','5px');
        if($params['area']==''){
        Yii::$app->reporter->col('Area : ALL AREA',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Area : ' .strtoupper($params['area']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        if($params['province']==''){
        Yii::$app->reporter->col('Province : ALL PROVINCE',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Province : ' .strtoupper($params['province']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        if($params['region']==''){
        Yii::$app->reporter->col('Region : ALL REGION',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Region : ' .strtoupper($params['region']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        //Yii::$app->reporter->col('Sort By : ' .$sortby,NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();

//function col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='') {
//$style=$this->styler($w, $h, $bg, $b, $b_, $al, $f, $fs, $fc, $fw, $pad, $m);
        //echo  $d='<td style="'.$style.'">'.$txt.'</td>';
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();


Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('CODE', '70px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('SUPPLIER NAME', '100px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('ADDRESS', '600px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('TELEPHONE #', '800px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('TIN #', '100px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->endrow();

//Yii::$app->reporter->endtable();

//Yii::$app->reporter->begintable();
for($i=0;$i<count($data);$i++){

Yii::$app->reporter->startrow();
Yii::$app->reporter->addline();
Yii::$app->reporter->col($data[$i]['client'],null,null,false,'10px solid ','','','Century Gothic','10','','','');
Yii::$app->reporter->col($data[$i]['clientname'],null,null,false,'10px solid ','','','Century Gothic','10','','','');
Yii::$app->reporter->col($data[$i]['addr'],null,null,false,'10px solid ','','','Century Gothic','10','','','');
Yii::$app->reporter->col($data[$i]['tel'],null,null,false,'10px solid ','','','Century Gothic','10','','','');
Yii::$app->reporter->col($data[$i]['tin'],null,null,false,'10px solid ','','','Century Gothic','10','','','');
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
        Yii::$app->reporter->col('SUPPLIER  LIST',null,null,false,'10px solid ','','','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','30px','5px');
        if($params['area']==''){
        Yii::$app->reporter->col('Area : ALL AREA',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Area : ' .strtoupper($params['area']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        if($params['province']==''){
        Yii::$app->reporter->col('Province : ALL PROVINCE',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Province : ' .strtoupper($params['province']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        if($params['region']==''){
        Yii::$app->reporter->col('Region : ALL REGION',NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Region : ' .strtoupper($params['region']),NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');    
        }
        //Yii::$app->reporter->col('Sort By : ' .$sortby,NULL,null,false,'1px solid ','','L','Century Gothic','11','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();

//function col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='') {
//$style=$this->styler($w, $h, $bg, $b, $b_, $al, $f, $fs, $fc, $fw, $pad, $m);
        //echo  $d='<td style="'.$style.'">'.$txt.'</td>';
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();


Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('CODE', '70px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('SUPPLIER NAME', '100px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('ADDRESS', '600px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('TELEPHONE #', '800px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->col('TIN #', '100px',null,false,'1px solid ','TB','','Century Gothic','11','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->printline();
$page=$page + $count;
}
    }

Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>