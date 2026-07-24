<?php
use yii\helpers\Url;
$this->title = "Select shipping address";
?>
<br>
<br>
 <!-- main-container -->
  <div class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">


        <section class="col-main col-sm-12 animated">


        	<div class="my-account col-md-6">
              <div class="recent-orders">
              	<div class="page-title">
                  <h2 style="font-size:15px;">Select a shipping Address: </h2>
                </div>
                <div class="table-responsive">
                <form id="frontend_caddress" method="POST" action="<?php echo  Url::to(['/frontend/checkout','step'=>2]);?>">
                  <table class="data-table" id="my-orders-table">
                    
                    <thead>
                      <tr class="first last">
                        <th>&nbsp</th>
                        <th>Address details</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr class="first odd">
                       <td><input id="addbook-addanother" value="NEW" type="radio" name="addbook"></td>
                       <td><strong>Add new address</strong></td>
                    </tr>
                    <?php
                    	$strhtml = "";
                  		foreach ($addressbook as $key => $value) {
                  		$contact1 = ($value['contact'] != '') ? $value['contact'] : '----------';
                  			$strhtml = $strhtml . '<tr class="first odd">';
                        if($key == 0){
                          $strhtml = $strhtml . '<td><input class="addbook" id="addbook-default" value="'.$value['addid'].'" type="radio" checked name="addbook"></td>';
                        }else{
                          $strhtml = $strhtml . '<td><input class="addbook" id="addbook-default" value="'.$value['addid'].'" type="radio" name="addbook"></td>';
                        }//end if
                  			$strhtml = $strhtml . '<td>'.$value['name'].'<br>';
                  			$strhtml = $strhtml . $value['address'].'<br>';
                  			$strhtml = $strhtml . $value['email'].'<br>';
                  			$strhtml = $strhtml . $contact1.'</td>';
                  			$strhtml = $strhtml . '</tr>';
                  		}//end for each
                  		echo $strhtml;
                    ?>
                   	</tbody>
                  </table>
                  <br>
                  <br>
                </div>

              </div>
            </div>


          	<div class="my-account col-md-6">
              <div class="recent-orders">
                <div class="title-buttons"><strong>Order Summary </strong> (<?php echo $gtotalqty;?> Items) <a href="<?php echo  Url::to(['/frontend/mycart']);?>">[Edit Cart]</a></div>

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
                    	foreach (Yii::$app->session['cart'] as $barcode => $subinfo) {
	                		echo '<tr class="first odd">
			                <td>'.$subinfo['itemname'].'</td>
							<td>'.$subinfo['qty'].'</td>
			                <td>'.$subinfo['price'].'</td>
			                <td class="ftblright">'.$subinfo['totprice'].'</td>
			                </tr>';	
                    	}//end for each
                    ?>
                   	</tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="title-buttons"><strong class="pull-right">Subtotal: &nbsp&nbsp <?php echo $gtotalamt;?></strong> </div>
              <br>
              <div class="title-buttons"><strong class="pull-right">Grandtotal: &nbsp&nbsp <?php echo $gtotalamt;?></strong> </div>
              <br>

              <div style="display:none;" class="content" id="addnewaddressform">
              <ul class="form-list">
                <li>
                  <label for="regemail">Name<span style="display:none;" class="required">*</span></label>
                  <br>
                  <input placeholder="Enter Name" type="text" title="Name" class="input-text addform" id="addformname" value="" name="add-name">
                </li>

                <li>
                  <label for="regname">Complete Address: <span style="display:none;" class="required">*</span></label>
                  <br>
                  <textarea placeholder="Enter Complete Address" style="resize:none;" name="add-address" id="addformaddress" title="Address" class="col-md-12 addform input-text" cols="5" rows="3"></textarea>
                </li>

                <li>
                  <label for="regemail">Province<!-- <span class="required">*</span> --></label>
                  <br>
                  <input placeholder="Province" type="text" title="Province" class="input-text addform" id="addformprovice" value="" name="add-province">
                </li>

                <li>
                  <label for="regemail">City<!-- <span class="required">*</span> --></label>
                  <br>
                  <input placeholder="City" type="text" title="City" class="input-text addform" id="addformcity" value="" name="add-city">
                </li>

                <li>
                  <label for="regemail">Municipality<!-- <span class="required">*</span> --></label>
                  <br>
                  <input placeholder="Municipality" type="text" title="Municipality" class="input-text addform" id="addformmunicipality" value="" name="add-municipality">
                </li>

                <li>
                  <label for="regemail">Mobile #:<span style="display:none;" class="required">*</span></label>
                  <br>
                  <input placeholder="Mobile" type="text" title="Mobile" class="input-text addform" id="addformmobile" value="" name="add-mobile">
                </li>

                
<!-- 
                <li>
                  <label for="regbday">Birthday <span class="required">*</span></label>
                  <br>
                  <input type="text" title="Birthday" id="regbday" class="input-text regform" name="reg-birthday">
                </li>

                <li>
                  <label for="reggender">Gender <span class="required">*</span></label>
                  <br>
                  <input type="text" title="Gender" id="reggender" class="input-text regform" name="reg-gender">
                </li> -->
              </ul>
              <p style="display:none;" class="required">Please fill up required fields (*)</p>
            </div>
              <button type="submit" style="margin-top:50px;" class="col-md-12 btn btn-lg btn-primary">Continue</button>
              
            </div>

            <!-- <div style="margin-top: 20px;" class="col-md-6 col-xs-12"> -->
            <!-- <button type="submit" style="margin-top: 20px;width:100%;" class="btn btn-lg btn-success">Continue</button> -->
            <!-- </div> -->
            </form>
        </section>


      </div>
    </div>
  </div>
  <!--End main-container --> 
  <br>
  <br>