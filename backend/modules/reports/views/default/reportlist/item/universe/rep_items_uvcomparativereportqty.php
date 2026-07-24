<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Comparative Report - Sales Qty VS Qty On Hand';
use yii\base\ErrorException;

try {
	
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=36;
$page=36;

//var_dump($params);

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('COMPARATIVE REPORT - SALES QTY vs QTY ON HAND',null,null,false,'1px solid ','','','Helvetica','18','B','','');
 Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';

Yii::$app->reporter->begintable('1000'); 
Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');

if($params['principalid'] != ''){
	$principal = $params['principalid'];
}else{
	$principal = 'All';
}//end if

if($params['divisionid'] != ''){
	$division = $params['divisionid'];
}else{
	$division = 'All';
}//end if

$docout = $params['viewout'];
if($params['viewout'] == 'SJ'){
	$docout_title = 'SALES QTY';
}else{
	$docout_title = 'TS OUT';
}//end if


if($params['wh'] != ''){
	$wh_filterview = $params['wh'];
}else{
	$wh_filterview = 'All';
}//end if


Yii::$app->reporter->col('Principal: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $principal,null,null,'','1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('Balance as of: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$params['asof'],'250',null,false,'1px solid ','','L','Helvetica','11','B','','');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
	Yii::$app->reporter->col('Division '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $division,null,null,'','1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('Sales Date Range: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$params['startdate'].' to '.$params['enddate'].'','450',null,false,'1px solid ','','L','Helvetica','11','B','','');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
	Yii::$app->reporter->col('Month Factor: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['nomonths'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');
	Yii::$app->reporter->col('Unit:' . strtoupper($params['unit']),'250',null,false,'1px solid ','','L','Helvetica','11','B','','');
	Yii::$app->reporter->col('Warehouse: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['wh'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');

	Yii::$app->reporter->pagenumber('Page');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('ITEM DESCRIPTION','250',null,false,'1px solid ','TB','L','Helvetica','17','B','','6px');
Yii::$app->reporter->col('QoH','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
// Yii::$app->reporter->col('PACK','50',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
Yii::$app->reporter->col('TO GO','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->col('EXPIRY','100',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
Yii::$app->reporter->col($docout_title,'50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->col('MOVE','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->col('SUPP PRICE','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
Yii::$app->reporter->endrow();

$rowbarcode = '';

for ($i=0; $i < count($data); $i++) { 
	
	if($i == 0){
		$rowbarcode = $data[$i]['barcode'];
			
			if($params['wh'] != ""){
				$whfilter = " and wh.client = '".$params['wh']."' ";
			}else{
				$whfilter = "";
			}//end if

			if($params['unit'] == 'retail'){
				$uomleftstr = " uom.uom = item.uom ";
			}else{
				$uomleftstr = " uom.uom = item.purchase_uom ";
			}//END IF

			if($data[$i]['nobal']){
				$qtyhand = '---';
			}else{
				$qryonhand = "select 
	            round(ifnull((sum(bal)/uom.factor),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal from rrstatus
	            left join client as wh on wh.clientid = rrstatus.whid
	            left join item on item.itemid = rrstatus.itemid
	            left join uom on uom.itemid = item.itemid and ".$uomleftstr."
	            where rrstatus.itemid = ".$data[$i]['itemid']." ".$whfilter." group by rrstatus.itemid";

				$qtyhand = Yii::$app->sbccommon->datareader($qryonhand);

				if($qtyhand > 0){
					number_format($qtyhand,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
				}else{
					$qtyhand = '---';
				}//end uf
			}//end if
			
			Yii::$app->reporter->addline();
			Yii::$app->reporter->startrow();
			Yii::$app->reporter->col($data[$i]['itemname'].'&nbsp-'.$data[$i]['factor'].'\'s','250',null,false,'1px solid ','','L','Helvetica','17','','','');
			Yii::$app->reporter->col($qtyhand,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','c','Helvetica','17','','','');
			// Yii::$app->reporter->col($data[$i]['factor'],'50',null,false,'1px solid ','','c','Helvetica','17','','','');

			/*$qry = "select round(qty,2) as qty from (
					select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
					left join lastock as stock on stock.trno = head.trno
					left join item on item.barcode = stock.barcode
					left join client as wh on wh.client = stock.wh
					left join uom on uom.itemid = item.itemid and ".$uomleftstr."
					where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
					and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
					group by item.barcode
					UNION ALL
					select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
					left join glstock as stock on stock.trno = head.trno
					left join item on item.itemid = stock.itemid
					left join client as wh on wh.clientid = stock.whid
					left join uom on uom.itemid = item.itemid and ".$uomleftstr."
					where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
					and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
					group by item.barcode) as tbl";*/

				$qry = "select round(sum(qty), 2) as qty from (
	              select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
	              left join lastock as stock on stock.trno = head.trno
	              left join item on item.barcode = stock.barcode
	              left join client as wh on wh.client = stock.wh
	              left join uom on uom.itemid = item.itemid and ".$uomleftstr."
	              where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
	              and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
	              group by item.barcode
	              UNION ALL
	              select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
	              left join glstock as stock on stock.trno = head.trno
	              left join item on item.itemid = stock.itemid
	              left join client as wh on wh.clientid = stock.whid
	              left join uom on uom.itemid = item.itemid and ".$uomleftstr."
	              where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
	              and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
	              group by item.barcode) as tbl";

			$qty = Yii::$app->sbccommon->datareader($qry);


			if($params['nomonths'] != ""){
				if($qty <= 0){
					$movemonth = 0;
					$months_to_go = 0;
				}else{
					$movemonth = $qty / $params['nomonths']; //denominator needs to be month factor (parameters)
					$months_to_go = $qtyhand / $movemonth; //denominator needs to be # of months (parameters)
				}//end if
			}else{
				$movemonth = 0;
				$months_to_go = 0;
			}//end if

			if(strlen($data[$i]['expiry']) != 0 && strlen($data[$i]['expiry']) == 10){
				$expiry = date_create($data[$i]['expiry']);
				$expiry = date_format($expiry,"m/Y");
			}else{
				$expiry = $data[$i]['expiry'];
			}
			
			if($months_to_go  == 0){
				$months_to_go = '';
				Yii::$app->reporter->col($months_to_go,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}else{
				Yii::$app->reporter->col(number_format($months_to_go,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}//END IF
			
			if($data[$i]['balance'] == 0){
				$balance = '---';
				$expiry = "";
			}else{
				$balance = $data[$i]['balance'];
				$balance = number_format($balance,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
			}//end if

			Yii::$app->reporter->col($balance,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col($expiry,'100',null,false,'1px solid ','','C','Helvetica','17','','','');
			Yii::$app->reporter->col($qty,'50',null,false,'1px solid ','','R','Helvetica','17','','','');

			if($movemonth  == 0){
				$movemonth = '';
				Yii::$app->reporter->col($movemonth,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}else{
				Yii::$app->reporter->col(number_format($movemonth,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}//ENND IF


			$qry2 = "select round(ifnull(stock.rrcost,'---'),2) as spc from hspchead as head
		    left join hspcstock as stock on stock.trno = head.trno
		    where stock.barcode = '".$data[$i]['barcode']."' order by head.dateid desc limit 1";

		    $spc =  Yii::$app->sbccommon->datareader($qry2);

			Yii::$app->reporter->col($spc,'100',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->endrow();
	}else{
		if($rowbarcode == $data[$i]['barcode']){
			Yii::$app->reporter->addline();
			Yii::$app->reporter->startrow();
			Yii::$app->reporter->col('&nbsp','250',null,false,'1px solid ','','L','Helvetica','17','','','');
			Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','','L','Helvetica','17','','','');
			// Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','','L','Helvetica','17','','','');
			
			if(strlen($data[$i]['expiry']) != 0 && strlen($data[$i]['expiry']) == 10){
				$expiry = date_create($data[$i]['expiry']);
				$expiry = date_format($expiry,"m/Y");
			}else{
				$expiry = $data[$i]['expiry'];
			}
			
			Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','','R','Helvetica','17','','','');
			
			if($data[$i]['balance'] == 0){
				$balance = 0;
				$expiry = "";
			}else{
				$balance = $data[$i]['balance'];
			}//end if

			Yii::$app->reporter->col($balance,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col($expiry,'100',null,false,'1px solid ','','C','Helvetica','17','','','');
			Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col('&nbsp','50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->endrow();
		}else{
			$rowbarcode = $data[$i]['barcode'];
			
			if($params['wh'] != ""){
				$whfilter = " and wh.client = '".$params['wh']."' ";
			}else{
				$whfilter = "";
			}//end if

			if($params['unit'] == 'retail'){
				$uomleftstr = " uom.uom = item.uom ";
			}else{
				$uomleftstr = " uom.uom = item.purchase_uom ";
			}//END IF

			if($data[$i]['nobal']){
				$qtyhand = '---';
			}else{
				$qryonhand = "select 
	            round(ifnull((sum(bal)/uom.factor),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal from rrstatus
	            left join client as wh on wh.clientid = rrstatus.whid
	            left join item on item.itemid = rrstatus.itemid
	            left join uom on uom.itemid = item.itemid and ".$uomleftstr."
	            where rrstatus.itemid = ".$data[$i]['itemid']." ".$whfilter." group by rrstatus.itemid";

				$qtyhand = Yii::$app->sbccommon->datareader($qryonhand);

				if($qtyhand > 0){
					number_format($qtyhand,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
				}else{
					$qtyhand = '---';
				}//end uf
			}//end if

			Yii::$app->reporter->addline();
			Yii::$app->reporter->startrow();
			Yii::$app->reporter->col($data[$i]['itemname'].'&nbsp-'.$data[$i]['factor'].'\'s','250',null,false,'1px solid ','','L','Helvetica','17','','','');
			Yii::$app->reporter->col($qtyhand,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','c','Helvetica','17','','','');
			// Yii::$app->reporter->col($data[$i]['factor'],'50',null,false,'1px solid ','','c','Helvetica','17','','','');

			/*$qry = "select round(qty,2) as qty from (
					select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
					left join lastock as stock on stock.trno = head.trno
					left join item on item.barcode = stock.barcode
					left join client as wh on wh.client = stock.wh
					left join uom on uom.itemid = item.itemid and ".$uomleftstr."
					where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
					and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
					group by item.barcode
					UNION ALL
					select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
					left join glstock as stock on stock.trno = head.trno
					left join item on item.itemid = stock.itemid
					left join client as wh on wh.clientid = stock.whid
					left join uom on uom.itemid = item.itemid and ".$uomleftstr."
					where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
					and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
					group by item.barcode) as tbl";*/
			$qry = "select round(sum(qty), 2) as qty from (
			select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
			left join lastock as stock on stock.trno = head.trno
			left join item on item.barcode = stock.barcode
			left join client as wh on wh.client = stock.wh
			left join uom on uom.itemid = item.itemid and ".$uomleftstr."
			where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
			and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
			group by item.barcode
			UNION ALL
			select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
			left join glstock as stock on stock.trno = head.trno
			left join item on item.itemid = stock.itemid
			left join client as wh on wh.clientid = stock.whid
			left join uom on uom.itemid = item.itemid and ".$uomleftstr."
			where head.doc = '".$docout."' and item.barcode = '".$data[$i]['barcode']."'
			and head.dateid between '".$params['startdate']."' and '".$params['enddate']."' ".$whfilter."
			group by item.barcode) as tbl";
			
			//ec
			$qty = Yii::$app->sbccommon->datareader($qry);

			if($params['nomonths'] != ""){
				if($qty <= 0){
					$movemonth = 0;
					$months_to_go = 0;
				}else{
					$movemonth = $qty / $params['nomonths']; //denominator needs to be month factor (parameters)
					$months_to_go = $qtyhand / $movemonth; //denominator needs to be # of months (parameters)
				}//end if
			}else{
				$movemonth = 0;
				$months_to_go = 0;
			}//end if

			if(strlen($data[$i]['expiry']) != 0 && strlen($data[$i]['expiry']) == 10){
				$expiry = date_create($data[$i]['expiry']);
				$expiry = date_format($expiry,"m/Y");
			}else{
				$expiry = $data[$i]['expiry'];
			}
			
			if($months_to_go  == 0){
				$months_to_go = '';
				Yii::$app->reporter->col($months_to_go,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}else{
				Yii::$app->reporter->col(number_format($months_to_go,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}

			if($data[$i]['balance'] == 0){
				$balance = '---';
				$expiry = "";
			}else{
				$balance = $data[$i]['balance'];
				$balance = number_format($balance,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
			}//end if
			
			Yii::$app->reporter->col($balance,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->col($expiry,'100',null,false,'1px solid ','','C','Helvetica','17','','','');
			Yii::$app->reporter->col($qty,'50',null,false,'1px solid ','','R','Helvetica','17','','','');

			if($movemonth  == 0){
				$movemonth = '';
				Yii::$app->reporter->col($movemonth,'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}else{
				Yii::$app->reporter->col(number_format($movemonth,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Helvetica','17','','','');
			}


			$qry2 = "select round(ifnull(stock.rrcost,'---'),2) as spc from hspchead as head
		    left join hspcstock as stock on stock.trno = head.trno
		    where stock.barcode = '".$data[$i]['barcode']."' order by head.dateid desc limit 1";

		    $spc =  Yii::$app->sbccommon->datareader($qry2);

			Yii::$app->reporter->col($spc,'100',null,false,'1px solid ','','R','Helvetica','17','','','');
			Yii::$app->reporter->endrow();
		}//end if
	}//end if

    if(Yii::$app->reporter->linecounter==$page){
    	Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('1000');
		$header=Yii::$app->reporter->letterhead();
		Yii::$app->reporter->endtable();
		echo '<br/><br/>';

    	Yii::$app->reporter->begintable('1000'); 
		Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Helvetica','10','','','');

		if($params['principalid'] != ''){
			$principal = $params['principalid'];
		}else{
			$principal = 'All';
		}//end if

		if($params['divisionid'] != ''){
			$division = $params['divisionid'];
		}else{
			$division = 'All';
		}//end if


		Yii::$app->reporter->col('Principal: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $principal,null,null,'','1px solid ','','L','Helvetica','11','B','','');

		Yii::$app->reporter->endrow();

		Yii::$app->reporter->startrow();
			Yii::$app->reporter->col('Division '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $division,null,null,'','1px solid ','','L','Helvetica','11','B','','');

			Yii::$app->reporter->col('Sales Date Range: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$params['startdate'].' - '.$params['enddate'].'','450',null,false,'1px solid ','','L','Helvetica','11','B','','');
		Yii::$app->reporter->endrow();

		Yii::$app->reporter->startrow();
			Yii::$app->reporter->col('Month Factor: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['nomonths'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');

			Yii::$app->reporter->col('Warehouse: '.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $params['wh'],null,null,'','1px solid ','','L','Helvetica','11','B','','4px');

			Yii::$app->reporter->pagenumber('Page');
		Yii::$app->reporter->endrow();
		Yii::$app->reporter->endtable();

		Yii::$app->reporter->begintable('1000');
		Yii::$app->reporter->startrow();
		Yii::$app->reporter->col('ITEM DESCRIPTION','250',null,false,'1px solid ','TB','L','Helvetica','17','B','','6px');
		Yii::$app->reporter->col('QoH','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','TB','c','Helvetica','17','B','','');
		// Yii::$app->reporter->col('PACK','50',null,false,'1px solid ','TB','c','Helvetica','17','B','','');
		Yii::$app->reporter->col('TO GO','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('EXPIRY','100',null,false,'1px solid ','TB','C','Helvetica','17','B','','');
		Yii::$app->reporter->col($docout_title,'50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('MOVE','50',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->col('SUPP PRICE','100',null,false,'1px solid ','TB','R','Helvetica','17','B','','');
		Yii::$app->reporter->endrow();

		$page=$page + $count;
	}//end if header 2 

}//end for each

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
} catch (ErrorException $e) {
	echo $e;
}
?>
