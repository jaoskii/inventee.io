<?php
use yii\helpers\Url;
$this->title = 'POS Retail';
?>
<!-- <script src="pos-scripts.js"></script>
  <script>
    function domo(){
      jQuery('#platform-details').html('<code>' + navigator.userAgent + '</code>');
        var elements = [
                          "f1","f2","f3","f4","f5","f6","f7","f8","f9","f10","f11","f12"
                       ];
                
        $.each(elements, function(i, e) { // i is element index. e is element as text.
          var newElement = ( /[\+]+/.test(elements[i]) ) ? elements[i].replace("+","_") : elements[i];
          // Binding keys
          $(document).bind('keydown', elements[i], function assets() {
            $('#_'+ newElement).addClass("dirty");
            return false;
          });
        });
                
    }
    jQuery(document).ready(domo);
            
  </script> -->
<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="savingtype" value="">
  <input type = "hidden" id ="lines" value="">

  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <input type="text" name="barcode">
        <label style="color: white">: Enter Barcode</label>
        <div class="pull-right">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-success btnactive btndocprefixlogs">
                <b>PRESS HERE FOR KEYBOARD ASSIST
          </div>
        </div>
      </div><!-- /.box-header -->
    </div><!-- /.box -->
  </div> <!-- END COL MD 12 -->


  <div class="col-md-4">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;color: white">LISTS OF ITEMS</h6></b>
        <div class="pull-right">
          <div class="btn-group"></div>
        </div>
      </div>
      <div class="box-body">
        <div class="poslists"></div>
      </div>

      <div class="box-footer clearfix">
        <label class="aimslabel" style="color: red; font-size: 10px">NUMBER OF ITEMS:   
          <span id ="totalitems"></span>
        </label>
        

        
        <label class="aimslabel pull-right" style="color: red; font-size: 10px">TOTAL AMOUNT:   
          <span id ="totalamt"></span>
        </label>
        
      </div>

    </div>
  </div>

  
  <div class="col-md-6">
    
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x="f1">
        <i class="posicons fa fa-calendar"></i><br>
        <label class="poslabel">F1</label>
      </button>
    
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f2'>
        <i class="posicons fa fa-calendar"></i><br>
          <label class="poslabel">F2</label>
      </button>
    
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f3' >
        <i class="posicons fa fa-calendar"></i><br>
        <label class="poslabel">F3</label>
      </button>
   
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f4'>
        <i class="posicons fa fa-calendar"></i><br>
        <label class="poslabel">F4</label>
      </button>

      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f5' >
        <i class="posicons fa fa-calendar"></i><br>
        <label class="poslabel">F5</label>
      </button>
    
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f6' >
        <i class="posicons fa fa-calendar"></i><br>
          <label class="poslabel">F6</label>
      </button>
    
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f7' >
        <i class="posicons fa fa-calendar"></i><br>
        <label class="poslabel">F7</label>
      </button>
   
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f8' >
          <i class="posicons fa fa-calendar"></i><br>
          <label class="poslabel">F8</label>
      </button>

      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f9' >
        <i class="posicons fa fa-edit"></i><br>
        <label class="poslabel">F9</label>
      </button>
   
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f10' >
        <i class="posicons fa fa-edit"></i><br>
          <label class="poslabel">F10</label>
      </button>
    
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f11' >
        <i class="posicons fa fa-edit"></i><br>
        <label class="poslabel">F11</label>
      </button>
   
      <button type="button" class="col-md-8 col-md-push-0 btn btn-app quicka_btn posretailbtn" x='f12' >
        <i class="posicons fa fa-file"></i><br>
          <label class="poslabel">F12</label>
      </button>


   
  </div>

  <div class="col-md-2">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;color: white">TRANSACTION DETAILS</h6></b>
        <div class="pull-right">
          <div class="btn-group"></div>
        </div>
      </div>
      <div class="postransitem box-body">
        <label>qwe</label><br>
        <label>qwe</label><br>
        <label>qwe</label><br>
        <label>qwe</label><br>
        <label>qwe</label>
      </div>

    
    </div>
  </div>

    

</div> <!-- END ROW -->
