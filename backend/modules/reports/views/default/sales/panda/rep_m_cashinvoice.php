<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Cash Invoice Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
Yii::$app->reporter->beginreport();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PANDA CONSTRUCTION SUPPLY INC.','600',null,false,'1px solid ','','L','Century Gothic','16','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Cah Invoice','600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('No. '.(isset($data[0]['docno'])? $data[0]['docno']:''),'600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Customer : ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col('','450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Agent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        if($data[0]['agent']==''){
        Yii::$app->reporter->col('&nbsp;&nbsp;()','210',null,false,'1px solid ','','L','Century Gothic','12','','','');    
        } else {
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['agent'])? $data[0]['agent']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        }
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address&nbsp;&nbsp;&nbsp;&nbsp;: ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Warehouse&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['whname'])? $data[0]['whname']:'').'('.(isset($data[0]['whcode'])? $data[0]['whcode']:'').')','210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Ship To&nbsp;&nbsp;&nbsp;&nbsp;: ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col((isset($data[0]['shipto'])? $data[0]['shipto']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Note&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['rem'])? $data[0]['rem']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Brand','100',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Item Description','400',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Quantity','50',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Amount','75',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Discount','50',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Total','75',null,false,'1px solid ','B','R','Century Gothic','12','B','','');

        

   $totalext=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['brand'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],2),'50',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],2),'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['disc'],'50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],2),'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        $totalext=$totalext+$data[$i]['ext'];
        
        
        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PANDA CONSTRUCTION SUPPLY INC.','600',null,false,'1px solid ','','L','Century Gothic','16','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Sales Order','600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('No. '.(isset($data[0]['docno'])? $data[0]['docno']:''),'600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Customer : ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col('','450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Agent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        if($data[0]['agent']==''){
        Yii::$app->reporter->col('&nbsp;&nbsp;()','210',null,false,'1px solid ','','L','Century Gothic','12','','','');    
        } else {
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['agent'])? $data[0]['agent']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        }
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address&nbsp;&nbsp;&nbsp;&nbsp;: ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Warehouse&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['whname'])? $data[0]['whname']:'').(isset($data[0]['wh'])? $data[0]['wh']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Ship To&nbsp;&nbsp;&nbsp;&nbsp;: ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        Yii::$app->reporter->col((isset($data[0]['shipto'])? $data[0]['shipto']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        Yii::$app->reporter->col('Note&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['rem'])? $data[0]['rem']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Brand','100',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Item Description','400',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Quantity','50',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Amount','75',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Discount','50',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Total','75',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
               Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}   
    
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Total','100',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','400',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','T','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','T','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($totalext,2),'75',null,false,'1px solid ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
		
		Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
		
		Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By :','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
		
		Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($prepared)? $prepared:''),'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>