<?php 
use yii\helpers\Url;

if(isset(Yii::$app->session['loggeduser'])){
  $menuaccess = Yii::$app->session['loggeduser']['access'];
}else{
  $menuaccess = "";
}//end if


$masterlist = array('coa','customer','supplier','agent','warehouse','stockcard');
$fixedasset = array('generalitem','itemprofile','vendor','location');
$inventory = array('IS','PC','AJ','TS');
$sales = array('SO','SJ','CM');
$purchases = array('PR','PO','RR','DM');
$acctg = array('GJ','DS','bankrecon');
$receivables = array('AR','CR','KR','CK');
$payables = array('AP','PV','CV');
$production = array('PI','PD','PK');
$utilities = array('useraccess','branchaccess','branchmasterfile','audittrail','terms','docprefix','changeitem','notification');
$moduleid = $this->params['moduleid'];
?>
     <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar" >
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php if(in_array($moduleid, $masterlist)){ echo 'active'; } ?> treeview fixed">
              <a href="#">
                <i class="fa fa-list-alt masterfile_ico"></i> <span>MASTERFILE</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              
              <?php
              
              if($menuaccess[2] == 1){
              echo'<li class=';
                if($moduleid == "coa"){ echo '"active"'; }
              echo'><a href="'.Url::to(['/coa/index']).'"><i class="masterfile_sub_ico fa fa-file"></i> Chart of Accounts</a></li>';
              }

              if($menuaccess[11] == 1){
                echo'<li class=';
                if($moduleid == "stockcard"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/stockcard/index']).'"><i class="masterfile_sub_ico fa fa-list-alt"></i> Stockcard</a></li>';
              }


              if($menuaccess[21] == 1){
                echo'<li class=';
                if($moduleid == "customer"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/customer/index']).'"><i class="masterfile_sub_ico fa fa-user"></i> Customer</a></li>';
              }

              if($menuaccess[31] == 1){
                echo'<li class=';
                if($moduleid == "supplier"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/supplier/index']).'"><i class="masterfile_sub_ico fa fa-user"></i> Supplier</a></li>';
              }
              
              if($menuaccess[41] == 1){
                echo'<li class=';
                if($moduleid == "agent"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/agent/index']).'"><i class="masterfile_sub_ico fa fa-user"></i> Agent</a></li>';
              }

              if($menuaccess[51] == 1){
                echo'<li class=';
                if($moduleid == "warehouse"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/warehouse/index']).'"><i class="masterfile_sub_ico fa fa-home"></i> Warehouse</a></li>';
              }

              ?>
              </ul>
            </li>

            <?php 
            if(Yii::$app->systemsettings->enableFixedAsset()){
            ?>
            <li class="<?php if(in_array($moduleid, $fixedasset)){ echo 'active'; } ?> treeview fixed">
              <a href="#">
                <i class="fa fa-list-alt masterfile_ico"></i> <span>FIXED ASSET</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              
              <?php
              
              if($menuaccess[11] == 1){
                echo'<li class=';
                if($moduleid == "generalitem"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/generalitem/index']).'"><i class="masterfile_sub_ico fa fa-list-alt"></i> General Item</a></li>';
              }

              if($menuaccess[717] == 1){
                echo'<li class=';
                if($moduleid == "itemprofile"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/itemprofile/index']).'"><i class="masterfile_sub_ico fa fa-list-alt"></i> Item Profile</a></li>';
              }       

              if($menuaccess[725] == 1){
                echo'<li class=';
                if($moduleid == "vendor"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/vendor/index']).'"><i class="masterfile_sub_ico fa fa-user"></i> Vendor</a></li>';
              }
              
              if($menuaccess[733] == 1){
                echo'<li class=';
                if($moduleid == "location"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/location/index']).'"><i class="masterfile_sub_ico fa fa-home"></i> Location</a></li>';
              }       

              ?>
              </ul>
            </li>
            <?php 
            }
            ?>

            <li class="<?php if(in_array($moduleid, $purchases)){ echo 'active'; } ?> treeview">
              <a href="#">
                <i class="fa fa-arrow-circle-o-down purchases_ico"></i>
                <span>PURCHASES</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <?php
              if($menuaccess[618] == 1){
                echo'<li class=';
                if($moduleid == "PR"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/PR/index/']).'"><i class="purchases_sub_ico fa fa-arrow-circle-o-down"></i> Purchase Requisition</a></li>';
              }
              if($menuaccess[62] == 1){
                echo '<li class=';
                if($moduleid == "PO"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/PO/index/']).'"><i class="purchases_sub_ico fa fa-arrow-circle-o-down"></i> Purchase Order</a></li>';
              }//FOR MENU ACCESS PO

              if($menuaccess[78] == 1){
                echo '<li class=';
                if($moduleid == "RR"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/RR/index/']).'"><i class="purchases_sub_ico fa fa-arrow-circle-o-down"></i> Receiving Report</a></li>';
              }//FOR MENU ACCESS RR
              
              if($menuaccess[97] == 1){
                echo '<li class=';
                if($moduleid == "DM"){ echo '"active"'; }
                echo '><a href="'.Url::to(['/DM/index/']).'"><i class="purchases_sub_ico fa fa-arrow-circle-o-down"></i> Purchase Return</a></li>';
              }//FOR MENU ACCESS DM
              ?>
              </ul>
            </li>

            <li class="<?php if(in_array($moduleid, $sales)){ echo 'active'; } ?>  treeview">
              <a href="#">
                <i class="sales_ico fa fa-tags"></i>
                <span>SALES</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php
                if($menuaccess[151] == 1){
                  echo '<li class=';
                  if($moduleid == "SO"){ echo '"active"'; }
                  echo'><a href="'.Url::to(['/SO/index/']).'"><i class="sales_sub_ico fa fa-tags"></i> Sales Order</a></li>';
                }//FOR MENU ACCESS SO

                if($menuaccess[168] == 1){
                echo '<li class=';
                  if($moduleid == "SJ"){ echo '"active"'; }
                  
                  switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'YULICK':
                      echo'><a href="'.Url::to(['/SJ2/index/']).'"><i class="sales_sub_ico fa fa-tags"></i> Sales Journal</a></li>';
                      break;

                      default:
                      echo'><a href="'.Url::to(['/SJ/index/']).'"><i class="sales_sub_ico fa fa-tags"></i> Sales Journal</a></li>';
                      break;
                  }//end switch case

                }//FOR MENU ACCESS SJ

                 /*if($menuaccess[168] == 1){
                echo '<li class=';
                  if($moduleid == "SJ"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/SJ2/index/']).'"><i class="sales_sub_ico fa fa-tags"></i> Sales Journal 2</a></li>';
                }//FOR MENU ACCESS SJ*/

                if($menuaccess[189] == 1){
                echo '<li class=';
                  if($moduleid == "CM"){ echo '"active"'; } 
                echo'><a href="'.Url::to(['/CM/index/']).'"><i class="sales_sub_ico fa fa-tags"></i> Sales Return</a></li>';
                }//FOR MENU ACCESS CM
                ?>
              </ul>
            </li>
            
            <li class="<?php if(in_array($moduleid, $inventory)){ echo 'active'; } ?> treeview">
              <a href="#">
                <i class="inventory_ico fa fa-table"></i>
                <span>INVENTORY</span>
                <i class="fa fa-angle-left pull-right"></i> 
              </a>
              <ul class="treeview-menu">
                <?php
                if($menuaccess[257] == 1){
                echo '<li class=';
                if($moduleid == "IS"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/IS/index/']).'"><i class="fa fa-table inventory_sub_ico"></i> Inventory Setup</a></li>';
                }//FOR MENU ACCESS IS

                if($menuaccess[275] == 1){
                echo '<li class=';
                if($moduleid == "PC"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/PC/index/']).'"><i class="fa fa-table"></i> Physical Count</a></li>';
                }//FOR MENU ACCESS PC


                if($menuaccess[308] == 1){
                echo '<li class=';
                if($moduleid == "TS"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/TS/index/']).'"><i class="fa fa-table"></i> Transfer Slip</a></li>';
                }//FOR MENU ACCESS TS

                if($menuaccess[290] == 1){
                echo '<li class=';
                if($moduleid == "AJ"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/AJ/index/']).'"><i class="fa fa-table"></i> Inventory Adjustment</a></li>';
                }//FOR MENU ACCESS AJ

                ?>
              </ul>
            </li>

            <?php
              switch(Yii::$app->systemsettings->companyConfig()){
                case 'YULICK':
                  echo '<li class="'; if(in_array($moduleid, $production)){ echo 'active'; } 
                  echo 'treeview">
                    <a href="#">
                       <i class="productions_ico fa fa-sticky-note"></i> <span>PRODUCTION</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">';

                    if($menuaccess[133] == 1){
                      echo'<li class=';
                      if($moduleid == "PI"){ echo '"active"'; }
                      echo'><a href="'.Url::to(['/PI/index/']).'"><i class="fa fa-sticky-note productions_sub_ico"></i> Production Instruction</a></li>';
                    }/*FOR MENU ACCESS AP SETUP*/

                    if($menuaccess[370] == 1){
                     echo'<li class=';
                     if($moduleid == "PD"){ echo '"active"'; }
                     echo'><a href="'.Url::to(['/PD/index/']).'"><i class="fa fa-sticky-note productions_sub_ico"></i> Production Order</a></li>';
                    }//FOR MENU ACCESS APV

                    if($menuaccess[116] == 1){
                     echo'<li class=';
                     if($moduleid == "PK"){ echo '"active"'; }
                     echo'><a href="'.Url::to(['/PK/index/']).'"><i class="fa fa-sticky-note productions_sub_ico"></i> Production Completion</a></li>';
                    }//FOR MENU ACCESS CV
                    
                    echo '</ul>
                  </li>';
                break;
              }//end switch
            ?>


            <li class="<?php if(in_array($moduleid, $payables)){ echo 'active'; } ?> treeview">
              <a href="#">
                <i class="payables_ico fa fa-edit"></i> <span>PAYABLES</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <?php 
              if($menuaccess[133] == 1){
                echo'<li class=';
                if($moduleid == "AP"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/AP/index/']).'"><i class="payables_sub_ico fa fa-circle-o"></i> AP Setup</a></li>';
              }/*FOR MENU ACCESS AP SETUP*/

              if($menuaccess[370] == 1){
               echo'<li class=';
               if($moduleid == "PV"){ echo '"active"'; }
               echo'><a href="'.Url::to(['/PV/index/']).'"><i class="payables_sub_ico fa fa-circle-o"></i> AP Voucher</a></li>';
              }//FOR MENU ACCESS APV

              if($menuaccess[116] == 1){
               echo'<li class=';
               if($moduleid == "CV"){ echo '"active"'; }
               echo'><a href="'.Url::to(['/CV/index/']).'"><i class="payables_sub_ico fa fa-circle-o"></i> Cash/Check Voucher</a></li>';
              }//FOR MENU ACCESS CV
              ?>
              </ul>
            </li>

            <li class="<?php if(in_array($moduleid, $receivables)){ echo 'active'; } ?> treeview">
              <a href="#">
                <i class="receivables_ico fa fa-edit"></i> <span>RECEIVABLE</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <?php 
              if($menuaccess[239] == 1){
                echo '<li class=';
                if($moduleid == "AR"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/AR/index/']).'"><i class="receivables_sub_ico fa fa-circle-o"></i> AR Setup</a></li>';
              }/*FOR MENU ACCESS AR SETUP*/

              if($menuaccess[223] == 1){
               echo'<li class=';
               if($moduleid == "CR"){ echo '"active"'; }
               echo'><a href="'.Url::to(['/CR/index/']).'"><i class="receivables_sub_ico fa fa-circle-o"></i> Received Payment</a></li>';
              }//FOR MENU ACCESS REC PAYMENT

              if($menuaccess[700] == 1){
               echo'<li class=';
               if($moduleid == "CR"){ echo '"active"'; }
               echo'><a href="'.Url::to(['/CK/index/']).'"><i class="receivables_sub_ico fa fa-circle-o"></i> Postdated Checks</a></li>';
              }//FOR MENU ACCESS PDC

              if($menuaccess[208] == 1){
                echo'<li class=';
                if($moduleid == "KR"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/KR/index/']).'"><i class="receivables_sub_ico fa fa-circle-o"></i> Counter Receipt</a></li>';
              }//FOR MENU ACCESS KR

              ?>
              </ul>
            </li> 

            <li class="<?php if(in_array($moduleid, $acctg)){ echo 'active'; } ?> treeview">
              <a href="#">
                <i class="accounting_ico fa fa-edit"></i> <span>ACCOUNTING</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <?php 
              
              if($menuaccess[343] == 1){
                echo'<li class=';
                if($moduleid == "GJ"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/GJ/index/']).'"><i class="accounting_sub_ico fa fa-circle-o"></i> General Journal</a></li>';
              }//FOR MENU ACCESS GJ

              if($menuaccess[326] == 1){
               echo'<li class=';
               if($moduleid == "DS"){ echo '"active"'; }
               echo'><a href="'.Url::to(['/DS/index/']).'"><i class="accounting_sub_ico fa fa-circle-o"></i> Deposit Slip</a></li>';
              }//FOR MENU ACCESS DS

              if($menuaccess[600] == 1){ //same access as audit trail
                echo '<li class=';
                if($moduleid == "bankrecon"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/bankrecon/index/']).'"><i class="fa fa-circle-o accounting_sub_ico"></i> Bank Reconciliation</a></li>';
              }//FOR MENU ACCESS PO

              ?>
              </ul>
            </li> 
            

            <li class="treeview">
             <a href="<?php echo Url::to(['/reportlist/default/index']); ?>"><i class="reportlist_ico fa fa-list"></i> <span>REPORT LIST</span></a>
            </li>
            

            
              </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
