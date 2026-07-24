<div class="row">
<div class="col-md-12">
     
                  <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>
              <li class=""><a class="clickable showacctg" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>
              
              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['grandtotal'];} ?></h6></li>

              <li class="pull-right"><h6 class="txtitemcount" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['itemcount'],Yii::$app->systemsettings->setDecimaldisplay('currency'));} ?></h6></li>

              <?php
              switch(Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                  echo '<li class="pull-right"><h6 class="txttotalkilo" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL QTY: ';
                  if(isset($moduledata)){echo $moduledata['head']['totalkilo'];}
                  echo '</h6></li>';
                  break;
                
                default:
                  echo '<li style="display:none;" class="pull-right"><h6 class="txttotalkilo" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL QTY: ';
                  if(isset($moduledata)){echo $moduledata['head']['totalkilo'];}
                  echo '</h6></li>';
                  break;
              }//END SWITCH
              ?>
            </ul>
              
            <!-- <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                            <div class="box-body mod-tble">
                             <table class="table tbl-fix bodytable table-hover">
                              <thead>
                                  <tr>
                                      <th class="col-min aimslabel"><span class="text">Options</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                                      <th class="col-quantity aimslabel"><span class="text">Qty</span></th>
                                      <th class="col-min aimslabel"><span class="text">UOM</span></th>
                                      <th class="col-description aimslabel"><span class="text">Item Name</span></th>
                                      <th class="col-currency aimslabel"><span class="text">Price</span></th>
                                      <th class="col-min aimslabel"><span class="text">Discount</span></th>
                                      <th class="col-currency aimslabel"><span class="text">Total Price</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Warehouse</span></th>
                                       --><?php
                                      // switch (Yii::$app->systemsettings->companyConfig()) {
                                      //   case 'YULICK':
                                      //     echo '<th style = "display:none;" class="col-codes aimslabel"><span class="text">Location</span></th>';
                                      //     break;
                                        
                                      //   default:
                                      //     echo '<th class="col-codes aimslabel"><span class="text">Location</span></th>';
                                      //     break;
                                      // }
                                      ?>
                                      <!-- <th class="col-codes aimslabel"><span class="text">Expiry</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Reference</span></th>
                                      <th class="col-description aimslabel"><span class="text">Notes</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody"> -->
                               <?php
                               // if(isset($moduledata['body']) && $moduledata['body'] != ""){
                               //    foreach ($moduledata['body'] as $itmindex => $itmdata) {
                               //      echo'<tr id="orgrow-'.$itmdata['line'].'" class="orgrow">
                               //      <td id="stockbuttons-'.$itmdata['line'].'"  class="origdata btnstockopt col-min aimslabelstock">';
                               //        if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
                               //        echo'<button id="stockedit-'.$itmdata['line'].'" class="stockbtn stockeditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                               //        <button id="stockdelete-'.$itmdata['line'].'" class="stockbtn stockdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>
                               //        <button class="stockbtn stockattrbtn btn btn-social-icon btn-github" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px; margin-top:-8px;" class="fa fa-eye"></i></button>';
                               //        }else{
                               //        echo'<button id="stockedit-'.$itmdata['line'].'" class="stockbtn stockeditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                               //        <button id="stockdelete-'.$itmdata['line'].'" class="stockbtn stockdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>
                               //        <button id = "showbalance-'.$itmdata['itemid'].'" class="stockbtn showbalance stockattrbtn btn btn-social-icon btn-github" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px; margin-top:-8px;" class="fa fa-eye"></i></button>';
                               //        }
                               //      echo '</td>

                               //      <td id="stockbarcode-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['barcode'].'</td>
                               //      <td id="stockisqty-'.$itmdata['line'].'" class="origdata col-quantity aimslabelstock">'.number_format($itmdata['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')).'</td>
                               //      <td id="stockuom-'.$itmdata['line'].'" class="origdata col-min aimslabelstock">'.$itmdata['uom'].'</td>
                               //      <td id="stockitemname-'.$itmdata['line'].'" class="origdata col-description aimslabelstock">'.$itmdata['itemname'].'</td>
                               //      <td id="stockisamt-'.$itmdata['line'].'" class="origdata col-currency aimslabelstock">'.number_format($itmdata['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</td>
                               //      <td id="stockdisc-'.$itmdata['line'].'" class="origdata col-min aimslabelstock">'.$itmdata['disc'].'</td>
                               //      <td id="stockext-'.$itmdata['line'].'" class="origdata col-currency aimslabelstock">'.number_format($itmdata['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</td>                                   
                               //      <td id="stockwhcode-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['whcode'].'</td>';

                               //      switch (Yii::$app->systemsettings->companyConfig()) {
                               //          case 'YULICK':
                               //            echo'<td style="display:none;" id="stockloc-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['loc'].'</td>';
                               //            break;
                                        
                               //          default:
                               //            echo'<td id="stockloc-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['loc'].'</td>';
                               //            break;
                               //        }//end switch
                                    
                               //      echo'<td class="origdata aimslabelstock col-codes" id="stockexpiry-'.$itmdata['line'].'">'.$itmdata['expiry'].'</td>      
                               //      <td id="stockref-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['ref'].'</td>
                               //      <td id="stockrem-'.$itmdata['line'].'" class="origdata col-description aimslabelstock">'.$itmdata['rem'].'</td>
                               //      <td id="stockwh-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['wh'].'</td>                                    
                               //      <td id="stockiss-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['iss'].'</td>
                               //      <td id="stockamt-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['amt'].'</td>
                               //      <td id="stockrefx-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['refx'].'</td>
                               //      <td id="stocklinex-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['linex'].'</td>
                               //      <td id="stockline-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['line'].'</td>
                                    
                               //    </tr>';
                               //    }
                               // }
                               ?>
                                <!-- </tbody> -->
                            <!-- </table>   -->
                        <!-- </div>/.box-body -->
                        <!-- </div>/.box -->
                    <!-- </div> -->
              <!-- </div> -->
              <!-- </div> -->
              <!-- /.tab-pane -->
            <!-- </div> -->
            <!-- /.tab-content -->
          <!-- </div> -->

          <!--savepoint-->
          <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                    <label class="clickable viewcopyclipboard"><i class="fa fa-copy"></i> [Copy Stock Details to Clipboard]</label>                      
                              <?php 
                                if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                                if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                                echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success"></div>'
                              ?>
                    </div>
              </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
</div>
</div>
</div>