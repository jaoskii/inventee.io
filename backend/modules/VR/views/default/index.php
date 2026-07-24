<?php
use yii\helpers\Url;
$this->title = 'Reimbursement Release';
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

    <div class="col-md-12">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                
                <div class="col-md-12">
                        <div class="col-md-3">
                            <h6 class="aimslabel dateidlookup"><b>Date: 
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                              <input type="text" name = "dateid" 
                              size="12" class="moduletxt vrtxtdateid form-control input-sm" disabled>
                            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down" style="color: #72AFD2;"></i></a></div>
                            </div></b>
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <h6 class="aimslabel"><b>Status:
                             <select id="vrstatus" class="input-sm form-control">
                                 <option value="app">APPROVED</option>
                                 <option value="nya">NOT YET APPROVED</option>
                             </select>
                             <!-- <?php if(isset($customerdata)){echo '<option>'.$customerdata['pricegroup'] . '</option>';}?> -->
                            </h6>    
                        </div>

                        <div class="col-md-3">
                            <h6 class="aimslabel"><b>User:  
                                <div class="input-group">
                                    <input name = "username" value ="" type="text" class="moduletxt txtvruser input-sm form-control" readonly><input name = "userid" value ="" type="hidden" class="moduletxt vrtxtid input-sm form-control"><div class="input-group-addon"><a class ="vruserlookup" href="#"><i class="fa fa-chevron-circle-down" style="color: #72AFD2;"></i></a></div>
                                </div>
                            </h6>
                        </div>
                        <div class="col-md-3 btn-group">
                          <h6 class="aimslabel">
                          <button type="button" data-toggle="tooltip" title="View" class="btn btn-default btn-success headbtn btnactive vrbtnview"><b><i class="fa fa-search new_btn"></i> View</b></button>    
                          </h6>
                        </div>
                </div>
        
            </div>
            <div class="box-body">
                     <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                         <div class="row">
                            <div class="col-md-12">
                              <?php 
                                // if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                                // if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                              // poststatus="'.$isposted.'" lockedstatus="'.$islocked.'"
                                echo '<div id="memschedview"  class="box box-solid box-success"></div>'
                              ?>
                            </div>
                         </div>
                        </div>
                     <!-- /.tab-pane -->
                    </div>
                    <div class="divapp" style="display:none;">
                      
                        <button type="button" data-toggle="tooltip" title="Approve" class="btn btn-default btn-success headbtn btnactive theapprover"><b><i class="fa fa-check new_btn"></i> Approve</b></button>    
                    </div>
            </div>
     

        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div> <!-- END COL MD 9 -->