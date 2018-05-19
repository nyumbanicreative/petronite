<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>

<section class="tables no-padding-top">  
    
    <div class="container-fluid" style="min-height: 500px;">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>&nbsp;Add Customer</button>
                </div>
            </div>
        </div>
        <br/>
        <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_hall_item_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Register Customer</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="item_name">
                                    <label>Item Name</label>
                                    <input placeholder="Enter the item name" class="form-control" name="item_name"  value="">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="addStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_stock_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title"> Add Item Stock</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="stock_date">
                                    <label>Stock Date</label>
                                    <input placeholder="Enter the stock receiving date" id="_stock_date" class="form-control" name="stock_date"  value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="stock_qty">
                                    <label>Quantity Received</label>
                                    <input placeholder="Enter Quantity Received" id="_stock_qty" class="form-control" name="stock_qty"  value="">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="stock_note">
                                    <label>Stock Notes <em><sup>(Optional)</sup></em></label>
                                    <textarea placeholder="Enter stock notes" rows="4" class="form-control" name="stock_notice"  value=""></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Stock</button>
                    </div>
                </form>
            </div>
        </div>
        
         <div id="editHallItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="edit_hall_item_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Edit Hall Item</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" >
                        <div id="edit_item_id">
                           <input name="edit_item_id"  type="hidden"/>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="edit_item_name">
                                    <label>Item Name</label>
                                    <input placeholder="Enter the item name" class="form-control" name="edit_item_name"  value="">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="customers_table" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Administrator</th>
                                    <th>Total Stations</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($customers as $i => $c) {
                                   
                                    ?>
                                    <tr>
                                        <td><a href="<?php echo site_url('developer/setcustomer/'.$c['pc_admin_id']); ?>"><?php echo $c['pc_name']; ?></a></td>
                                        <td><?php echo $c['user_name']; ?></td>
                                        <td><?php echo $c['total_stations']; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('developer/setcustomer/' . $c['pc_admin_id']); ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-building-o"></i>&nbsp;&nbsp;Stations</a>
                                                    <a href="<?php echo site_url('inventory/edithallitem/' . $c['pc_id']); ?>"  class="dropdown-item edit_item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                    <a href="<?php echo site_url('inventory/deletehallitem/'. $c['pc_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!--  <script src="<?php echo base_url(); ?>assets/js/charts-home.js" type="text/javascript"></script>-->

<script type="text/javascript">

    $(document).ready(function () {
        $('#customers_table').DataTable({
            responsive: true,
            searching: false,
            lengthChange : false,
            fixedHeader: { headerOffset: 70 },
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1}
            ]
        });
    });

</script>


