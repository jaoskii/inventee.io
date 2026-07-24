<?php
$this->params['getlane'] = Yii::$app->frontend->verifyWhatLane($details[0]['f_cattagging']);
$this->title= $details[0]['itemname'];
$img1 = Yii::$app->homeUrl . 'frontendassets/steamlayout/products-images/product1.jpg';
$img2 = "";
$img3 = "";
$img4 = "";
$img5 = "";
$img6 = "";
$img7 = "";
$img8 = "";

if($details[0]['img1'] != ''){
  $img1 = $details[0]['img1'];
}//end if

if($details[0]['img2'] != ''){
  $img2 = $details[0]['img2'];
}//end if

if($details[0]['img3'] != ''){
  $img3 = $details[0]['img3'];
}//end if

if($details[0]['img4'] != ''){
  $img4 = $details[0]['img4'];
}//end if

if($details[0]['img5'] != ''){
  $img5 = $details[0]['img5'];
}//end if

if($details[0]['img6'] != ''){
  $img6 = $details[0]['img6'];
}//end if

if($details[0]['img7'] != ''){
  $img7 = $details[0]['img7'];
}//end if

if($details[0]['img8'] != ''){
  $img8 = $details[0]['img8'];
}//end if
?>

<section class="main-container col1-layout">
              

    <div class="main container">
      <div class="col-main">
       <div class="new_title center">
        <h2><?php echo $details[0]['itemname']; ?></h2>
      </div>
      <br>
        <div class="row">
          <div class="product-view">
            <div class="product-essential">
              <form action="#" method="post" id="product_addtocart_form">
                <input name="form_key" value="6UbXroakyQlbfQzK" type="hidden">
                <div class="product-img-box col-lg-6 col-sm-6 col-xs-12">
                  <ul class="moreview" id="moreview">
                    <?php 
                    if($img1 != ""){
                      echo '<li class="moreview_thumb thumb_1"> 
                      <img class="moreview_thumb_image" src="'.$img1.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img1.'" alt="">
                      </li>';
                    }//end if img 1

                    if($img2 != ""){
                      echo '<li class="moreview_thumb thumb_2"> 
                      <img class="moreview_thumb_image" src="'.$img2.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img2.'" alt="">
                      </li>';
                    }//end if img 1

                    if($img3 != ""){
                      echo '<li class="moreview_thumb thumb_3"> 
                      <img class="moreview_thumb_image" src="'.$img3.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img3.'" alt="">
                      </li>';
                    }//end if img 1

                    if($img4 != ""){
                      echo '<li class="moreview_thumb thumb_4"> 
                      <img class="moreview_thumb_image" src="'.$img4.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img4.'" alt="">
                      </li>';
                    }//end if img 1

                    if($img5 != ""){
                      echo '<li class="moreview_thumb thumb_5"> 
                      <img class="moreview_thumb_image" src="'.$img5.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img5.'" alt="">
                      </li>';
                    }//end if img 1

                    if($img6 != ""){
                      echo '<li class="moreview_thumb thumb_6"> 
                      <img class="moreview_thumb_image" src="'.$img6.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img6.'" alt="">
                      </li>';
                    }//end if img 1

                    if($img7 != ""){
                      echo '<li class="moreview_thumb thumb_7"> 
                      <img class="moreview_thumb_image" src="'.$img7.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img7.'" alt="">
                      </li>';
                    }//end if img 1

                    if($img8 != ""){
                      echo '<li class="moreview_thumb thumb_8"> 
                      <img class="moreview_thumb_image" src="'.$img8.'" alt="thumbnail"> 
                      <img class="moreview_source_image" src="'.$img8.'" alt="">
                      </li>';
                    }//end if img 1
                    ?>
                  </ul>
                  <div class="moreview-control"> <a href="javascript:void(0)" class="moreview-prev"></a> <a href="javascript:void(0)" class="moreview-next"></a> </div>
                </div>
                <div class="product-shop col-lg-6 col-sm-6 col-xs-12">
                  <!-- <div class="product-name">
                    <h1>Sample Product</h1>
                  </div> -->
                  <div class="short-description">
                    <h2 class="aimslabel" style="font-weight: normal;"><?php 
                    $warranty_period = str_replace('~', ' ', $details[0]['f_warrantperiod']);
                    echo '<span style="font-weight:bold;color:red;">'.$warranty_period . '</span> ' . $details[0]['f_warrantytype'];
                    ?></h2>
                    <span style="font-weight:bold;font-size: 10px;" class="aimslabel warrantydetail clickable" title="<?php echo $details[0]['f_warrantpolicy'];?>">View Warranty Details</span>
                  </div>

                  <div class="short-description">
                    <h2>Quick Overview</h2>
                    <p><?php echo nl2br($details[0]['f_highlights']);?></p>
                  </div>
                  <div class="short-description">
                    <!-- <h2>See <span style="color:blue;">Warranty Information</span></h2>  -->
                  </div>
                  <div class="price-block">
                    <div class="price-box">
                    <?php
                      if($details[0]['issale']){
                        echo '<p class="special-price"> <span class="price">'.$details[0]['saleprice'].'</span> </p><br>';
                        echo '<p class="old-price"> <span class="price-sep">-</span> <span class="price">'.$details[0]['amt'].'</span> 
                        <label style="font-size:12px;">('.$details[0]['fdiscounted'].')</label></p>
                        ';
                      }else{
                        echo '<p class="" style="font-size: 17px;"><b>PRICE:</b> '.$details[0]['amt'].'</p><br>';
                        echo '<p class="old-price"><label style="font-size:9px;">&nbsp</label></p>';
                      }//end if is sale
                    ?>
                    </div>
                  </div>

                   <!-- <div class="ratings">
                    <div class="rating-box">
                      <div class="rating"></div>
                    </div>
                    <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Your Review</a> </p>
                  </div> -->
                  <p class="availability in-stock">Availability: <span><?php echo $details[0]['instock']; ?></span></p>
                  
                  <div class="add-to-box">
                    <div class="">
                      <!-- <label for="qty">Quantity:</label>
                      <div class="pull-left">
                        <div class="custom pull-left">
                          <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="icon-minus">&nbsp;</i></button>
                          <input type="text" class="input-text qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                          <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items-count" type="button"><i class="icon-plus">&nbsp;</i></button>
                        </div>
                      </div> -->
                      <button id="<?php echo $details[0]['barcode']; ?>" class="button add-to-cart btn-cart" title="Add to Cart" type="button"><span><i class="icon-basket"></i> Add to Cart</span></button>
                      <div class="email-addto-box">
                        <ul class="add-to-links">
                          <!-- <li> <a id="wishlist-<?php echo $details[0]['barcode']; ?>" class="btnaddwishlist link-wishlist" href="#"><span>Add to Wishlist</span></a></li> -->
                          <!-- <li><span class="separator">|</span> <a class="link-compare" href="compare.html"><span>Add to Compare</span></a></li> -->
                        </ul>
                      </div>
                    </div>
                  </div>


                </div>
              </form>
            </div>
            <div class="product-collateral">
              <div class="col-sm-12 animated">
                <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                  <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Product Description </a> </li>
                  <li> <a href="#product_tabs_specs" data-toggle="tab">Specifications for <?php echo $details[0]['itemname']; ?></a> </li>
                  <!-- <li> <a href="#product_tabs_custom1" data-toggle="tab">Custom Tab1</a> </li>
                  <li><a href="#product_tabs_tags" data-toggle="tab">Tags</a></li>
                  <li> <a href="#reviews_tabs" data-toggle="tab">Reviews</a> </li> -->
                </ul>
                <div id="productTabContent" class="tab-content">
                  <div class="tab-pane fade in active" id="product_tabs_description">
                    <div class="std">
                      <p><?php echo nl2br($details[0]['f_proddesc']); ?></p>
                    </div>
                  </div>

                 <!--  <div class="tab-pane fade" id="product_tabs_tags">
                    <div class="box-collateral box-tags">
                      <div class="tags">
                        <form id="addTagForm" action="#" method="get">
                          <div class="form-add-tags">
                            <label for="productTagName">Add Tags:</label>
                            <div class="input-box">
                              <input class="input-text required-entry" name="productTagName" id="productTagName" type="text" >
                              <button type="button" title="Add Tags" class=" button btn-add" onClick="submitTagForm()"> <span>Add Tags</span> </button>
                            </div> -->
                            <!--input-box--> 
                          <!-- </div>
                        </form>
                      </div> -->
                      <!--tags-->
                     <!--  <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>
                    </div>
                  </div> -->
                  <div class="tab-pane fade" id="product_tabs_specs">
                    <div class="std">
                      <?php
                      if($details[0]['f_mainmaterial'] != ''){
                      echo '<label>Main Material</label>';
                      echo '<p>'.nl2br($details[0]['f_mainmaterial']).'</p>';
                      }//end if highlights
                      ?>
                      <?php
                      if($details[0]['f_type'] != ''){
                      echo '<label>Type</label>';
                      echo '<p>'.nl2br($details[0]['f_type']).'</p>';
                      }//end if highlights
                      ?>

                      <?php
                      if($details[0]['f_whatsbox'] != ''){
                      echo '<label>What`s in the box</label>';
                      echo '<p>'.nl2br($details[0]['f_whatsbox']).'</p>';
                      }//end if highlights
                      ?>

                      
                      <?php
                      if($details[0]['f_freeitems'] != ''){
                      echo '<label>Free Items</label>';
                      echo '<p>'.nl2br($details[0]['f_freeitems']).'</p>';
                      }//end if highlights
                      ?>

                      <?php
                      if($details[0]['f_videourl'] != ''){
                      echo '<label>Video Url</label>';
                      echo '<a href="'.$details[0]['f_videourl'].'"><b><p style="color:red;">'.nl2br($details[0]['f_videourl']).'</p></b></a>';
                      }//end if highlights
                      ?>
                    </div>
                  </div>


                  <div class="tab-pane fade" id="reviews_tabs">
                    <div class="box-collateral box-reviews" id="customer-reviews">
                      <div class="box-reviews1">
                        <div class="form-add">
                          <form id="review-form" method="post" action="#">
                            <h3>Write Your Own Review</h3>
                            <fieldset>
                              <h4>How do you rate this product? <em class="required">*</em></h4>
                              <span id="input-message-box"></span>
                              <table id="product-review-table" class="data-table">
                                
                                <thead>
                                  <tr class="first last">
                                    <th>&nbsp;</th>
                                    <th><span class="nobr">1 *</span></th>
                                    <th><span class="nobr">2 *</span></th>
                                    <th><span class="nobr">3 *</span></th>
                                    <th><span class="nobr">4 *</span></th>
                                    <th><span class="nobr">5 *</span></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr class="first odd">
                                    <th>Price</th>
                                    <td class="value"><input type="radio" class="radio" value="11" id="Price_1" name="ratings[3]"></td>
                                    <td class="value"><input type="radio" class="radio" value="12" id="Price_2" name="ratings[3]"></td>
                                    <td class="value"><input type="radio" class="radio" value="13" id="Price_3" name="ratings[3]"></td>
                                    <td class="value"><input type="radio" class="radio" value="14" id="Price_4" name="ratings[3]"></td>
                                    <td class="value last"><input type="radio" class="radio" value="15" id="Price_5" name="ratings[3]"></td>
                                  </tr>
                                  <tr class="even">
                                    <th>Value</th>
                                    <td class="value"><input type="radio" class="radio" value="6" id="Value_1" name="ratings[2]"></td>
                                    <td class="value"><input type="radio" class="radio" value="7" id="Value_2" name="ratings[2]"></td>
                                    <td class="value"><input type="radio" class="radio" value="8" id="Value_3" name="ratings[2]"></td>
                                    <td class="value"><input type="radio" class="radio" value="9" id="Value_4" name="ratings[2]"></td>
                                    <td class="value last"><input type="radio" class="radio" value="10" id="Value_5" name="ratings[2]"></td>
                                  </tr>
                                  <tr class="last odd">
                                    <th>Quality</th>
                                    <td class="value"><input type="radio" class="radio" value="1" id="Quality_1" name="ratings[1]"></td>
                                    <td class="value"><input type="radio" class="radio" value="2" id="Quality_2" name="ratings[1]"></td>
                                    <td class="value"><input type="radio" class="radio" value="3" id="Quality_3" name="ratings[1]"></td>
                                    <td class="value"><input type="radio" class="radio" value="4" id="Quality_4" name="ratings[1]"></td>
                                    <td class="value last"><input type="radio" class="radio" value="5" id="Quality_5" name="ratings[1]"></td>
                                  </tr>
                                </tbody>

                              </table>
                              <input type="hidden" value="" class="validate-rating" name="validate_rating">
                              <div class="review1">
                                <ul class="form-list">
                                  <li>
                                    <label class="required" for="nickname_field">Nickname<em>*</em></label>
                                    <div class="input-box">
                                      <input type="text" class="input-text required-entry" id="nickname_field" name="nickname">
                                    </div>
                                  </li>
                                  <li>
                                    <label class="required" for="summary_field">Summary<em>*</em></label>
                                    <div class="input-box">
                                      <input type="text" class="input-text required-entry" id="summary_field" name="title">
                                    </div>
                                  </li>
                                </ul>
                              </div>
                              <div class="review2">
                                <ul>
                                  <li>
                                    <label class="label-wide" for="review_field">Review<em>*</em></label>
                                    <div class="input-box">
                                      <textarea class="required-entry" rows="3" cols="5" id="review_field" name="detail"></textarea>
                                    </div>
                                  </li>
                                </ul>
                                <div class="buttons-set">
                                  <button class="button submit" title="Submit Review" type="submit"><span>Submit Review</span></button>
                                </div>
                              </div>
                            </fieldset>
                          </form>
                        </div>
                      </div>
                      <div class="box-reviews2">
                        <h3>Customer Reviews</h3>
                        <div class="box visible">
                          <ul>
                            <li>
                              <table class="ratings-table">
                                
                                <tbody>
                                  <tr>
                                    <th>Value</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <th>Quality</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <th>Price</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                </tbody>
                              </table>
                              <div class="review">
                                <h6><a href="#/catalog/product/view/id/61/">Excellent</a></h6>
                                <small>Review by <span>Leslie Prichard </span>on 1/3/2014 </small>
                                <div class="review-txt"> I have purchased shirts from Minimalism a few times and am never disappointed. The quality is excellent and the shipping is amazing. It seems like it's at your front door the minute you get off your pc. I have received my purchases within two days - amazing.</div>
                              </div>
                            </li>
                            <li class="even">
                              <table class="ratings-table">
                                
                                <tbody>
                                  <tr>
                                    <th>Value</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <th>Quality</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <th>Price</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                </tbody>
                              </table>
                              <div class="review">
                                <h6><a href="#/catalog/product/view/id/60/">Amazing</a></h6>
                                <small>Review by <span>Sandra Parker</span>on 1/3/2014 </small>
                                <div class="review-txt"> Minimalism is the online ! </div>
                              </div>
                            </li>
                            <li>
                              <table class="ratings-table">
                                
                                <tbody>
                                  <tr>
                                    <th>Value</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <th>Quality</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <th>Price</th>
                                    <td><div class="rating-box">
                                        <div class="rating"></div>
                                      </div></td>
                                  </tr>
                                </tbody>
                              </table>
                              <div class="review">
                                <h6><a href="#/catalog/product/view/id/59/">Nicely</a></h6>
                                <small>Review by <span>Anthony  Lewis</span>on 1/3/2014 </small>
                                <div class="review-txt"> Unbeatable service and selection. This store has the best business model I have seen on the net. They are true to their word, and go the extra mile for their customers. I felt like a purchasing partner more than a customer. You have a lifetime client in me. </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                        <div class="actions"> <a class="button view-all" id="revies-button"><span><span>View all</span></span></a> </div>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </div>


                </div>
              </div>


    <!--           <div class="col-sm-12">
                <div class="box-additional">
                  
                </div>
              </div> -->


            </div>
          </div>
        </div>
      </div>
    </div>
  </section>