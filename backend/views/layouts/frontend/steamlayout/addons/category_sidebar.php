<?php
use yii\helpers\Url;

?>

<div class="side-nav-categories">
            <div class="block-title"> Categories </div>
            <!--block-title--> 
            <!-- BEGIN BOX-CATEGORY -->
            <div class="box-content box-category">
              <ul>
              <?php
              $strhtml = "";
              foreach (Yii::$app->session['lanes'] as $key => $value) {
                $strhtml = $strhtml . '<li class="active">';
                /*if($this->params['getlane'] != ''){
                  if($value['navid'] == $this->params['getlane']){
                    $strhtml = $strhtml . '<li class="active">';
                  }else{
                    $strhtml = $strhtml . '<li class="">';
                  }//end if
                }else{
                  $strhtml = $strhtml . '<li class="">';
                }//end if 1st*/

                $strhtml = $strhtml . '<a href="'.Url::to(['/frontend/products/', 'type' => 'lane','v'=>$value['navid']]).'">'.strtoupper($value['nav_desc']).'</a> <span class="subDropdown minus"></span>';
                  $fcats = Yii::$app->frontend->getLaneChildCategories('LANES',$value['navid']); //THIS IS FOR ITEMS  
                   $strhtml = $strhtml . '<ul class="level0_455">';
                     if(!empty($fcats)){
                          foreach ($fcats as $ckey => $cvalue) {
                           $strhtml = $strhtml . '<li> <a href="'.Url::to(['/frontend/products/', 'type' => 'category','v'=>$cvalue['catid']]).'">'.strtoupper($cvalue['cat_desc']).'</a></span>';
                             /*$strhtml = $strhtml . '<ul class="level1">';
                               $strhtml = $strhtml . '<li> <a href="grid.html"> Flat Shoes </a> </li>';
                               $strhtml = $strhtml . '<li> <a href="grid.html"> Boots </a> </li>';
                               $strhtml = $strhtml . '<li> <a href="grid.html"> Heels </a> </li>';
                             $strhtml = $strhtml . '</ul>';*/
                           $strhtml = $strhtml . '</li>';
                          }//end for each
                      }//end if
                   $strhtml = $strhtml . '</ul>';
                $strhtml = $strhtml . '</li>';
              }//end lanes loop
              echo $strhtml;
              ?>
              </ul>
            </div>
            <!--box-content box-category--> 
          </div></li>