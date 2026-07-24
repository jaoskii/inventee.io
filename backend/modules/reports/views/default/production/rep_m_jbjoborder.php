<?php
//WTODO: [KIM][2019.09.20][JB job order layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Job Order';
//WTODO: [KIM][2019.11.13][updated job order layout]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

$c_index = 0;
for ($i=0; $i < 10; $i++) { 
  $c_index += 1;
  if(isset($data[$i]['name'])){
    $color = $data[$i]['name'];
  }else{
    $color = '';
  }//end if
  $colors[$c_index] = $color;
}


Yii::$app->reporter->beginreport();

  Yii::$app->reporter->begintable('800');
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['username']).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_contact'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER','400',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('(CUSTOMER COPY)','400',null,false,'4px solid ','','R','Century Gothic','12','','','8px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspJO No &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['docno'],'500',null,false,'4px solid ','TLR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp','10',null,false,'4px solid ','TL','C','Century Gothic','12','','','').'<br />';
       Yii::$app->reporter->col($data[0]['trnx_type'],'290',null,false,'4px solid ','TR','L','Century Gothic','20','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspDate&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['dateid'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspPO No&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['yourref'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbspShip : &nbsp&nbsp'.$data[0]['shipto'],'150',null,false,'4px solid ','TL','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','TR','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspCustomer&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['clientname'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspAddress&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['address'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','L','C','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspTel No&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['tel'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','LB','L','Century Gothic','12','B','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    // padalwang box
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp'.$data[0]['barcode'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$data[0]['itemname'],'500',null,false,'4px solid ','TLR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbspP Color :','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','TR','L','Century Gothic','12','','','').'<br />';

    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspPlastic Color&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_plasticcolor'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';


      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[1],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';

      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[6],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';

    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspMaterials&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_combi'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[2],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[7],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspSealing&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_sealing'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[3],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[8],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspOrder Qty&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.number_format($data[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')) . ' - ' . $data[0]['uom'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[4],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[9],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    
    if($data[0]['fg_jolength'] == ''){
      $jolength = 0;
    }else{
      $jolength = number_format($data[0]['fg_jolength'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
    }//end if

    if($data[0]['fg_jowidth'] == ''){
      $jowidth = 0;
    }else{
      $jowidth = number_format($data[0]['fg_jowidth'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
    }//end if

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspSize&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$jowidth.'&nbspX&nbsp'.$jolength.'&nbsp&nbsp'.$data[0]['fg_jowidthuom'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[5],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[10],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspThickness&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_thickness'].'&nbsp&nbsp'.$data[0]['fg_thicknessuom'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbspPrice : &nbsp&nbsp','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspTransformation&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_transform'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp'.number_format($data[0]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('quantity')) . ' / ' .$data[0]['uom'],'150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp&nbsp&nbsp'.$data[0]['pricetype'],'150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','500',null,false,'4px solid ','LRB','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','LB','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','RB','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();

  Yii::$app->reporter->endtable();

  echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Reviewed By : ','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By : ','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Noted By : ','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'180',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($reviewed,'180',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($approved,'180',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($noted,'180',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','180',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','180',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Manager','180',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Finance Manager','180',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
     echo '<br/>';
    
     Yii::$app->reporter->printline();


  //padalwang copy
  Yii::$app->reporter->begintable('800');

  Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['username']).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
    // $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER','400',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('(PRESS COPY)','400',null,false,'4px solid ','','R','Century Gothic','12','','','8px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspJO No &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['docno'],'500',null,false,'4px solid ','TLR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp','10',null,false,'4px solid ','TL','C','Century Gothic','12','','','').'<br />';
       Yii::$app->reporter->col($data[0]['trnx_type'],'290',null,false,'4px solid ','TR','L','Century Gothic','20','b','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspDate&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['dateid'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspPO No&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['yourref'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbspShip : &nbsp&nbsp'.$data[0]['shipto'],'150',null,false,'4px solid ','TL','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','TR','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspCustomer&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['clientname'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspAddress&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['address'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','L','C','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspTel No&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['tel'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','LB','L','Century Gothic','12','B','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    // padalwang box
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp'.$data[0]['barcode'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$data[0]['itemname'],'500',null,false,'4px solid ','TLR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbspP Color :','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','TR','L','Century Gothic','12','','','').'<br />';

    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspPlastic Color&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_plasticcolor'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';


      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[1],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';

      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[6],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';

    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspMaterials&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_combi'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[2],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[7],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspSealing&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_sealing'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[3],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[8],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspOrder Qty&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.number_format($data[0]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')) . ' - ' . $data[0]['uom'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[4],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[9],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();

    if($data[0]['fg_jolength'] == ''){
      $jolength = 0;
    }else{
      $jolength = number_format($data[0]['fg_jolength'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
    }//end if

    if($data[0]['fg_jowidth'] == ''){
      $jowidth = 0;
    }else{
      $jowidth = number_format($data[0]['fg_jowidth'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
    }//end if


    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspSize&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$jowidth.'&nbspX&nbsp'.$jolength.'&nbsp&nbsp'.$data[0]['fg_jolengthuom'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[5],'200',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbsp&nbsp '.$colors[10],'200',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspThickness&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_thickness'].'&nbsp&nbsp'.$data[0]['fg_thicknessuom'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbspTransformation&nbsp&nbsp: &nbsp&nbsp'.$data[0]['fg_transform'],'500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','TL','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','TR','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','500',null,false,'4px solid ','LR','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('&nbspReq Del Date : '.$data[0]['reqdate'],'150',null,false,'4px solid ','L','L','Century Gothic','12','','','').'<br />';
      Yii::$app->reporter->col('','150',null,false,'4px solid ','R','L','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();

  Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->col('NOTES:','50',null,false,'4px solid ','TLB','L','Century Gothic','12','','','15px');
          Yii::$app->reporter->col($data[0]['rem'],'740',null,false,'4px solid ','TB','L','Century Gothic','12','','','15px');
          Yii::$app->reporter->col('','10',null,false,'4px solid ','TRB','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

  echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Approved: ','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($approved,'200',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','240',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Prepared:','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','','L','Century Gothic','12','','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
 
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Manager','200',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','240',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>