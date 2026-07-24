<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Statement of Accounts';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=50;
$page=3;
// $header=Yii::$app->reporter->letterhead();

Yii::$app->reporter->beginreport();

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
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('STATEMENT OF ACCOUNTS',null,null,false,'1px solid ','','C','Courier New','17','B');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('For the Period Ending '. date('M-d-Y', strtotime($params['asof'])),null,null,false,'1px solid ','','C','Courier New','14','B');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

$customer='';
$customersub='';
$balance=0;
//$page=1;

for($i=0;$i<count($data);$i++){
    if($customer=='' || ($customer == $data[$i]['clientname'] && $data[$i]['clientname'] != '')){
        if ($customer != $data[$i]['clientname']){
             $customer = $data[$i]['clientname'];

             Yii::$app->reporter->begintable('800');
                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('CUSTOMER : '.$data[$i]['clientname'],'75px',null,false,'1px solid ','LTR','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();

                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('ADDRESS    : '.$data[$i]['addr'],null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();

                   Yii::$app->reporter->startrow();
                   Yii::$app->reporter->col('ATTENTION : '.$params['attention'],null,null,false,'1px solid ','LRB','L','Helvetica','12','B');
                   Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();

             Yii::$app->reporter->begintable('800');
                 Yii::$app->reporter->startrow();
                     Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','B','L','Courier New','12','B');
                 Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();

             Yii::$app->reporter->begintable('800');
                 Yii::$app->reporter->startrow();
                       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                       Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Helvetica','11','B');
                       Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                       Yii::$app->reporter->col('APPLIED','150',null,false,'1px solid ','','C','Helvetica','11','B');
                       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                       Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                 Yii::$app->reporter->endrow();

                 Yii::$app->reporter->startrow();
                       Yii::$app->reporter->col('DATE','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                       Yii::$app->reporter->col('TRANSACTION','150',null,false,'1px dotted ','B','C','Helvetica','11','B');
                       Yii::$app->reporter->col('NO.','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                       Yii::$app->reporter->col('TO','150',null,false,'1px dotted ','B','C','Helvetica','11','B');
                       Yii::$app->reporter->col('DEBIT','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                       Yii::$app->reporter->col('CREDIT','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                       Yii::$app->reporter->col('BALANCE DUE','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                 Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();

             Yii::$app->reporter->begintable('800');
                 Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                        Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['trcode'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['refno'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                        if($data[$i]['applied']==0){
                            Yii::$app->reporter->col('None','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col($data[$i]['applied'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        }

                        if($data[$i]['debit']==0){
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }


                        if($data[$i]['credit']==0){
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }

                        Yii::$app->reporter->col(number_format($data[$i]['balance'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        
                        if($data[$i]['debit']!=0){
                          $balance = $balance + $data[$i]['balance'];
                        }else{$balance = $balance - $data[$i]['balance'];}    
                        

                 Yii::$app->reporter->endrow();
             Yii::$app->reporter->endtable();


        }elseif($customer == $data[$i]['clientname']){
            $customer = $data[$i]['clientname'];
             Yii::$app->reporter->begintable('800');
                 Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                        Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['trcode'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        Yii::$app->reporter->col($data[$i]['refno'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                        if($data[$i]['applied']==0){
                            Yii::$app->reporter->col('None','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col($data[$i]['applied'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                        }

                        if($data[$i]['debit']==0){
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }


                        if($data[$i]['credit']==0){
                            Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }else{
                            Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                        }

                        Yii::$app->reporter->col(number_format($data[$i]['balance'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');

                        if($data[$i]['debit']!=0){
                          $balance = $balance + $data[$i]['balance'];
                        }else{$balance = $balance - $data[$i]['balance'];}    
                       

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
                              Yii::$app->reporter->col(number_format($balance,2),null,null,false,'1.5px solid ','T','R','Helvetica','11','B','','');

                              $customersub = $data[$i]['clientname'];
                              $balance=0;
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                     Yii::$app->reporter->startrow();
                         Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                     Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();
                 
                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('PLEASE DISREGARD STATEMENT',null,null,false,'1px solid ','LTR','C','Helvetica','12','B','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('IF ALREADY PAID',null,null,false,'1px solid ','LRB','C','Helvetica','12','B','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('Important: This statement is presumed correct unless otherwise notified within fifteen (15) days of receipt',null,'50px',false,'1px solid ','LR','C','Helvetica','12','BI','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','LRB','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Helvetica','12','','B','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('CERTIFIED CORRECT:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('RECEIVED BY:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();
                 
                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('<br>'.$params['certified'],null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();
                 

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Helvetica','12','','B','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

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
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('STATEMENT OF ACCOUNTS',null,null,false,'1px solid ','','C','Courier New','17','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('800');
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('For the Period Ending '. date('M-d-Y', strtotime($params['asof'])),null,null,false,'1px solid ','','C','Courier New','14','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('');
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();


                        Yii::$app->reporter->begintable('800');
                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('CUSTOMER : '.$data[$i]['clientname'],'75px',null,false,'1px solid ','LTR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('ADDRESS    : '.$data[$i]['addr'],null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('ATTENTION : '.$params['attention'],null,null,false,'1px solid ','LRB','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','B','L','Courier New','12','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                   Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('APPLIED','150',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             Yii::$app->reporter->endrow();

                             Yii::$app->reporter->startrow();
                                   Yii::$app->reporter->col('DATE','','100',false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('TRANSACTION','150',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('NO.','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('TO','150',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DEBIT','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('CREDIT','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('BALANCE DUE','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                                    Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['trcode'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['refno'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                                    if($data[$i]['applied']==0){
                                        Yii::$app->reporter->col('None','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col($data[$i]['applied'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    }

                                    if($data[$i]['debit']==0){
                                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }


                                    if($data[$i]['credit']==0){
                                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }

                                    Yii::$app->reporter->col(number_format($data[$i]['balance'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');

                                    if($data[$i]['debit']!=0){
                                      $balance = $balance + $data[$i]['balance'];
                                    }else{$balance = $balance - $data[$i]['balance'];}    

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
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('STATEMENT OF ACCOUNTS',null,null,false,'1px solid ','','C','Courier New','17','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('800');
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('For the Period Ending '. date('M-d-Y', strtotime($params['asof'])),null,null,false,'1px solid ','','C','Courier New','14','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();

                        Yii::$app->reporter->begintable('');
                                Yii::$app->reporter->startrow();
                                Yii::$app->reporter->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
                                Yii::$app->reporter->endrow();
                        Yii::$app->reporter->endtable();


                        Yii::$app->reporter->begintable('800');
                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('CUSTOMER : '.$data[$i]['clientname'],'75px',null,false,'1px solid ','LTR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('ADDRESS    : '.$data[$i]['addr'],null,null,false,'1px solid ','LR','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();

                               Yii::$app->reporter->startrow();
                               Yii::$app->reporter->col('ATTENTION : '.$params['attention'],null,null,false,'1px solid ','LRB','L','Helvetica','12','B');
                               Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                 Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','B','L','Courier New','12','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                   Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DOCUMENT','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('APPLIED','150',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('<br>','100',null,false,'1px solid ','','C','Helvetica','11','B');
                             Yii::$app->reporter->endrow();

                             Yii::$app->reporter->startrow();
                                   Yii::$app->reporter->col('DATE','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('TRANSACTION','150',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('NO.','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('TO','150',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('DEBIT','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('CREDIT','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                                   Yii::$app->reporter->col('BALANCE DUE','100',null,false,'1px dotted ','B','C','Helvetica','11','B');
                             Yii::$app->reporter->endrow();
                         Yii::$app->reporter->endtable();

                         Yii::$app->reporter->begintable('800');
                             Yii::$app->reporter->startrow();
                                //($txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                                    Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['trcode'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    Yii::$app->reporter->col($data[$i]['refno'],'100',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');

                                    if($data[$i]['applied']==0){
                                        Yii::$app->reporter->col('None','150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col($data[$i]['applied'],'150',null,false,'1px solid ','LTRB','C','Helvetica','11','','','');
                                    }

                                    if($data[$i]['debit']==0){
                                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col(number_format($data[$i]['debit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }


                                    if($data[$i]['credit']==0){
                                        Yii::$app->reporter->col('-','100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }else{
                                        Yii::$app->reporter->col(number_format($data[$i]['credit'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');
                                    }

                                    Yii::$app->reporter->col(number_format($data[$i]['balance'],2),'100',null,false,'1px solid ','LTRB','R','Helvetica','11','','','');

                                    if($data[$i]['debit']!=0){
                                      $balance = $balance + $data[$i]['balance'];
                                    }else{$balance = $balance - $data[$i]['balance'];}    

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
                              Yii::$app->reporter->col(number_format($balance,2),null,null,false,'1.5px solid ','T','R','Helvetica','11','B','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                     Yii::$app->reporter->startrow();
                         Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Courier New','12','B');
                     Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('PLEASE DISREGARD STATEMENT',null,null,false,'1px solid ','LTR','C','Helvetica','12','B','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        //$txt='',$w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
                        Yii::$app->reporter->col('IF ALREADY PAID',null,null,false,'1px solid ','LRB','C','Helvetica','12','B','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('Important: This statement is presumed correct unless otherwise notified within fifteen (15) days of receipt',null,'50px',false,'1px solid ','LR','C','Helvetica','12','BI','','');
                        Yii::$app->reporter->endrow();

                        Yii::$app->reporter->startrow();

                        Yii::$app->reporter->col('<br>',null,null,false,'1px solid ','LRB','C','Helvetica','12','','','BI');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('<br>',null,null,false,'2px solid ','','L','Helvetica','12','','B','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('CERTIFIED CORRECT:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('RECEIVED BY:',null,null,false,'1px dotted ','','L','Helvetica','12','B','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();
                 
                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('<br>'.$params['certified'],null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','','L','Helvetica','12','','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();

                 Yii::$app->reporter->begintable('800');
                        Yii::$app->reporter->startrow();
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->col('<br>',null,null,false,'1.5px solid ','B','L','Helvetica','12','','','');
                        Yii::$app->reporter->endrow();
                 Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();
//var_dump($params);
//var_dump($data);




?>
