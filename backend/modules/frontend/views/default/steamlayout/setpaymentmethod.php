<?php
use yii\helpers\Url;
use yii\base\ErrorException;
$this->title = "Select payment method";
?>

<br>
<br>
 <!-- main-container -->
  <div class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">

        <section class="col-main col-sm-12 animated">

        <form id="frontend_cpaymentmethod" method="POST" action="<?php echo Url::to(['/frontend/checkout','step'=>3]);?>">
        	<div class="my-account col-md-6">
              <div class="recent-orders">
              	<div class="page-title">
                  <h2 style="font-size:15px;">Select payment method: </h2>
                </div>
                
                <div class="paymentinline ftblcenter">
                <img src="<?php echo Yii::$app->homeUrl.'frontendassets/steamlayout/images/payment1.jpg';?>" class="thumbnail" height="200px;" width="200px;"><br>
                <label>Cash on Delivery<br> 
                <input id="paymentmethod-default" class="paymentmethodselection" type="radio" value = "COD" checked name="paymentmethod"></label>
                </div>

                <div class="paymentinline ftblcenter">
                <img src="<?php echo Yii::$app->homeUrl.'frontendassets/steamlayout/images/payment2.jpg';?>" class="thumbnail" height="200px;" width="200px;"><br>
                <label>Online Payment<br> 
                <input id="paymentmethod-online" class="paymentmethodselection" type="radio" value="ONLINE" name="paymentmethod"></label>
                </div>

                <!-- <div class="paymentinline ftblcenter">
                <img src="" class="thumbnail" height="100px;" width="100px;"><br>
                <label>BDD<br> 
                <input id="paymentmethod-sam3" type="radio" name="paymentmethod"></label>
                </div>

                <div class="paymentinline ftblcenter">
                <img src="" class="thumbnail" height="100px;" width="100px;"><br>
                <label>BPP<br> 
                <input id="paymentmethod-sam2" type="radio" name="paymentmethod"></label>
                </div>

                <div class="paymentinline ftblcenter">
                <img src="" class="thumbnail" height="100px;" width="100px;"><br>
                <label>MBT<br> 
                <input id="paymentmethod-sam1" type="radio" name="paymentmethod"></label>
                </div> -->
              </div>
            </div>


          	<div class="my-account col-md-6">
              <div class="recent-orders">
                <div class="table-responsive">
                  <table class="data-table" id="my-orders-table">
                    
                    <thead>
                      <tr class="first last">
                        <th>Shipping and Billing Address</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr class="first odd">
                    <?php 
                    echo '<td>'.$addbookdetail[0]['name'].'<br>
                    '.$addbookdetail[0]['address'].'<br>
                    '.$addbookdetail[0]['contact'].'<br>
                    <strong><a href="'.Url::to(['/frontend/checkout/','step'=>1]).'">[ Edit ]</a></strong></td>';
                    ?>
                    </tr>
                  
                    </tbody>
                  </table>
                  <br>
                  <br>
                </div>

                <!-- <div class="row"><div class="col-md-12"><span class="pull-right"><a href="<?php echo  Url::to(['/frontend/mycart']);?>">[Edit Cart]</a></span></div></div> -->
                <div class="table-responsive">
                  <table class="data-table" id="my-orders-table">
                    
                    <thead>
                      <tr class="first last">
                        <th>PRODUCT</th>
                        <th>QTY</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $gtotalamt = 0;
                      foreach (Yii::$app->session['cart'] as $barcode => $subinfo) {
  	                		echo '<tr class="first odd">
  			                <td>'.$subinfo['itemname'].'</td>
  							        <td>'.$subinfo['qty'].'</td>
  			                <td>'.number_format($subinfo['price'],2).'</td>
  			                <td class="ftblright">'.$subinfo['totprice'].'</td>
  			                </tr>';
                      
                      $subinfo['totprice'] = str_replace(',', '', $subinfo['totprice']);
                      $gtotalamt = floatval($gtotalamt)+ floatval($subinfo['totprice']);	
                    	}//end for each
                    ?>
                   	</tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="title-buttons"><strong class="pull-right">Subtotal: &nbsp&nbsp <?php echo number_format($gtotalamt,2);?></strong> </div>
              <br>
              <div class="title-buttons"><strong class="pull-right">Grandtotal: &nbsp&nbsp <?php echo number_format($gtotalamt,2);?></strong> </div>
              <button id="codplacebtn" type="submit" style="margin-top:50px;" class="col-md-12 btn btn-lg btn-primary"><i class="fa fa-gears"></i>CONFIRM ORDER</button>
              </form>

            </div>
        </section>


      </div>
    </div>
  </div>
  <!--End main-container --> 

  <br>
  <br>