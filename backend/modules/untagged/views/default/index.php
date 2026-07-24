<?php
use yii\helpers\Url;
$this->title = 'Untagged Client';
?>

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
    <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="savingtype" value="">
    <input type = "hidden" id ="client" value="">


    <div class="col-md-12">
          <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">
                  <div class="col-md-6 pull-right">
                    <div class="input-group">
                      <input value ="" type="text" class="txtuntaggedclientsearch input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                    </div>
                  </div>
                  </div><!-- /.box-header -->
               <div class="box-body scroll-divs">

                            <table class="table tbl-fix bodytable">
                              <thead>
                                  <tr>
                                    <th class="col-min aimslabel"><span class="text">Options</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Client</span></th>
                                      <th class="col-description aimslabel"><span class="text">Client Name</span></th>
                                      <th class="col-min aimslabel"><span class="text">IsCustomer</span></th>
                                      <th class="col-codes aimslabel"><span class="text">IsSupplier</span></th>
                                      <th class="col-codes aimslabel"><span class="text">IsAgent</span></th>
                                      <th class="col-codes aimslabel"><span class="text">IsWarehouse</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody untaggedclienttbl">
                                <?php
  foreach ($untaggeddata as $itmindex => $itmdata) {
  echo'<tr id="orgrow-'.$itmdata['client'].'" class="orgrow">
  <td id="changebuttons-'.$itmdata['client'].'" style="margin-bottom:-5px;" class="origdata btnstockopt col-min aimslabelstock">
  <button id="untaggedclientedit-'.$itmdata['client'].'" class="untaggedclienteditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;">
  <i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button></td>
  <td id="untaggedclient-'.$itmdata['client'].'" class="origdata col-codes aimslabelstock">'.$itmdata['client'].'</td>
  <td id="untaggedclientname-'.$itmdata['client'].'" class="origdata col-description aimslabel aimslabelstock">'.$itmdata['clientname'].'</td>
  <td id="untaggedclientiscustomer-'.$itmdata['client'].'" class="origdata col-min aimslabelstock">'.$itmdata['iscustomer'].'</td>
  <td id="untaggedclientissupplier-'.$itmdata['client'].'" class="origdata col-codes aimslabelstock">'.$itmdata['issupplier'].'</td>
  <td id="untaggedclientisagent-'.$itmdata['client'].'" class="origdata col-codes aimslabelstock">'.$itmdata['isagent'].'</td>
  <td id="untaggedclientiswarehouse-'.$itmdata['client'].'" class="origdata col-codes aimslabelstock">'.$itmdata['iswarehouse'].'</td>
  </tr>';
                                  }
                                ?>
                                </tbody>
                            </table>  
                </div><!-- /.box-body -->
            </div><!-- /.box -->
    </div> <!-- END COL MD 9 -->
    </div> <!-- END ROW -->

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
