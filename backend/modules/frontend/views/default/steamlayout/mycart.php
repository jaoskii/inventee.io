<?php
use yii\helpers\Url;
$this->title = "My Cart";
//unset(Yii::$app->session['cart']);
?>

<section class="main-container col2-layout">
<div class="main container">
<div class="col-main">

<div class="cart animated">
          <div class="page-title">
            <h2>Shopping Cart</h2>
          </div>
          <div class="table-responsive">
            <form method="post" action="#updatePost/">
              <input type="hidden" value="Vwww7itR3zQFe86m" name="form_key">
              <fieldset>
                <table class="data-table cart-table" id="shopping-cart-table">
                  <thead>
                    <tr class="first last">
                      <th rowspan="1">&nbsp;</th>
                      <th rowspan="1"><span class="nobr">Product Name</span></th>
                      <th colspan="1" class="a-center"><span class="nobr">Unit Price</span></th>
                      <th class="a-center" rowspan="1">Qty</th>
                      <th colspan="1" class="a-center">Subtotal</th>
                      <th class="a-center" rowspan="1">&nbsp;</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="first last">
                      <td class="a-right last" colspan="7">
                      <a href="<?php echo Url::to(['/']); ?>"><button class="button btn-continue" title="Continue Shopping" type="button"><span><span>Continue Shopping</span></span></button></a>
                        <button class="refreshcart button btn-update" title="Update Cart" value="update_qty" name="update_cart_action" type="button"><span><span>Refresh Cart</span></span></button>
                        <?php 
                        if(isset(Yii::$app->session['cart'])){
                            if(empty(Yii::$app->session['cart'])){
                              echo '<button style="display:none;" id="empty_cart_button" class="clearcart button btn-empty" title="Clear Cart" value="empty_cart" name="update_cart_action" type="button"><span><span>Clear Cart</span></span></button></td>';    
                            }else{
                              echo '<button id="empty_cart_button" class="clearcart button btn-empty" title="Clear Cart" value="empty_cart" name="update_cart_action" type="button"><span><span>Clear Cart</span></span></button></td>';
                            }
                        }else{
                          echo '<button style="display:none;" id="empty_cart_button" class="clearcart button btn-empty" title="Clear Cart" value="empty_cart" name="update_cart_action" type="button"><span><span>Clear Cart</span></span></button></td>';
                        }//end if
                        ?>
                    </tr>
                  </tfoot>
                  <tbody id="mycartitems">
                  <?php

                    if(isset(Yii::$app->session['cart'])){
                        $gtotal = 0;
                        if(!empty(Yii::$app->session['cart'])){
                          foreach (Yii::$app->session['cart'] as $key => $value) {
                              $value['totprice'] = str_replace(',', '', $value['totprice']);
                              $gtotal = str_replace(',', '', $gtotal);
                              $gtotal = floatval($gtotal)+ floatval($value['totprice']);
                              $keys = explode('_', $key);
                              echo '<tr class="first odd">
                                      <td class="image">
                                      <a class="product-image" title="'.$value['itemname'].'" href="product_detail.html">
                                      <img width="75" alt="'.$value['itemname'].'" src="'.$value['picture'].'">
                                      </a></td>
                                      <td><a href="'.Url::to(['/frontend/productdetail/', 'sku' => $keys[0]]).'"><h6 class="product-name" id="cartprodname-'.$keys[0].'_'.$keys[1].'"> '.$value['itemname'].'</h6></a></td>
                                      <td class="a-right"><span class="cart-price"> <span class="price">'.number_format($value['price'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</span> </span></td>
                                      <td class="a-right movewishlist"><input uid = "txtcartqty~'.$keys[0].'~'.$keys[1].'" id="txtcartqty-'.$keys[0].'_'.$keys[1].'" maxlength="12" class="input-text qty txt-cartqty" title="Qty" size="2" value="'.$value['qty'].'" name="cartqty"></td>
                                      <td class="a-right movewishlist"><span class="cart-price"> <span class="cartprice-'.$keys[0].'_'.$keys[1].'">'.number_format($value['totprice'],Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</span> </span></td>
                                      <td class="a-center last"><a id="cartremove~'.$keys[0].'~'.$keys[1].'" class="cartremove button remove-item" title="Remove item" href="#"><span><span>Remove item</span></span></a></td>
                                    </tr>';
                          }//end for each
                        }else{
                          echo '<tr><td colspan="6" align="center" >There is no item on your cart, <a href="'.Url::to(['/']).'"> Shop now</a></td></tr>';
                        }//ebnd if empty
                    }else{
                      echo '<tr><td colspan="6" align="center" >There is no item on your cart, <a href="'.Url::to(['/']).'"> Shop now</a></td></tr>';
                    }//end if
                  ?>

                  </tbody>
                </table>
              </fieldset>
            </form>
          </div>
        </div>


        <!-- BEGIN CART COLLATERALS -->
        <div class="cart-collaterals row animated">
          <?php
          if(isset(Yii::$app->session['cart'])){
            if(!empty(Yii::$app->session['cart'])){
              echo '<div style="display:block;" class="gtotaldetails col-sm-4 pull-right col-xs-12">';
            }else{
              echo '<div style="display:none;" class="gtotaldetails col-sm-4 pull-right col-xs-12">';     
            }
          }else{
            echo '<div style="display:none;" class="gtotaldetails col-sm-4 pull-right col-xs-12">';   
          }//end if
          ?>
          
            <div class="totals">
              <h3>Shopping Cart Total</h3>
              <div class="inner">
                <table id="shopping-cart-totals-table" class="table shopping-cart-table-total">
                  <colgroup>
                  <col>
                  <col width="1">
                  </colgroup>
                  <tfoot>
                    <tr>
                      <td class="a-left" colspan="1"><strong>Grand Total</strong></td>
                      <td class="a-right"><strong><span class="cartgrandtotal"><?php if(isset(Yii::$app->session['cart'])){ echo number_format($gtotal,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')); }?></span></strong></td>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr>
                      <td class="a-left" colspan="1"> Subtotal </td>
                      <td class="a-right"><span class="cartsubtotal"><?php if(isset(Yii::$app->session['cart'])){ echo number_format($gtotal,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')); }?></span></td>
                    </tr>
                  </tbody>
                </table>
                <ul class="checkout">
                  <li>
                    <a href="<?php echo Url::to(['/frontend/checkout','step' => 1]);?>"><button type="button" title="Proceed to Checkout" class="button btn-proceed-checkout"><span>Proceed to Checkout</span></button></a>
                  </li>
              
                  
                  <!-- <li><a href="#" title="Checkout with Multiple Addresses">Checkout with Multiple Addresses</a> </li> -->
                  <br>
                </ul>
              </div>
              <!--inner--> 
            </div>
            <!--totals--> 
          </div>
          <!--cart-collaterals--> 
        </div>
        </div>
          </div>
          </section>