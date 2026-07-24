<?php
use yii\helpers\Url;
?>
 <!-- Navbar -->
  <nav>
    <div class="container">
      <div class="nav-inner">
        <div class="logo-small"> <a class="logo" title="Magento Commerce" href="<?php echo Url::to(['/']); ?>"><img alt="Magento Commerce" src="<?php echo Yii::$app->homeUrl; ?>frontendassets/steamlayout/fimages/logo/logo.jpg"></a> </div>

        <!-- mobile-menu -->
        <div class="hidden-desktop" id="mobile-menu">
          <ul class="navmenu">
            <li>
              <div class="menutop">
                <div class="toggle"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></div>
                <h2>Menu</h2>
              </div>
              <ul class="submenu">
                <li>
                  <ul class="topnav">
                    <li class="level0 nav-6 level-top first parent"> <a class="level-top" href="<?php echo Url::to(['/']); ?>"> <span>Home</span> </a>
                    </li>
                    <li class="level0 nav-3 level-top parent"> <a href="<?php echo Url::to(['/frontend/highlights']); ?>" class="level-top"> <span>Highlights</span> </a><em>+</em>
                    </li>
                    <li class="level0 nav-3 level-top parent"> <a href="grid.html" class="level-top"> <span>Shop by Categories</span> </a><em>+</em>
                      
                      <ul class="level0">
                      <?php
                        $strhtmlmobile = "";
                        foreach (Yii::$app->session['lanes'] as $key => $value) {
                          $strhtmlmobile = $strhtmlmobile . '<li class="level1 nav-3-1 first parent"> <a href=""><span>'.strtoupper($value['nav_desc']).'</span> </a><em>+</em>';

                          $strhtmlmobile = $strhtmlmobile . '</li>';
                        }//end for each lanes
                        echo $strhtmlmobile;
                      ?>
                      </ul>
                      
                    </li>
                  <!--  <li class="level0 nav-3 level-top parent"> <a href="grid.html" class="level-top"> <span>Shop by Brands</span> </a><em>+</em>
                    </li> -->
                   <!--  <li class="level0 nav-7 level-top parent"> <a class="level-top" href="grid.html"> <span>Contact Us</span> </a>
                    </li>
                    <li class="level0 nav-7 level-top parent"> <a class="level-top" href="grid.html"> <span>About Us</span> </a>
                    </li> -->
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
          <!--navmenu--> 
        </div>
        <!--End mobile-menu -->

        <!-- DESKTOP MENU -->
        <ul id="nav" class="hidden-xs">
          <li class="level0"> <a class="level-top" href="<?php echo Url::to(['/']); ?>"><span>Home</span></a></li>
          <li class="level0"> <a class="level-top" href="<?php echo Url::to(['/frontend/mycart/']); ?>">
          <span>My Cart</span>
          <?php
          if(isset(Yii::$app->session['cart']) && !empty(Yii::$app->session['cart'])){
            $count = 0;
            foreach (Yii::$app->session['cart'] as $key => $value) {
              $count += 1;
            }//end for each
            echo '<b><span style="color:red;" class="cartitemscount">('.$count.') Items</span></b>';
          }else{
            echo '<b><span style="color:red;" class="cartitemscount"></span></b>';
          }//end if
          ?>
          </a></li>
          <li class="level0"> <a class="level-top" href="<?php echo Url::to(['/frontend/highlights']); ?>"><span>Highlights</span></a></li>
          <li class="level0"> <a class="level-top" href="<?php echo Url::to(['/frontend/listing','z'=>'brands']); ?>"><span>Shop by Brands</span></a></li>
       <!--    <li class="level0"> <a class="level-top" href="grid.html"><span>Highlights</span></a>
              <div class="level0-wrapper dropdown-6col">
                <div class="level0-wrapper2">
                    
                </div>
              </div>
          </li> -->
          <li class="level0"> <a class="level-top clickable"><span>Shop by Categories</span></a>
            <div class="level0-wrapper dropdown-6col">
              <div class="level0-wrapper2">
                <div class="nav-block nav-block-center"> 
                  <ul class="level0">
                    <?php
                      $strhtmldesktop = "";
                      foreach (Yii::$app->session['lanes'] as $key => $value) {
                        $strhtmldesktop = $strhtmldesktop . '<li class="level3 nav-6-1 parent item"> <a href="'.Url::to(['/frontend/products/', 'type' => 'lane','v'=>$value['navid']]).'"><span>'.strtoupper($value['nav_desc']).'</span></a> ';
                            $cats = Yii::$app->backend->retrieveSubcategory('LANE',$value['navid']);
                            foreach ($cats as $catkey => $kitten) {
                                  $strhtmldesktop = $strhtmldesktop . '<ul class="level1">';
                                  $strhtmldesktop = $strhtmldesktop . '<li class="level2 nav-3-2-5 first"> <a href="'.Url::to(['/frontend/products/', 'type' => 'category','v'=>$kitten['catid']]).'"> <span>'.strtoupper($kitten['cat_desc']).'</span> </a> </li>';
                                  $strhtmldesktop = $strhtmldesktop . '</ul>';
                            }//end for each
                        $strhtmldesktop = $strhtmldesktop . '</li>';
                      }//end for each lanes
                      echo $strhtmldesktop;
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <!-- <li class="level0"> <a class="level-top" href="grid.html"><span>Shop by Brands</span></a></li> -->
        </ul>
        <!-- END DESKTOP MENU -->
      </div>
    </div>
  </nav>
  <!-- end nav -->  