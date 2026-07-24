<?php
use yii\helpers\Url;
?>
<div class="block block-account">
            <div class="block-title">My Account</div>
            <div class="block-content">
              <ul>
                <li class=""><a href="<?php echo Url::to(['/frontend/customerdashboard']);?>">Account Dashboard</a></li>
                <li><a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'accountinfo']);?>">Account Information</a></li>
                <li><a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'pchange']);?>">Manage Password</a></li>
                <!-- <li><a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'myaddressbook']);?>">Address Book</a></li> -->
                <li><a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'orderhistory']);?>">Order History</a></li>
                <li><a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'unfinished']);?>">Unfinished / Pending Orders</a></li>
                <!-- <li><a href="http://demo.magentomagik.com/computerstore/sales/billing_agreement/">Billing Agreements</a></li>
                <li><a href="http://demo.magentomagik.com/computerstore/sales/recurring_profile/">Recurring Profiles</a></li> -->
                <!-- <li><a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'myreviews']);?>">My Product Reviews</a></li> -->
                <!-- <li><a href="http://demo.magentomagik.com/computerstore/tag/customer/">My Tags</a></li> -->
                <!-- <li><a href="<?php echo Url::to(['/frontend/customerdashboard','q'=>'wishlist']);?>">My Wishlist</a></li> -->
                <!-- <li><a href="http://demo.magentomagik.com/computerstore/downloadable/customer/products/">My Downloadable</a></li> -->
                <!-- <li class="last"><a href="http://demo.magentomagik.com/computerstore/newsletter/manage/">Newsletter Subscriptions</a></li> -->
              </ul>
            </div>
          </div>
          <!-- <div class="block block-compare">
            <div class="block-title ">Compare Products (2)</div>
            <div class="block-content">
              <ol id="compare-items">
                <li class="item odd">
                  <input type="hidden" value="2173" class="compare-item-id">
                  <a class="btn-remove1" title="Remove This Item" href="#"></a> <a href="#" class="product-name"> Sofa with Box-Edge Polyester Wrapped Cushions</a> </li>
                <li class="item last even">
                  <input type="hidden" value="2174" class="compare-item-id">
                  <a class="btn-remove1" title="Remove This Item" href="#"></a> <a href="#" class="product-name"> Sofa with Box-Edge Down-Blend Wrapped Cushions</a> </li>
              </ol>
              <div class="ajax-checkout">
                <button type="submit" title="Submit" class="button button-compare"><span>Compare</span></button>
                <button type="submit" title="Submit" class="button button-clear"><span>Clear</span></button>
              </div>
            </div>
          </div> -->