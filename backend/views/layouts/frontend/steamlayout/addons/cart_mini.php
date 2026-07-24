<?php
use yii\helpers\Url;
  foreach (Yii::$app->session['cart'] as $key => $value) {

  }//end for each
?>

<div class="block block-cart">
  <div class="block-title ">My Cart</div>
  <div class="block-content">
    <div class="summary">
      <p class="amount">There are <a href="#">2 items</a> in your cart.</p>
      <p class="subtotal"> <span class="label">Cart Subtotal:</span> <span class="price">$27.99</span> </p>
    </div>
    <div class="ajax-checkout">
      
      <button type="submit" title="Submit" class="button view-cart"><span>View Cart</span></button>
    </div>

    <p class="block-subtitle">Recently added item(s) </p>
    <ul>
      <li class="item"> <a class="product-image" title="Fisher-Price Bubble Mower" href="#"><img width="80" alt="Fisher-Price Bubble Mower" src="<?php echo Yii::$app->homeUrl; ?>frontendassets/steamlayout/products-images/product1.jpg"></a>
        <div class="product-details">
          <div class="access"> <a class="btn-remove1" title="Remove This Item" href="#"> <span class="icon"></span> Remove </a> </div>
          <p class="product-name"> <a href="#">Skater Dress In Leaf Print Grouped Product</a> </p>
          <strong>1</strong> x <span class="price">$19.99</span> </div>
      </li>
      <li class="item last"> <a class="product-image" title="Prince Lionheart Jumbo Toy Hammock" href="#"><img width="80" alt="Prince Lionheart Jumbo Toy Hammock" src="<?php echo Yii::$app->homeUrl; ?>frontendassets/steamlayout/products-images/product1.jpg"></a>
        <div class="product-details">
          <div class="access"> <a class="btn-remove1" title="Remove This Item" href="#"> <span class="icon"></span> Remove </a> </div>
          <p class="product-name"> <a href="#"> Sample Fashion Product Prince Lionheart </a> </p>
          <strong>1</strong> x <span class="price">$8.00</span> 
          <!--access clearfix--> 
        </div>
      </li>
    </ul>

  </div>
</div>