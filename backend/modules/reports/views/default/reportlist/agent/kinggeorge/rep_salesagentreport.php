<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Agent Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>


<?php
$count=50;
$page=50;

$agent = "";
Yii::$app->reporter->beginreport('1000');
	Yii::$app->reporter->begintable('1000');
	$header=Yii::$app->reporter->letterhead();
	Yii::$app->reporter->endtable();

	Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Sales Agent Report',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow()
        ;
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->endrow();
	Yii::$app->reporter->endtable();


	Yii::$app->reporter->begintable('1000'); 
	        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');

	        if($params['agent']==''){
	        	Yii::$app->reporter->col('Agent : ALL','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
	        } else {
	        	Yii::$app->reporter->col('Agent :'.$params['agent'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','');
	        }//end if

	        if($params['poststatus'] !=''){
	        	Yii::$app->reporter->col('Status :'. strtoupper($params['poststatus']),'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
	        }//end if
	        
	        Yii::$app->reporter->col('Start : ' . $params['start'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
	        Yii::$app->reporter->col('End : ' . $params['end'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');    	
	        Yii::$app->reporter->pagenumber('Page');
	        Yii::$app->reporter->endrow();
	Yii::$app->reporter->endtable();


	Yii::$app->reporter->printline();
	//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
	Yii::$app->reporter->begintable('1000');
	Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();
    	Yii::$app->reporter->col('AGENT','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DR DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DR #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('KGS','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
    Yii::$app->reporter->endrow();


   $stotal = 0;
   $gtotal = 0;
   foreach ($data as $key => $value) {

	   	if($key == 0){
	    	$agent = $value['agent'];
	    	if($value['agent'] != ""){
	    		Yii::$app->reporter->addline();
	    		Yii::$app->reporter->startrow();
	    			Yii::$app->reporter->col($value['agent'] . ' - ','100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col($value['agentname'],'100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','250',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','TB','R','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			    Yii::$app->reporter->endrow();
	    	}//end if
	    }else{
	    	if($agent != $value['agent']){
	    		$agent = $value['agent'];

	    		Yii::$app->reporter->addline();
	    		Yii::$app->reporter->startrow();
			        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','250',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','T','R','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('SUBTOTAL: ','50',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col(number_format($stotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
			    Yii::$app->reporter->endrow();	
			    
			    $stotal = 0;
			    Yii::$app->reporter->addline();
	    		Yii::$app->reporter->startrow();
	    			Yii::$app->reporter->col($value['agent'] . ' - ','100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col($value['agentname'],'100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','250',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','TB','R','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','50',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			        Yii::$app->reporter->col('','100',null,false,'1px dotted','TB','C','Century Gothic','11','B','30px','8px');
			    Yii::$app->reporter->endrow();
	    	}//end if
	    }//end if

	    Yii::$app->reporter->addline();
	    Yii::$app->reporter->startrow();
	        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
	        Yii::$app->reporter->col($value['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
	        Yii::$app->reporter->col($value['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
	        Yii::$app->reporter->col($value['itemname'],'250',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
	        Yii::$app->reporter->col(number_format($value['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
	        Yii::$app->reporter->col(number_format($value['kgs'],Yii::$app->systemsettings->setDecimaldisplay('kgs')),'50',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
	        Yii::$app->reporter->col(number_format($value['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
	        Yii::$app->reporter->col(number_format($value['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
	    Yii::$app->reporter->endrow();

	    if(Yii::$app->reporter->linecounter==$page){
		    Yii::$app->reporter->endtable();
		    Yii::$app->reporter->page_break();

		   	Yii::$app->reporter->begintable('1000');
			$header=Yii::$app->reporter->letterhead();
			Yii::$app->reporter->endtable();

			Yii::$app->reporter->begintable('1000');
		        Yii::$app->reporter->startrow();
		        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
		        Yii::$app->reporter->col('Sales Agent Report',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
		        Yii::$app->reporter->endrow()
		        ;
		        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
		        Yii::$app->reporter->endrow();
			Yii::$app->reporter->endtable();


			Yii::$app->reporter->begintable('1000'); 
			        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');

			        if($params['agent']==''){
			        	Yii::$app->reporter->col('Agent : ALL','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
			        } else {
			        	Yii::$app->reporter->col('Agent :'.$params['agent'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','');
			        }//end if

			        if($params['poststatus'] !=''){
			        	Yii::$app->reporter->col('Status :'. strtoupper($params['poststatus']),'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
			        }//end if
			        
			        Yii::$app->reporter->col('Start : ' . $params['start'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
			        Yii::$app->reporter->col('End : ' . $params['end'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');    	
			        Yii::$app->reporter->pagenumber('Page');
			        Yii::$app->reporter->endrow();
			Yii::$app->reporter->endtable();


			Yii::$app->reporter->printline();
			//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
			Yii::$app->reporter->begintable('1000');
			Yii::$app->reporter->addline();
		    Yii::$app->reporter->startrow();
		    	Yii::$app->reporter->col('AGENT','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
		        Yii::$app->reporter->col('DR DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
		        Yii::$app->reporter->col('DR #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
		        Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
		        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','R','Century Gothic','11','B','30px','8px');
		        Yii::$app->reporter->col('KGS','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
		        Yii::$app->reporter->col('PRICE','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
		        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
		    Yii::$app->reporter->endrow();
		    Yii::$app->reporter->printline();
        	$page=$page + $count;
		}//end if
		$gtotal += $value['ext'];
   		$stotal += $value['ext'];
   }//end for each

   Yii::$app->reporter->addline();
	Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','250',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted','T','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('SUBTOTAL: ','50',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col(number_format($stotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
    Yii::$app->reporter->endrow();	
	
   Yii::$app->reporter->endtable();
   Yii::$app->reporter->begintable('1000');
   Yii::$app->reporter->addline();
   Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','250',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted','T','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('GRANDTOTAL: ','50',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col(number_format($gtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','C','Century Gothic','11','B','30px','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>