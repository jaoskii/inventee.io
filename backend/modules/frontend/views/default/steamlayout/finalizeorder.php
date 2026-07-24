-<?php
use yii\helpers\Url;
$this->title = "Confirm and Finalize your Order";
?>
<br>
<br>
 <!-- main-container -->
  <div class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">

        <section class="col-main col-sm-12 animated animated" style="visibility: visible;">
            <div class="my-account col-md-12">
              <div class="recent-orders">
                <div class="table-responsive">
                  <table class="data-table" id="my-orders-table">
                    
                    <thead>
                      <tr class="first last">
                        <th>Shipping and Billing Address</th>
                        <th>Payment Method</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr class="first odd">
                      <td><?php echo nl2br($params['shipto']); ?>
                      <br>
                      </td>
                      <td>Payment Type: <strong><?php echo Yii::$app->session['ongoingcheckout']['ptype'];?></strong>
                      </td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <br>
                </div>
                <!-- <div class="row"><div class="col-md-12"><span class="pull-right"><a href="#">[ Edit Cart ]</a></span></div></div> -->
                <div class="table-responsive">
                  <table class="data-table" id="my-orders-table">
                    
                    <thead>
                      <tr class="first last">
                        <th>PRODUCT</th>
                        <th>QTY</th>
                        <th class="ftblright">PRICE</th>
                        <th class="ftblright">TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $strhtml = '';
                    $gtotalamt = 0;
                    foreach ($cart as $key => $value) {
                        $strhtml =  $strhtml . '<tr class="first odd">';
                        $strhtml =  $strhtml . '<td>'.$cart[$key]['itemname'].'</td>';
                        $strhtml =  $strhtml . '<td>'.$cart[$key]['qty'].'</td>';
                        $totprice = str_replace(',', '', $cart[$key]['totprice']);
                        $price = str_replace(',', '', $cart[$key]['price']);
                        $strhtml =  $strhtml . '<td>'.number_format($price,2).'</td>';
                        $strhtml =  $strhtml . '<td class="ftblright">'.number_format($totprice,2).'</td>';
                        $strhtml =  $strhtml . '</tr>';
                        $amt = str_replace(',','',$cart[$key]['totprice']);
                        $gtotalamt = intval($gtotalamt) + intval($amt);
                    }//end for each

                    echo $strhtml;

                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="title-buttons"><strong class="pull-right">Subtotal: &nbsp;&nbsp; <?php echo number_format($gtotalamt,2); ?></strong> </div>
              <br>
              <div class="title-buttons"><strong class="pull-right">Grandtotal: &nbsp;&nbsp; <?php echo number_format($gtotalamt,2); ?></strong> </div>
              
              <?php 
              $olamt = str_replace(',','',$gtotalamt);
              $hashtag = sha1('18066439|'.$docreference['docno'].'|608|'.$olamt.'|N|jhmK1QOnQGUOMDridHMgv9wlBMDp6JJs'); 
              ?>
              <form name="payFormCcard" method="post" action="https://test.pesopay.com/b2cDemo/eng/payment/payForm.jsp"> 
              <input type="hidden" name="merchantId" value="18064485">  
              <input type="hidden" name="amount" value="<?php echo $olamt; ?>">
              <input type="hidden" name="orderRef" value="<?php echo $docreference['docno'];?>"> 
              <input type="hidden" name="currCode" value="608"> 
              <input type="hidden" name="mpsMode" value="NIL"> 
              <input type="hidden" name="successUrl" value="<?php echo Yii::$app->urlManager->createAbsoluteUrl('frontend/checkout?step=4');?>"> 
              <input type="hidden" name="failUrl" value="<?php echo Yii::$app->urlManager->createAbsoluteUrl('frontend/error');?>"> 
              <input type="hidden" name="cancelUrl" value="<?php echo Yii::$app->urlManager->createAbsoluteUrl('frontend/checkout?step=olcancelled');?>"> 
              <input type="hidden" name="payType" value="N"> 
              <input type="hidden" name="lang" value="E"> 
              <input type="hidden" name="payMethod" value="CC"> 
              <input type="hidden" name="secureHash" value="<?php echo $hashtag;?>"> 
              <?php
                switch (Yii::$app->session['ongoingcheckout']['ptype']) {
                  case 'ONLINE':
                    echo '<button id="onlineplacebtn" type="submit" style="margin-top:50px;" class="col-md-push-7 col-md-5 btn btn-lg btn-primary">FINALIZE AND PLACE ORDER</button>';
                  break;
                  
                  case 'COD':
                    echo '<a href="'.Url::to(['/frontend/checkout','step'=>4]).'">
                    <button id="codplacebtn" type="button" style="margin-top:50px;" class="col-md-push-7 col-md-5 btn btn-lg btn-primary">FINALIZE AND PLACE ORDER</button>
                    </a>';
                  break;
                }//END SWITCH CASE
              ?>
              </form> 


            </div>
        </section>
      </div>
    </div>
  </div>
  <!--End main-container --> 

  <br>
  <br>