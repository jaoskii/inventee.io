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

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM LIST',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000'); 
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');
            if($params['barcode']==''){
            Yii::$app->reporter->col('Item : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
            } else {
            Yii::$app->reporter->col('Item :'.$params['itemname'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
            }
           
            if($params['brand']==''){
            Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
            } else {
            Yii::$app->reporter->col('Brand :'. $params['brand'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
            }
            if($params['categoryid']==''){
            Yii::$app->reporter->col('Category : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
            } else {
            Yii::$app->reporter->col('Category :'. $params['category'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
            }
            if($params['genericid']==''){
            Yii::$app->reporter->col('Generic : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
            } else {
            Yii::$app->reporter->col('Generic :'. $params['generic'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
            }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');
            if($params['principalid']==''){
                Yii::$app->reporter->col('Principal : ALL','300',null,false,'1px solid ','','L','Helvetica','10','','','');    
            } else {
                Yii::$app->reporter->col('Principal :'. $params['principalid'],'300',null,false,'1px solid ','','L','Helvetica','10','','','');
            }
            if($params['divisionid']==''){
                Yii::$app->reporter->col('Division : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','','');    
            } else {
                Yii::$app->reporter->col('Division :'. $params['divisionid'],'150',null,false,'1px solid ','','L','Helvetica','10','','','');
            }
            if($params['classid']==''){
                Yii::$app->reporter->col('Classification : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
            } else {
                Yii::$app->reporter->col('Classification :'. $params['class'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'UNIVERSE':
                    if($params['status'] == '0,1'){
                        Yii::$app->reporter->col('Status : All','200',null,false,'1px solid ','','L','Helvetica','10','','','');
                    } else {
                        if($params['status'] == 0){
                            $status = 'ACTIVE';
                        }
                        if($params['status'] == 1){
                            $status = 'INACTIVE';
                        }
                        Yii::$app->reporter->col('Status : '. $status,'200',null,false,'1px solid ','','L','Helvetica','10','','','');
                    }
                break;
            }//END SWITCH

            Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','300',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('PRINCIPAL','150',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('DIVISION','150',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','200',null,false,'1px solid ','B','R','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('STATUS','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
     
$principal = "";
$divi = "";
    for($i=0;$i<count($data);$i++){
        
        $price= number_format($data[$i]['price'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        if ($price==0){
            $price='-';
        } 

        if($principal != $data[$i]['principal']){
            Yii::$app->reporter->endtable();

            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('&nbsp','1000',null,false,'1px solid ','','L','Helvetica','12','B','','0px');
            Yii::$app->reporter->endrow();

            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('&nbsp','1000',null,false,'1px solid ','','L','Helvetica','12','B','','0px');
            Yii::$app->reporter->endrow();

            Yii::$app->reporter->begintable('1000');
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col($data[$i]['principal'],'1000',null,false,'1px solid ','','L','Helvetica','12','B','','0px');
                Yii::$app->reporter->endrow();
                Yii::$app->reporter->endtable();

            Yii::$app->reporter->begintable('1000');
            $principal = $data[$i]['principal'];
        }//end if

        if($divi != $data[$i]['groupid']){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->begintable('1000');
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('&nbsp&nbsp&nbsp'.$data[$i]['groupid'],'1000',null,false,'1px solid ','','L','Helvetica','12','B','','0px');
                Yii::$app->reporter->endrow();
                Yii::$app->reporter->endtable();

            Yii::$app->reporter->begintable('1000');
            $divi = $data[$i]['groupid'];
        }//end if
           
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
            if($data[$i]['isinactive']) {
                $isinactive = 'INACTIVE';
            }else{
                $isinactive = 'ACTIVE';
            }//end if

            Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Helvetica','11','','','0px');
            Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Helvetica','11','','','0px');
            Yii::$app->reporter->col($data[$i]['principal'],'150',null,false,'1px solid ','','C','Helvetica','11','','','0px');
            Yii::$app->reporter->col($data[$i]['groupid'],'150',null,false,'1px solid ','','C','Helvetica','11','','','0px');
            Yii::$app->reporter->col($price,'200',null,false,'1px solid ','','R','Helvetica','11','','','0px');
            Yii::$app->reporter->col($isinactive,'100',null,false,'1px solid ','','C','Helvetica','11','','','0px');

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
        Yii::$app->reporter->col('ITEM LIST',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('1000'); 
            Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');
                if($params['barcode']==''){
                Yii::$app->reporter->col('Item : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
                } else {
                Yii::$app->reporter->col('Item :'.$params['itemname'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
                }
               
                if($params['brand']==''){
                Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
                } else {
                Yii::$app->reporter->col('Brand :'. $params['brand'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
                }
                if($params['categoryid']==''){
                Yii::$app->reporter->col('Category : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
                } else {
                Yii::$app->reporter->col('Category :'. $params['category'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
                }
                if($params['genericid']==''){
                Yii::$app->reporter->col('Generic : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
                } else {
                Yii::$app->reporter->col('Generic :'. $params['generic'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
                }
            Yii::$app->reporter->endrow();

            Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');
                if($params['principalid']==''){
                    Yii::$app->reporter->col('Principal : ALL','300',null,false,'1px solid ','','L','Helvetica','10','','','');    
                } else {
                    Yii::$app->reporter->col('Principal :'. $params['principalid'],'300',null,false,'1px solid ','','L','Helvetica','10','','','');
                }
                if($params['divisionid']==''){
                    Yii::$app->reporter->col('Division : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','','');    
                } else {
                    Yii::$app->reporter->col('Division :'. $params['divisionid'],'150',null,false,'1px solid ','','L','Helvetica','10','','','');
                }
                if($params['classid']==''){
                    Yii::$app->reporter->col('Classification : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
                } else {
                    Yii::$app->reporter->col('Classification :'. $params['class'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
                }

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        if($params['status'] == '0,1'){
                            Yii::$app->reporter->col('Status : All','200',null,false,'1px solid ','','L','Helvetica','10','','','');
                        } else {
                            if($params['status'] == 0){
                                $status = 'ACTIVE';
                            }
                            if($params['status'] == 1){
                                $status = 'INACTIVE';
                            }
                            Yii::$app->reporter->col('Status : '. $status,'200',null,false,'1px solid ','','L','Helvetica','10','','','');
                        }
                    break;
                }//END SWITCH

                Yii::$app->reporter->pagenumber('Page');
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();



//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
    Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','300',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('PRINCIPAL','150',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('DIVISION','150',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','200',null,false,'1px solid ','B','R','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('STATUS','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
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