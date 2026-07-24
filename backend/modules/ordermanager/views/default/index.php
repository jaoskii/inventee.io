<?php
use yii\helpers\Url;
$this->title = 'Order Manager';
?>

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
<div class="row">
<div class="col-md-12">
        <div class="box box-solid box-success">
               

                <div class="box-body">

                <div class="col-md-1">
                <label style="margin-top: 5px;" class="aimslabel">Search Filters: </label>
                </div>

                <div class="col-md-2">
                <select id="fstatusfilter" style="margin-top: 2px;" class="input-sm form-control">
                <option></option>
                </select>
                </div>

                <div class="col-md-4">
                  <div class="input-group">
                    <input value ="" type="text" class="txtstockordersearch input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
                </div>

                <div class="col-md-1">
                <label style="margin-top: 5px;" class="aimslabel">Tag selected as: </label>
                </div>

                <div class="col-md-2">
                <select id="fstatus" style="margin-top: 2px;" class="input-sm form-control">
                <option></option>
                </select>
                </div>


                <div class="col-md-2">
                <button class="fchangestatustagging col-md-12 btn btn-success btn-flat"><i class="fa fa-refresh"></i> Change Status</button>
                </div>

                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<div class="row">
    <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

    <div class="col-md-12">
          <div class="box box-solid box-success">
               <div class="box-body scroll-divs">

                            <table class="table tbl-fix bodytable">
                              <thead>
                                  <tr>
                                    <th class="col-checkbox btblcenter aimslabel"><span class="text">&nbsp</span></th>
                                    <th class="col-codes aimslabel"><span class="text">Order Status</span></th>
                                    <th class="col-description aimslabel"><span class="text">Customer</span></th>
                                    <th class="col-codes aimslabel"><span class="text">Order #</span></th>
                                    <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                                    <th class="col-description aimslabel"><span class="text">Itemname</span></th>
                                    <th class="col-quantity aimslabel"><span class="text">Qty</span></th>
                                    <th class="col-currency aimslabel"><span class="text">Amount</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody orderlisttbl">
                                    <?php
                                        $strhtml = "";
                                        if(!empty($orders)){
                                          foreach ($orders as $key => $value) {
                                              $strhtml = $strhtml . '<tr>';
                                              $strhtml = $strhtml . '<td id="fbtngrp-'.$value['trno'].'-'.$value['line'].'" class="col-checkbox btblcenter aimslabel">';
                                              $strhtml = $strhtml . '<input type="checkbox" class="forderchecker" id="forderchecker-'.$value['trno'].'-'.$value['line'].'">';
                                              $strhtml = $strhtml . '</td>';
                                              $strhtml = $strhtml . '<td id="fstatus-'.$value['trno'].'-'.$value['line'].'" class="col-codes aimslabel">'.$value['fstatus'].'</td>';
                                              $strhtml = $strhtml . '<td id="fcustomer-'.$value['trno'].'-'.$value['line'].'" class="col-codes aimslabel">'.$value['clientname'].'</td>';
                                              $strhtml = $strhtml . '<td id="fdocno-'.$value['trno'].'-'.$value['line'].'" class="col-codes aimslabel">'.$value['docno'].'</td>';
                                              $strhtml = $strhtml . '<td id="fbarcode-'.$value['trno'].'-'.$value['line'].'" class="col-codes aimslabel">'.$value['barcode'].'</td>';
                                              $strhtml = $strhtml . '<td id="fitemname-'.$value['trno'].'-'.$value['line'].'" class="col-description aimslabel">'.$value['itemname'].'</td>';
                                              $strhtml = $strhtml . '<td id="fqty-'.$value['trno'].'-'.$value['line'].'" class="col-quantity aimslabel">'.$value['qty'].'</td>';
                                              $strhtml = $strhtml . '<td id="famt-'.$value['trno'].'-'.$value['line'].'" class="col-currency aimslabel">'.$value['amt'].'</td>';
                                              $strhtml = $strhtml . '</tr>';
                                          }//end order loop
                                        }//end if
                                        echo $strhtml;
                                    ?>
                                </tbody>
                            </table>  
                </div><!-- /.box-body -->
            </div><!-- /.box -->
    </div> <!-- END COL MD 9 -->
    </div> <!-- END ROW -->

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
