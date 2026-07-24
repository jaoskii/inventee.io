<?php
// WTODO JAD 06-03-2019
date_default_timezone_set('Asia/Manila');
$this->title = 'Login Attempts Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count = $page = 55;

Yii::$app->reporter->beginreport('1200');

  Yii::$app->reporter->begintable('1200');
    $header = Yii::$app->reporter->letterhead();
  Yii::$app->reporter->endtable();

  echo '<br/><br/>';

  Yii::$app->reporter->begintable('1200');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('LOGIN ATTEMPTS REPORT',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','12','','','5px');
      if($params['user'] == '') {
        Yii::$app->reporter->col('USER : All',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
      } else {
        Yii::$app->reporter->col('USER : ' .strtoupper($params['user']),NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');    
      }

        Yii::$app->reporter->col('Start date : ' .strtoupper($params['start']),NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');    
        Yii::$app->reporter->col('Start date : ' .strtoupper($params['end']),NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');    

      if($params['user_validity'] == 'ALL') {
        Yii::$app->reporter->col('User Validity : All',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
      } else {
          if($params['user_validity']){
                Yii::$app->reporter->col('User Validity : Valid Users',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
          }else{
                Yii::$app->reporter->col('User Validity : Invalid Users',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
          }//end if
      }
      
      if($params['attempt_status'] == 'ALL') {
        Yii::$app->reporter->col('Attempt Status : All',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
      } else {
        if($params['attempt_status']){
            Yii::$app->reporter->col('Attempt Status : Successfull Logins',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
        }else{
            Yii::$app->reporter->col('Attempt Status : Unsuccessful Logins',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
        }//end if
      }

      Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();

  Yii::$app->reporter->begintable('1200');
  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('USER','50',null,false,'1px solid ','B','L','Helvetica','13','B','','');
  Yii::$app->reporter->col('DATE ATTEMPT','200',null,false,'1px solid ','B','C','Helvetica','13','B','','');
  Yii::$app->reporter->col('IP ADDRESS ','200',null,false,'1px solid ','B','C','Helvetica','13','B','','');
  Yii::$app->reporter->col('ATTEMPT STATUS','200',null,false,'1px solid ','B','C','Helvetica','13','B','','');
  Yii::$app->reporter->col('PASSED CREDENTIALS','250',null,false,'1px solid ','B','C','Helvetica','13','B','','');
  Yii::$app->reporter->col('USER VALIDITY','200',null,false,'1px solid ','B','C','Helvetica','13','B','',''); 

  echo "<div style='line-height: 1.6;'>";
  
      for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['org_username'],'50',null,false,'1px solid ','B','L','Helvetica','11','','','');
          Yii::$app->reporter->col($data[$i]['attempdate'],'200',null,false,'1px solid ','B','C','Helvetica','11','','','');
          Yii::$app->reporter->col($data[$i]['ip'],'200',null,false,'1px solid ','B','C','Helvetica','11','','','');
          
          if($data[$i]['attempt_status']){
            Yii::$app->reporter->col('Successful Login','200',null,false,'1px solid ','B','C','Helvetica','11','','','');
          }else{
            Yii::$app->reporter->col('Unsuccessful Login','200',null,false,'1px solid ','B','C','Helvetica','11','','','');
          }//end if
          
          Yii::$app->reporter->col($data[$i]['creds_username'] . ' / ' . $data[$i]['creds_password'],'250',null,false,'1px solid ','B','C','Helvetica','11','','','');
          
          if($data[$i]['user_validity']){
            Yii::$app->reporter->col('Valid','200',null,false,'1px solid ','B','C','Helvetica','11','','','');
          }else{    
            Yii::$app->reporter->col('Invalid','200',null,false,'1px solid ','B','C','Helvetica','11','','','');
          }//end if

        Yii::$app->reporter->endrow();
        
        echo "</div>";
      
        if(Yii::$app->reporter->linecounter == $page) {
          Yii::$app->reporter->endtable();
          Yii::$app->reporter->page_break();
          
          Yii::$app->reporter->begintable('1200');
            $header = Yii::$app->reporter->letterhead();
          Yii::$app->reporter->endtable();
          
          echo '<br/><br/>';
            
          Yii::$app->reporter->begintable('1200');
            Yii::$app->reporter->startrow();
              Yii::$app->reporter->col('LOGIN ATTEMPTS REPORT',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
            Yii::$app->reporter->endrow();

            Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','12','','','5px');
            if($params['user'] == '') {
                Yii::$app->reporter->col('USER : All',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
            } else {
                Yii::$app->reporter->col('USER : ' .strtoupper($params['user']),NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');    
            }

                Yii::$app->reporter->col('Start date : ' .strtoupper($params['start']),NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');    
                Yii::$app->reporter->col('Start date : ' .strtoupper($params['end']),NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');    

            if($params['user_validity'] == 'ALL') {
                Yii::$app->reporter->col('User Validity : All',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
            } else {
                if($params['user_validity']){
                        Yii::$app->reporter->col('User Validity : Valid Users',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
                }else{
                        Yii::$app->reporter->col('User Validity : Invalid Users',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
                }//end if
            }
            
            if($params['attempt_status'] == 'ALL') {
                Yii::$app->reporter->col('Attempt Status : All',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
            } else {
                if($params['attempt_status']){
                    Yii::$app->reporter->col('Attempt Status : Successfull Logins',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
                }else{
                    Yii::$app->reporter->col('Attempt Status : Unsuccessful Logins',NULL,null,false,'1px solid ','','L','Helvetica','12','','','5px');
                }//end if
            }
              Yii::$app->reporter->pagenumber('Page');
            Yii::$app->reporter->endrow();
          Yii::$app->reporter->endtable();

          Yii::$app->reporter->printline();
      
          Yii::$app->reporter->begintable('1200');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('USER','50',null,false,'1px solid ','B','L','Helvetica','13','B','','');
                Yii::$app->reporter->col('DATE ATTEMPT','200',null,false,'1px solid ','B','C','Helvetica','13','B','','');
                Yii::$app->reporter->col('IP ADDRESS ','200',null,false,'1px solid ','B','C','Helvetica','13','B','','');
                Yii::$app->reporter->col('ATTEMPT STATUS','200',null,false,'1px solid ','B','C','Helvetica','13','B','','');
                Yii::$app->reporter->col('PASSED CREDENTIALS','250',null,false,'1px solid ','B','C','Helvetica','13','B','','');
                Yii::$app->reporter->col('USER VALIDITY','200',null,false,'1px solid ','B','C','Helvetica','13','B','',''); 
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->printline();
            $page=$page + $count;
        } 
      }//END FOR LOOKP
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

?>