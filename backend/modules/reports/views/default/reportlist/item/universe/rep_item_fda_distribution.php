<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Distribution Report (FDA)';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

if(!isset($data[1])){
    echo 'No Data Found. Please double check Item Required filters.';
    echo '<br>';
    echo '- Item, Item Unit';
    return 0;
}//end if

$count=55;
$page=54;

$sqlmain = "select itemid, barcode, itemname, uom, purchase_uom, ifnull(uv_principal.name,'') as uvprincipal from item
            left join uv_principal on item.uv_principal = uv_principal.line
            where barcode = '" . $params['barcode'] . "'";

$iteminstance = Yii::$app->sbccommon->opentable($sqlmain);

if($params['unit'] == 'retail'){
    $uomchecker = $iteminstance[0]['uom'];
}else{
    $uomchecker = $iteminstance[0]['purchase_uom'];
}//END IF

$sql="select factor from uom where itemid = " . $iteminstance[0]['itemid'] . " and uom ='".$uomchecker."'";
$uomfactor=Yii::$app->sbccommon->datareader($sql);


$lotsqry = "select stock.expiry, stock.rem, 0 as closest from glhead as head 
            left join glstock as stock on stock.trno = head.trno
            where head.doc = 'RR' and stock.itemid = ".$iteminstance[0]['itemid']."
            group by stock.expiry, stock.rem
            order by expiry";
$lot_numbers = Yii::$app->sbccommon->opentable($lotsqry);


Yii::$app->reporter->beginreport('1200');

 //if (Yii::$app->backend->getcompanyid() == 1) {
    $loggeduser = Yii::$app->session['loggeduser']['name'];
    /* Yii::$app->reporter->begintable('1200');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';//}     */

Yii::$app->reporter->begintable('1200');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Establishment: Universe Pharmacy',null,null,false,'1px solid ','','','Avenir','15','B','','').'<br />';
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address: 366 Magallanes St., Brgy Ermita, Cebu City, Philippines 6000',null,null,false,'1px solid ','','','Avenir','15','B','','').'<br />';
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Pharmacist: Perlita Coliao Arnado',null,null,false,'1px solid ','','','Avenir','15','B','','').'<br />';
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date: '.$params['start'].' to '.$params['end'],'225',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Product: ' . $iteminstance[0]['itemname'] . ' Distribution Record','200',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Packaging: ' . ucfirst($params['unit']) . ' - ' . ucfirst($uomchecker),'75',null,false,'1px solid ','','L','Avenir','11','B','','1px');
         Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Manufacturer: ' . $iteminstance[0]['uvprincipal'],'75',null,false,'1px solid ','','L','Avenir','11','B','','1px');
         Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

/* Yii::$app->reporter->begintable('1200');
Yii::$app->reporter->col('WAREHOUSE: ','75',null,false,'1px solid ','','L','Avenir','11','B','','1px');
Yii::$app->reporter->col($params['warehouse'],'200',null,false,'1px solid ','','L','Avenir','11','B','','1px');
Yii::$app->reporter->col('UOM: '.$params['uom'],'325',null,false,'1px solid ','','L','Avenir','11','B','','1px');

$sql="select factor from uom where itemid = " . $data[1]['itemid2'] . " and uom ='".$params['uom']."'";
$uomfactor=Yii::$app->sbccommon->datareader($sql);

Yii::$app->reporter->col('FACTOR: '.number_format($uomfactor,2),'200',null,false,'1px solid ','','L','Avenir','11','B','','1px'); */

Yii::$app->reporter->endtable();


Yii::$app->reporter->endtable();
echo '<br/>';
//Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();



Yii::$app->reporter->begintable('1200');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Receive Date','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Invoice No.','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Qty Received','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Expiry Date','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Lot No.','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Name ','300',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Date Sold','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Qty Sold','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Balance','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('Doc #','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    
$bal=0;
$totaliss = 0;
$totalqty = 0; 
$tobal = 0;
$bal = 0;
$totalrows = 0;

for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    if ($data[$i]['docno'] == 'beginning bal.'){
        $qty=$data[$i]['qty'];
        $totalrows = $totalrows + 1;
    
        if ($qty<1){
            $qty='-';
        }//end if

        $iss=$data[$i]['iss'];
        
        if ($iss==0){
            $iss='-';
        }//end if
        
        if($i == 0){
            $bal = $data[$i]['bal'];
        }else{
            $bal = $bal - $iss;
            $bal = $bal + $qty;
        }//end if 

        $tobal=$bal;
        $tobal = $tobal;

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','LBR','C','Avenir','11','','','');
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','BR','L','Avenir','11','','','');
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','BR','r','Avenir','11','','','');
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','BR','c','Avenir','11','','','');
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','BR','c','Avenir','11','','','');
            Yii::$app->reporter->col('Beginning Balance','300',null,false,'1px solid ','BR','C','Avenir','11','','','');
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','BR','c','Avenir','11','','','');
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','BR','R','Avenir','11','','','');
            Yii::$app->reporter->col(number_format($data[$i]['bal'],2),'100',null,false,'1px solid ','BR','R','Avenir','11','','','');
            Yii::$app->reporter->col('-','100',null,false,'1px solid ','RB','R','Avenir','11','','','');
        Yii::$app->reporter->endrow();
    } else {
        if($data[$i]['doc'] == 'TS'){
            if($params['wh'] != ''){
                $totalrows = $totalrows + 1;
                $qty=$data[$i]['qty'];
    
                if ($qty<1){
                    $qty='-';
                }//end if

                $iss=$data[$i]['iss'];
                
                if ($iss==0){
                    $iss='-';
                }//end if
                
                if($i == 0){
                    $bal = $data[$i]['bal'];
                }else{
                    $bal = $bal - $iss;
                    $bal = $bal + $qty;
                }//end if 

                $tobal=$bal;
                $tobal = $tobal;
                if($data[$i]['iss'] > 0){
                    Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col('<div style="color:red;">'.number_format($data[$i]['iss'] * -1,2).'</div>','100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['expiry'],'100',null,false,'1px solid ','','C','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','c','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','R','Avenir','11','','','');
                    Yii::$app->reporter->endrow();
                }else{
                    Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['qty'],'100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['expiry'],'100',null,false,'1px solid ','','C','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','c','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','R','Avenir','11','','','');
                    Yii::$app->reporter->endrow();
                }//end if
            }//end if
        }else{
            $totalrows = $totalrows + 1;
            $qty=$data[$i]['qty'];
    
            if ($qty<1){
                $qty='-';
            }//end if

            $iss=$data[$i]['iss'];
            
            if ($iss==0){
                $iss='-';
            }//end if
            
            if($i == 0){
                $bal = $data[$i]['bal'];
            }else{
                $bal = $bal - $iss;
                $bal = $bal + $qty;
            }//end if 

            $tobal=$bal;
            $tobal = $tobal;

            switch($data[$i]['doc']){
                case 'SJ': case 'CM':
                    $targetDate = new DateTime($data[$i]['expiry']);

                    foreach ($lot_numbers as &$lot) {
                        if (isset($lot['expiry'])) {
                            $expiryDate = new DateTime($lot['expiry']);
                            $dateDifference = $expiryDate->diff($targetDate)->days;

                            // Update the 'closest' field with the date difference
                            $lot['closest'] = $dateDifference;
                        } else {
                            // Set a default high value if 'expiry' is not set
                            $lot['closest'] = PHP_INT_MAX;
                        }
                    }

                    // Ensure all elements have 'closest' field before sorting
                    usort($lot_numbers, function($a, $b) {
                        if ($a['closest'] == $b['closest']) {
                            return 0;
                        }
                        return ($a['closest'] < $b['closest']) ? -1 : 1;
                    });

                    // Get the first instance with the lowest 'closest' value
                    $closestLot = $lot_numbers[0];

                    Yii::$app->reporter->startrow();
                        Yii::$app->reporter->startrow();
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','','C','Avenir','11','','','');
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','','L','Avenir','11','','','');
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','','R','Avenir','11','','','');
                            Yii::$app->reporter->col($data[$i]['expiry'],'100',null,false,'1px solid ','','C','Avenir','11','','','');
                            Yii::$app->reporter->col($closestLot['rem'],'100',null,false,'1px solid ','','L','Avenir','11','','','');
                            Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px solid ','','L','Avenir','11','','','');
                            //Yii::$app->reporter->col($data[$i]['iss'],'100',null,false,'1px solid ','','R','Avenir','11','','','');
                            Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','c','Avenir','11','','','');
                            if($data[$i]['doc'] == 'SJ'){
                                Yii::$app->reporter->col(number_format($data[$i]['iss'] ,2),'100',null,false,'1px solid ','','R','Avenir','11','','','');
                            }else{
                                Yii::$app->reporter->col('<div style="color:red;">'.number_format($data[$i]['qty'] * -1,2).'</div>','100',null,false,'1px solid ','','R','Avenir','11','','','');
                            }//end if
                            Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','','R','Avenir','11','','','');
                            Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->endrow();
                break;

                case 'RR': case 'DM': case 'AJ':
                    Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['yourref'],'100',null,false,'1px solid ','','L','Avenir','11','','','');
                        if($data[$i]['qty'] > 0){
                            Yii::$app->reporter->col(number_format($data[$i]['qty'] ,2),'100',null,false,'1px solid ','','R','Avenir','11','','','');
                        }else{
                            Yii::$app->reporter->col('<div style="color:red;">' . number_format($data[$i]['iss'] * -1,2).'</div>','100',null,false,'1px solid ','','R','Avenir','11','','','');
                        }//end if
                        //Yii::$app->reporter->col($data[$i]['qty'],'100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['expiry'],'100',null,false,'1px solid ','','C','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px solid ','','L','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','c','Avenir','11','','','');
                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','','R','Avenir','11','','','');
                        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','R','Avenir','11','','','');
                    Yii::$app->reporter->endrow();
                break;
            }//end swithc
        }//end if

        
    }//end if
    
    $totaliss = $totaliss+$iss;
    $totalqty = $totalqty+$qty;
}

Yii::$app->reporter->endtable();

 Yii::$app->reporter->begintable('1200');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('GRAND TOTAL:','100',null,false,'1px solid ','T','C','Avenir','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','L','Avenir','11','','','');
        Yii::$app->reporter->col(number_format($totalqty,2),'100',null,false,'1px solid ','T','R','Avenir','13','b','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','C','Avenir','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','L','Avenir','11','','','');
        Yii::$app->reporter->col('','300',null,false,'1px solid ','T','L','Avenir','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','R','Avenir','11','','','');
        Yii::$app->reporter->col(number_format($totaliss,2),'100',null,false,'1px solid ','T','R','Avenir','13','b','','');
        Yii::$app->reporter->col(number_format($tobal,2),'100',null,false,'1px solid ','T','R','Avenir','13','b','','');
        Yii::$app->reporter->col('Total Rows: '.$totalrows,'100',null,false,'1px solid ','T','R','Avenir','11','','','');
    Yii::$app->reporter->endrow();

    /* Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','75',null,false,'1px solid ','T','C','Avenir','11','','','');
    Yii::$app->reporter->col('&nbsp;','230',null,false,'1px solid ','T','L','Avenir','11','','','');
    Yii::$app->reporter->col('&nbsp;','70',null,false,'1px solid ','T','L','Avenir','11','','','');
    Yii::$app->reporter->col('TOTAL QTY : ','100',null,false,'1px solid ','T','L','Avenir','11','','','');
  
    Yii::$app->reporter->col(number_format($totalqty,2),'65',null,false,'1px solid ','T','R','Avenir','11','','','');
  
    Yii::$app->reporter->col(number_format($totaliss,2),'75',null,false,'1px solid ','T','R','Avenir','11','','','');
    Yii::$app->reporter->col($tobal,'70',null,false,'1px solid ','T','R','Avenir','11','','','');
    Yii::$app->reporter->col('&nbsp;','95',null,false,'1px solid ','T','R','Avenir','11','','','');

    Yii::$app->reporter->endrow(); */
Yii::$app->reporter->endtable();


/* echo '<br/><br/>';
    Yii::$app->reporter->begintable('1200'); 
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
 */
    echo '<br/>';
    /* Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Avenir','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Avenir','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Avenir','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); */

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>
