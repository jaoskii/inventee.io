<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\helpers\Url;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\base\ErrorException;

use app\models\Postock;
use app\models\Lastock;
use app\models\Ladetail;
use app\models\Taxdetail;
class tablegenerator extends Component{ 
  
  public function getStockViewQuery($doc,$trno){
      switch($doc) {
          case 'SO': case 'QA': case 'PO': case 'PC': case 'TR': case 'PR': case 'QA': case 'PS': case 'pscheme': case 'SP':
          case 'quotation':
          case 'JB':
            $qry = Postock::openstock($doc,$trno,'');
          break;
          case 'MX': case 'SJ': case 'CM': case 'MI': case 'IS': case 'TS': case 'AJ': case 'DM': case 'RR': case 'SV':
            $qry = Lastock::openstock($trno, $doc,'');
          break;

          case 'GJ': case 'DS': case 'AP': case 'PV': case 'CV': case 'AR': case 'CR':
            $qry = Ladetail::opendetail($trno,$doc);
          break;

          case 'TW':
            $qry = Taxdetail::opendetail($trno, $doc);
          break;

          case 'KR':
            $qry = Yii::$app->backend->retrieveKRreceivables($trno);
          break;

          case 'changeitem':
            $qry = Yii::$app->backend->retrieveChangeitemdata($trno);
          break;

          case 'tpshipping':             
            $qry = Yii::$app->backend->invoicedata();
          break;          

          case 'tphandling':
            $qry = Yii::$app->backend->invoicehandling();
          break;
      }//end swtich
      
      return $qry;
  }//end function

  public function getBankreconQuery($acno,$startdate,$enddate,$cleardate) {
    if($acno != '') {
      // $acno = '\\'.$acno;
      $contra = explode('~',$acno);
      $acno = '\\'.$contra[0];
    } else {
      $acno = '\\\\';
    }
    $qry= "select sort,trno,line,brecon.type,docno,left(dateid,10) as dateid,brecon.acno,left(postdate,10) as postdate,db,cr,checkno,rem,acnoname,0.00 as bal,clientname,clearday, db - cr as balance from
        (select 'p' as `type`,1 as `sort`,`gldetail`.`trno` as `trno`,`gldetail`.`line` as `line`,left(ifnull(`gldetail`.`clearday`,''),10)  as `clearday`,
         `glhead`.`docno` as `docno`,`glhead`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`gldetail`.`postdate` as `postdate`,
         `gldetail`.`db` as `db`,`gldetail`.`cr` as `cr`, gldetail.db - gldetail.cr as balance, `gldetail`.`checkno` as `checkno`,`gldetail`.`rem` as `rem`,`client`.`client` as `client`,`glhead`.`clientname` as `clientname`
         from (((`glhead` left join `gldetail` on((`gldetail`.`trno` = `glhead`.`trno`))) left join `coa` on((`coa`.`acnoid` = `gldetail`.`acnoid`))) left join `client` on((`client`.`clientid` = `gldetail`.`clientid`))) where (`glhead`.`doc` in ('ds','cv','cr','gj'))
         union all
         select 'p' as `type`,2 as `sort`,0 as `trno`,0 as `line`,left(ifnull(`brecon`.`dateid`,''),10) as `clearday`,'Recon' as `docno`,
         `brecon`.`dateid` as `dateid`,`brecon`.`acno` as `acno`,coa.acnoname,`brecon`.`dateid` as `postdate`,
         `brecon`.`bal` as `db`, brecon.bal as balance,0 as `cr`,'Recon' as `checkno`,concat('Recon-' , date_format(`brecon`.`dateid`,'%b %d %Y')) as `rem`,'' as `client`, '' as `clientname`
         from `brecon` left join coa on coa.acno = brecon.acno where (`brecon`.`line` <> 2)) as brecon
         where postdate between '$startdate' and '$enddate' and (clearday ='$cleardate' or clearday ='') and acno='$acno'";
    return $qry;
  }

  public function generateGrid($params) {
      try {
        if(isset($params['key'])) { if($params['key'] == '') { $key = ''; } else { $key = $params['key']; } } else { $key = ''; } // UNIQUE KEY COLUMN NAME
        
        if(isset($params['checkbox'])) { 
          if($params['checkbox'] === true) {
            $checkboxcolumn = 'true'; 
          }else{
            $checkboxcolumn = 'false'; 
          }//end if
        }else{ 
          $checkboxcolumn = 'false'; 
        } // CHECKBOX ACTIONCOLUMN
        
        if(isset($params['hidden'])) { $hidden = $params['hidden'];} else { $hidden = ''; } // HIDDEN COLUMNS
        
        if(isset($params['actionheader'])) { if($params['actionheader'] == '') { $actionheader = 'ACTION'; } else { $actionheader = $params['actionheader']; } } else { $actionheader = 'ACTION'; } // BUTTONS HEADER TITLE
        
        if(isset($params['template'])) { if($params['template'] !== '') { $template = $params['template']; } else { $template = ['checkbox','buttons','columns']; } } else { $template = ['checkbox','buttons','columns']; } // GRIDVIEW TEMPLATE

        if(isset($params['buttons'])) { if($params['buttons'] == '') { $gridbuttons = ''; } else { $gridbuttons = $params['buttons']; } } else { $gridbuttons = ''; }

        // FOR HIDDEN ROW
        $hiddenbuttons = [];
        $hiddencheckbox = [];
        $hiddeninput = [];

        $buttoncount = 0;
        $colcont = array(); // COLUMN CONTENTS
        

        switch (Yii::$app->systemsettings->companyConfig()) {
          case 'KINGGEORGE':
            switch (Yii::$app->session['king_db_set']){
                case md5(1):
                    $db = 'g1';
                break;
                
                case md5(2):
                    $db = 'g2';
                break;

                case md5(3):
                    $db = 'g3';
                break;

                case md5(4):
                    $db = 'g4';
                break;

                case md5(5):
                    $db = 'g5';
                break;

                case md5(6):
                    $db = 'g6';
                break;

                case md5(7):
                    $db = 'g7';
                break;

                case md5(8):
                    $db = 'g8';
                break;

                case md5(9):
                    $db = 'g9';
                break;

                case md5(10):
                    $db = 'g10';
                break;
            }//end switch
          break;
          
          default:
            $db = 'db';
          break;
        }//end switch

        $data = new SqlDataProvider([ // DATA PROVIDER
            'db' => $db,
            'sql' => $params['sql'],
            // 'totalCount' => $count,
            'pagination' => false,
        ]);
        
        $recordcount = $data->totalCount; // TOTAL RECORD COUNT

        foreach ($template as $index) {
          if($index == 'checkbox') {
            // ================================= CHECKBOX COLUMN ============================== //
                if($checkboxcolumn == 'true') {
                  $keys = '';
                  $colcont[] = [
                    'class' => 'yii\grid\CheckboxColumn',
                    'headerOptions' => ['style'=>'text-align:center;','class'=>'aimslabel'],
                    'header' => Html::checkbox('checkbox_all', false, ['class'=>'checkbox_all']),
                    'contentOptions' => ['style'=>'width:10px;text-align:center;padding:0px;'],
                    'checkboxOptions' => function($data) use($key) {
                      return ['id'=>$key,'class'=>'gridcheckbox'];
                    }
                  ];
                  // $hiddenbuttons[]['checkbox'] = ["<input type='checkbox' style='width:10px;text-align:center;padding:0px;' id='".$keys."' class='gridcheckbox'>"];
                  $hiddencheckbox[] = [
                    'id' => $keys,
                    'class' => 'gridcheckbox'
                  ];
                }
            // ================================================================================ //
          } else if($index == 'buttons') {
            // ============================== LOAD GRIDVIEW BUTTONS =========================== //
                if($gridbuttons !== '') {
                  foreach ($gridbuttons as $buttons) {
                    $buttoncount += 1;
                  }
                  $buttoncount = ($buttoncount * 18) - 18;
                  $colcont[] = [
                    'header' => $actionheader,
                    'format' => 'raw',
                    'headerOptions' => ['class'=>'gv-options aimslabel col-min'],
                    'contentOptions' => ['class'=>'gv-options aimslabel col-min','style'=>'text-align:center;'],
                    'value' => function($data) use($params,$gridbuttons) {
                    $buttonss = '';
                    $buttonattr = '';
                      foreach ($gridbuttons as $buttons) {
                        if(isset($buttons['attributes'])) {
                          foreach ($buttons['attributes'] as $attributes) {
                            $buttonattr.= ' '.$attributes['name'].'="'.$data[$attributes['value']].'" ';
                          }//end for each
                        }//end if attributes

                        $buttonss.= "<a href='javascript:return(0);' title='{$buttons['name']}' 
                                    class='{$buttons['class']} col-description' 
                                    txtclass='{$params['txtclass']}' style='{$buttons['style']}' 
                                    tableid='{$params['tableid']}' $buttonattr>{$buttons['caption']}</a>";
                      }//end for each grid buttons
                      return $buttonss;
                    }//end value params 
                  ];

                  // HIDDEN BUTTONS
                  foreach ($params['buttons'] as $buttons) {
                      if(isset($buttons['attributes'])) { $attributes = $buttons['attributes']; } else { $attributes = []; }
                      $hiddenbuttons[] = [
                        'title' => $buttons['name'],
                        'class' => $buttons['class'],
                        'txtclass' => $params['txtclass'],
                        'caption' => $buttons['caption'],
                        'style' => $buttons['style'],
                        'tableid' => $params['tableid'],
                        'width' => $buttoncount,
                        'attributes' => $attributes
                      ];
                    }
                }
            // ================================================================================ //
          } else {
            // ============================== LOAD GRIDVIEW COLUMNS =========================== //
                $columncount = count($params['column']);
                foreach ($params['column'] as $cols) {
                  if(isset($cols['width']) != '') { $contops = ['class'=>'aimslabel','style'=>'width:'.$cols['width'].';']; } else { $contops = ['class'=>'aimslabel']; } // COLUMN WIDTH
                  if(isset($cols['label']) != '') { $label = $cols['label']; } else { $label = ucfirst($cols['name']); } // COLUMN LABEL
                  if(isset($cols['editable'])) { if($cols['editable'] == true) {$editable = 'true';} else {$editable = 'false';} } else {$editable = 'false';} // INPUT EDITABLE
                  if(isset($cols['class'])) { if($cols['class'] == '') { $colclass = ''; } else { $colclass = $cols['class']; } } else {$colclass = '';} // INPUT CLASS
                  if(isset($cols['default'])) { if($cols['default'] == '') { $default = '';} else { $default = $cols['default']; } } else {$default = '';} // INPUT DEFAULT VALUE/PLACEHOLDER
                  if(isset($cols['readonly'])) { if($cols['readonly'] == true) { $readonly = $cols['readonly']; } else { $readonly = false; } } else { $readonly = false; }

                  if(isset($cols['disabled'])) { if($cols['disabled'] == true) { $disabled = $cols['disabled']; } else { $disabled = false; } } else { $disabled = false; }

                  if(isset($params['txtclass'])) { if($params['txtclass'] == '') { $txtclass = ''; } else { $txtclass = $params['txtclass']; } } else { $txtclass = ''; }

                  if(isset($cols['hidden'])) { if($cols['hidden'] == true) { $hiddencol = 'true'; } else { $hiddencol = 'false'; } } else { $hiddencol = 'false'; }


                  if($hiddencol == 'true') {
                    $colcont[] = [
                      'format' => 'raw',
                      'headerOptions'=>['style'=>'display:none;'],
                      'contentOptions' => ['style'=>'display:none'],
                      'value' => function($data) use($cols,$params,$colclass) {
                        return Html::input('text',$cols['name'],$data[$cols['name']],
                        ['class'=>$colclass. ' ' .$params['txtclass'],'coltype'=>$cols['name']]);
                      }
                    ];

                    $hiddeninput[] = [
                      'type' => 'hidden',
                      'name' => $cols['name'],
                      'coltype'=>$cols['name'],
                      'placeholder'=>$cols['default'],
                      'class' => 'form-control input-sm '.$txtclass.' '.$colclass
                    ];
                  } else {
                    //DITO
                        if($editable == 'true') {
                        switch($cols['type']) {
                          case 'text': case 'number': case 'datepicker':
                            $hiddeninput[] = [
                              'type' => $cols['type'],
                              'name' => $cols['name'],
                              'class' => 'form-control input-sm '.$txtclass.' '.$colclass,
                              'coltype' => $cols['name'],
                              'placeholder' => $default,
                              'readonly' => $readonly
                            ];
                          break;

                          case 'checkbox':
                            $hiddeninput[] = [
                              'for' => $cols['for'],
                              'type' => $cols['type'],
                              'class' => $txtclass.' '.$colclass
                            ];
                          break;

                          case 'lookup':
                            if(isset($cols['lookupbutton']['colw'])){if($cols['lookupbutton']['colw'] == ''){$cols['lookupbutton']['colw'] = 'col-min';}}else{$cols['lookupbutton']['colw'] = 'col-min';}

                            if(isset($cols['lookupbutton']['lookuptxtclass'])){if($cols['lookupbutton']['lookuptxtclass'] == ''){$cols['lookupbutton']['lookuptxtclass'] = '';}}else{$cols['lookupbutton']['lookuptxtclass'] = '';}

                            if(isset($cols['lookupbutton']['lookupclass'])){if($cols['lookupbutton']['lookupclass'] == ''){$cols['lookupbutton']['lookupclass'] = '';}}else{$cols['lookupbutton']['lookupclass'] = '';}

                            if(isset($cols['lookupbutton']['lookupclass'])){if($cols['lookupbutton']['lookupclass'] == ''){$cols['lookupbutton']['lookupclass'] = '';}}else{$cols['lookupbutton']['lookupclass'] = '';}

                            if(isset($cols['lookupbutton']['autocall'])){if($cols['lookupbutton']['autocall'] == ''){$cols['lookupbutton']['autocall'] = '';}}else{$cols['lookupbutton']['autocall'] = '';}

                            $hiddeninput[] = [
                              'type' => $cols['type'],
                              'name' => $cols['name'],
                              'class' => 'form-control input-sm '.$txtclass.' '.$colclass,
                              'coltype' => $cols['name'],
                              'placeholder' => $default,
                              'readonly' => false,
                              'lookupbutton'=>['colw'=>$cols['lookupbutton']['colw'],
                                              'lookuptxtclass'=>$cols['lookupbutton']['lookuptxtclass'],
                                              'lookupclass'=>$cols['lookupbutton']['lookupclass'],
                                              'autocall'=>$cols['lookupbutton']['autocall']],
                            ];
                          break;

                          case 'elookup':
                            if(isset($cols['lookupbutton']['colw'])){if($cols['lookupbutton']['colw'] == ''){$cols['lookupbutton']['colw'] = 'col-min';}}else{$cols['lookupbutton']['colw'] = 'col-min';}

                            if(isset($cols['lookupbutton']['lookuptxtclass'])){if($cols['lookupbutton']['lookuptxtclass'] == ''){$cols['lookupbutton']['lookuptxtclass'] = '';}}else{$cols['lookupbutton']['lookuptxtclass'] = '';}

                            if(isset($cols['lookupbutton']['lookupclass'])){if($cols['lookupbutton']['lookupclass'] == ''){$cols['lookupbutton']['lookupclass'] = '';}}else{$cols['lookupbutton']['lookupclass'] = '';}

                            if(isset($cols['lookupbutton']['lookupclass'])){if($cols['lookupbutton']['lookupclass'] == ''){$cols['lookupbutton']['lookupclass'] = '';}}else{$cols['lookupbutton']['lookupclass'] = '';}

                            if(isset($cols['lookupbutton']['autocall'])){if($cols['lookupbutton']['autocall'] == ''){$cols['lookupbutton']['autocall'] = '';}}else{$cols['lookupbutton']['autocall'] = '';}

                            $hiddeninput[] = [
                              'type' => $cols['type'],
                              'name' => $cols['name'],
                              'class' => 'form-control input-sm '.$txtclass.' '.$colclass,
                              'coltype' => $cols['name'],
                              'placeholder' => $default,
                              'readonly' => false,
                              'lookupbutton'=>['colw'=>$cols['lookupbutton']['colw'],
                                              'lookuptxtclass'=>$cols['lookupbutton']['lookuptxtclass'],
                                              'lookupclass'=>$cols['lookupbutton']['lookupclass'],
                                              'autocall'=>$cols['lookupbutton']['autocall']],
                            ];
                          break;
                        }

                        $colcont[] = [
                          'label' => $label,
                          'format' => 'raw',
                          'headerOptions'=>['class'=>'aimslabel'],
                          'contentOptions' => $contops,
                          'value' => function($data) use($cols,$params,$key,$colclass,$default,$readonly,$txtclass,$disabled) {
                            switch($cols['type']) { // INPUT TYPES
                              case 'text': case 'number': // TEXTBOX & NUMBER
                                // Html::input($type,$name,$value,$options);
                                if(isset($cols['viewtype'])){
                                  $types = $cols['viewtype'];
                                }else{
                                  $types = '';
                                }//end switch

                                switch ($types) {
                                  case 'currency': case 'quantity': case 'unitprice': case 'kgs':
                                    return Html::input($cols['type'],$cols['name'],number_format($data[$cols['name']],Yii::$app->systemsettings->setDecimaldisplay($types)),['class'=>'form-control input-sm '.$txtclass.' '.$colclass,'coltype'=>$cols['name'],'placeholder'=>$default, 'readonly'=>$readonly,'disabled'=>$disabled]);
                                  break;
                                  
                                  default:
                                    return Html::input($cols['type'],$cols['name'],$data[$cols['name']],['class'=>'form-control input-sm '.$txtclass.' '.$colclass,'coltype'=>$cols['name'],'placeholder'=>$default, 'readonly'=>$readonly,'disabled'=>$disabled]);
                                  break;
                                }//end switch

                              break;
                              
                              case 'datepicker':
                                return '<div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="'.$data[$cols['name']].'" class="input-group date dpYears '.$colclass.'" style="margin-top:-3px;">
                                          <input type="text" name="'.$cols['name'].'" style="margin-top:0px;" coltype="'.$cols['name'].'" value="'.$data[$cols['name']].'" class="form-control input-sm '.$txtclass.' '.$colclass.'" "'.$readonly.'">
                                          <div class="dateid-lookup input-group-addon add-on" style="padding:0px;height:18px;width:25px;"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                        </div>';
                              break;

                              case 'checkbox':
                                return '<input for="'.$cols['for'].'" type="checkbox" style="margin-top:-3px;" class="'.$txtclass.' '.$colclass.'">';
                              break;

                              case 'lookup': // LOOKUP INPUT GROUP - FOR MODAL
                              if($readonly){
                                $str_readonly = 'readonly';
                              }else{
                                $str_readonly = '';
                              }
                              return '<div class="'.$cols['lookupbutton']['colw'].' input-group" style="margin-top:-3px;">        
                                      <input name="'.$cols['name'].'" 
                                      coltype="'.$cols['name'].'" '.$str_readonly.' value="'.$data[$cols['name']].'" 
                                      class="'.$txtclass.' form-control input-sm '.$cols['lookupbutton']['lookuptxtclass'].'" type="text">       
                                      <div style="padding:0px;height:21px;width:25px;" class="frmwh input-group-addon">
                                      <a lookup="'.$cols['lookupbutton']['autocall'].'" class="'.$cols['lookupbutton']['lookupclass'].'" data-toggle="modal">       
                                      <i class="fa fa-chevron-circle-down" style="margin-right:3px;margin-left:3px;">
                                      </i></a>
                                      </div>
                                      </div>';
                              break;

                              case 'elookup': // LOOKUP INPUT GROUP - FOR MODAL
                              return '<div class="'.$cols['lookupbutton']['colw'].' input-group" style="margin-top:-3px;">        
                                      <input name="'.$cols['name'].'" 
                                      coltype="'.$cols['name'].'" value="'.$data[$cols['name']].'" 
                                      class="'.$txtclass.' form-control input-sm '.$cols['lookupbutton']['lookuptxtclass'].'" type="text">       
                                      <div style="padding:0px;height:21px;width:25px;" class="frmwh input-group-addon">
                                      <a lookup="'.$cols['lookupbutton']['autocall'].'" class="'.$cols['lookupbutton']['lookupclass'].'" data-toggle="modal">       
                                      <i class="fa fa-chevron-circle-down" style="margin-right:3px;margin-left:3px;">
                                      </i></a>
                                      </div>
                                      </div>';
                              break;

                              case 'documentlink':
                                return "<b><a target='_blank' href='".Url::to(['/'.$data[$cols['linkdoc']],'q'=>$data[$cols['linkparam']]])."'><p class='aimslabel $colclass'>".$data[$cols['name']]."</p></a></b>";
                              break;

                              case 'link':
                                return "<b><a href='".$cols['link']."'><p class='aimslabel $colclass'>".$data[$cols['name']]."</p></a></b>";
                              break;
                            } // INPUT TYPES
                          } // COLUMN VALUE
                        ]; // COLCONT
                      } else {
                        if($cols['name'] != ""){
                          $colcont[] = [
                            'label' => $label,
                            'headerOptions' => ['class'=>'aimslabel '.$colclass],
                            'contentOptions' => ['style'=>'font-weight:bold;','class'=>$colclass],
                            'format' => 'raw',
                            'value' => function($data) use($cols,$colclass) {
                                
                                if(isset($cols['viewtype'])){
                                  $types = $cols['viewtype'];
                                }else{
                                  $types = '';
                                }//end switch

                                switch ($types) {
                                  case 'quantity': case 'currency':
                                    return "<p class='aimslabel $colclass'>".number_format($data[$cols['name']],Yii::$app->systemsettings->setDecimaldisplay($types))."</p>";
                                  break;
                                  
                                  default:
                                    return "<p class='aimslabel $colclass'>".$data[$cols['name']]."</p>";
                                  break;
                                }//end switch
                            } // COLUMN CONTENT
                          ]; // COLCONT
                        }//end if
                      }
                  }

                  
                }
            // ================================================================================ //
          }
        }




        // =========================== LOAD GRIDVIEW HEAD BUTTONS ========================= //
          $headbuttons = '';
          if(isset($params['add']) || isset($params['deleteselect']) || isset($params['saveall'])){
          $headbuttons.= "<div class='btn-group'>";
              if(isset($params['add'])) { // ADD NEW ROW BUTTON
                if($params['add'] == true) {
                  $headbuttons.= "<button tableid='".$params['tableid']."' txtclass='".$params['txtclass']."' class='btn btn-success btnaddnewgridrow' style='color:white;'><i class='fa fa-file' style='color:white;'></i> Add</button>";
                }
              }
              if(isset($params['saveall'])) { // SAVE ALL EDITED ROWS BUTTON
                if($params['saveall'] == true) {
                  $headbuttons.= "<button tableid='".$params['tableid']."' txtclass='".$params['txtclass']."' class='btn btn-success btnsaveallgridrow' style='color:white;'><i class='fa fa-save' style='color:white;'></i> Save All</button>";
                }
              }
              if(isset($params['deleteselect']) && isset($params['checkbox'])) { // DELETE SELECTED ROWS BUTTON
                if($params['deleteselect'] == true && $params['checkbox'] == true) {
                  $headbuttons.= "<button tableid='".$params['tableid']."' txtclass='".$params['txtclass']."' class='btn btn-success btndeleteselectedrow' style='color:white;'><i class='fa fa-trash' style='color:white;'></i> Delete Selected</button>";
                }
              }
          $headbuttons.= "</div>";
          }//end if isset || || ||
        // ================================================================================ //

        echo $headbuttons;
        return Gridview::widget([ // LOAD GRIDVIEW
          'dataProvider' => $data,
          'id' => $params['tableid'],
          'options' => ['class'=>'box-body mod-tble jadgridview-'.$params['tableid'],'hiddenbuttons'=>$hiddenbuttons,'hiddencheckbox'=>$hiddencheckbox,'hiddeninput'=>$hiddeninput,'template'=>$template],
          'emptyText' => '',
          'tableOptions' => ['class' => 'table'],
          'rowOptions' => function($data) use ($key) {
            return ['id' => 'gvrow-'.$data[$key]];
          },
          'columns' => $colcont
        ]);
      } catch(ErrorException $e) {
        echo $e;
      }
  }  
}//END COMPONENTS
?>
