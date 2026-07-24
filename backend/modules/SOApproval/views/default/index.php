<?php

use yii\db\Query;
use yii\grid\GridView;
use yii\helpers\Html;
    $this->title = 'SO Approval';


$script = <<< JS
    $(document).ready(function(){  });
JS;
$this->registerJs($script);

$this->registerCss("
        
    ");
?>
<div class="row">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
    <input type="hidden" id="savingtype">
    <input type="hidden" id="empcode">
        <div class="box box-solid box-success" style='border-top-left-radius:7px;border-top-right-radius:7px;'>
            <div class="modulehead box-header with-border">
                <div>
                    <div class="btn-group">
                        <!-- <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn btnsavepayentry" style='color:white;'><b><i class="save_btn fa fa-save"></i> Save</b></button>

                        <button type="button" data-toggle="tooltip" title="Edit" class="btn btn-default btn-success headbtn btneditpayentry" style='color:white;'><b><i class="save_btn fa fa-pencil"></i> Edit</b></button> -->

                        <button type="button" class="btn btn-default btn-success headbtn btnsoapprove" style="color:white;"><b><i class="fa fa-check"></i> Approve</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn btnsoaupdate" style="color:white;"><b><i class="fa fa-check"></i> Update Remarks Only</b></button>
                    </div>
                </div>
            </div> 

        </div>

<div class="box-body">
    <div class="panel panel-success col-md-12" style='margin:5px 5px 5px 10px;'>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="aimslabel"><b>Document #:  
                            <div class="input-group">
                                <input name = "docno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['docno'];}?>" type="text" class="moduletxt txtsoadocno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="soadocnolookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div></h6>
                                    

                            <h6 class="aimslabel"><b>SO Date: <input name="soatxtdate" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoadate form-control input-sm" disabled="true"></b></h6>
                            
                            <h6 class="aimslabel"><b>Code: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoaclientcode form-control input-sm" disabled="true"></b></h6>
                                    
                            <h6 class="aimslabel"><b>Name: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoaclientname form-control input-sm" disabled="true"></b></h6>
                            
                            <h6 class="aimslabel"><b>Customer Status: <input name="soatxtcustomerstatus" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt soatxtcustomerstatus form-control input-sm" disabled="true"></b></h6>
                            
                            <h6 class="aimslabel"><b>Agent: <input name="soatxtagent" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt soatxtagent form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Reason: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoareason form-control input-sm"></b></h6>
                        </div>
                        <div class="col-md-6">
                            <h6 class="aimslabel"><b>Unserved SO: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoaunserved form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Unpaid: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoaunpaid form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>PDC: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoapdc form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>S.O Total: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoatotal form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>GrandTotal: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtgrandtotal form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>CR Limit: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoacrlimit form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Remark: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtsoarem form-control input-sm"></b></h6>

                            <h6 class="aimslabel"><b>Reason Disapproved: <input disabled name="clientname" value ="" type="text" class="txtsoareason2 form-control input-sm"></b></h6>
                        </div>
                    </div>


                        </div>
                        </div>
</div>