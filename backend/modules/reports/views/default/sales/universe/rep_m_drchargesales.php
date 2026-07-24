<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Charge Sales Invoice';
try {
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
echo "<br>";
Yii::$app->reporter->beginreport('800');
    echo "<div style='margin-top:-5px;'>";
    // Yii::$app->reporter->begintable('800');
    // $loggeduser = Yii::$app->session['loggeduser']['name'];
    //         Yii::$app->reporter->startrow();
    //             Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Verdana','12','','10px','');
    //             Yii::$app->reporter->col('&nbsp;&nbsp;'.strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'750',null,false,'1px solid ','','L','Verdana','10','','','');
    //         Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo "</div>";

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(substr($data[0]['docno'], -6),'600',null,false,'1px solid ','','R','Verdana','12','B','','');
            Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Verdana','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'440',null,false,'1px solid ','','L','Verdana','13','B','10px','');
            Yii::$app->reporter->col(substr($data[0]['ourref'], 0, 2).' '.substr($data[0]['ourref'], -5),'120',null,false,'1px solid ','','L','Verdana','13','B','','');
              $dateid = date_create($data[0]['dateid']);
              $dateid = date_format($dateid,'m-d-Y');
            Yii::$app->reporter->col($dateid,'150',null,false,'1px solid ','','R','Verdana','13','B','','');
            Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Verdana','12','','10px','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo "</div>";    

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'280',null,false,'1px solid ','','L','Verdana','13','B','10px','');
            Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'160',null,false,'1px solid ','','L','Verdana','13','B','','');
            Yii::$app->reporter->col((isset($data[0]['pickname'])? $data[0]['pickname']:''),'120',null,false,'1px solid ','','L','Verdana','13','B','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','','R','Verdana','13','B','','');
            Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Verdana','12','','10px','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo "</div>";

    
    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'440',null,false,'1px solid ','','L','Verdana','13','B','10px','');
            Yii::$app->reporter->col((isset($data[0]['agname'])? $data[0]['agname']:''),'120',null,false,'1px solid ','','L','Verdana','13','B','','');
            Yii::$app->reporter->col('','120',null,false,'1px solid ','','L','Verdana','13','B','','');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Verdana','12','','10px','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo "</div>";

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['bstyle'])? $data[0]['bstyle']:''),'440',null,false,'1px solid ','','L','Verdana','13','B','10px','');
            Yii::$app->reporter->col((isset($data[0]['checkname'])? $data[0]['checkname']:''),'120',null,false,'1px solid ','','L','Verdana','13','B','','');
            Yii::$app->reporter->col('','120',null,false,'1px solid ','','L','Verdana','12','B','','');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Verdana','12','','10px','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo "</div>";

Yii::$app->reporter->endtable();

echo '<div>';


    echo '<div style="margin-top:30px;height:240px;">';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();

            
   $totalext=0;
   $totalqty=0;
   $sales=0;
   $tax=0;
   $zerononvat = 0;
   $vatablesales = 0;
   $isvatex = 0;
    for($i=0;$i<count($data);$i++){
        $qry = "select isvat from item where barcode = '" . $data[$i]['barcode']."'";
        $isvatitem = Yii::$app->sbccommon->datareader($qry);

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','12','','10px','');
        Yii::$app->reporter->col(number_format($data[$i]['isqty']),'50',null,false,'1px solid ','','R','Verdana','12','','','1px');
        Yii::$app->reporter->col($data[$i]['uom'],'80',null,false,'1px solid ','','C','Verdana','12','','','1px');
        Yii::$app->reporter->col($data[$i]['itemname'],'380',null,false,'1px solid ','','L','Verdana','12','','','1px');
        // Yii::$app->reporter->col('','0',null,false,'1px solid ','','L','Verdana','12','','10px','');
        Yii::$app->reporter->col(number_format($data[$i]['isamt'],2),'80',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col($data[$i]['disc'],'70',null,false,'1px solid ','','R','Verdana','12','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],2),'80',null,false,'1px solid ','','R','Verdana','12','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],2),'100',null,false,'1px solid ','','R','Verdana','12','','','1px');
        
        if($isvatitem){
            $vstr = 'V';
        }else{
            $vstr = 'E';
        }   //end if
          
        Yii::$app->reporter->col($vstr,'5',null,false,'1px solid ','','R','Verdana','11','','','1px');
        
        $totalext=$totalext+$data[$i]['ext'];
        $totalqty=$totalqty+$data[$i]['isqty'];

        
        if($data[$i]['isvat'] == 1){
            $sales += $data[$i]['ext'] / 1.12;  
            $tax += ($data[$i]['ext'] / 1.12) * .12;  
            $vatablesales += $data[$i]['ext'];
        }//end if
     

        if(!$isvatitem){
            $isvatex += $data[$i]['ext'];
        }//end if
    }//end for each   

    switch($data[0]['vattype']){
        case 'ZERO-RATED': 
            $sales=0;
            $tax = 0;
            $zerononvat = $totalext;
            $isvatex = 0;
            $vatablesales = 0;
        break;

        default: 
            $isvatex;
            $zerononvat = '';
            $vatablesales = ($vatablesales / 1.12);
        break;
    }//end 

   
    if($vatablesales != ''){
        $vatablesales =  number_format($vatablesales,2);
    }else{
        $vatablesales = '---';
    }//end if

    if($zerononvat != ''){
        $zerononvat =  number_format($zerononvat,2);
    }else{
        $zerononvat = '---';
    }//end if

    if($isvatex != 0){
        $isvatex =  number_format($isvatex,2);
    }else{
        $isvatex = '---';
    }//end if

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','20',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col(number_format($totalqty),'50',null,false,'1px solid ','T','C','Verdana','12','','10px','');
    Yii::$app->reporter->col('','80',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','380',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','80',null,false,'1px dotted ','','C','Verdana','12','','','');
    // Yii::$app->reporter->col('','0',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','70',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('TOTAL:','80',null,false,'1px dotted ','','R','Verdana','12','B','','');
    Yii::$app->reporter->col(number_format($totalext,2),'100',null,false,'1px dotted ','T','R','Verdana','12','B','','');
    
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();

    

echo '</div>';




    if ($data[0]['rem'] == ""){
        echo '<br/>';
    } else {
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('** '.$data[0]['rem'],'750',null,false,'1px dotted ','','L','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    }

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col($vatablesales,'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->col(number_format($totalext,2),'225',null,false,'1px dotted ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col($isvatex,'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->col(number_format($tax,2),'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col($zerononvat,'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->col(number_format($totalext - $tax,2),'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col(number_format($tax,2),'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->col('','225',null,false,'1px dotted ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';


    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->col(number_format($totalext - $tax,2),'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->col(number_format($tax,2),'225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';

    echo "<div style='margin-top:5px;'>";
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','225',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
        Yii::$app->reporter->col(number_format($totalext,2),'225',null,false,'1px dotted ','','R','Verdana','13','B','30px','1px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';
    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
echo '</div>';
echo '</div>';

    
} catch (ErrorException $e) {
    echo $e;
}
?> 