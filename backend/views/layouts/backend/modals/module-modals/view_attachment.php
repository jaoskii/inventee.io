<!-- MODAL FOR CALENDAR-->
<div class="modal fade" id="modal-view-attachment" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">View Attchment</h4>
      </div>

      <div class="modal-body">
          <img style="width:870px;height: 520px;" class="thumbnail attachframe" src="">
      </div>

      <div class="modal-footer">
      <?php
      switch ($this->params['moduleid']) {
        case 'stockcard':
          echo '<button type="button" class="cleargallery btn btn-flat btn-success">Clear</button>';      
        break;
      }//end switch
      ?>
      <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>