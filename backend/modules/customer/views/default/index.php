<?php
$this->title = 'Customer Ledger';
$datetoday = date("Y-m-d");
$date = strtotime($datetoday .' -6 months');
$finaldate=date('Y-m-d', $date);

switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<div  id="dragme">
<i onclick="myFunction()" class="title fa fa-list"></i><br/>
<ul id="menu-float">
<?php if(!empty($customerdata['clientid'])){?>
  <!-- ADD CLASS (pop-btn btn-xx ) to BUTTONS added here also Remove button captions -->  
  <!-- then add (<div class="list">CAPTION</div>) after each </button>
<div class="list">CAPTION</div> -->
  
  <!-- BEGIN BTN GROUP -->
  <button type="button" title="New Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> </b></button>
<div class="list">New</div>
  <button type="button" title="Save Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> </b></button>
<div class="list">Save</div>
   <?php
      echo'<button type="button" title="Edit Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> </b></button>
<div class="list">Edit</div>';
   ?>
  <button type="button" title="Cancel" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button>
<div class="list">Cancel</div>
  <button type="button" title="Print" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> </b></button>
<div class="list">Print</div>

   <?php
    echo'<button type="button" title="Delete Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> </b></button>
<div class="list">Delete</div>';
   ?>

  <button type="button" title="Customer Logs" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> </b></button>
<div class="list">Logs</div>
  <button type="button" title="Unpaid" class="pop-btn btn-xx btn btn-default btn-success headbtn client-btnunpaid"><b><i class="fa fa-money unpaid_btn"></i> </b></button>
<div class="list">Unpaid</div>
  <button type="button"  title="Orders" class="pop-btn btn-xx btn btn-default btn-success headbtn client-orders"><b><i class="fa fa-tags order_btn"></i> </b></button>
<div class="list">Orders</div>


 <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
  <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
  <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
  <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>

<?php }else{ ?>

  <button type="button" title="New Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> </b></button>
<div class="list">New</div>
  <button type="button" title="Save Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> </b></button>
<div class="list">Save</div>
  <button disabled="true" type="button" title="Edit Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> </b></button>
<div class="list">Edit</div>
  <button type="button" title="Cancel" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button>
<div class="list">Cancel</div>
  <button disabled="true" type="button" title="Print" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> </b></button>
<div class="list">Print</div>
  <button disabled="true" type="button" title="Delete Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> </b></button>
<div class="list">Delete</div>
  <button disabled="true" type="button" title="Customer Logs" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> </b></button>
<div class="list">Logs</div>
  <button disabled="true" type="button"  title="Unpaid" class="pop-btn btn-xx btn btn-default btn-success headbtn client-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> </b></button>
<div class="list">Unpaid</div>
  <button disabled="true" type="button" title="Orders" class="pop-btn btn-xx btn btn-default btn-success headbtn client-orders"><b><i class="fa fa-tags order_btn"></i> </b></button>
<div class="list">Orders</div>
  

  <button disabled="true" id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
  <button disabled="true" id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
  <button disabled="true"id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
  <button disabled="true" id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>
  <!-- <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="fa fa-minus"></i></button>
<div class="list">CAPTION</div> -->
 <?php } ?>


</ul>
</div> <!-- dragme end -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="clientid" name ="clientid" class="moduletxt" value="<?php echo  $customerdata['clientid']; ?>">

        <div class="col-md-12">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">

                  <b><h6 class="txtclientid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Client ID: <?php if(isset($customerdata)){echo $customerdata['clientid'];} ?></h6></b>

                  <div class="btn-x pull-right">
                      <div class="btn-group">
                      <?php if(!empty($customerdata['clientid'])){?>
                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                         <?php
                            echo'<button type="button" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>';
                         ?>
                        <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> Print</b></button>

                         <?php
                          echo'<button type="button" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>';
                         ?>

                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>

                        <button type="button" class="btn btn-default btn-success headbtn client-btnunpaid"><b><i class="fa fa-money unpaid_btn"></i> Unpaid</b></button>

                        <button type="button" class="btn btn-default btn-success headbtn client-orders"><b><i class="fa fa-tags order_btn"></i> Orders</b></button>


                       <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>

                      <?php }else{ ?>

                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> Print</b></button>
                        <button disabled="true" type="button" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn client-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> Unpaid</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn client-orders"><b><i class="fa fa-tags order_btn"></i> Orders</b></button>
                        

                       <button disabled="true" id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button disabled="true" id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button disabled="true"id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button disabled="true" id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                        <!-- <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="fa fa-minus"></i></button> -->
                       <?php } ?>
                        </div>
                       </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                  <div class="box-body">
                    <div class="pull-right" style="margin-top:-15px;">
                    </div>
                    <div class="invoice-info col-md-12" style="margin-left:-15px;">
                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Client:  
                                <div class="input-group">
                                    <input name = "client" value ="<?php if(isset($customerdata)){echo $customerdata['client'];}?>" type="text" class="moduletxt txtclient input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>

                            <h6 class="aimslabel" style="display:block;">
                                <b>Name: <input name="clientname" value ="<?php if(isset($customerdata)){echo $customerdata['clientname'];}?>" type="text" class="moduletxt txtclientnameview form-control input-sm" disabled="true"></b>
                            </h6>

                         
                            <h6 class="aimslabel"><b>Address: <textarea  disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($customerdata)){echo $customerdata['addr'];}?></textarea></b></h6>

                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                              case 'SOUTHCENTRAL':
                                $styler = 'style="display:block;"';
                                break;
                              
                              default:
                                $styler = 'style="display:none;"';
                                break;
                            }//END IF
                            ?>

                            <h6 <?php echo $styler; ?> class="aimslabel"><b>Collection Area :
                            <div class="input-group">
                                 <input name="collectionarea" disabled="true" value ="<?php if(isset($customerdata)){echo $customerdata['collectionarea'];}?>" type="text" class="moduletxt txtclientcollection form-control input-sm">
                                 <div class="input-group-addon"><a style="display:none;" class ="proplookup clientcollctionlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                 <input type="hidden" class="moduletxt txtcollectionid" name="collectionid" value="<?php if(isset($customerdata)){echo $customerdata['collectionareaid'];}?>"">
                            </div></h6>

                            <h6 class="aimslabel"><b>Group Code:
                            <div class="input-group">
                                 <input name="grpcode" readonly value ="<?php if(isset($customerdata)){echo $customerdata['grpcode'];}?>" type="text" class="moduletxt txtclientgrpcode form-control input-sm">
                                 <div class="input-group-addon"><a style="display:none;" class ="proplookup clientgrpcodelookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div></h6>
                            
                            </div><!-- /.col -->

                            <div class="invoice-col col-md-3">
                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                              case 'KINGGEORGE':
                                $contactperlabel = "Owner:";
                              break;
                              
                              default:
                                $contactperlabel = "Contact Person:";
                              break;
                            }//END SWITCH
                            ?>
                            <h6 class="aimslabel"><b> <?php echo $contactperlabel;?><input name="contact" value ="<?php if(isset($customerdata)){echo $customerdata['contact'];}?>" type="text" class="moduletxt txtclientcontact form-control input-sm" disabled="true"></b></h6>

                            <h6 class="agentlookup" style="display: none;"><b>Agent:  
                                <div class="input-group">
                                    <input id = "clientagentcode" name = "agentcode" readonly="true" value ="<?php if(isset($customerdata)){echo $customerdata['agentcode'];}?>" type="text" class="moduletxt txtagentcode input-sm form-control" disabled="true"><div class="frmdocumentno input-group-addon"><a class ="agentlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>

                            <h6 class="agentlookupview"><b>Agent: <input name="agentcodeview" value ="<?php if(isset($customerdata)){echo $customerdata['agentcode'];}?>" type="text" class="moduletxt agentlookupview2 input-sm form-control" disabled="true"></b></h6>

                           <h6 class="aimslabel"><b>Telephone #: <input name="tel" value ="<?php if(isset($customerdata)){echo $customerdata['tel'];}?>" type="text" class="moduletxt txtclienttel form-control input-sm" disabled="true"></b></h6>

                          <h6 class="aimslabel"><b>Group :
                          <div class="input-group">
                               <input disabled="true" name="groupid" value ="<?php if(isset($customerdata)){echo $customerdata['groupid'];}?>" type="text" class="moduletxt txtclientgroupid form-control input-sm">
                               <div class="input-group-addon"><a style="display:none;" class ="proplookup clientgrpidlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                          </div></h6>


                          <h6 class="aimslabel"><b>Sales Account:</b>
                          <div class="input-group">
                              <input readonly name="rev" value="<?php if(isset($customerdata)){echo $customerdata['rev'];}?>" type="text" class="moduletxt txtsalesaccnt form-control input-sm">
                              <div class="input-group-addon"><a style="display:none;" class ="btnclientrev proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                          </div></h6>

                                    
                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Fax #: <input name="fax" value ="<?php if(isset($customerdata)){echo $customerdata['fax'];}?>" type="text" class="moduletxt txtclientfax form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Mobile: <input name="tel2" value ="<?php if(isset($customerdata)){echo $customerdata['tel2'];}?>" type="text" class="moduletxt txtclienttel2 form-control input-sm" disabled="true"></b></h6>
                          
                            <h6 class="aimslabel"><b>Email Address: <input name="email" value ="<?php if(isset($customerdata)){echo $customerdata['email'];}?>" type="text" class="moduletxt txtclientemail form-control input-sm" disabled="true"></b></h6>
                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                              case 'SOUTHCENTRAL':
                                echo '<h6 class="aimslabel"><b>Route :
                                <div class="input-group">
                                     <input name="route" readonly value ="';
                                     if(isset($customerdata)){
                                      echo $customerdata['route'];
                                      }//end if
                                     echo '" type="text" class="moduletxt txtroute form-control input-sm">
                                     <div class="input-group-addon"><a style="display:none;" class ="proplookup routelookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                     <input type="hidden" value="';
                                     if(isset($customerdata)){
                                      echo $customerdata['routeid'];
                                      }//end if
                                     echo '" class="moduletxt txtrouteid" name="routeid">
                                </div></h6>';                      
                                break;
                              
                              default:
                                echo '<h6 class="aimslabel"><b>Category :
                                <div class="input-group">
                                     <input readonly name="category" disabled="true" value ="';
                                     if(isset($customerdata)){echo $customerdata['category'];}
                                     echo'" type="text" class="moduletxt txtclientcat form-control input-sm">
                                     <div class="input-group-addon"><a style="display:none;" class ="proplookup clientcatlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                     <input type="hidden" value="';
                                     if(isset($customerdata)){echo $customerdata['categorynameid'];}
                                     echo '" class="moduletxt txtcategoryid" name="categoryid">
                                </div></h6>';
                                break;
                            }//END SWITCH
                            ?>

                            <h6 class="aimslabel"><b>Business Style: <input name="bstyle" value ="<?php if(isset($customerdata)){echo $customerdata['bstyle'];}?>" type="text" class="moduletxt txtclientbstyle form-control input-sm" disabled="true"></b></h6>
                        </div><!-- /.col -->


                        <div class="invoice-col col-md-3">

                            
                       <h6 class="aimslabel termsview"><b>Terms: <input name="termview"  disabled="true" value="<?php if(isset($customerdata)){echo $customerdata['terms'];}?>" type="text" class="txttermsview moduletxt form-control input-sm"></b></h6>

                      <h6 class="aimslabel termslookup" style="display:none;"><b>Terms :</b>
                        <div class="input-group">
                            <input readonly="" name="terms" value="<?php if(isset($customerdata)){echo $customerdata['terms'];}?>" type="text" class="moduletxt txtterms form-control input-sm">
                            <div class="input-group-addon"><a class ="btnshowterms" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                        </div></h6>

                      <h6 class="aimslabel"><b>T.I.N #: <input name="tin" value ="<?php if(isset($customerdata)){echo $customerdata['tin'];}?>" type="text" class="moduletxt txtclienttin form-control input-sm" disabled="true"></b></h6>                          

                      <h6 class="aimslabel"><b>Price Group:
                             <select disabled = "true" id="pricegroup" class="pricegroup input-sm form-control"><?php if(isset($customerdata)){echo '<option>'.$customerdata['pricegroup'] . '</option>';}?></select>
                      </h6>

                      <?php
                      switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                          $styler = 'style="display:block;"';
                          break;
                        
                        default:
                          $styler = 'style="display:none;"';
                          break;
                      }//END IF
                      ?>
                      <h6 <?php echo $styler;?> class="aimslabel"><b>Distribution Area :
                      <div class="input-group">
                           <input name="distributionarea" disabled="true" value ="<?php if(isset($customerdata)){echo $customerdata['distributionarea'];}?>" type="text" class="moduletxt txtclientdistribution form-control input-sm">
                           <div class="input-group-addon"><a style="display:none;" class ="proplookup clientdistributionlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                           <input type="hidden" class="moduletxt txtdistributionid" value="<?php if(isset($customerdata)){echo $customerdata['distributionareaid'];}?>" name="distributionid">
                      </div></h6>

                        </div><!-- /.col -->
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

        <div class="row">
        <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs bg-green">
                  <li id="acctgtab" class="clickacctg clienttabs"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>
                  <li id="inventorytab" class="clickinventory clienttabs"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>
                  <li id="profiletab" class="active clienttabs"><a href="#tab_4" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Profile</a></li>
                  <li class="clickable customerstats clienttabs"><a aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Stats</a></li>

                  <?php 
                    switch (Yii::$app->systemsettings->companyConfig()) {
                      // WTODO JAD 03-15-2019 customer Activity Notes
                      case 'SBC':
                        echo "<li id='activitynotes' class='clienttabs'><a href='#tab_5' data-toggle='tab' aria-expanded='true' style='font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);'>Activity Notes</a></li>";
                      break;
                    }//end switch
                  ?>

                  <li class="pull-right"><h6 class="acctgbal" style="display:none;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">BALANCE : 0.00</h6></li>    
                  <li class="pull-right"><h6 class="acctgcredit" style="display:none;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">CREDIT : 0.00</h6></li>
                <li class="pull-right"><h6 class="acctgdebit" style="display:none;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">DEBIT : 0.00</h6></li>
                </ul>



                <div class="tab-content">


                <div class="tab-pane" id="tab_5">
                  <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success btn-xs customer-act-add-note" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Add Note</button>
                        <div class="box box-solid box-success"><div class="clientactnotes"></div></div><!-- /.box -->
                    </div>
                  </div>
                </div>
                  
                <div class="tab-pane" id="tab_1">
                <?php 
                if ($customerdata['clientname'] == ""){
                echo '<div class="row acctgdateid" style="display:none;">';
                }else{
                echo '<div class="row acctgdateid">';
                }
                ?>
                
                <div class="col-md-6">
                <label class="aimslabel">Filter Start Date (will show transactions from Start Date until Today): </label>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo $finaldate;?>"  class="paedit input-group date dpYears">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down clientfilterlookup"></i></a></div>
                <input type="text" name = "dateid" readonly="" value="<?php echo $finaldate;?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                </div>
                </div>
                <div class="col-md-3">
                <label class="aimslabel">&nbsp</label>
                <select style="display: inline;" class="selectacctg input-sm form-control clientfilter">
                <option>AR</option>
                <option>AP</option>
                <option>PDC</option>
                <option>RC</option>
                </select>
                </div>

                <div class="col-md-3">
                <br>
                <button style="margin-top: 5px;" class="clientfilter btn btn-success btn-flat btn-sm" id="btnrefreshledger"><i class="fa fa-refresh"></i> Refresh</button>
                </div>
                </div>
                </br>
                   <div class="row">
                      <div class="col-md-12">
                        <div class="accttable" style='margin-bottom:25px;'></div>
                      </div>
                    </div>
                  </div>
                    <div class="tab-pane " id="tab_2">
                       <?php 
                        if ($customerdata['clientname'] == ""){
                        echo '<div class="row acctgdateid" style="display:none;">';
                        }else{
                        echo '<div class="row acctgdateid">';
                        }
                      ?>
                      
                      <div class="col-md-6">
                      <h6 class="aimslabel acctgdateid" style="display: inline;"><b>Search Keywords: </b>
                        <input name="search" value ="" type="text" class="txtinventorysearch form-control input-sm">
                      </div>

                      <div class="col-md-4">
                      <h6 class="aimslabel acctgdateid" style="display: inline;"><b>Cutoff Date (To Latest): </b>
                      <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo $finaldate;?>"  class="paedit input-group date dpYears">
                        <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="clientfilterlookup fa fa-chevron-circle-down" ></i></a></div>
                        <input id="xdateid" type="text" readonly="" value="<?php echo $finaldate;?>" size="12" class="form-control input-sm" >
                        </div>
                      </div>

                      <div class="col-md-2">
                      <button style="margin-top:1em;" class="clientfilter btn btn-success btn-flat" id ="btninventory">Load Data</button>
                      </div>
                    </div>
                      
                    </br>

                         <div class="row">
                            <div class="col-md-12">
                               <div class="computeinvdiv" style='margin-bottom:25px;'></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="tab_3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-solid box-success">
                                    <div class="box-body">

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>

                    <?php
                      switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                          echo '<div class="tab-pane " id="tab_6">
                                    <button class="btn btn-success saveotherremarks btn-xs" style="margin-bottom: 10px;"><i class="fa fa-save"></i> Save Other Remarks</button>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-solid box-success">
                                                <div class="box-body">';

                                                echo '<div class="col-md-4">
                                                      <h6 class="aimslabel"><b>REMARKS 1: <textarea id="rem1" name="rem1" class="activeform othernote form-control" style="resize:none;" rows="2" cols="50"></textarea></b></h6>
                                                      </div>';
                                                
                                                echo '<div class="col-md-4">
                                                      <h6 class="aimslabel"><b>REMARKS 2: <textarea id="rem2" name="rem2" class="activeform othernote form-control" style="resize:none;" rows="2" cols="50"></textarea></b></h6>
                                                      </div>';

                                                echo '<div class="col-md-4">
                                                      <h6 class="aimslabel"><b>REMARKS 3: <textarea id="rem3" name="rem3" class="activeform othernote form-control" style="resize:none;" rows="2" cols="50"></textarea></b></h6>
                                                      </div>';

                                                echo '</div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div>
                                    </div>
                                </div>';
                        break;
                      }//end switch
                    ?>

                    <div class="tab-pane active" id="tab_4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-solid box-success">
                                    <div class="box-body">
                                          <div class="invoice-col col-md-2">
                                            <h6 class="aimslabel"><b>Started: <input name="started" placeholder="format (yyyy-mm-dd)" value ="<?php if(isset($customerdata)){echo $customerdata['start'];}?>" type="text" class="moduletxt txtclientstarted form-control input-sm" disabled="true"></b></h6>

                                            <h6 class="aimslabel"><b>Credit Limit: <input name="crlimit" value ="<?php if(isset($customerdata)){echo $customerdata['crlimit'];}?>" type="text" class="moduletxt txtclientcrlimit form-control input-sm" disabled="true"></b></h6>

                                            
                                            <h6 class="aimslabel" style="display: none;"><b>Ad Fee (Charge 1): <input name="charge1" value ="<?php if(isset($customerdata)){echo $customerdata['charge1'];}?>" type="text" class="moduletxt txtclientcharge1 form-control input-sm" disabled="true"></b></h6>

                                            <h6 class="aimslabel" style="display: none;"><b>Royalt Fee (Charge 2): <input name="charge2" value ="<?php if(isset($customerdata)){echo $customerdata['charge2'];}?>" type="text" class="moduletxt txtclientcharge2 form-control input-sm" disabled="true"></b></h6>

                                          </div><!-- /.col -->

                                        <div class="invoice-col col-md-3">
                                            <?php
                                            switch (Yii::$app->systemsettings->companyConfig()) {
                                              case 'SOUTHCENTRAL':
                                                echo '<h6 class="aimslabel"><b>City / Municipality
                                                  <div class="input-group">
                                                       <input disabled="true" name="sccity" value ="';
                                                        //PUT CITY VALUE
                                                       if(isset($customerdata)){
                                                        echo $customerdata['sccity'];
                                                        }
                                                    echo '" type="text" class="moduletxt txtclientsccity form-control input-sm">
                                                       <div class="input-group-addon"><a style="display:none;" class ="proplookup sccitylookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                                    <input type="hidden" name="sccityid" class="moduletxt txtclientsccityid" value="';
                                                      //PUT CITY ID VALUE
                                                      if(isset($customerdata)){
                                                        echo $customerdata['sccityid'];
                                                      }
                                                    echo '">
                                                  </div></h6>';

                                                  echo '<h6 class="aimslabel"><b>Province: 
                                                       <input disabled="true" name="scprovince" value ="';
                                                        //PUT PROVINCE VALUE
                                                       if(isset($customerdata)){
                                                        echo $customerdata['scprovname'];
                                                        }
                                                  echo '" type="text" class="txtclientscprovince form-control input-sm">
                                                  </h6>';

                                                  echo '<h6 class="aimslabel"><b>Territory: 
                                                       <input disabled="true" name="scterritory" value ="';
                                                        //PUT TERRITORY VALUE
                                                       if(isset($customerdata)){
                                                        echo $customerdata['scterrname'];
                                                        }
                                                  echo '" type="text" class="txtclientscterritory form-control input-sm">
                                                  </h6>';
                                                break;
                                              
                                              default:
                                                echo '<h6 class="aimslabel"><b>Area: 
                                                <div class="input-group">
                                                     <input disabled="true" name="area" value ="';
                                                     if(isset($customerdata)){
                                                      echo $customerdata['area'];
                                                      }
                                                echo '" type="text" class="moduletxt txtclientarea form-control input-sm">
                                                     <div class="input-group-addon"><a style="display:none;" class ="proplookup arealookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                                </div></h6>


                                                <h6 class="aimslabel"><b>Province: 
                                                <div class="input-group">
                                                     <input disabled="true" name="province" value ="';
                                                if(isset($customerdata)){
                                                  echo $customerdata['province'];
                                                }
                                                echo '" type="text" class="moduletxt txtclientprovince form-control input-sm">
                                                     <div class="input-group-addon"><a style="display:none;" class ="proplookup provincelookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                                </div></h6>


                                                <h6 class="aimslabel"><b>Region: 
                                                <div class="input-group">
                                                     <input disabled="true" name="region" value ="';
                                                if(isset($customerdata)){
                                                  echo $customerdata['region'];
                                                }
                                                echo '" type="text" class="moduletxt txtclientregion form-control input-sm">
                                                     <div class="input-group-addon"><a style="display:none;" class ="proplookup regionlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                                </div></h6>';
                                                break;
                                            }//END SWITCH CASE
                                            ?>

                                            <!-- <h6 class="aimslabel"><b>Status: <input name="status" value ="<?php if(isset($customerdata)){echo $customerdata['status'];}?>" type="text" class="moduletxt txtclientstatus form-control input-sm" disabled="true"></b></h6> -->
                                            
                                            <h6 class="aimslabel"><b>Status:
                                                <select disabled = "true" name="status" id="cstatus" class="moduletxt txtclientstatus input-sm form-control">
                                                <?php if(isset($customerdata)){
                                                  echo '<option>'.$customerdata['status'] . '</option>';
                                                }?></select>
                                            </h6>    
                                                                   
                                          </div><!-- /.col -->  
                                              <div class="invoice-col col-md-3">
                                              <label style="margin-top:10px;">Tagging</label></br>
                                                <input disabled="true" name = "iscustomer" style="margin-left:7px;" class ="checkediscustomer clientboxes" type="checkbox"
                                                <?php if(isset($customerdata)){if($customerdata['IsCustomer'] == 1){echo "checked";}}?>>
                                                <label>Customer</label></br>
                                                <input style="margin-left:7px;" disabled="true" class ="clientboxes checkedisagent" type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsAgent'] == 1){echo "checked";}}?>>
                                                <label>Agent</label></br>
                                               <input style="margin-left:7px;" disabled="true" class ="clientboxes checkedissupplier" type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsSupplier'] == 1){echo "checked";}}?>>
                                               <label>Supplier</label></br>
                                               <input style="margin-left:7px;" disabled="true" class ="checkediswarehouse clientboxes"type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsWarehouse'] == 1){echo "checked";}}?>>
                                               <label>Warehouse</label></br>
                                                <input style="margin-left:7px;" disabled="true" class ="checkedisemployee clientboxes"type="checkbox" 
                                                <?php if(isset($customerdata)){if($customerdata['IsEmployee'] == 1){echo "checked";}}?>>
                                                <label>Employee</label></br>
                                               <input style="margin-left:7px;" disabled="true" class ="checkedishold clientboxes" type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsInactive'] == 1){echo "checked";}}?>>
                                               <label>Hold Customer</label></br>

                                               <input style="margin-left:7px;" disabled="true" class ="checkedisexempt clientboxes" type="checkbox"  <?php if(isset($customerdata)){if($customerdata['IsExempt'] == 1){echo "checked";}}?>>
                                               <label>Charge Exempted </label></br>

                                              </div><!-- /.col --> 

                                              <div class="invoice-col col-md-2">
                                              <h6 class="aimslabel picbox">
                                              <?php if(isset($customerdata)){
                                                if(empty($customerdata['picture'])){
                                                  $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                                }else{
                                                  $str = $customerdata['picture'];
                                                }
                                              }else{
                                                $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                              }
                                              ?>
                                              <img src ="<?php echo $str;?>" width="160px" height ="150px" class="thumbnail recordpicture">
                                              <?php
                                              $url = "/". $moduleid ."/". "uploadpic/";
                                              ?>
                                              <form id ="picupload" method="POST" enctype="multipart/form-data">
                                              <span id="fileselector">
                                                  <label class="btn btn-default" for="upload-file-selector" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                                      <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture">
                                                      <i class="fa fa-upload margin-correction"></i>Browse Pic
                                                  </label>
                                              </span>

                                              <button type = "submit" class="uploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                              <button type = "button" class="uploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                              </form>
                                              </h6>
                                              </div>


                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>


                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
    </div>
    </div>