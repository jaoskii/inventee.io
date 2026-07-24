<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report - Detailed(Ton Ren Tang)';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$pagenumber=1;
$count=6;
$page=6;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1000');
    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('1000');
//header
    $start=$params['start'];
    $end=$params['end'];
    if($params['username']!=""){
        $user=$params['username'];
    }
    else{
        $user="ALL USERS";
    }
    Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Sales Journal Report',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Date Range: '.$start.' to '.$end,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('User: '.$user,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('Prefix: '.$params['bref'],null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','B','Century Gothic','10','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$docno="";
// var_dump(count($data));
 
        $total=0;
        $totalcost=0;
         Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')

                Yii::$app->reporter->col('Doc#','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');

                Yii::$app->reporter->col('Date','80',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');

                Yii::$app->reporter->col('Customer','120',null,false,'1px solid ','B','L','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Barcode','80',null,false,'1px solid ','B','L','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Item Description','150',null,false,'1px solid ','B','L','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Quantity','80',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('UOM','80',null,false,'1px solid ','B','L','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Price','80',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Discount','80',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Total Amount','80',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Total Cost','80',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('Markup','80',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');

                Yii::$app->reporter->col('Notes','80',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 

for($i=0;$i<count($data);$i++)
{
    
       

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->col($data[$i]['dateid'],'80',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['supplier'],'120',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['barcode'],'80',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['itemname'],'150',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['iss'],2),'80',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['uom'],'80',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['isamt'],2),'80',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['disc'],'80',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['ext'],2),'80',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            $cost=$data[$i]['iss']*$data[$i]['cost'];
            Yii::$app->reporter->col(number_format($cost,2),'80',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            $markup = $data[$i]['ext']-$cost;
            Yii::$app->reporter->col(number_format($markup,2),'80',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
          
            Yii::$app->reporter->col($data[$i]['rem'],'80',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->addline();
        
            $total+=$data[$i]['ext'];
            $totalcost+=$cost;
    Yii::$app->reporter->endtable();
    if($i==count($data)-1)
    {
        Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Grand Total Amount: '.number_format($total,2),'1000',null,false,'1px solid','','R','Century Gothic','11','B','30px','8px');
                
            Yii::$app->reporter->endrow();
          
           Yii::$app->reporter->startrow();
              
                 Yii::$app->reporter->col('Grand Total Cost: '.number_format($totalcost,2),'100',null,false,'1px solid','','R','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();

            

        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
              $totalmarkup= $total-$totalcost;
                   Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid','','R','Century Gothic','11','B','30px','8px');
                 Yii::$app->reporter->col('Markup: '.number_format($totalmarkup,2),'200',null,false,'1px dotted','T','R','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
    }
}
?>