<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Customer List';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

$count=55;
$page=55;
Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER LIST',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();

       
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','11','','30px','5px');
        if($params['area']==''){
        Yii::$app->reporter->col('Area : ALL AREA',NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Area : ' .strtoupper($params['area']),NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');    
        }
        if($params['province']==''){
        Yii::$app->reporter->col('Province : ALL PROVINCE',NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Province : ' .strtoupper($params['province']),NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');    
        }
        if($params['region']==''){
        Yii::$app->reporter->col('Region : ALL REGION',NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Region : ' .strtoupper($params['region']),NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');    
        }
        if($params['pricegroup']==''){
        Yii::$app->reporter->col('Price Group : ALL REGION',NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
        } else {
        Yii::$app->reporter->col('Price Group : ' .strtoupper($params['pricegroup']),NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');    
        }
        //Yii::$app->reporter->col('Sort By : ' .$sortby,NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','11','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();


Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('CUSTOER NAME','300',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('ADDRESS','300',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('TELEPHONE #','150',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('TIN #','150',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        

    for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
//        Yii::$app->reporter->col($data[$i]['barcode'],'20px',null,false,'1px solid ','','C','Helvetica','11','','30px','');
        Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','C','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['addr'],'300',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['tel'],'150',null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['tin'],'150',null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->endrow();

        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
            

                Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
            
            Yii::$app->reporter->begintable('1000');
                Yii::$app->reporter->startrow();
                //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('CUSTOMER LIST',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
                Yii::$app->reporter->endrow();
                Yii::$app->reporter->startrow();
         
                Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','11','','30px','5px');
                if($params['area']==''){
                Yii::$app->reporter->col('Area : ALL AREA',NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
                } else {
                Yii::$app->reporter->col('Area : ' .strtoupper($params['area']),NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');    
                }
                if($params['province']==''){
                Yii::$app->reporter->col('Province : ALL PROVINCE',NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
                } else {
                Yii::$app->reporter->col('Province : ' .strtoupper($params['province']),NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');    
                }
                if($params['region']==''){
                Yii::$app->reporter->col('Region : ALL REGION',NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
                } else {
                Yii::$app->reporter->col('Region : ' .strtoupper($params['region']),NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');    
                }
               // Yii::$app->reporter->col('Sort By : ' .$sortby,NULL,null,false,'1px solid ','','L','Helvetica','11','','30px','5px');
                // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','11','','','');
                Yii::$app->reporter->pagenumber('Page');
                Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();

             Yii::$app->reporter->printline();
        //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
             Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
                //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
                Yii::$app->reporter->col('CUSTOER NAME','300',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
                Yii::$app->reporter->col('ADDRESS','300',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
                Yii::$app->reporter->col('TELEPHONE #','150',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
                Yii::$app->reporter->col('TIN #','150',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
             Yii::$app->reporter->endrow();
               Yii::$app->reporter->printline();
                $page=$page + $count;
        } 
    

    }//END FOR LOOKP

    //Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>