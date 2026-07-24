<?php
use yii\helpers\Url;
$this->title = 'Chart of Accounts (COA)';
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<div class="col-md-8">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Chart of Accounts</h6></b>
                <div class="pull-right">
                <button class="btncoa-addgrandgrandparent btn btn-info btn-xs btn-flat"><i class="fa fa-plus"></i> Add Type of Account</button>
                <button class="btncoa-search btn btn-warning btn-xs btn-flat"><i class="fa fa-search"></i> Search Account</button>
                <button class="btncoa-checkrequired btn btn-primary btn-xs btn-flat"><i class="fa fa-check"></i> Check Required Aliases</button>
                </div>
                </div><!-- /.box-header -->
            <div class="box-body coadiv">
            <ul id="tree3">
            <li class="open" disabled>
                <a class="clickable" id ="coa-grandgrandparent">Chart of Account</a>
                <ul id="grandgrandparentacno">
                <?php
                    foreach ($moduledata as $coadata) {
                      echo '<li disabled>
                            <a class="acctgparents clickable" id="'.$coadata['acnoid'].'-'.$coadata['acno'].'">
                            '.$coadata['acno'] . ' - ' .$coadata['acnoname'].'</a>';
                        if($coadata['detail'] == 0){
                        echo'<ul id="child'.$coadata['acnoid'].'"></ul>';
                        }//END IF 
                    echo '</li>';
                    }//END FOR EACH     
                    ?>
                </ul>
            </li>
            </ul> <!--  END UL -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->

<div class="col-md-4">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Account Attributes</h6></b>
                </div><!-- /.box-header -->
              
            <div class="box-body">
            <h6 class="aimslabel">
            <input disabled name = "savingtype" value ="" type="hidden" class="coatxt txtsavingtype input-sm form-control">
            </h6>
            <h6 class="aimslabel">
            <input disabled name = "levelid" value ="" type="hidden" class="coatxt txtlevelid input-sm form-control">
            </h6>
            <h6 class="aimslabel">
            <input disabled name = "acnoid" value ="" type="hidden" class="coatxt txtacnoid input-sm form-control">
            </h6>
            <h6 class="aimslabel">
            <input disabled name = "parent" value ="" type="hidden" class="coatxt txtparent input-sm form-control">
            </h6>

            <h6 class="aimslabel"><b>Account Code (Acno): 
            <input disabled name = "acno" value ="" type="text" class="coatxt txtacno input-sm form-control">
            </h6>
            <h6 class="aimslabel"><b>Account Name:
            <input disabled name = "acnoname" value ="" type="text" class="interact coatxt txtacnoname input-sm form-control">
            </h6>
            <h6 class="aimslabel"><b>Account Alias:
            <input disabled name = "alias" value ="" type="text" class="interact coatxt txtalias input-sm form-control">
            </h6>
            <h6 class="aimslabel"><b>Type: 
            <input disabled name = "type" value ="" type="text" class="coatxt txttype input-sm form-control">
            </h6>
            <h6 class="aimslabel"><b>Parent: 
            <input disabled value ="" type="text" class="coatxt txtparentview input-sm form-control">
            </h6>
            </br>
            <div class="pull-right">
            <button disabled class="btncoa-edit btn btn-sm btn-info btn-flat">Edit Account</button>
            <button disabled class="btncoa-add btn btn-sm btn-info btn-flat">Add Sub Account</button>
            <button  disabled class="btncoa-delete btn btn-sm btn-danger btn-flat">Delete</button>
            <button class="btncoa-save btn btn-sm btn-info btn-flat" style="display:none;">Save</button>
            <button class="btncoa-cancel btn btn-sm btn-danger btn-flat" style="display:none;">Cancel</button>
            </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


        <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Types of Accounts</h6></b>
                </div><!-- /.box-header -->
              
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                    <span>A - Assets</span></br>
                    <span>L - Liabilities</span></br>
                    <span>C - Equity</span></br>
                    </div>
                    <div class="col-md-6">
                    <span>R - Revenue</span></br>
                    <span>E - Expenses</span></br>
                    <span>O - Others</span>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div><!--  END COL MD 3 -->
</div> <!-- END ROW -->