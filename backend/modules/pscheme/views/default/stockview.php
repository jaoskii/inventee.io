<div class="row">
<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>
             
             
              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['grandtotal'];} ?></h6></li>

              <li class="pull-right"><h6 class="txtitemcount" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['itemcount'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));} ?></h6></li>

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

                  // XANDABELS

                  case 'SOUTHCENTRAL':
                    echo '<li class="pull-right"><h6 class="txttotalcbm" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL CBM: ';
                    if(isset($moduledata)){echo $moduledata['head']['totalcbm'];}
                    echo '</h6></li>';

                    echo '<li class="pull-right"><h6 class="txttotaltonnage" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL TONNAGE: ';
                    if(isset($moduledata)){echo $moduledata['head']['totaltonnage'];}
                    echo '</h6></li>';
                  break;

                  // END XANDA
                  
              }//END SWITCH
              ?>
            </ul>
              
           <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                        if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                        echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success">'
                      ?>
                    </div>
                  </div>
                 
              </div>

<!-- SBC EXCLUSIVES UPDATE -->
                      <!-- /.tab-pane -->
            </div><!-- /.tab-content -->
          </div>
</div>
</div>
