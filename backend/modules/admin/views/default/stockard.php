<?php

$this->title = 'Stockard';

?>

<!--BUTTON HEADERS -->
<div class="row">
<div class="col-md-12">
      <div class="box box-solid box-success">
        <div class="box-body">
             <div class="btn-group"> 
               <button type="button" class="btn bg-green btn-flat margin"  role="button">New Item</button>
               <button type="button" class="btn bg-green btn-flat margin"  role="button">Edit Item</button>
               <button type="button" class="btn bg-green btn-flat margin"  role="button">Print Item</button>
               <button type="button" class="btn bg-green btn-flat margin"  role="button">Delete Item</button>
               <button type="button" class="btn bg-red btn-flat margin"  role="button">User Logs</button>

                    
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


<div class="row">
            
            <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom box box-solid box-success">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">General Information</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Ledger</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Recieved</a></li>
                  <li><a href="#tab_2" data-toggle="tab">PO</a></li>
                  <li><a href="#tab_2" data-toggle="tab">SO</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Warehouse</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Supplier</a></li> 
                  <li><a href="#tab_3" data-toggle="tab">Properties</a></li>
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

                        <div class="col-md-5">
                        <label>Barcode:</label>
                        </br>
                        <label>Item Name:</label>
                        </br>
                        <label>Brand:</label>
                        </br>
                        <label>Part #:</label>
                        </br>
                        <label>Model:</label>
                        </br>
                        <label>Class:</label>
                        </br>
                        <label>Category:</label>
                        
                        </div>  

                        <div class="col-md-5">
                        <label>Group:</label>
                        </br>
                        <label>Body:</label>
                        </br>
                        <label>Size:</label>
                        </br>
                        <label>UOM:</label>
                        </br>
                        <label>Remarks :</label>
                        
                        </div>  
                    </div>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="tab_2">
                    <!-- PUT CONTENT HERE -->
                  <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Doc #</th>
                                <th>Date</th>
                                <th>Supplierr/Customer</th>
                                <th>Ref #</th>
                                <th>Landed Cost</th>
                                <th>QTY In</th>
                                <th>QTY Out</th>
                                <th>Balance</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Remarks</th>
                                <th>Encoded</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="tab_3">
                  <div class="row">
                      <div class="col-md-4">
                        <label>PRICES</label>
                        </br>
                        <div class="form-group">
                        <label>Retail:</label>  
                        </br>
                        <label>Discount:</label>  
                        </div>

                        <div class="form-group">
                        <label>Wholesale:</label>  
                        </br>
                        <label>Discount:</label>  
                        </div>

                        <div class="form-group">
                        <label>ATP:</label>  
                        </br>
                        <label>Discount:</label>  
                        </div>

                        <div class="form-group">
                        <label>Price1:</label>  
                        </br>
                        <label>Discount:</label>  
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label>ALERTS</label>
                        </br>
                        <div class="form-group">
                        <label>Minimum:</label>  
                        </div>

                        <div class="form-group">
                        <label>Maximum:</label>  
                        </div>
                      </div>

                      <div class="col-md-4">
                      <label>TAGGING</label>
                          <div class="form-group">
                            <label><input type="checkbox" class="minimal" checked></label>
                            <label>Inactive</label>
                          </div>

                          <div class="form-group">
                            <label><input type="checkbox" class="minimal" checked></label>
                            <label>Imported</label>
                          </div>

                          
                      </div>

                      

                  </div><!--row-->
                  </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->

          <!-- END CUSTOM TABS -->

           

