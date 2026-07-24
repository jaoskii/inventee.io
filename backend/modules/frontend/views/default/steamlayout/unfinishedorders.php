<?php
use yii\helpers\Url;
$this->title = "Unfinished / Pending Orders";
?>
<br>
<br>  
<div class="container">
<input type="hidden" id="orderlistdetail" value="UNFINISHED">
<div class="my-account">
<div class="page-title">
  <h2>UNFINISHED / PENDING ORDERS <a href="<?php echo Url::to(['/frontend/customerdashboard/']);?>"><span style="font-size: 10px;">(Back to My Dashboard)</span></a></h2>
</div>
<div class="dashboard">

<div class="row">
    <div class="col-md-4">
        <div class="block block-compare" style="height:550px;overflow-y: scroll;">
            <div class="block-title ">All Unfinished Orders</div>
            <div class="block block-account">
             <div class="block-content">
                <div>
                <?php
                  if(!empty($orderhistory)){
                  foreach ($orderhistory as $key => $order) {
                      echo '
                      <a id="orderinfo-'.$order['trno'].'" class="clickable spreadorderdetail">
                      <div style="margin-top:10px;">
                      <b>Created on: '.$order['dateid'].'</b><br>
                      <b>Order #: '.$order['docno'].'</b><br>
                      <b>Amount: '.$order['amt'].'</b>
                      <hr>
                      </div></a>';
                  }//end for each order history
                  }//end if
                ?>
                </div>
              </div>
            </div>
        </div>
       
    </div>

    <div class="col-md-8 orderdetaildiv">
        <div class="block block-compare">
            <div class="block-title ">
            <span>Order #: </span><span class="ordernumber"><?php if(!empty($orderdetail)){echo $orderdetail[0]['docno'];}else{echo '-----';}?></span>
              <div class="pull-right">
              <?php
                $ordertotal = 0;
                if(!empty($orderdetail)){
                foreach ($orderdetail as $key => $value) {
                  $ordertotal = floatval($ordertotal) + floatval($value['totalamt']);
                }//end for each
                }
              ?>
              <span class="">Total Amount : </span>
              <span style="margin-right:50px;"  class="ordertotal"><?php echo number_format($ordertotal,2);?></span>
              </div>
            </div>
            <br>
            <div class="row">
            <div class="col-md-6">
            <label>Ship to:</label><br>
            <label class="ordershipto"><?php if(!empty($orderdetail)){ echo nl2br($orderdetail[0]['shipto']); }else{echo '-----';}?></label>
            </div>

            </div>

        </div>
        <h5 class="notetocustomer"><b>NOTE: All prior changes to prices are immediately applied upon checkout.</b></h5>
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
            <!-- <th>Status</th> -->
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
              $strhtml = $strhtml . '<td>'.$value['qty'].'</td>';
                if($value['ispricechanged']){
                  $strhtml = $strhtml . '<td class="bg-danger ftblright">'.$value['amt'].'</td>';
                }else{
                  $strhtml = $strhtml . '<td class="ftblright">'.$value['amt'].'</td>';
                }//end if
              $strhtml = $strhtml . '<td class="ftblright">'.$value['totalamt'].'</td>';
                if($value['ispricechanged']){
                  $strhtml = $strhtml . '<td class="bg-danger ftblright">'.$value['currentamt'].'<br><b>'.$value['pricechangemsg'].'</b></td>';
                }else{
                  $strhtml = $strhtml . '<td class="ftblright">'.$value['currentamt'].'</td>';
                }//end if
             /* $strhtml = $strhtml . '<td><em>'.$value['fstatus'].'</em></td>';*/
              $strhtml = $strhtml . '</tr>';
            }//end for each
            }//end if
            echo $strhtml;
          ?>
        </tbody>
        </table>
        </div>
        <br>
         <ul class="checkout">
          <li>
        
            <form method="POST" action="<?php echo Url::to(['/frontend/checkout','step'=>'unfcontinue']);?>">
              <input id="unfinishedtranscode" name="ordercode" type = "hidden" value="<?php if(!empty($orderdetail)){ echo $orderdetail[0]['trno']; }?>">
              <?php
              if(!empty($orderdetail)){
              echo '<button type="submit" title="Proceed to Checkout" class="btncontinue-unfinished button btn-proceed-checkout"><span>Proceed to Checkout</span></button>';
              }else{
                echo '<button style="display:none;" type="submit" title="Proceed to Checkout" class="btncontinue-unfinished button btn-proceed-checkout"><span>Proceed to Checkout</span></button>';
              }
              ?>
            </form>
          
          </li>
      
          
          <!-- <li><a href="#" title="Checkout with Multiple Addresses">Checkout with Multiple Addresses</a> </li> -->
          <br>
        </ul>
    </div>
</div>

</div>
</div>
</div>

<br>
<br>