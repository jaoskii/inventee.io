<?php
use yii\helpers\Url;
$this->title = 'Chart of Accounts (COA)';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF


$current = date("Y-m-d");
$cmonth = date('m');
$cmonth = date('Y');
$date = strtotime($current .' -6 months');
$previous=date('Y-m-d', $date);
$pmonth = date('m',$date);
$pyear = date('Y',$date);

?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<div class="col-md-7">
      <div class="box box-solid box-success">
                    <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Chart of Accounts</h6></b>
                <div class="pull-right">
                <li class="btncoa-addgrandgrandparent btn btn-xs btn-flat"><i class="fa fa-plus"></i> Add Type of Account</li>
                <li class="btncoa-search btn  btn-xs btn-flat"><i class="fa fa-search"></i> Search Account</li>
                <li class="btncoa-checkrequired btn y btn-xs btn-flat"><i class="fa fa-check"></i> Check Required Aliases</li>
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

<div class="col-md-5">
      <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Account Attributes</h6></b> 
                
                <div id="clegend">
                <span> Legend<i class="new_btn fa fa-list-alt"></i></span>
        
                <ul class="clegend-content">

                    <div class="box box-solid box-success">
                    <div class="modulehead box-header with-border">
                        <b>
                            <h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Types of Accounts</h6>
                        </b>
                    </div><!-- /.box-header -->
                    </div>
            
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                        <h6>A - Assets</h6>
                        <h6>L - Liabilities</h6>
                        <h6>C - Equity</h6>
                        <h6>R - Revenue</h6>
                        <h6>E - Expenses</h6>
                        <h6>O - Others</h6>
                        </div>
                    </div> <!--row-->
                </div><!-- /.box-body -->
                </ul>          
                </div>
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
            <button class="btncoa-details btn btn-sm btn-github btn-flat" style="display:none"><i class="fa fa-eye"></i> Show Details</button>
            <button disabled class="btncoa-edit btn btn-sm btn-info btn-flat"><i class="fa fa-pencil"></i> Edit Account</button>
            <button disabled class="btncoa-add btn btn-sm btn-info btn-flat"><i class="fa fa-plus"></i> Add Sub Account</button>
            <button  disabled class="btncoa-delete btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button>
            <button class="btncoa-save btn btn-sm btn-info btn-flat" style="display:none;"><i class="fa fa-save"></i> Save</button>
            <button class="btncoa-cancel btn btn-sm btn-danger btn-flat" style="display:none;"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div>
        </div><!-- /.box -->

        <div id="clegend-x" class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Types of Accounts</h6></b>
                </div><!-- /.box-header -->
              
            <div class="box-body" style="height:25px;">
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
        </br></br></br>
        </div><!-- /.box -->
</div><!--  END COL MD 3 -->
</div> <!-- END ROW -->