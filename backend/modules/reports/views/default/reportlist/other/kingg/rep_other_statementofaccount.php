<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Statement of Accounts';

//WTODO: [JLY][2019.08.23][KINGG CONCERNS][EDIT SOA]
//WTODO: [JLY][2019.08.28][KINGG CONCERNS][EDIT SOA-added BR space before good day]
//WTODO: [JLY][2019.09.6][KINGG CONCERNS][Payment added]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=50;
$page=3;
// $header=Yii::$app->reporter->letterhead();

Yii::$app->reporter->beginreport();

//     Yii::$app->reporter->begintable('800');
// $header=Yii::$app->reporter->letterhead();
// Yii::$app->reporter->endtable();
// echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<br>');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

$customer='';
$customersub='';
$balance=0;
$bal=0;
//$page=1;

for($i=0;$i<count($data);$i++){
    if($customer=='' || ($customer == $data[$i]['clientname'] && $data[$i]['clientname'] != '')){
        if ($customer != $data[$i]['clientname']){
             $customer = $data[$i]['clientname'];

             Yii::$app->reporter->begintable('800');
                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('To : '.$data[$i]['clientname'],'75px',null,false,'1px solid ','LTR','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();

                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('Address: '.$data[$i]['addr'],null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();

                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('Owner : '.$data[$i]['contact'] ,null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();

                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('Contact No. : '.$data[$i]['tel2'] ,null,null,false,'1px solid ','LRB','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();

             Yii::$app->reporter->endtable();
             echo "<br>";

             Yii::$app->reporter->begintable('800');
                Yii::$app->reporter->startrow();
                     Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                 Yii::$app->reporter->endrow();
                 Yii::$app->reporter->startrow();
                     Yii::$app->reporter->col('Good Day!',null,null,false,'2px solid ','','L','Courier New','12','B');
                 Yii::$app->reporter->startrow();
                     Yii::$app->reporter->col('The current balance of your account is shown below:',null,null,false,'2px solid ','','L','Courier New','12','B');
                 Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('<div style="margin-top:10px;">Statement Date: as of '. date('M-d-Y', strtotime($params['asof'])).'</div>',null,null,false,'1px solid ','','L','Helvetica','14','B');
                 Yii::$app->reporter->startrow();
                     Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                 Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();


             Yii::$app->reporter->begintable('800');
                 // Yii::$app->reporter->startrow();
                 //       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                 //       Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Helvetica','11','B');
                 //       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                 //       Yii::$app->reporter->col('APPLIED','150',null,false,'1px solid ','','C','Helvetica','11','B');
                 //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                 //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                 //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                 // Yii::$app->reporter->endrow();

                 Yii::$app->reporter->startrow();
                       Yii::$app->reporter->col('DR DATE','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                       Yii::$app->reporter->col('DR #','150',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                       Yii::$app->reporter->col('PARTICULARS','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                       Yii::$app->reporter->col('DR AMOUNT','150',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                       Yii::$app->reporter->col('CRR','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                       Yii::$app->reporter->col('PAYMENT','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                       Yii::$app->reporter->col('REMAINING','100',null,false,'1px solid ','TLRB','C','Helvetica','11','B');
                 Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();

             Yii::$app->reporter->begintable('800');
                 Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                        Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['itemname'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                        if($data[$i]['dramt']==0){
                            if($data[$i]['debit']==0){
                                Yii::$app->reporter->col('-','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                            }else{
                                Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');    
                            }
                            
                        }else{
                            Yii::$app->reporter->col(number_format($data[$i]['dramt'],2),'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        }

                        if($data[$i]['crr']==0){
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col(number_format($data[$i]['crr'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }
                        if($data[$i]['dramt']==0){
                            $bal=$data[$i]['balance'];
                        }else{
                            // $bal=$data[$i]['dramt']-$data[$i]['crr'];
                            $bal=$data[$i]['dramt']-($data[$i]['crr']+($data[$i]['debit']-$data[$i]['balance']));
                        }

                        

                        // if($data[$i]['credit']==0){
                            $payment=$data[$i]['debit']-$data[$i]['balance'];
                                        Yii::$app->reporter->col(number_format($payment,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                            // Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        // }else{
                            // Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        // }

                        Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        
                        // if($data[$i]['debit']!=0){
                        $balance = $balance + $bal;
                        // }else{$balance = $balance - $data[$i]['balance'];}    
                        

                 Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();


        }elseif($customer == $data[$i]['clientname']){
            $customer = $data[$i]['clientname'];
             Yii::$app->reporter->begintable('800');
                 Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                        Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['itemname'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                        
                        if($data[$i]['dramt']==0){
                            if($data[$i]['debit']==0){
                                Yii::$app->reporter->col('-','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                            }else{
                                Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');    
                            }
                            
                        }

                        if($data[$i]['crr']==0){
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col(number_format($data[$i]['crr'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }


                        if($data[$i]['dramt']==0){
                            $bal=$data[$i]['balance'];
                        }else{
                            // $bal=$data[$i]['dramt']-$data[$i]['crr'];
                            $bal=$data[$i]['dramt']-($data[$i]['crr']+($data[$i]['debit']-$data[$i]['balance']));
                        }
                        // if($data[$i]['credit']==0){
                            // Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        $payment=$data[$i]['debit']-$data[$i]['balance'];
                                        Yii::$app->reporter->col(number_format($payment,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        // }else{
                            // Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        // }

                        Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');

                        // if($data[$i]['dramt']!=0){
                          $balance = $balance + $bal;
                        // }else{$balance = $balance - $data[$i]['balance'];}    
                       

                 Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();

        }else{
                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();
        }
    }else{

            $customer = $data[$i]['clientname'];

             if (($customersub != '' && $customersub != $customer) && $balance != 0) {
                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','1','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('TOTAL DUE : ',null,null,false,'1px dotted ','','R','Helvetica','11','B','','');
                              Yii::$app->reporter->col(number_format($balance,2),null,null,false,'1.5px solid ','','R','Helvetica','11','B','','');

                              $customersub = $data[$i]['clientname'];
                              $balance=0;
                              $bal=0;
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                     Yii::$app->reporter->startrow();
                         Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                     Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();
                 
                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('Please settle your Outstanding balance immediately.',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Your Prompt action on this matter is highly appreciated.',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();


                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Thank you!',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();


                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();


                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Sincerely,',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();


                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();


                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        
                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col($params['certified'],'200',null,false,'1px solid ','B','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Credit and Collection Staff','200',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('<br>','200',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();
                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col($params['attention'],'200',null,false,'1px solid ','B','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Received by:','200',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 // Yii::$app->reporter->begintable('800');
                 //        Yii::$app->reporter->startrow();
                 //        Yii::$app->reporter->col('CERTIFIED CORRECT:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('RECEIVED BY:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->endrow();
                 // Yii::$app->reporter->endtable();
                 
                 // Yii::$app->reporter->begintable('800');
                 //        Yii::$app->reporter->startrow();
                 //        Yii::$app->reporter->col('<br>'.$params['certified'],null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->endrow();
                 // Yii::$app->reporter->endtable();
                 

                 // Yii::$app->reporter->begintable('800');
                 //        Yii::$app->reporter->startrow();
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->endrow();
                 // Yii::$app->reporter->endtable();

                 // Yii::$app->reporter->begintable('800');
                 //        Yii::$app->reporter->startrow();
                 //        Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Helvetica','12','','B','');
                 //        Yii::$app->reporter->endrow();
                 // Yii::$app->reporter->endtable();

             }


            Yii::$app->reporter->begintable('800');
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('<br>');
                    Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();

            Yii::$app->reporter->addline();

            if(Yii::$app->reporter->linecounter==$page){
//                Yii::$app->reporter->endtable();
                Yii::$app->reporter->page_break();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
                        Yii::$app->reporter->begintable('800');
                              Yii::$app->reporter->startrow();
                              Yii::$app->reporter->col('<br>');
                              Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('800');
                        $header=Yii::$app->reporter->letterhead();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('');
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();


                        Yii::$app->reporter->begintable('800');
                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('To : '.$data[$i]['clientname'],'75px',null,false,'1px solid ','LTR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('Address: '.$data[$i]['addr'],null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('Owner : '.$data[$i]['contact'] ,null,null,false,'1px solid ','LR','L','Helvetica','12','B');

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('Contact No. : '.$data[$i]['tel2'] ,null,null,false,'1px solid ','LRB','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         
                         Yii::$app->reporter->begintable('800');
                            Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->endrow();
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('Good Day!',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('The current balance of your account is shown below:',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('Statement Date: as of '. date('M-d-Y', strtotime($params['asof'])),null,null,false,'1px solid ','','L','Courier New','14','B');
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             // Yii::$app->reporter->startrow();
                             //       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('APPLIED','150',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             // Yii::$app->reporter->endrow();

                             Yii::$app->reporter->startrow();
                                   Yii::$app->reporter->col('DR DATE','','100',false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DR #','150',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('PARTICULARS','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DR AMOUNT','150',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('CRR','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('PAYMENT','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('REMAINING','100',null,false,'1px solid ','TLRB','C','Helvetica','11','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                                    Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['itemname'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                                    if($data[$i]['dramt']==0){
                                        if($data[$i]['debit']==0){
                                            Yii::$app->reporter->col('-','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                        }else{
                                            Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');    
                                        }
                                        
                                    }

                                    if($data[$i]['crr']==0){
                                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col(number_format($data[$i]['crr'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }


                                    if($data[$i]['dramt']==0){
                                        $bal=$data[$i]['balance'];
                                    }else{
                                        // $bal=$data[$i]['dramt']-$data[$i]['crr'];
                                        $bal=$data[$i]['dramt']-($data[$i]['crr']+($data[$i]['debit']-$data[$i]['balance']));
                                    }
                                    // if($data[$i]['credit']==0){
                                        $payment=$data[$i]['debit']-$data[$i]['balance'];
                                        Yii::$app->reporter->col(number_format($payment,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    // }else{
                                        // Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    // }

                                    Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');

                                    // if($data[$i]['debit']!=0){
                                    $balance = $balance + $bal;
                                    // }else{$balance = $balance - $data[$i]['balance'];}    

                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

             $page=$page + $count;
             }else{

                Yii::$app->reporter->page_break();  

                        Yii::$app->reporter->begintable('800');
                              Yii::$app->reporter->startrow();
                              Yii::$app->reporter->col('<br>');
                              Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('800');
                        $header=Yii::$app->reporter->letterhead();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('');
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();


                        Yii::$app->reporter->begintable('800');
                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('To : '.$data[$i]['clientname'],'75px',null,false,'1px solid ','LTR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('Address: '.$data[$i]['addr'],null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('Owner : '.$data[$i]['contact'] ,null,null,false,'1px solid ','LR','L','Helvetica','12','B');

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('Contact No. : '.$data[$i]['tel2'] ,null,null,false,'1px solid ','LRB','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         
                         Yii::$app->reporter->begintable('800');
                            Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->endrow();
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('Good Day!',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('The current balance of your account is shown below:',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('Statement Date: as of '. date('M-d-Y', strtotime($params['asof'])),null,null,false,'1px solid ','','L','Courier New','14','B');
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             // Yii::$app->reporter->startrow();
                             //       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('APPLIED','150',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             //       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             // Yii::$app->reporter->endrow();

                             Yii::$app->reporter->startrow();
                                   Yii::$app->reporter->col('DR DATE','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DR #','150',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('PARTICULARS','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DR AMOUNT','150',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('CRR','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('PAYMENT','100',null,false,'1px solid ','TLB','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('REMAINING','100',null,false,'1px solid ','TLRB','C','Helvetica','11','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                                    Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['itemname'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                                    if($data[$i]['dramt']==0){
                                        if($data[$i]['debit']==0){
                                            Yii::$app->reporter->col('-','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                        }else{
                                            Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');    
                                        }
                                        
                                    }

                                    if($data[$i]['crr']==0){
                                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col(number_format($data[$i]['crr'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }


                                    if($data[$i]['dramt']==0){
                                        $bal=$data[$i]['balance'];
                                    }else{
                                        $bal=$data[$i]['dramt']-($data[$i]['crr']+($data[$i]['debit']-$data[$i]['balance']));
                                    }
                                    // if($data[$i]['credit']==0){
                                        $payment=$data[$i]['debit']-$data[$i]['balance'];
                                        Yii::$app->reporter->col(number_format($payment,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                        // Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    // }else{
                                        // Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    // }

                                    Yii::$app->reporter->col(number_format($bal,2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');

                                    // if($data[$i]['debit']!=0){
                                    $balance = $balance + $bal;
                                    // }else{$balance = $balance - $data[$i]['balance'];}    

                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

             $page=$page + $count;
             
             }

//            Yii::$app->reporter->begintable();
        
    }

             if ($customersub == ''){
                    $customersub = $data[$i]['clientname'];
             }
}

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','1','','','');
                              Yii::$app->reporter->col('<br>',null,null,false,'1px dotted ','','L','Helvetica','11','','','');
                              Yii::$app->reporter->col('TOTAL DUE : ',null,null,false,'1px dotted ','','R','Helvetica','11','B','','');
                              Yii::$app->reporter->col(number_format($balance,2),null,null,false,'1.5px solid ','','R','Helvetica','11','B','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                     Yii::$app->reporter->startrow();
                         Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                     Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('Please settle your Outstanding balance immediately.',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Your Prompt action on this matter is highly appreciated.',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();


                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Thank you!',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();


                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Sincerely,',null,null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();


                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();


                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        
                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col($params['certified'],'200',null,false,'1px solid ','B','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Credit and Collection Staff','200',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('<br>','200',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();
                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col($params['attention'],'200',null,false,'1px solid ','B','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('Received by:','200',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->col('&nbsp','600',null,false,'1px solid ','','L','Helvetica','11','','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 // Yii::$app->reporter->begintable('800');
                 //        Yii::$app->reporter->startrow();
                 //        Yii::$app->reporter->col('CERTIFIED CORRECT:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('RECEIVED BY:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->endrow();
                 // Yii::$app->reporter->endtable();
                 
                 // Yii::$app->reporter->begintable('800');
                 //        Yii::$app->reporter->startrow();
                 //        Yii::$app->reporter->col('<br>'.$params['certified'],null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->endrow();
                 // Yii::$app->reporter->endtable();

                 // Yii::$app->reporter->begintable('800');
                 //        Yii::$app->reporter->startrow();
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                 //        Yii::$app->reporter->endrow();
                 // Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();
//var_dump($params);
//var_dump($data);




?>
