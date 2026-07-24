<?php
use yii\helpers\Url;
$this->title = 'Company Prefixes';
?>



<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="lines" value="">

<div class="col-md-12">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
              <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">COMPANY PREFIX</h6></b>
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                    <div class="btn-group">
                    <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success module-btnnewcomprefix"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success module-btnsavecomprefix" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success module-btncancelcomprefix" style="display: none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                    </div>
                </div>
                </div><!-- /.box-header -->
            
            <div class="box-body">
                
                <div class="invoice-col col-md-6 prefixform" style="display:none;">
                    <h6 style="width: 100%;" class="aimslabel3"><b>Company Name: <input name="companyname" value ="" type="text" class="moduletxt txtcompanyname form-control input-sm" ></b></h6>
                </div>

                <div class="invoice-col col-md-6 prefixform" style="display:none;">
                    <h6 style="width: 100%;" class="aimslabel3" ><b>Prefix: <input name="prefix" value ="" type="text" class="moduletxt txtdocprefix form-control input-sm" ></b></h6>
                </div>

                <div class="invoice-col col-md-6 prefixform" style="display:none;">
                    <h6 style="width: 100%;" class="aimslabel3" ><b>Company Address: <input name="companyadd" value ="" type="text" class="moduletxt txtcomadd form-control input-sm" ></b></h6>
                </div>

                <div class="invoice-col col-md-6 prefixform" style="display:none;">
                    <h6 style="width: 100%;" class="aimslabel3" ><b>Company Contact: <input name="companytel" value ="" type="text" class="moduletxt txtcomtel form-control input-sm" ></b></h6>
                </div>

                <!-- <div class="invoice-col col-md-3 prefixform" style="display:none;">
                    <h6 style="width: 230px;" class="aimslabel3" ><b>Company Alias: <input name="alias" value ="" type="text" class="moduletxt txtcompanyalias form-control input-sm" ></b></h6>
                </div> -->

                <table class="bodytable table tableSection table-fixed">
                    <thead>
                    <tr>
                        <th class="col-description aimslabel"><span class="text">COMPANY</span></th>
                        <th class="col-description aimslabel"><span class="text">PREFIXES</span></th>
                        <!-- <th class="col-min aimslabel"><span class="text">ALIAS</span></th> -->
                        <th class="col-min aimslabel"><span class="text">OPTION</span></th>
                    </tr>
                    </thead>
                    
                    <tbody id="compref-modulebody" class="compref-modulebody"style="height:400px;">
                        <?php
                            foreach ($comprefs as $key => $value) {
                                echo '<tr>
                                <td class="col-description" id="comprefcompanyname-'.$comprefs[$key]['line'].'">'.$comprefs[$key]['companyname'].'</td>
                                <td class="col-description" id="comprefixes-'.$comprefs[$key]['line'].'">'.$comprefs[$key]['availprefs'].'</td>
                                <td class="nobody" id="compadd-'.$comprefs[$key]['line'].'">'.$comprefs[$key]['company_add'].'</td>
                                <td class="nobody" id="comptel-'.$comprefs[$key]['line'].'">'.$comprefs[$key]['company_tel'].'</td>
                                <td id="stockbuttons-'.$comprefs[$key]['line'].'" style="margin-bottom:-5px;" class="origdata btnstockopt col-min aimslabelstock">
                                <button id="comprefixedit-'.$comprefs[$key]['line'].'" data-toggle="tooltip" title="Edit" class="btneditcomprefix btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                </td>
                                </tr>';
                            }//end foreach
                        ?>
                    </tbody>
                </table>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->