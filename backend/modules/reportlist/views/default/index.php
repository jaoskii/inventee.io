<?php
use yii\helpers\Url;
$this->title = 'List of Reports';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<div class="col-md-12 col-xs-12">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">List of Accounts</h6></b>
                </div><!-- /.box-header -->
            <div class="box-body">
            <ul id="tree3">
            <li class="open" disabled>
                <a class="clickable" id ="report-grandgrandparent">List of Reports</a>
                <ul id="grandgrandparentreport">
                <?php
                    foreach ($moduledata as $reportdata) {
                    $attribute = $reportdata['attribute'];   
                    if(Yii::$app->session['loggeduser']['access'][$attribute] == 1){
                    echo '<li disabled>
                    <a class="reportparents clickable" id="'.$reportdata['attribute'].'-'.$reportdata['code'].'">' .$reportdata['description'].'</a>';
                    echo '<ul id="child'.$reportdata['attribute'].'"></ul>';
                    echo '</li>';
                    }
                    }//END FOR EACH     
                    ?>
                </ul>
            </li>
            </ul> <!--  END UL -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->


