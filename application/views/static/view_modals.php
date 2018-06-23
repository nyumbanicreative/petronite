<?php
//ADDING NEW USER MODAL
if (in_array('modal_add_user', $modals)) {
    ?>
    <div id="addUser"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="add_user_form" class="modal-content" action="<?php echo site_url('admin/submitnewuser'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add New User</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="full_name">
                                <label>Full Name</label>
                                <input autocomplete="off" placeholder="Enter Full Name"  class="form-control" name="full_name" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="user_name">
                                <label>Username</label>
                                <input autocomplete="off" placeholder="Enter Username" class="form-control" name="user_name" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="driving_license">
                                <label>Driving License</label>
                                <input autocomplete="off" placeholder="Enter Driving License" class="form-control" name="driving_license" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="user_role">
                                <label>User Role</label>
                                <select style="width: 100%" name="user_role">
                                    <option value=""></option>
                                    <?php
                                    foreach ($user_roles as $ur) {
                                        ?>
                                        <option value="<?php echo $ur['key']; ?>"><?php echo ucwords(strtolower($ur['value'])); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="user_phone">
                                <label>User Phone</label>
                                <input autocomplete="off" placeholder="Enter Driving License"  class="form-control" name="user_phone" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="user_email">
                                <label>User Email</label>
                                <input autocomplete="off" placeholder="Enter Driving License"  class="form-control" name="user_email" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="user_address">
                                <label>User Address</label>
                                <input autocomplete="off" placeholder="Enter Driving License"  class="form-control" name="user_address" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add User</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}


//ADDING ORDER DELIVERY
if (in_array('modal_add_order_delivery', $modals)) {
    ?>
    <div id="addOrderDelivery"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="add_user_form" class="modal-content" action="<?php echo site_url('admin/submitnewuser'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add New User</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group" id="od_po_id">
                                <label>Order No</label>
                                <select style="width: 100%" name="od_po_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($orders as $o) {
                                        ?>
                                        <option value="<?php echo $o['po_id']; ?>"><?php echo $o['po_number']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" id="od_date">
                                <label>Delivery Date</label>
                                <input autocomplete="off" placeholder="Enter Username" class="form-control" name="user_name" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="driving_license">
                                <label>Driving License</label>
                                <input autocomplete="off" placeholder="Enter Driving License" class="form-control" name="driving_license" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="user_role">
                                <label>User Role</label>
                                <select style="width: 100%" name="user_role">
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="user_phone">
                                <label>User Phone</label>
                                <input autocomplete="off" placeholder="Enter Driving License"  class="form-control" name="user_phone" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="user_email">
                                <label>User Email</label>
                                <input autocomplete="off" placeholder="Enter Driving License"  class="form-control" name="user_email" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="user_address">
                                <label>User Address</label>
                                <input autocomplete="off" placeholder="Enter Driving License"  class="form-control" name="user_address" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add User</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

//ADDING NEW VESSEL MODAL
if (in_array('modal_add_vessel', $modals)) {
    ?>
    <div id="addVessel"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="add_vessel_form" class="modal-content" action="<?php echo site_url('depots/submitnewvessel'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add New Vessel</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="vessel_name">
                                <label>Vessel Name</label>
                                <input placeholder="Enter the vessel name" id="_vessel_name" class="form-control" name="vessel_name" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="ftg_id">
                                <label>Fuel Type</label>
                                <select style="width: 100%" name="ftg_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($fuel_types_group as $key => $ftg) {
                                        ?>
                                        <option value="<?php echo $ftg['fuel_type_group_id'] ?>"><?php echo $ftg['fuel_type_group_generic_name'] . ' - ' . $ftg['fuel_type_group_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="vesselaycan">
                                <label>Vessel Laycan</label>
                                <input autocomplete="off" readonly="" placeholder="Enter vessel laycan" id="_vesselaycan" class="form-control max_date" name="vesselaycan"  value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="date_received">
                                <label>Date Received</label>
                                <input autocomplete="off" readonly="" placeholder="Enter vessel laycan" id="_date_received" class="form-control max_date" name="date_received"  value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="volume_ordered">
                                <label>Quantity Arrived</label>
                                <input autocomplete="off" placeholder="Enter volume ordered" id="_volume_received" class="form-control volume" name="volume_ordered"  value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="volume_received">
                                <label>Quantity Received</label>
                                <input autocomplete="off" placeholder="Enter colume received" id="_volume_received" class="form-control volume" name="volume_received"  value="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Vessel</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

//ADDING STOCK LOADING
if (in_array('modal_add_stock_loading', $modals)) {
    ?>
    <div id="addStockLoading"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="add_loading_form" class="modal-content" action="<?php echo site_url('depots/submitstockloading'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add Stock Loading</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="loading_date">
                                <label>Loading Date</label>
                                <input autocomplete="off" readonly="" placeholder="Enter stock loading date" id="_vesselaycan" class="form-control min_date" name="loading_date"  value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="invoice_number">
                                <label>Invoice Number</label>
                                <input autocomplete="off" placeholder="Enter the invoice number" id="_volume_received" class="form-control" name="invoice_number"  value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="loading_vessel_id">
                                <label>Select Vessel</label>
                                <select style="width: 100%" name="loading_vessel_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($vessels as $key => $vs) {
                                        ?>
                                        <option value="<?php echo $vs['vessel_id']; ?>"><?php echo $vs['vessel_name'] . ' - ' . $vs['fuel_type_group_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="loading_po_id">
                                <label>Purchase Order</label>
                                <select style="width: 100%" name="loading_po_id">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group" id="loading_volume_ordered">
                                <label>Volume Ordered</label>
                                <input autocomplete="off" readonly="" placeholder="Enter volume ordered" id="_volume_received" class="form-control volume" name="loading_volume_ordered"  value="">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" id="volume_loaded">
                                <label>Volume Loaded</label>
                                <input autocomplete="off" placeholder="Enter colume received"  class="form-control volume" name="volume_loaded"  value="">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="conversion_factor">
                                <label>Conversion Factor</label>
                                <input autocomplete="off" placeholder="Enter the conversion factor"  class="form-control volume" name="conversion_factor"  value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="transfer_note">
                                <label>Transfer Note Number</label>
                                <input autocomplete="off" placeholder="Enter the transfer note number"  class="form-control" name="transfer_note"  value="">
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
    <?php
}


//ADDING STOCK LOADING SINGLE
if (in_array('modal_add_stock_loading_single', $modals)) {
    ?>
    <div id="addStockLoadingSingle"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="add_loading_form" class="modal-content" action="<?php echo site_url('depots/submitstockloadingsingle/' . $vessel_id); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add Stock Loading</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="loading_date">
                                <label>Loading Date</label>
                                <input autocomplete="off" readonly="" placeholder="Enter stock loading date" id="_vesselaycan" class="form-control min_date" name="loading_date"  value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="invoice_number">
                                <label>Invoice Number</label>
                                <input autocomplete="off" placeholder="Enter the invoice number" id="_volume_received" class="form-control" name="invoice_number"  value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="loading_po_id">
                                <label>Purchase Order</label>
                                <select style="width: 100%" name="loading_po_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($orders as $po) {
                                        ?>
                                        <option value="<?php echo $po['poq_id']; ?>"><?php echo $po['po_number'] . ' - ' . $po['po_driver_name'] . ' ' . $po['po_truck_number']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="loading_volume_ordered">
                                <label>Volume Ordered</label>
                                <input autocomplete="off" readonly="" placeholder="Enter volume ordered" id="_volume_received" class="form-control volume" name="loading_volume_ordered"  value="">
                            </div>
                        </div>

                    </div>


                    <div class="row">



                        <div class="col-lg-6">
                            <div class="form-group" id="volume_loaded">
                                <label>Volume Loaded</label>
                                <input autocomplete="off" placeholder="Enter colume received"  class="form-control volume" name="volume_loaded"  value="">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" id="conversion_factor">
                                <label>Conversion Factor</label>
                                <input autocomplete="off" placeholder="Enter the conversion factor"  class="form-control volume" name="conversion_factor"  value="">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group" id="transfer_note">
                                <label>Transfer Note Number</label>
                                <input autocomplete="off" placeholder="Enter the transfer note number"  class="form-control" name="transfer_note"  value="">
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
    <?php
}


//Creating PURCHASE ORDER
if (in_array('modal_add_purchase_order', $modals)) {
    ?>
    <div id="addPurchaseOrder"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="create_order_form" class="modal-content" action="<?php echo site_url('dailyentries/submitcreateorder'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Create Purchase Order</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <h1 class="h5">Order Information</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="order_date">
                                <label>Order Date</label>
                                <input autocomplete="off" readonly="" placeholder="Select the order date" id="_order_date" class="form-control max_date" name="order_date"  value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="order_number">
                                <label>Order Number</label>
                                <input placeholder="Enter the order number" id="_order_number" class="form-control" name="order_number" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="volume_ordered">
                                <label>Volume in Ltrs</label>
                                <input autocomplete="off" placeholder="Enter volume ordered" id="_volume_ordered" class="form-control volume" name="volume_ordered"  value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="truck_number">
                                <label>Truck Number</label>
                                <input autocomplete="off" placeholder="Enter the truck number" id="_truck_number" class="form-control" name="truck_number"  value="">
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="driver_name">
                                <label>Driver Name</label>
                                <input autocomplete="off" placeholder="Enter the driver name" id="_driver_name" class="form-control" name="driver_name"  value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="driver_license">
                                <label>Driver Licence</label>
                                <input autocomplete="off" placeholder="Enter the driver's license" id="_driver_license" class="form-control" name="driver_license"  value="">
                            </div>
                        </div>

                    </div>

                    <br/>
                    <h1 class="h5">Release Instructions</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="loading_date">
                                <label>Loading Date</label>
                                <input autocomplete="off" readonly="" placeholder="Select the loading date" id="_loading_date" class="form-control min_date" name="loading_date"  value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="release_inst_number">
                                <label>Release Inst. Number</label>
                                <input placeholder="Enter the release instruction number" id="_release_inst_number" class="form-control" name="release_inst_number" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="depo_id">
                                <label>Depot</label>
                                <select style="width: 100%" name="po_depo_id">
                                    <option></option>
                                    <?php
                                    foreach ($station_depots as $key => $depo) {
                                        ?>
                                        <option value="<?php echo $depo['depo_id'] ?>"><?php echo $depo['depo_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="po_vessel_id">
                                <label>Vessel</label>
                                <select style="width: 100%" name="po_vessel_id">
                                    <option value=""></option>
                                </select>
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
    <?php
}


//Creating PURCHASE ORDER HQ
if (in_array('modal_add_purchase_order_hq', $modals)) {
    ?>
    <div id="addPurchaseOrder"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="create_order_form" class="modal-content" action="<?php echo site_url('station/submitcreateorderhq'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Create Purchase Order</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <h1 class="h5">Order Information</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="order_date">
                                <label>Order Date</label>
                                <input autocomplete="off" readonly="" placeholder="Select the order date" id="_order_date" class="form-control max_date" name="order_date"  value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="po_station_id">
                                <label>Delivery Point</label>
                                <select style="width: 100%" name="po_station_id">
                                    <option></option>
                                    <?php
                                    foreach ($delivery_points as $key => $s) {
                                        ?>
                                        <option value="<?php echo $s['station_id'] ?>"><?php echo strtoupper($s['station_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="driver_id">
                                <label>Select Driver</label>
                                <select style="width: 100%" name="driver_id">
                                    <option></option>
                                    <?php
                                    foreach ($drivers as $key => $d) {
                                        ?>
                                        <option value="<?php echo $d['user_id'] ?>"><?php echo strtoupper($d['user_fullname'] . ' - ' . $d['user_driving_license']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="truck_number">
                                <label>Truck Number</label>
                                <input autocomplete="off" placeholder="Enter the truck number" id="_truck_number" class="form-control" name="truck_number"  value="">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="diesel_qty">
                                <label>Diesel Quantity</label>
                                <input autocomplete="off" placeholder="Enter volume ordered for diesel" id="_diesel_qty" class="form-control volume" name="diesel_qty"  value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="super_qty">
                                <label>Super Quantity</label>
                                <input autocomplete="off" placeholder="Enter volume ordered for super" id="_super_qty" class="form-control volume" name="super_qty"  value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="kerosene_qty">
                                <label>Kerosene Quantity</label>
                                <input autocomplete="off" placeholder="Enter volume ordered for kerosine" id="_kerosene_qty" class="form-control volume" name="kerosene_qty"  value="">
                            </div>
                        </div>
                    </div>
                    <br/>
                    <h1 class="h5">Depot &amp; Vessel</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="po_depo_id">
                                <label>Depot</label>
                                <select style="width: 100%" name="po_depo_id">
                                    <option></option>
                                    <?php
                                    foreach ($station_depots as $key => $depo) {
                                        ?>
                                        <option value="<?php echo $depo['depo_id'] ?>"><?php echo $depo['depo_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="po_vessel_id">
                                <label>Vessel</label>
                                <select multiple="" style="width: 100%" id="_po_vessel_id" name="po_vessel_id[]">
                                    <option value=""></option>
                                </select>
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
    <?php
}

//Editing PURCHASE ORDER HQ
if (in_array('modal_edit_purchase_order_hq', $modals)) {
    ?>
    <div id="editPurchaseOrder"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="edit_order_form" class="modal-content" action="<?php echo site_url('station/submiteditorderhq'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Edit Purchase Order</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <h1 class="h5">Order Information</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="edit_order_date">
                                <label>Order Date</label>
                                <input autocomplete="off" readonly="" placeholder="Select the order date" id="_order_date" class="form-control max_date" name="edit_order_date"  value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="edit_po_station_id">
                                <label>Delivery Point</label>
                                <select style="width: 100%" name="edit_po_station_id">
                                    <option></option>
                                    <?php
                                    foreach ($delivery_points as $key => $s) {
                                        ?>
                                        <option value="<?php echo $s['station_id'] ?>"><?php echo strtoupper($s['station_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" id="edit_driver_id">
                                <label>Select Driver</label>
                                <select style="width: 100%" name="edit_driver_id">
                                    <option></option>
                                    <?php
                                    foreach ($drivers as $key => $d) {
                                        ?>
                                        <option value="<?php echo $d['user_id'] ?>"><?php echo strtoupper($d['user_fullname'] . ' - ' . $d['user_driving_license']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="edit_truck_number">
                                <label>Truck Number</label>
                                <input autocomplete="off" placeholder="Enter the truck number" id="_truck_number" class="form-control" name="edit_truck_number"  value="">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="edit_diesel_qty">
                                <label>Diesel Quantity</label>
                                <input autocomplete="off" placeholder="Enter volume ordered for diesel" id="_diesel_qty" class="form-control volume" name="edit_diesel_qty"  value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="edit_super_qty">
                                <label>Super Quantity</label>
                                <input autocomplete="off" placeholder="Enter volume ordered for super" id="_super_qty" class="form-control volume" name="edit_super_qty"  value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="edit_kerosene_qty">
                                <label>Kerosene Quantity</label>
                                <input autocomplete="off" placeholder="Enter volume ordered for kerosine" id="_kerosene_qty" class="form-control volume" name="edit_kerosene_qty"  value="">
                            </div>
                        </div>
                    </div>

                    <br/>
                    <h1 class="h5">Depot &amp; Vessel</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="edit_po_depo_id">
                                <label>Depot</label>
                                <select style="width: 100%" name="edit_po_depo_id">
                                    <option></option>
                                    <?php
                                    foreach ($station_depots as $key => $depo) {
                                        ?>
                                        <option value="<?php echo $depo['depo_id'] ?>"><?php echo $depo['depo_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="edit_po_vessel_id">
                                <label>Vessel</label>
                                <select multiple="" style="width: 100%" id="_edit_po_vessel_id" name="edit_po_vessel_id[]">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}


//Create Release Instruction
if (in_array('modal_add_release_instruction', $modals)) {
    ?>
    <div id="addReleaseInstruction"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="add_release_instruction_form" class="modal-content" action="<?php echo site_url('station/submitreleaseinstruction'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Create Release Instruction</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="loading_date">
                                <label>Loading Date</label>
                                <input placeholder="Enter the loading date" readonly="" id="_vessel_name" class="form-control max_date" name="loading_date" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="depo_id">
                                <label>Depot</label>
                                <select style="width: 100%" name="depo_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($depots as $key => $depo) {
                                        ?>
                                        <option value="<?php echo $depo['depo_id'] ?>"><?php echo $depo['depo_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="auth_id">
                                <label>RI Authorizer</label>
                                <select style="width: 100%" name="auth_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($authorizers as $key => $auth) {
                                        ?>
                                        <option value="<?php echo $auth['user_id'] ?>"><?php echo $auth['user_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}


//Add Purchase Order in Release Instruction

if (in_array('modal_add_po_in_ri', $modals)) {
    ?>
    <div id="addPoInRi"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="add_po_in_ri_form" class="modal-content" action="<?php echo site_url('station/submitpoinri/' . $ri_id); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add LPO In Release Instruction</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="po_id">
                                <label>Purchase Order</label>
                                <select style="width: 100%" multiple="multiple" id="_po_ids" name="po_id[]">
                                    <option value=""></option>
                                    <?php
                                    foreach ($pos as $key => $po) {
                                        $order_qty = [];
                                        $products = "";

                                        if (cus_is_json('[' . $po['order_qty'] . ']')) {
                                            $order_qty = (array) json_decode('[' . $po['order_qty'] . ']');
                                        }

                                        foreach ($order_qty as $key => $oq) {
                                            if ($key > 0) {
                                                $products .= ', ';
                                            }
                                            $products .= $oq->product;
                                        }
                                        ?>
                                        <option value="<?php echo $po['po_id'] ?>"><?php echo $po['po_number'] . ' - ' . $po['po_driver_name'] . ' - ' . $po['po_truck_number'] . ' (' . $products . ') '; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

// CLOSE VESSEL
if (in_array('modal_close_vessel', $modals)) {
    ?>
    <div id="closeVessel"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="close_vessel_form" class="modal-content" action="">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Close Vessel</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="close_vs_vessel_name">
                                <label>Vessel Name</label>
                                <input placeholder="Vessel Name" readonly=""  class="form-control" name="close_vs_vessel_name" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="close_vs_available_volume">
                                <label>Vessel Available Volume</label>
                                <input placeholder="Available Volume" readonly=""  class="form-control" name="close_vs_available_volume" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="close_vs_remain_transfered_to">
                                <label>Remains Transfered To</label>
                                <select style="width: 100%;" name="close_vs_remain_transfered_to">

                                </select>
                            </div>
                        </div>
                    </div>

                    <p class="text-info"><strong>Note:</strong> Closing this vessel will automaticaly open another vessel if remains transfered to field is selected</p>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>

<script type="text/javascript">

    $(document).ready(function () {

        $('select[name=ftg_id]').select2({placeholder: 'Select product type'});
        $('select[name=auth_id]').select2({placeholder: 'Select user'});
        $('select[name=user_role]').select2({placeholder: 'Select user role'});
        $('select[name=edit_driver_id],select[name=driver_id]').select2({placeholder: 'Select driver'});
        $('select[name=po_station_id],select[name=edit_po_station_id]').select2({placeholder: 'Select station'});
        $('select[name=loading_po_id],#_po_ids,select[name=od_po_id]').select2({placeholder: 'Select purchase order'}); // Purchase Order
        $('select[name=po_depo_id], select[name=depo_id],select[name=edit_po_depo_id]').select2({placeholder: 'Select depot'});
        $('select[name=po_vessel_id],#_po_vessel_id,select[name=loading_vessel_id],select[name=close_vs_remain_transfered_to],#edit_po_vessel_id').select2({placeholder: 'Select vessel'});


        $(document).on('submit', '#create_order_form,#add_vessel_form,#add_loading_form,#add_release_instruction_form,#add_po_in_ri_form,#close_vessel_form,#edit_order_form,#add_user_form', function (e) {
            e.preventDefault();
            var post_data = $(this).serializeArray();
            submitAjaxForm(post_data, $(this).attr('action'));
        });

        //Cache Vessels
        $(document).on('change', 'select[name=po_depo_id],select[name=loading_vessel_id],select[name=loading_po_id]', function (e) {
            e.preventDefault();
            field = $(this).attr('name');
            value = $(this).val()
            cacheAjaxFields({field: field, value: value}, $(this).prop("tagName"));

        });

        // Request Form

        $(document).on('click', '.request_form', function (e) {

            e.preventDefault();

            url = $(this).attr('href');

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`}); // Block user interdace during submitting

            // Ajax request itself
            $.ajax({
                url: url,
                type: 'post',
                data: {}, // post data that are passed
                success: function (data, status) {

                    // Check if response have server error
                    if (data.status.error == true) {
                        // Check type of error if its pop 
                        if (data.status.error_type == 'pop') {
                            // Pop an error
                            $.alert(data.status.error_msg);
                        }

                    } else {

                        if (data.status.redirect == true) {

                            window.location.href = data.status.redirect_url;

                        } else if (data.status.pop_form == true) {

                            switch (data.status.form_type) {

                                // Populate close vessel form
                                case 'closeVessel':

                                    $('input[name=close_vs_vessel_name]').val(data.status.form_data.vessel_name);
                                    $('input[name=close_vs_available_volume]').val(data.status.form_data.vessel_balance);
                                    $("select[name=close_vs_remain_transfered_to]").empty().select2({
                                        placeholder: 'Select vessel',
                                        data: data.status.form_data.vessels
                                    });
                                    $('#close_vessel_form').attr('action', data.status.form_url);

                                    break;

                                    // Populate Edit LPO form
                                case 'editPurchaseOrder':

                                    $('select[name=edit_po_station_id]').val(data.status.form_data.po.po_station_id).trigger('change');
                                    $('select[name=edit_po_depo_id]').val(data.status.form_data.po.po_depo_id).trigger('change');
                                    $('select[name=edit_driver_id]').val(data.status.form_data.po.po_driver_id).trigger('change');
                                    $('input[name=edit_driver_name]').val(data.status.form_data.po.po_driver_name);
                                    $('input[name=edit_diesel_qty]').val(data.status.form_data.po.po_volume);
                                    $('input[name=edit_super_qty').val(data.status.form_data.po.po_volume);
                                    $('input[name=edit_kerosene_qty]').val(data.status.form_data.po.po_volume);
                                    $('input[name=edit_truck_number]').val(data.status.form_data.po.po_truck_number);
                                    $('input[name=edit_driver_license]').val(data.status.form_data.po.po_driver_license);
                                    $("#_edit_po_vessel_id").empty().select2({
                                        placeholder: 'Select vessel',
                                        data: data.status.form_data.vessels
                                    });
                                    $('#_edit_po_vessel_id').val(data.status.form_data.po.po_vessel_id).trigger('change');
                                    $('#edit_order_form').attr('action', data.status.form_url);
                                    break;

                            }

                            $('#' + data.status.form_type).modal('show');

                        }
                    }
                    $.unblockUI(); // Ublock UI coz we got the response

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on

                    $.unblockUI(); // ublock UI so they can be able to try again
                    $.alert({
                        title: 'Something went wrong!',
                        content: '<br/>' + err + '<br/>' + 'Please try again.',
                        confirm: function () {
                            // $.alert('Confirmed!'); // shorthand.
                        }
                    });
                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });

        });

        // This function submit all the modal ajax forms 
        function submitAjaxForm(post_data, url) {

            $('.field_error').remove(); // Remove red errors from all fields
            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`}); // Block user interdace during submitting

            // Ajax request itself
            $.ajax({
                url: url,
                type: 'post',
                data: post_data, // post data that are passed
                success: function (data, status) {

                    $.unblockUI(); // Ublock UI coz we got the response

                    // Check if response have server error
                    if (data.status.error == true) {

                        // Check type of error, display or pop 
                        if (data.status.error_type == 'display') {

                            // Display Errors 
                            for (var key in data.status.form_errors) {
                                console.log(key);
                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key.replace("[]", "")).append("<p class=\"field_error invalid-feedback\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    $('#' + key.replace("[]", "")).addClass("remove_error");
                                    $('#' + key.replace("[]", "")).children('.form-control').addClass("is-invalid");
                                }
                            }
                            // Animate by scrolling to a error field
                            $('html, body').animate({
                                scrollTop: $(".remove_error").offset().top - 10
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop an error
                            $.alert(data.status.error_msg);
                        }
                    } else {

                        if (data.status.redirect == true) {
                            // Redirect to a respose url
                            window.location.href = data.status.redirect_url;
                        }

                    }

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on

                    $.unblockUI(); // ublock UI so they can be able to try again
                    $.alert({
                        title: 'Something went wrong!',
                        content: '<br/>' + err + '<br/>' + 'Please try again.',
                        confirm: function () {
                            // $.alert('Confirmed!'); // shorthand.
                        }
                    });
                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        }

        // This function will autofill some fields
        function cacheAjaxFields(data, field_type) {

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`}); // Block user interdace during submitting

            // Ajax request itself
            $.ajax({
                url: '<?php echo site_url('maintenance/cachefields'); ?>',
                type: 'post',
                data: data, // post data that are passed
                success: function (data, status) {

                    $.unblockUI(); // Ublock UI coz we got the response

                    // Check if response have server error
                    if (data.status.error == true) {

                        if (field_type == 'SELECT') {
                            $('select[name=' + field + ']').select2("val", "")
                        }

                        // Check type of error if its pop 
                        if (data.status.error_type == 'pop') {
                            // Pop an error
                            $.alert(data.status.error_msg);
                        }

                    } else {

                        switch (field) {
                            case  'po_depo_id':
                                $("#_po_vessel_id").empty().select2({
                                    placeholder: 'Select vessel',
                                    data: data.vessels
                                });
                                break;

                            case 'loading_vessel_id':
                                console.log(data.po);
                                $("select[name=loading_po_id]").empty().select2({
                                    placeholder: 'Select purchase order',
                                    data: data.po
                                });

                                break;

                            case 'loading_po_id':
                                $("input[name=loading_volume_ordered]").val(data.po.poq_volume);
                                break;

                        }
                    }

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on

                    $.unblockUI(); // ublock UI so they can be able to try again
                    $.alert({
                        title: 'Something went wrong!',
                        content: '<br/>' + err + '<br/>' + 'Please try again.',
                        confirm: function () {
                            // $.alert('Confirmed!'); // shorthand.
                        }
                    });
                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        }
    });
</script>
