  <?php

  $this->title = 'Warehouse Ledger';

  ?>
  <!-- BUTTON HEADERS -->
    <div class="row">
    <div class="col-md-12">
          <div class="box box-solid box-success">
            <div class="box-body">
                 <div class="btn-group"> 
                   <button type="button" class="btn bg-green btn-flat margin"  role="button">New</button>
                   <button type="button" class="btn bg-green btn-flat margin"  role="button">Edit</button>
                   <button type="button" class="btn bg-green btn-flat margin"  role="button">Save</button>
                   <button type="button" class="btn bg-green btn-flat margin"  role="button">Delete</button>
                   <button type="button" class="btn bg-red btn-flat margin"  role="button">Print</button>

                        
                            <div class="input-group" style="width:777px;margin-top:10px;">
                                  <div class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                  </div>
                                  <input type="text" class="form-control">
                            </div><!-- /.input group -->



                </div>  
                
            </div><!-- /.box-body -->
          </div><!-- /.box -->
    </div>
    </div>

   
  <!-- HEAD AND STOCK -->
   <div class="row">
              
              <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom box box-solid box-success">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">General Information</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Available Items</a></li>
                    <li class="pull-right" style="margin-right:20px;">
                    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                          <ul class="pagination" id="pagination2">
                              <li class="paginate_button active">
                                  <a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">First</a>
                              </li>
                              <li class="paginate_button previous disabled" id="example1_previous">
                                  <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Prev</a>
                              </li>
                              </li>
                              <li class="paginate_button next" id="example1_next">
                                  <a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a>
                              </li>
                              <li class="paginate_button ">
                                  <a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">Last</a>
                              </li>
                          </ul>
                      </div>

                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                    <div class="row">
                          <div class="col-md-2">
                          <img class="thumbnail" src="#" width="190px" height="190px">
                          </div>

                          <div class="col-md-6">
                          <label>Warehouse Code:</label>
                          </br>
                          <label>Warehouse Name:</label>
                          </br>
                          <label>Address:</label>
                          </div>  
                          
                          <div class="col-md-2">
                        <label>TAGGING</label>
                            <div class="form-group">
                              <label><input type="checkbox" class="minimal" checked></label>
                              <label>Customer</label>
                            </div>

                            <div class="form-group">
                              <label><input type="checkbox" class="minimal" checked></label>
                              <label>Supplier</label>
                            </div>

                            <div class="form-group">
                              <label><input type="checkbox" class="minimal" checked></label>
                              <label>Warehouse</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                        </br>
                            <div class="form-group">
                              <label><input type="checkbox" class="minimal" checked></label>
                              <label>Agent</label>
                            </div>

                            <div class="form-group">
                              <label><input type="checkbox" class="minimal" checked></label>
                              <label>Employee</label>
                            </div>

                            <div class="form-group">
                              <label><input type="checkbox" class="minimal" checked></label>
                              <label>Hold Customer</label>
                            </div>
                        </div>

                      </div>
                    </div><!-- /.tab-pane -->

                    <div class="tab-pane" id="tab_2">
                      <!-- PUT CONTENT HERE -->
                    <div class="table-responsive">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Barcode</th>
                                  <th>Itemname</th>
                                  <th>Balance</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>1</td>
                                  <td>Table cell</td>
                                  <td>Table cell</td>
                                  

                              </tr>
                              <tr>
                                  <td>1</td>
                                  <td>Table cell</td>
                                  <td>Table cell</td>

                              </tr>
                              <tr>
                                  <td>1</td>
                                  <td>Table cell</td>
                                  <td>Table cell</td>

                              </tr>
                          </tbody>
                      </table>
                      </div>
                    </div><!-- /.tab-pane -->

                  </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
              </div><!-- /.col -->

            <!-- END CUSTOM TABS -->