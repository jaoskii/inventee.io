<?php
use yii\helpers\Url;
$this->title = "Order History";
?>
<br>
<br>  
<div class="container">
<input type="hidden" id="orderlistdetail" value="ORDERHISTORY">
<div class="my-account">
<div class="page-title">
  <h2>Order History <a href="<?php echo Url::to(['/frontend/customerdashboard/']);?>"><span style="font-size: 10px;">(Back to My Dashboard)</span></a></h2>
</div>
<div class="dashboard">

<div class="row">
    <div class="col-md-4">
        <div class="block block-compare" style="height:550px;overflow-y: scroll;">
            <div class="block-title ">My Orders</div>
            <div class="block block-account">
             <div class="block-content">
                <div class="orderhistorylist">
                <?php
                if(!empty($orderhistory)){
                  foreach ($orderhistory as $key => $order) {
                      echo '<a id="orderinfo-'.$order['trno'].'" class="clickable spreadorderdetail">
                      <div style="margin-top:10px;">
                      <b>Created on: '.$order['dateid'].'</b><br>
                      <b>Order #: '.$order['docno'].'</b><br>
                      <b>Amount: '.$order['amt'].'</b>
                      <hr>
                      </div></a>';
                  }//end for each order history
                }
                ?>
                </div>
              </div>
            </div>
        </div>
       
    </div>

    <div class="col-md-8 orderdetaildiv">
        <div class="block block-compare">
            <div class="block-title ">
            <span>Order #: </span><span class="ordernumber"><?php if(!empty($orderdetail)){ echo $orderdetail[0]['docno']; }else{echo '-----';}?></span>
              <div class="pull-right">

              <?php
                $ordertotal = 0;
                if(!empty($orderdetail)){
                  foreach ($orderdetail as $key => $value) {
                    $ordertotal = floatval($ordertotal) + floatval($value['totalamt']);
                  }//end for each
                }//end if
              ?>
              <span class="">Total Amount : </span>

              <span style="margin-right:50px;"  class="ordertotal"><?php echo number_format($ordertotal,2);?></span>
              <span class="">Status: </span>
              <?php 
              if(!empty($orderdetail)){
                if($orderdetail[0]['status']){
                  echo '<span style="color:rgb(253, 217, 34);" class="orderstatus">OPEN</span>';
                }else{ 
                  echo '<span style="rgb(194, 51, 33);" class="orderstatus">CLOSED</span>';
                }//end if
              }else{
                echo '<span style="rgb(194, 51, 33);" class="orderstatus">-----</span>';
              }//end if
              ?>
              </div>
            </div>
            <br>
            <div class="row">
            <div class="col-md-6">
            <label>Ship to:</label><br>
            <label class="ordershipto"><?php if(!empty($orderdetail)){ echo nl2br($orderdetail[0]['shipto']);}else{echo '-----';} ?></label>
            </div>

            </div>

        </div>

        <!-- <h5 class="notetocustomer"><b>NOTE: All prior changes to prices are immediately applied upon checkout.</b></h5> -->
        <div class="table-responsive">
        <table class="data-table" id="my-orders-table">
        <thead>
          <tr class="first last">
            <th>&nbsp</th>
            <th>Itemname</th>
            <th>Qty</th>
            <th class="ftblright">Amt</th>
            <th class="ftblright">Total</th>
            <th class="ftblright">Current Price</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="orderhistorytbl">
          <?php
            $strhtml = "";
            if(!empty($orderdetail)){
            foreach ($orderdetail as $key => $value) {
              $strhtml = $strhtml . '<tr class="last even">';
              $strhtml = $strhtml . '<td><img width="50px" src="'.$value['img1'].'"></td>';
              $strhtml = $strhtml . '<td>'.$value['itemname'].'</td>';
              $strhtml = $strhtml . '<td>'.number_format($value['qty'],0).'</td>';
               if($value['ispricechanged']){
                  $strhtml = $strhtml . '<td class="changedprice bg-danger ftblright">'.number_format($value['amt'],2).'</td>';
                }else{
                  $strhtml = $strhtml . '<td class="ftblright">'.number_format($value['amt'],2).'</td>';
                }//end if
              $strhtml = $strhtml . '<td class="ftblright">'.number_format($value['totalamt'],2).'</td>';
                if($value['ispricechanged']){
                  $strhtml = $strhtml . '<td class="changedprice bg-danger ftblright">'.number_format($value['currentamt'],2).'<br><b>'.$value['pricechangemsg'].'</b></td>';
                }else{
                  $strhtml = $strhtml . '<td class="ftblright">'.number_format($value['currentamt'],2).'</td>';
                }//end if
              $strhtml = $strhtml . '<td><em>'.$value['fstatus'].'</em></td>';
              $strhtml = $strhtml . '</tr>';
            }//end for each
            }//end if
            echo $strhtml;
          ?>
        </tbody>
        </table>
        </div>
    </div>
</div>

</div>
</div>
</div>

<br>
<br>