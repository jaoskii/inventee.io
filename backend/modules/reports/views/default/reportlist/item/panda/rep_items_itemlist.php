<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Item List';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=50;
$page=50;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1000');

    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM LIST',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800'); 
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        if($params['item']==''){
        Yii::$app->reporter->col('Item : ALL','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'.$params['item'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Group :'. $params['group'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['part']==''){
        Yii::$app->reporter->col('Part : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Part'.$params['part'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        }
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','500',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('GROUP / CATEGORY','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','200',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
        
     $part="";
     $brand="";
    for($i=0;$i<count($data);$i++){
            if ($part==strtoupper($data[$i]['part'])){
              $part=""; 
              if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";  
              }  else {
                $brand=strtoupper($data[$i]['brand']);  
              }
            }
            else {
              $part=$data[$i]['part'];
               if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";  
              }  else {
                $brand=strtoupper($data[$i]['brand']);  
              }
            }
        
         $price=number_format($data[$i]['price'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($price==0)
            {
            $price='-';
            }
           
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($part,'150',null,false,'1px solid ','','L','Century Gothic','11','B','','0px');
            Yii::$app->reporter->col('','500',null,false,'1px solid ','','R','Century Gothic','11','Bi','','0px');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','11','','','0px');
            Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Century Gothic','11','','','0px');
            Yii::$app->reporter->endrow();
            
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($brand,'150',null,false,'1px solid ','','R','Century Gothic','11','Bi','','0px');
            Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','11','Bi','','0px');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','11','','','0px');
            Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Century Gothic','11','','','0px');

    $item_desc = $data[$i]['itemname'];

    if($data[$i]['brand'] != ""){
        $item_desc = $data[$i]['brand'] . " " . $item_desc;
    }//end if

    if($data[$i]['model'] != ""){
        $item_desc = $item_desc . " " . $data[$i]['model'];
    }//end if

    if($data[$i]['size'] != ""){
        $item_desc = $item_desc . " " . $data[$i]['size'];
    }//end if        

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','0px');
        Yii::$app->reporter->col($item_desc,'500',null,false,'1px solid ','','L','Century Gothic','11','','','0px');
        Yii::$app->reporter->col($data[$i]['groupid'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','0px');
        Yii::$app->reporter->col($price,'200',null,false,'1px solid ','','R','Century Gothic','11','','','0px');
        
        $brand=strtoupper($data[$i]['brand']);
        $part=$data[$i]['part'];
        
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
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM LIST',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800'); 
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        if($params['item']==''){
        Yii::$app->reporter->col('Item : ALL','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'.$params['item'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Group :'. $params['group'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['part']==''){
        Yii::$app->reporter->col('Part : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Part'.$params['part'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        }
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
    Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','500',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('GROUP / CATEGORY','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();
       Yii::$app->reporter->printline();
        $page=$page + $count;
} 


}

    //Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>