<?php
// WTODO JAD 06-03-2019
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Vs Collection';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count = 38;
$page = 40;

Yii::$app->reporter->beginreport('1650');
	Yii::$app->reporter->begintable('1650');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('SOLUTION BASE CORPORATION','1500','','','1px solid ','','C','century gothic','18','B','','');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('SALES vs COLLECTION - Annual '.$params['year'],'1500','','','1px solid ','','L','century gothic','18','B','','');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(strtoupper($params['type']).' Transactions','1500','','','1px solid ','','L','century gothic','18','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1650');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CUSTOMER','255',null,false,'1px solid ','T','C','Century Gothic','9','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('JAN' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('FEB' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('MAR' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('APR' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('MAY' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('JUN' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('JUL' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('AUG' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SEP' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('OCT' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('NOV' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('DEC' ,'90','','','1px solid ','TB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','T','C','century gothic','9','B','','');
            Yii::$app->reporter->col('TOTAL' ,'100','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1650');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('NAME','255',null,false,'1px solid ','B','C','Century Gothic','9','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'45','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'45','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col('SALES' ,'50','','','1px solid ','RB','C','century gothic','9','B','','');
            Yii::$app->reporter->col('COL.' ,'50','','','1px solid ','B','C','century gothic','9','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

        $totals = $totalc = $totalsmojan = $totalsmofeb = $totalsmomar = $totalsmoapr = $totalsmomay = $totalsmojun = $totalsmojul = $totalsmoaug = $totalsmosep = $totalsmooct = $totalsmonov = $totalsmodec = 0;
	    $totalpmojan = $totalpmofeb = $totalpmomar = $totalpmoapr = $totalpmomay = $totalpmojun = $totalpmojul = $totalpmoaug = $totalpmosep = $totalpmooct = $totalpmonov = $totalpmodec = $grands = $grandc = 0;
    
    Yii::$app->reporter->begintable('1650');
        for($i = 0; $i < count($data); $i++) {
			$smojan = number_format($data[$i]['smo1'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smojan < 1) { $smojan = '-'; }

            $smofeb = number_format($data[$i]['smo2'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smofeb < 1) { $smofeb = '-'; }

            $smomar = number_format($data[$i]['smo3'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smomar < 1) { $smomar = '-'; }

            $smoapr = number_format($data[$i]['smo4'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smoapr < 1) { $smoapr = '-'; }

            $smomay = number_format($data[$i]['smo5'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smomay < 1) { $smomay = '-'; }

            $smojun = number_format($data[$i]['smo6'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smojun < 1) { $smojun = '-'; }

            $smojul = number_format($data[$i]['smo7'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smojul < 1) { $smojul = '-'; }

            $smoaug = number_format($data[$i]['smo8'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smoaug < 1) { $smoaug = '-'; }

            $smosep = number_format($data[$i]['smo9'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smosep < 1) { $smosep = '-'; }

            $smooct = number_format($data[$i]['smo10'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smooct < 1) { $smooct = '-'; }

            $smonov = number_format($data[$i]['smo11'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smonov < 1) { $smonov = '-'; }

            $smodec = number_format($data[$i]['smo12'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($smodec < 1) { $smodec = '-'; }
                        
            $totals = $data[$i]['smo1'] + $data[$i]['smo2'] + $data[$i]['smo3'] + $data[$i]['smo4'] + $data[$i]['smo5'] + $data[$i]['smo6'] + $data[$i]['smo7'] + $data[$i]['smo8'] + $data[$i]['smo9'] + $data[$i]['smo10'] + $data[$i]['smo11'] + $data[$i]['smo12'];

            $pmojan = number_format($data[$i]['pmo1'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmojan < 1) { $pmojan = '-'; }

            $pmofeb = number_format($data[$i]['pmo2'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmofeb < 1) { $pmofeb = '-'; }

            $pmomar = number_format($data[$i]['pmo3'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmomar < 1) { $pmomar = '-'; }

            $pmoapr = number_format($data[$i]['pmo4'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmoapr < 1) { $pmoapr = '-'; }

            $pmomay = number_format($data[$i]['pmo5'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmomay < 1) { $pmomay = '-'; }

            $pmojun = number_format($data[$i]['pmo6'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmojun < 1) { $pmojun = '-'; }

            $pmojul = number_format($data[$i]['pmo7'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmojul < 1) { $pmojul = '-'; }

            $pmoaug = number_format($data[$i]['pmo8'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmoaug < 1) { $pmoaug = '-'; }

            $pmosep = number_format($data[$i]['pmo9'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmosep < 1) { $pmosep = '-'; }

            $pmooct = number_format($data[$i]['pmo10'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmooct < 1) { $pmooct = '-'; }

            $pmonov = number_format($data[$i]['pmo11'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmonov < 1) { $pmonov = '-'; }

            $pmodec = number_format($data[$i]['pmo12'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if($pmodec < 1) { $pmodec = '-'; }

            $totalc = $data[$i]['pmo1'] + $data[$i]['pmo2'] + $data[$i]['pmo3'] + $data[$i]['pmo4'] + $data[$i]['pmo5'] + $data[$i]['pmo6'] + $data[$i]['pmo7'] + $data[$i]['pmo8'] + $data[$i]['pmo9'] + $data[$i]['pmo10'] + $data[$i]['pmo11'] + $data[$i]['pmo12'];

            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($data[$i]['clientname'],'255','','','1px solid ','','L','century gothic','8','B','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','','century gothic','9','B','','');
                Yii::$app->reporter->col($smojan ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmojan ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','R','century gothic','9','B','','');
                Yii::$app->reporter->col($smofeb ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmofeb ,'45','','','1px solid ','','C','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smomar ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmomar ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smoapr ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmoapr ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smomay ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmomay ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smojun ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmojun ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smojul ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmojul ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smoaug ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmoaug ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smosep ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmosep ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smooct ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmooct ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smonov ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmonov ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col($smodec ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col($pmodec ,'45','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
                Yii::$app->reporter->col(number_format($totals,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'50','','','1px solid ','','R','century gothic','8','','','');
                Yii::$app->reporter->col(number_format($totalc,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50','','','1px solid ','','R','century gothic','8','','','');

            $totalsmojan += $data[$i]['smo1'];
            $totalsmofeb += $data[$i]['smo2'];
            $totalsmomar += $data[$i]['smo3'];
            $totalsmoapr += $data[$i]['smo4'];
            $totalsmomay += $data[$i]['smo5'];
            $totalsmojun += $data[$i]['smo6'];
            $totalsmojul += $data[$i]['smo7'];
            $totalsmoaug += $data[$i]['smo8'];
            $totalsmosep += $data[$i]['smo9'];
            $totalsmooct += $data[$i]['smo10'];
            $totalsmonov += $data[$i]['smo11'];
            $totalsmodec += $data[$i]['smo12'];
            $grands += $totals;
    		$totalpmojan += $data[$i]['pmo1'];
            $totalpmofeb += $data[$i]['pmo2'];
            $totalpmomar += $data[$i]['pmo3'];
            $totalpmoapr += $data[$i]['pmo4'];
            $totalpmomay += $data[$i]['pmo5'];
            $totalpmojun += $data[$i]['pmo6'];
            $totalpmojul += $data[$i]['pmo7'];
            $totalpmoaug += $data[$i]['pmo8'];
            $totalpmosep += $data[$i]['pmo9'];
            $totalpmooct += $data[$i]['pmo10'];
            $totalpmonov += $data[$i]['pmo11'];
            $totalpmodec += $data[$i]['pmo12'];
    	    $grandc += $totalc;
        }
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '</br>';
    
    Yii::$app->reporter->begintable('1650');
		Yii::$app->reporter->startrow();
		  Yii::$app->reporter->col('','1650','','','1px solid ','T','C','century gothic','8','B','','');        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1650');
        Yii::$app->reporter->startrow();
    		Yii::$app->reporter->col('Grand Total','255','','','1px solid ','T','C','century gothic','8','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmojan,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmofeb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmomar,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmoapr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmomay,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmojun,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmojul,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmoaug,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmosep,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmooct,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmonov,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($totalsmodec,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','45','','','1px solid ','','C','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','','C','century gothic','9','B','','');
            Yii::$app->reporter->col(number_format($grands,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'50','','','1px solid ','','R','century gothic','8','','','');
            Yii::$app->reporter->col('','50','','','1px solid ','','C','century gothic','8','','','');

        Yii::$app->reporter->startrow();
    		Yii::$app->reporter->col('','255','','','1px solid ','B','C','century gothic','8','B','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmojan,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmofeb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmomar,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmoapr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmomay,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmojun,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmojul,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmoaug,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmosep,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmooct,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmonov,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($totalpmodec,Yii::$app->systemsettings->setDecimaldisplay('currency')),'45','','','1px solid ','B','R','century gothic','8','','','');
            Yii::$app->reporter->col('' ,'6','','','1px solid ','B','C','century gothic','9','B','','');
            Yii::$app->reporter->col('','45','','','1px solid ','B','C','century gothic','8','','','');
            Yii::$app->reporter->col(number_format($grandc,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50','','','1px solid ','B','R','century gothic','8','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
?>