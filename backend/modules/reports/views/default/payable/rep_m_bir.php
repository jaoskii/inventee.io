<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'BIR Form 2307';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;

$birlogo = Yii::$app->homeURl . 'fimages/reports/BIRlogo.png';


Yii::$app->reporter->beginreport();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

  //1st row


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();    
      Yii::$app->reporter->col('<img src ="'.$birlogo.'" alt="BIR" width="80px" height ="80px">','95',null,false,'2px solid ','LTB','C','Century Gothic','15','B','','8px');
      Yii::$app->reporter->col('Republika ng Pilipinas Kagawaran ng Pananalapi','90',null,false,'2px solid ','TB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','55',null,false,'2px solid ','TB','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Certificate of Creditable Tax Withheld At Source','350',null,false,'2px solid ','TB','C','Century Gothic','20','B','','');
      
      Yii::$app->reporter->col('','55',null,false,'2px solid ','TB','L','Century Gothic','11','B','','');
      
      Yii::$app->reporter->col('BIR Form No. <h4><b> 2307 </b></h4> September 2005 (ENCS)','135',null,false,'2px solid ','TB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','20',null,false,'2px solid ','RTB','L','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //2nd row blank
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','125',null,false,'2px solid ','LT','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','180',null,false,'2px solid ','T','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','300',null,false,'2px solid','T','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','195',null,false,'2px solid ','RT','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //3rd row -> 1 for the period
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('1','40',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('For the Period','120',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','70',null,false,'2px solid','','C','Century Gothic','20','','','');

      // var_dump($data['head'][0]['month']);
      // return 0;

      switch ($data['head'][0]['month']) {
        case '1': case '2': case '3':
          Yii::$app->reporter->col('01','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('01','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('','270',null,false,'2px solid','LR','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('03','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('31','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          break;

        case '4': case '5': case '6':
          Yii::$app->reporter->col('04','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('01','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('','270',null,false,'2px solid','LR','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('06','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('30','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          break;

        case '7': case '8': case '9':
          Yii::$app->reporter->col('07','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('01','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('','270',null,false,'2px solid','LR','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('09','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('30','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          break;
        
        default:
          Yii::$app->reporter->col('10','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('01','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('','270',null,false,'2px solid','LR','C','Century Gothic','14','','','8px');

          Yii::$app->reporter->col('12','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('31','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          Yii::$app->reporter->col('18','10',null,false,'2px solid','LRTB','C','Century Gothic','14','','','8px');
          break;
      }


      

      Yii::$app->reporter->col('','340',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //4th row -> from
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','20',null,false,'2px solid ','LB','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('From','90',null,false,'2px solid ','B','R','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','60',null,false,'2px solid','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','B','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','B','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('(MM/DD/YY)','140',null,false,'2px solid','B','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('To','120',null,false,'2px solid ','B','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('','0',null,false,'2px solid ','B','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','100',null,false,'2px solid ','B','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('(MM/DD/YY)','240',null,false,'2px solid','RB','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //5th row -> part 1
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Part I','50',null,false,'2px solid ','TLB','C','Century Gothic','12','B','','3px');
      Yii::$app->reporter->col('Payee Information','750',null,false,'2px solid ','TRB','C','Century Gothic','12','B','','3px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //6th row -> blank 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','125',null,false,'2px solid ','LT','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','180',null,false,'2px solid ','T','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','300',null,false,'2px solid','T','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','195',null,false,'2px solid ','RT','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //7th row -> 2 tax payer
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('2','30',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Tax Payer','100',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','50',null,false,'2px solid','','C','Century Gothic','20','','','15px');

      Yii::$app->reporter->col((isset($data['head'][0]['tin'])? $data['head'][0]['tin']:''),'250',null,false,'2px solid','LRTB','C','Century Gothic','20','','','15px');
     
      Yii::$app->reporter->col('','370',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //8th row -> 2 identification
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Identification Number','150',null,false,'2px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid','','C','Century Gothic','20','','','3px');
      Yii::$app->reporter->col('','630',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //9th row -> 3 payees name
   Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('3','30',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col("Payee's Name" ,'100',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','50',null,false,'2px solid','','C','Century Gothic','20','','','15px');

      Yii::$app->reporter->col((isset($data['head'][0]['payee'])? $data['head'][0]['payee']:''),'610',null,false,'2px solid','LRTB','L','Century Gothic','12','B','','3px');
     
      Yii::$app->reporter->col('','10',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //10th row -> registered name
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','90',null,false,'2px solid ','L','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','30',null,false,'2px solid','','C','Century Gothic','20','','','10px');

      Yii::$app->reporter->col('(Last Name, First Name, Middle Name for Individuals)(Registered Name for Non-Individuals)','560',null,false,'2px solid','','C','Century Gothic','11','','','');
     
      Yii::$app->reporter->col('','40',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //11th row -> 4 registered address
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('4','30',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Registered Address' ,'125',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','0',null,false,'2px solid','','C','Century Gothic','20','','','15px');

      Yii::$app->reporter->col((isset($data['head'][0]['address'])? $data['head'][0]['address']:''),'380',null,false,'2px solid','LRTB','L','Century Gothic','12','B','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','20','','','15px');
      Yii::$app->reporter->col('4A','5',null,false,'2px solid ','','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Zip Code','90',null,false,'2px solid ','R','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','145',null,false,'2px solid ','LRTB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //12th row -> blank 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','125',null,false,'2px solid ','L','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','180',null,false,'2px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','300',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','195',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //13th row -> 4 foreign address
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('5','30',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Foreign Address' ,'127',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','0',null,false,'2px solid','','C','Century Gothic','20','','','15px');

      Yii::$app->reporter->col('','380',null,false,'2px solid','LRTB','C','Century Gothic','20','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','20','','','15px');
      Yii::$app->reporter->col('5A','5',null,false,'2px solid ','','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Zip Code','90',null,false,'2px solid ','R','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','145',null,false,'2px solid ','LRTB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //14th row -> blank 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','125',null,false,'2px solid ','LB','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','180',null,false,'2px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','300',null,false,'2px solid','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','195',null,false,'2px solid ','RB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //15th row -> blank 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','50',null,false,'2px solid ','TLB','C','Century Gothic','12','B','','3px');
      Yii::$app->reporter->col('Payor Information','750',null,false,'2px solid ','TRB','C','Century Gothic','12','B','','3px');
      
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //16th row -> blank 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','125',null,false,'2px solid ','LT','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','180',null,false,'2px solid ','T','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','300',null,false,'2px solid','T','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','195',null,false,'2px solid ','RT','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //17th row -> 6 tax payer
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('6','30',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Tax Payer','100',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','50',null,false,'2px solid','','C','Century Gothic','20','','','15px');

      Yii::$app->reporter->col('','250',null,false,'2px solid','LRTB','C','Century Gothic','20','','','15px');
     
      Yii::$app->reporter->col('','370',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


  //18th row ->  identification
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Identification Number','150',null,false,'2px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid','','C','Century Gothic','20','','','3px');
      Yii::$app->reporter->col('','630',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //19th row -> 7 payors name
   Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('7','30',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col("Payor's Name" ,'100',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','50',null,false,'2px solid','','C','Century Gothic','20','','','15px');

      Yii::$app->reporter->col('','610',null,false,'2px solid','LRTB','C','Century Gothic','20','','','15px');
     
      Yii::$app->reporter->col('','10',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //20th row -> registered name
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','90',null,false,'2px solid ','L','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','30',null,false,'2px solid','','C','Century Gothic','20','','','10px');

      Yii::$app->reporter->col('(Last Name, First Name, Middle Name for Individuals)(Registered Name for Non-Individuals)','560',null,false,'2px solid','','C','Century Gothic','11','','','');
     
      Yii::$app->reporter->col('','40',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //21th row -> 8 registered address
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('8','30',null,false,'2px solid ','L','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Registered Address' ,'127',null,false,'2px solid ','','L','Century Gothic','11','','','');

      Yii::$app->reporter->col('','0',null,false,'2px solid','','C','Century Gothic','20','','','15px');

      Yii::$app->reporter->col('','380',null,false,'2px solid','LRTB','C','Century Gothic','20','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','20','','','15px');
      Yii::$app->reporter->col('8A','5',null,false,'2px solid ','','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col('Zip Code','90',null,false,'2px solid ','R','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','145',null,false,'2px solid ','LRTB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //22th row -> blank 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','125',null,false,'2px solid ','LB','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','180',null,false,'2px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','300',null,false,'2px solid','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','195',null,false,'2px solid ','RB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //23th row -> part II
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Part II','50',null,false,'2px solid ','TLB','C','Century Gothic','12','B','','3px');
      Yii::$app->reporter->col('Details of Monthly Income Payments and Tax Withheld for the Quarter','750',null,false,'2px solid ','TRB','C','Century Gothic','12','B','','3px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //24th row -> income payments 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRT','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRT','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('AMOUNT OF INCOME PAYMENTS','380',null,false,'2px solid','LRTB','C','Century Gothic','11','B','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRT','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //25th row -> month header
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Income Payments Subject to Expanded Withholding Tax','200',null,false,'2px solid ','LR','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('ATC','80',null,false,'2px solid ','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('1st Month of the Quarter','95',null,false,'2px solid','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('2nd Month of the Quarter','95',null,false,'2px solid ','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('3rd Month of the Quarter','95',null,false,'2px solid ','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Total','95',null,false,'2px solid','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Tax Withheld For the Quarter','140',null,false,'2px solid ','LR','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //26th row -> blank 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LR','C','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LR','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LR','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LR','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LR','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  //27th row -> line
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      
      Yii::$app->reporter->col('','800',null,false,'2px solid ','LTRB','C','Century Gothic','12','B','','1px');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


  //28th row -> atc1
 Yii::$app->reporter->begintable('800');
  
  $total =0;

      foreach ($data['detail'] as $key => $value) 
      {
       


        Yii::$app->reporter->startrow();



          Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','15px');
          Yii::$app->reporter->col($key,'80',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');

          // var_dump($data['head'][0]['month']);
          // return 0;
          switch ($data['head'][0]['month']) 
          {
            case '1': case '2': case '3':
              Yii::$app->reporter->col(number_format($data['detail'][$key]['oamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'95',null,false,'2px solid','LRB','R','Century Gothic','11','','','');
              Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','R','Century Gothic','11','','','');
              Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','R','Century Gothic','11','','','');
               
              break;
            case '4': case '5': case '6':
              Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','R','Century Gothic','11','','','');
              Yii::$app->reporter->col(number_format($data['detail'][$key]['oamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'95',null,false,'2px solid ','LRB','R','Century Gothic','11','','','');
              Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','R','Century Gothic','11','','','');
              
              break;
            default:
              Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','R','Century Gothic','11','','','');
              Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','R','Century Gothic','11','','','');
              Yii::$app->reporter->col(number_format($data['detail'][$key]['oamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'95',null,false,'2px solid ','LRB','R','Century Gothic','11','','','');
              
              break;
           
          }
          $total=number_format($data['detail'][$key]['oamt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
          Yii::$app->reporter->col($total,'95',null,false,'2px solid','LRB','R','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data['detail'][$key]['xamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'140',null,false,'2px solid ','LRB','R','Century Gothic','11','','','');
          

      }
Yii::$app->reporter->endrow();
      Yii::$app->reporter->endtable();

  
  //29th row -> total
  Yii::$app->reporter->begintable('800');
    $totaltax =0;

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Total','200',null,false,'2px solid ','LR','L','Century Gothic','11','B','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LR','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LR','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LR','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LR','R','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LR','R','Century Gothic','11','','','');
      
      foreach ($data['detail'] as $key => $value) {
        
        $totaltax =$totaltax + $data['detail'][$key]['xamt'];
        }  
      
      Yii::$app->reporter->col(number_format($totaltax,Yii::$app->systemsettings->setDecimaldisplay('currency')),'140',null,false,'2px solid ','LR','R','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //30th row -> space for total 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','B','','15px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //31th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Money Payments Subjects to Withholding of Business Tax (Government & Private)','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','3px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //32th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //32th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //32th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //32th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //32th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //32th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','200',null,false,'2px solid ','LRB','L','Century Gothic','11','','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //32th row -> money payments row
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Total','200',null,false,'2px solid ','LRB','L','Century Gothic','11','B','','10px');
      Yii::$app->reporter->col('','80',null,false,'2px solid ','LRB','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','95',null,false,'2px solid','LRB','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','140',null,false,'2px solid ','LRB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //33th row -> declaration
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('We declare, under the penalties of perjury, that this certificate has been made in good faith, verified by me, and to the best of my knowledge and belief, is true and correct, pursuant to the provisions of the National Internal Revenue Code, as amended, and the regulations issued under authority thereof.','800',null,false,'2px solid ','LRT','L','Century Gothic','11','','','10px');
     
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //34th row -> space after declaration
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','800',null,false,'2px solid ','LR','L','Century Gothic','11','B','','10px');
      
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //35th row -> signature line 1
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col($approved,'395',null,false,'2px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','B','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //35th row -> signature line 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //36th row -> authorized signature
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col("Payor/Payor's Authorized Representative/Accredited Tax Agent",'395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('TIN of Signatory','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Title/Position of Signatory','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //37th row -> authorized signature 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col("(Signature Over Printed Name)",'395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

 //38th row -> blank space after authorized signature 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','10px');
      Yii::$app->reporter->col("",'395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


  //39th row -> signature line 1
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','B','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //40th row -> signature line 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //41th row -> authorized signature
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col("Tax Agent Accreditation No./Attorney Roll No. (if applicable)",'395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Date of Issuance','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Date of Expiry','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  //42th row -> blank space after authorized signature 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','LB','L','Century Gothic','11','B','','5px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','B','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','RB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //43th row -> space after declaration
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Conforme','800',null,false,'2px solid ','LRT','L','Century Gothic','11','B','','3px');
      
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //44th row -> space after declaration
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','800',null,false,'2px solid ','LR','L','Century Gothic','11','B','','10px');
      
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //45th row -> signature line 1
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','120',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','140',null,false,'2px solid','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','85',null,false,'2px solid','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //45th row -> signature line 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','120',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','140',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','85',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //46th row -> authorized signature
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col("Payee/Payee's Authorized Representative/Accredited Tax Agent",'395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('TIN of Signatory','120',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','10',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Title/Position of Signatory','140',null,false,'2px solid','','C','Century Gothic','11','','','');
       Yii::$app->reporter->col('','10',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Date Signed','85',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //47th row -> authorized signature 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col("(Signature Over Printed Name)",'395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

 //48th row -> blank space after authorized signature 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','10px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


  //49th row -> signature line 1
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','B','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','B','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //50th row -> signature line 2
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','3px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  //51th row -> authorized signature
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','L','L','Century Gothic','11','B','','');
      Yii::$app->reporter->col("Tax Agent Accreditation No./Attorney Roll No. (if applicable)",'395',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Date of Issuance','175',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('Date of Expiry','175',null,false,'2px solid','','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','R','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  //52th row -> blank space after authorized signature 
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','10',null,false,'2px solid ','LB','L','Century Gothic','11','B','','10px');
      Yii::$app->reporter->col('','395',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','15',null,false,'2px solid ','B','C','Century Gothic','11','','','');
      Yii::$app->reporter->col('','175',null,false,'2px solid','B','C','Century Gothic','11','','','');
    
      Yii::$app->reporter->col('','15',null,false,'2px solid ','RB','C','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();




        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);
?>