<?php
use yii\helpers\Url;
$this->title = 'Frontend Logs';
?>

<div class="row">
<div class="col-md-12">
        <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Filters</h6></b>
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                    <button type="button" data-toggle="tooltip" title="Delete Selected" class="btn btn-default btn-success btnlogdelete-selected"><b><i class="fa fa-trash delete_btn"></i> Delete Selected</b></button>
                    <button type="button" data-toggle="tooltip" title="Clear Filtered" class="btn btn-default btn-success btnlogdelete-filtered"><b><i class="fa fa-trash delete_btn"></i> Clear Filtered Logs</b></button>
                    <button type="button" data-toggle="tooltip" title="Swipe delete logss" class="btn btn-default btn-success btnlogdelete-swipe"><b><i class="fa fa-trash delete_btn"></i> Swipe All Logs</b></button>
                </div>
                </div><!-- /.box-header -->
           
                <div class="box-body">
                <div class="col-md-3">
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <input type="text" name = "dateid" readonly="" value="" size="12" class="moduletxt txtdateid1 form-control input-sm" disabled="true">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down clientfilterlookup"></i></a></div>
                </div>
                </div>
                <div class="col-md-3">
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <input type="text" name = "dateid" readonly="" value="" size="12" class="moduletxt txtdateid2 form-control input-sm" disabled="true">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div>
                </div>
                <div class="col-md-3">
                <select style="display: inline;" class="input-sm form-control fronttype">
                <option></option>
                <option>VIEW_ITM_DETAIL</option>
                <option>ADD_TO_CART</option>
                <option>EMAIL</option>
                <option>REGISTER_USER</option>
                <option>USER_LOGGED_IN</option>
                <option>PLACE_ORDER</option>
                </select>
                </div>
                <div class="col-md-3">
                <button class="front-logs col-md-12 btn btn-info btn-flat">Load Filter</button>
                </div>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->
<div class="row">
<div class="col-md-12">
        <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">FRONTEND LOGS</h6></b>
                <div class="pull-right">
                
                </div>
                </div><!-- /.box-header -->
           
                            <div class="box-body mod-tble">
                            <table class="table tbl-fix bodytable">
                              <thead>
                                <tr>
                                    <th class="col-min aimslabel"><span class="text">OPTION</span></th>
                                    <th class="col-min aimslabel"><span class="text">DELETE</span></th>
                                    <th class="col-description aimslabel"><span class="text">USERNAME</span></th>
                                    <th class="col-description aimslabel"><span class="text">ACTIVITY</span></th>
                                    <th class="col-description aimslabel"><span class="text">DATE OCCURED</span></th>
                                    <th class="col-codes aimslabel"><span class="text">IP ADDRESS</span></th>
                                    <th class="col-codes aimslabel"><span class="text">REFERENCE #</span></th>
                                </tr>
                              </thead>

                                <tbody class="flog-modulebody">
                                                             
                                </tbody>
                            </table>     
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->
</br>   