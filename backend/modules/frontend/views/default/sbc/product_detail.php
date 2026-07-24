<?php
use yii\helpers\Url;
?>

<section class="">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <ul class="clean-list posts-loop">
          <li class="post-item">
            <div class="row">
              <div class="col-md-12">
                <figure class="text-center post-thumb">
                  <img class="pd-img" style="height: 300px;" src="<?php echo $details[0]['picture']; ?>" data-src="<?php echo $details[0]['picture']; ?>" alt="blog post">
                </figure>
              </div>
              <div class="col-md-12">
                <div class="post-content">
                  <h5 class="font-alpha post-title uppercase"><a href="#"><b><?php echo $details[0]['itemname']; ?> </b></a></h5>
                  <?php 
                    if($details[0]['f_proddesc'] == ""){
                      echo "No Details Given.";
                    }else{
                      echo $details[0]['f_proddesc'];
                    }//end if
                  ?>
                  <br>
                </div>
              </div>
            </div>
          </li>
        </ul>

      </div>

      <div class="col-md-3">
        <aside class="main-sidebar row" data-masonry=".widget">
          
          <div class="widget widget-categories col-md-12 col-sm-6">
            <h6 class="uppercase widget-title">Recomended Solutions</h6>
            
            <div class="widget-content style-alpha">
              <ul class="clean-list fancy-list">
                <li><a href="<?php echo Url::to(['/frontend/productdetail','sku'=>'e697c353f5f895f7e2686e572afb2dc8']); ?>">Accounting</a><i class="icon-100 font--2x bg-beta text-white"></i></li>
                <li><a href="<?php echo Url::to(['/frontend/productdetail','sku'=>'aa572f464be7036f5c7390c81697bd5e']); ?>">Inventory</a><i class="icon-100 font--2x bg-beta text-white"></i></li>
                <li><a href="<?php echo Url::to(['/frontend/productdetail','sku'=>'0613449b07400eb2834f2017cfa93a2a']); ?>">POS</a><i class="icon-100 font--2x bg-beta text-white"></i></li>
                <li><a href="<?php echo Url::to(['/frontend/productdetail','sku'=>'384aeefa1b5dbbaca75c0bef6a43821b']); ?>">Payroll</a><i class="icon-100 font--2x bg-beta text-white"></i></li>
              </ul>
            </div>
          </div> <!-- /.widget-categories -->
          
          <div class="widget widget-text col-md-12 col-sm-6">
            <h6 class="uppercase widget-title">About SBC</h6>
            
            <div class="widget-content style-alpha">
              The following package solutions/software available for installation on as-is basis or customizable depending on our clients’ preference: Accounting with Inventory Management System (AIMS), Inventory Solution, Billing and Collection System, Payroll and Timekeeping Solution, Human Resource Information System and Point of Sales Solution.
            </div>
          </div> <!-- /.widget-text -->
        </aside>
      </div>      
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</section> <!-- /.box -->