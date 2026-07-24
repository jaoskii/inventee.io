<?php
use yii\helpers\Url;
$this->title = "Customer Dashboard";
?>

<div class="my-account">

<?php 
if(!empty($params)){
    echo $msg;
}//end if
?>
<div class="page-title">
  <h2>My Dashboard</h2>
</div>
<div class="dashboard">
  <div class="welcome-msg"> <strong>Hello, <?php echo Yii::$app->session['customerdata']['customername'];?></strong>
    <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</p>
  </div>

    <div class="box-account">
    <div class="page-title">
      <h2>Account Information</h2>
    </div>
    <div class="col2-set">
      <div class="col-1">
        <h5>Contact Information</h5>
        <a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'accountinfo']);?>">Edit</a><br>
        <p><?php echo Yii::$app->session['customerdata']['customername'];?><br>
          <?php echo Yii::$app->session['customerdata']['email'];?><br>
          <?php echo Yii::$app->session['customerdata']['customercontact'];?><br>
          <!-- <a href="#">Change Password</a>  --></p>
      </div>
      <div class="col-2">
        <!-- <h5>Newsletters</h5>
        <a href="#">Edit</a>
        <p> You are currently not subscribed to any newsletter. </p> -->
      </div>
    </div>
   <!--  <div class="col2-set">
      <h4>Address Book</h4>
      <div class="manage_add"><a href="#">Manage Addresses</a> </div>
      <div class="col-1">
        <h5>Primary Billing Address</h5>
        <address>
        pranali d<br>
        aundh<br>
        tyyrt,  Alabama, 46532<br>
        United States<br>
        T: 454541 <br>
        <a href="#">Edit Address</a>
        </address>
      </div>
      <div class="col-2">
        <h5>Primary Shipping Address</h5>
        <address>
        pranali d<br>
        aundh<br>
        tyyrt,  Alabama, 46532<br>
        United States<br>
        T: 454541 <br>
        <a href="#">Edit Address</a>
        </address>
      </div>
    </div>
  </div> -->

  <br>

   
    <?php
      if(!empty($recentorders)){
          $strhtml = "";
          $strhtml = "";
          $strhtml = '<div class="recent-orders">';
          $strhtml = '<div class="title-buttons"><strong>Recent Orders</strong> <a href="'.Url::to(['/frontend/customerdashboard','q'=>'orderhistory']).'">View All Orders</a> </div>';
          $strhtml = $strhtml . '<div class="table-responsive">';
          $strhtml = $strhtml . '<table class="data-table" id="my-orders-table">';
          $strhtml = $strhtml . '<thead>';
          $strhtml = $strhtml . '<tr class="first last">';
          $strhtml = $strhtml . '<th>Order #</th>';
          $strhtml = $strhtml . '<th>Date</th>';
          $strhtml = $strhtml . '<th>Ship to</th>';
          $strhtml = $strhtml . '<th><span class="nobr">Order Total</span></th>';
          $strhtml = $strhtml . '<th>Status</th>';
          $strhtml = $strhtml . '</tr>';
          $strhtml = $strhtml . '</thead>';
          $strhtml = $strhtml . '<tbody>';
                    
          foreach ($recentorders as $key => $value) {
            $strhtml = $strhtml . '<tr class="last even">';
            $strhtml = $strhtml . '<td>'.$value['docno'].'</td>';
            $strhtml = $strhtml . '<td>'.$value['dateid'].'</td>';
            $strhtml = $strhtml . '<td>'.nl2br($value['shipto']).'</td>';
            $strhtml = $strhtml . '<td class="ftblcenter">'.number_format($value['amt'],2).'</td>';
            $strhtml = $strhtml . '<td><a href="'.Url::to(['/frontend/customerdashboard','q'=>'orderhistory','ord'=>$value['trno']]).'"><em>View Status</em></a></td>';
            $strhtml = $strhtml . '</tr>';
          }//end for each

          $strhtml = $strhtml . '</tbody>';
          $strhtml = $strhtml . '</table>';
          $strhtml = $strhtml . '</div>';

          echo $strhtml;
      }//end if else
    ?>

  </div>


</div>
</div>

<br>
<br>          


