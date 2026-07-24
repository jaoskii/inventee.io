<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Item Purchase Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');

    Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col('ITEM PURCHASE REPORT',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
            Yii::$app->reporter->endrow();

            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),'200',null,'','1px solid ','','l','','10','','','');
                
                if($params['barcode']==''){
                Yii::$app->reporter->col('Items : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Items : '. $params['itemname'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['supplier']==''){
                Yii::$app->reporter->col('Supplier : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Supplier : '. $params['suppliername'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['brand']==''){
                Yii::$app->reporter->col('Brand : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Brand : '. $params['brand'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['class']==''){
                Yii::$app->reporter->col('Classification : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Classification : '. $params['class'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
                if($params['principalid']==''){
                Yii::$app->reporter->col('Principal : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Principal : '. $params['principalid'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['divisionid']==''){
                Yii::$app->reporter->col('Division : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Division : '. $params['divisionid'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['categoryid']==''){
                Yii::$app->reporter->col('Category : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Category : '. $params['category'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['genericid']==''){
                Yii::$app->reporter->col('Classification : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Classification : '. $params['generic'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'700',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                Yii::$app->reporter->pagenumber('Page');
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

$totalbalqty=0;
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','L','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','300',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('DATE PURCHASE','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        echo '<br/><br/>';
    Yii::$app->reporter->endrow();
        
//var_dump($data);
$part="";
$partname = "";
$brand="";
$totalext=0;

for($i=0;$i<count ($data);$i++){
    Yii::$app->reporter->addline();
        if($partname != $data[$i]['partname']){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','','L','Helvetica','11','B','','');
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->col($data[$i]['partname'],'800',null,false,'1px solid ','','L','Helvetica','11','B','','');
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->begintable('800');
            $part = $data[$i]['part'];
            $partname = $data[$i]['partname'];
        }

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','L','Helvetica','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Helvetica','11','','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],2),'100',null,false,'1px solid ','','C','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['price'],2),'100',null,false,'1px solid ','','R','Helvetica','11','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Helvetica','11','','','');
        Yii::$app->reporter->endrow();
        //$totalbalqty=$totalbalqty+$data[$i]['balance'];
//    
		if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
           // Yii::$app->reporter->header($header);
			
			Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col('ITEM PURCHASE REPORT',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
            Yii::$app->reporter->endrow();

            Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),'200',null,'','1px solid ','','l','','10','','','');
                    
                    if($params['barcode']==''){
                    Yii::$app->reporter->col('Items : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                    } else {
                    Yii::$app->reporter->col('Items : '. $params['itemname'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                    }
                    if($params['supplier']==''){
                    Yii::$app->reporter->col('Supplier : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                    } else {
                    Yii::$app->reporter->col('Supplier : '. $params['suppliername'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                    }
                    if($params['brand']==''){
                    Yii::$app->reporter->col('Brand : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                    } else {
                    Yii::$app->reporter->col('Brand : '. $params['brand'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                    }
                    if($params['class']==''){
                    Yii::$app->reporter->col('Classification : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                    } else {
                    Yii::$app->reporter->col('Classification : '. $params['class'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                    }
                Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
                if($params['principalid']==''){
                Yii::$app->reporter->col('Principal : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Principal : '. $params['principalid'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['divisionid']==''){
                Yii::$app->reporter->col('Division : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Division : '. $params['divisionid'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['categoryid']==''){
                Yii::$app->reporter->col('Category : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Category : '. $params['category'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
                if($params['genericid']==''){
                Yii::$app->reporter->col('Classification : ALL','150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                } else {
                Yii::$app->reporter->col('Classification : '. $params['generic'],'150',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
                }
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'700',null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
                Yii::$app->reporter->pagenumber('Page');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
            $totalbalqty=0;
            Yii::$app->reporter->printline();
            //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('ITEM DESCRIPTION','300',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('DATE PURCHASE','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('PRICE','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->endrow();
    		Yii::$app->reporter->printline();
            $page=$page + $count;
		}
}    
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


//var_dump($params);
?>