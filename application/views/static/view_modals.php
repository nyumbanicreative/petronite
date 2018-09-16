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
                                <label>User Login Role</label>
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
                                <input autocomplete="off" placeholder="Enter user phone number"  class="form-control" name="user_phone" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="user_email">
                                <label>User Email</label>
                                <input autocomplete="off" placeholder="Enter user email"  class="form-control" name="user_email" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="user_address">
                                <label>User Address</label>
                                <input autocomplete="off" placeholder="Enter user address"  class="form-control" name="user_address" autocomplete="off" value="">
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


//ADDING SUPPLIER
if (in_array('modal_add_supplier', $modals)) {
    ?>
    <div id="addSupplier"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="add_supplier_form" class="modal-content" action="<?php echo site_url('suppliers/submitnewsupplier'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add New Supplier</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="sup_name">
                                <label>Supplier Name</label>
                                <input autocomplete="off" placeholder="Enter Supplier Name"  class="form-control" name="sup_name" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="sup_tel">
                                <label>Supplier Tel No.</label>
                                <input autocomplete="off" placeholder="Enter Supplier Tel" class="form-control" name="sup_tel" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="sup_mob_1">
                                <label>Supplier Mobile No. 1</label>
                                <input autocomplete="off" placeholder="Enter Supplier Mobile No. 1" class="form-control" name="sup_mob_1" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="sup_mob_2">
                                <label>Supplier Mobile No. 2</label>
                                <input autocomplete="off" placeholder="Enter Supplier Mobile No. 2" class="form-control" name="sup_mob_2" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="sup_fax">
                                <label>Supplier Fax</label>
                                <input autocomplete="off" placeholder="Enter Supplier Fax"  class="form-control" name="sup_fax" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="sup_email">
                                <label>Supplier Email</label>
                                <input autocomplete="off" placeholder="Enter Supplier Email" class="form-control" name="sup_email" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="sup_address">
                                <label>Supplier Address</label>
                                <textarea name="sup_address" placeholder="Enter Supplier Address" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" id="sup_url">
                                <label>Supplier Url</label>
                                <input autocomplete="off" placeholder="Enter Supplier Website Url"  class="form-control" name="sup_url" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Supplier</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

//ADDING EDIT USER MODAL
if (in_array('modal_add_user', $modals)) {
    ?>
    <div id="editUser"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="edit_user_form" class="modal-content" action="<?php echo site_url('admin/submitnewuser'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Edit User Details</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="edit_full_name">
                                <label>Full Name</label>
                                <input autocomplete="off" placeholder="Enter Full Name"  class="form-control" name="edit_full_name" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="edit_user_name">
                                <label>Username</label>
                                <input autocomplete="off" placeholder="Enter Username" class="form-control" name="edit_user_name" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="edit_driving_license">
                                <label>Driving License</label>
                                <input autocomplete="off" placeholder="Enter Driving License" class="form-control" name="edit_driving_license" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="edit_user_role">
                                <label>User Login Role</label>
                                <select style="width: 100%" name="edit_user_role">
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
                            <div class="form-group" id="edit_user_phone">
                                <label>User Phone</label>
                                <input autocomplete="off" placeholder="Enter user phone number"  class="form-control" name="edit_user_phone" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="edit_user_email">
                                <label>User Email</label>
                                <input autocomplete="off" placeholder="Enter user email"  class="form-control" name="edit_user_email" autocomplete="off" value="">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="edit_user_address">
                                <label>User Address</label>
                                <input autocomplete="off" placeholder="Enter user address"  class="form-control" name="edit_user_address" autocomplete="off" value="">
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
                                <label>Supplier</label>
                                <select style="width: 100%" name="po_station_id">
                                    <option></option>
                                    <?php
                                    foreach ($suppliers as $key => $sup) {
                                        ?>
                                        <option value="<?php echo $sup['supplier_id'] ?>"><?php echo strtoupper($sup['supplier_name']); ?></option>
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
                                        <option value="<?php echo $auth['user_id'] ?>"><?php echo!empty($auth['user_fullname']) ? $auth['user_fullname'] : $auth['user_name']; ?></option>
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


//ADDING CREDIT SALE
if (in_array('modal_add_credit_sale', $modals)) {
    ?>
    <div id="addCreditSale"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="add_credit_sale_form" class="modal-content" action="">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add Credit Sale</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div id="add_credit_form">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="cr_attendant_details">
                                <label>Attendant</label>
                                <input placeholder="Attendant Details" readonly="" class="form-control" name="cr_attendant_details" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="cr_del_note">
                                <label>Delivery Note No</label>
                                <input placeholder="Enter delivery note no"  class="form-control" name="cr_del_note" autocomplete="off" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="cr_order_no">
                                <label>Order No</label>
                                <input placeholder="Enter the order number"  class="form-control" name="cr_order_no" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="cr_customer">
                                <label>Customer</label>
                                <select style="width: 100%;" name="cr_customer">
                                    <option value=""></option>
                                    <?php
                                    foreach ($customers as $key => $cust) {
                                        ?>
                                        <option value="<?php echo $cust['credit_type_id']; ?>"><?php echo $cust['credit_type_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="cr_truck_no">
                                <label>Truck No</label>
                                <input placeholder="Enter the truck number"  class="form-control" name="cr_truck_no" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="for_transit" style="display: none;">

                        <div class="col-md-6">
                            <div class="form-group" id="cr_driver_name">
                                <label>Driver Name</label>
                                <input placeholder="Enter the driver name"  class="form-control" name="cr_driver_name" autocomplete="off" value="">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="cr_delivery_point">
                                <label>Delivery Point</label>
                                <input placeholder="Enter the delivery point"  class="form-control" name="cr_delivery_point" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="cr_qty">
                                <label>Quantity (Ltrs)</label>
                                <input placeholder="Enter the quantity in ltrs"  class="form-control volume" name="cr_qty" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="cr_notes">
                                <label>Credit Sale Notes</label>
                                <textarea placeholder="Enter the sale notes (optional)"  class="form-control" name="cr_notes" autocomplete="off"></textarea>
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



if (in_array('modal_add_payment', $modals)) {
    ?>
    <div id="addPayment"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="add_payment_form" class="modal-content" action="<?php echo site_url('customers/submitcustomerpayment'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Add Payment</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="add_payment_form_error">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="pay_date">
                                <label>Payment Date</label>
                                <input placeholder="Enter the payment date" readonly=""  class="form-control max_date" name="pay_date" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="pay_customer">
                                <label>Customer</label>
                                <select style="width: 100%;" name="pay_customer">
                                    <option value=""></option>
                                    <?php
                                    foreach ($credit_customers as $cust) {
                                        ?>
                                        <option value="<?php echo $cust['credit_type_id']; ?>"><?php echo $cust['credit_type_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="pay_method">
                                <label>Payment Method</label>
                                <select style="width: 100%;" name="pay_method">
                                    <option value=""></option>
                                    <?php
                                    foreach ($pay_methods as $pm) {
                                        ?>
                                        <option name ="<?php echo $pm; ?>"><?php echo $pm; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="pay_amount">
                                <label>Amount Paid</label>
                                <input placeholder="Enter the amount paid"  class="form-control amount" name="pay_amount" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="pay_reference">
                                <label>Payment Reference</label>
                                <input placeholder="Enter payment reference number"  class="form-control" name="pay_reference" autocomplete="off" value="">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" id="pay_reference">
                                <label>Payment Point</label>
                                <select name="pay_point" style="width: 100%;">
                                    <option value=""></option>
                                    <?php
                                    if ($user_system_role == 'admin') {
                                        ?>
                                        <option value="0">Headquarter (HQ)</option>
                                        <?php
                                    }

                                    foreach ($pay_points as $pp) {
                                        ?>
                                        <option value="<?php echo $pp['station_id']; ?>"><?php echo $pp['station_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="pay_notes">
                                <label>Payment Notes</label>
                                <textarea class="form-control" name="pay_notes" placeholder="Enter payment notes"></textarea>
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

if (in_array('modal_close_att_shift', $modals)) {
    ?>
    <div id="closeAttShift"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="close_att_shift_form" class="modal-content" action="">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Close Attendant Shift</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="cs_form">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Attendant</label>
                                <input readonly="" type="text"placeholder="Attendant" name="cs_attendant" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" >
                                <label>Opening Meter Readings</label>
                                <input readonly="" type="text"placeholder="Opening Meter Readings" name="cs_op_mtr_rdngs" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" >
                                <label>Credit Sales Total Ltrs</label>
                                <input readonly="" type="text"placeholder="Opening Meter Readings" name="cs_ctredit_ltrs" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="cs_clo_mtr_rdngs">
                                <label>Closing Meter Readings</label>
                                <input type="text" autocomplete="off" placeholder="Closing Meter Readings" name="cs_clo_mtr_rdngs" class="form-control volume"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="cs_throughput">
                                <label>Throughput</label>
                                <input readonly="" type="text"placeholder="Throughput" name="cs_throughput" class="form-control"/>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Cancel</button>
                    <button type="submit" class="btn btn-success">Close Shift</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>

<script type="text/javascript">

    $(document).ready(function () {

        $('select[name=pay_point]').select2({placeholder: 'Select payment point'});
        $('select[name=ftg_id]').select2({placeholder: 'Select product type'});
        $('select[name=pay_method]').select2({placeholder: 'Select payment method'});
        $('select[name=cr_customer],select[name=pay_customer]').select2({placeholder: 'Select customer'});
        $('select[name=auth_id]').select2({placeholder: 'Select user'});
        $('select[name=supplier_id]').select2({placeholder: 'Select supplier'});
        $('select[name=user_role], select[name=edit_user_role]').select2({placeholder: 'Select user role'});
        $('select[name=edit_driver_id],select[name=driver_id]').select2({placeholder: 'Select driver'});
        $('select[name=po_station_id],select[name=edit_po_station_id]').select2({placeholder: 'Select station'});
        $('select[name=loading_po_id],#_po_ids,select[name=od_po_id]').select2({placeholder: 'Select purchase order'}); // Purchase Order
        $('select[name=po_depo_id], select[name=depo_id],select[name=edit_po_depo_id]').select2({placeholder: 'Select depot'});
        $('select[name=po_vessel_id],#_po_vessel_id,select[name=loading_vessel_id],select[name=close_vs_remain_transfered_to],#_edit_po_vessel_id').select2({placeholder: 'Select vessel'});


        $(document).on('submit', '#edit_dipping_form,#close_dipping_form,#edit_customer_balance_form,#edit_collection_form,#add_collection_form,#close_att_shift_form,#cancel_payment_form,#edit_petronite_customer_form,#create_order_form,#add_vessel_form,#add_loading_form,#add_release_instruction_form,#add_po_in_ri_form,#close_vessel_form,#edit_order_form,#add_user_form,#edit_user_form,#add_supplier_form,#add_credit_sale_form,#add_petronite_customer_form,#add_payment_form', function (e) {
            e.preventDefault();
            var post_data = $(this).serializeArray();
            submitAjaxForm(post_data, $(this).attr('action'));
        });

        //Cache Vessels
        $(document).on('change', 'select[name=as_pump_id],select[name=po_depo_id],select[name=loading_vessel_id],select[name=loading_po_id],select[name=cr_customer]', function (e) {
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
                                
                                // Edit Dipping
                                case 'editDipping':
                                
                                $('input[name=ed_tank]').val(data.dipping.fuel_tank_name);
                                $('input[name=ed_shift]').val(data.dipping.inventory_traking_date +' - '+data.dipping.shift_name);
                                $('input[name=ed_opening]').val(data.dipping.inventory_traking_phisical_op);
                                $('input[name=ed_closing]').val(data.dipping.inventory_traking_phisical_clo);
                                $('#edit_dipping_form').attr('action', data.status.form_url);
                                
                                
                                break;

                                // Close Dipping
                                case 'closeDipping':
                                
                                $('input[name=cd_tank]').val(data.dipping.fuel_tank_name);
                                $('input[name=cd_shift]').val(data.dipping.inventory_traking_date + ' - '+ data.dipping.shift_name);
                                $('input[name=cd_opening]').val(data.dipping.inventory_traking_phisical_op);
                                $('#close_dipping_form').attr('action', data.status.form_url);
                                
                                
                                break;
                                // Edit credit customer balance

                                case 'editCustomerBalance':
                                    
                                    $('input[name=b_customer_name]').val(data.data.customer_data.credit_type_name);
                                    
                                    var balance_amount = data.data.customer_data.credit_type_balance;
                                    if(balance_amount > 0){
                                        $('select[name=b_balance_type]').val('CREDIT').trigger('change');
                                    }else if(balance_amount < 0){
                                        $('select[name=b_balance_type]').val('DEBIT').trigger('change');
                                    }
                                    $('input[name=b_balance_amount]').val(balance_amount);
                                    $('#edit_customer_balance_form').attr('action', data.status.form_url);
                                    
                                    
                                    break;

                               // Populate close vessel form

                                case 'addCollection':

                                    throughput_amount = data.collection.througput_amount;
                                    credit_sales_amount = data.collection.credit_sales_amount;
                                    amount_to_collect = throughput_amount - credit_sales_amount;


                                    $(document).on('keyup', 'input[name=addc_amount_collected]', function () {

                                        amount_collected = ($(this).val() || 0);

                                        loss_gain = amount_collected - amount_to_collect;

                                        if (loss_gain >= 0) {
                                            $('input[name=addc_loss_gain]').val(jsAmount(parseFloat(loss_gain).toFixed(2)) + " <?php echo CURRENCY; ?>")
                                            $('input[name=addc_loss_gain]').css({'background': '#0f8234', 'color': '#fff'});
                                        } else if (loss_gain < 0) {

                                            $('input[name=addc_loss_gain]').val(jsAmount(parseFloat(Math.abs(loss_gain)).toFixed(2)) + " <?php echo CURRENCY; ?>")
                                            $('input[name=addc_loss_gain]').css({'background': 'red', 'color': '#fff'});

                                        }

                                    });

                                    console.log(amount_to_collect);

                                    $('input[name=addc_date]').val(data.collection.att_date);
                                    $('input[name=addc_amount_to_collect]').val(jsAmount(parseFloat(amount_to_collect).toFixed(2)));
                                    $('input[name=addc_attendant]').val(data.collection.attendant + ' - ' + data.collection.shift_name + '');
                                    $('#add_collection_form').attr('action', data.status.form_url);
                                    break;

                                case 'editCollection':

                                    throughput_amount = data.collection.througput_amount;
                                    credit_sales_amount = data.collection.credit_sales_amount;
                                    amount_to_collect = throughput_amount - credit_sales_amount;

                                    amount_collected = data.collection.attc_amount;

                                    loss_gain = amount_collected - amount_to_collect;

                                    if (loss_gain >= 0) {
                                        $('input[name=editc_loss_gain]').val(jsAmount(parseFloat(loss_gain).toFixed(2)) + " <?php echo CURRENCY; ?>")
                                        $('input[name=editc_loss_gain]').css({'background': '#0f8234', 'color': '#fff'});
                                    } else if (loss_gain < 0) {

                                        $('input[name=editc_loss_gain]').val(jsAmount(parseFloat(Math.abs(loss_gain)).toFixed(2)) + " <?php echo CURRENCY; ?>")
                                        $('input[name=editc_loss_gain]').css({'background': 'red', 'color': '#fff'});

                                    }

                                    $('input[name=editc_amount_collected]').val(amount_collected);

                                    $(document).on('keyup', 'input[name=editc_amount_collected]', function () {

                                        amount_collected = ($(this).val() || 0);

                                        loss_gain = amount_collected - amount_to_collect;

                                        if (loss_gain >= 0) {
                                            $('input[name=editc_loss_gain]').val(jsAmount(parseFloat(loss_gain).toFixed(2)) + " <?php echo CURRENCY; ?>")
                                            $('input[name=editc_loss_gain]').css({'background': '#0f8234', 'color': '#fff'});
                                        } else if (loss_gain < 0) {

                                            $('input[name=editc_loss_gain]').val(jsAmount(parseFloat(Math.abs(loss_gain)).toFixed(2)) + " <?php echo CURRENCY; ?>")
                                            $('input[name=editc_loss_gain]').css({'background': 'red', 'color': '#fff'});

                                        }

                                    });

                                    console.log(amount_to_collect);

                                    $('input[name=editc_date]').val(data.collection.att_date);
                                    $('input[name=editc_amount_to_collect]').val(jsAmount(parseFloat(amount_to_collect).toFixed(2)));
                                    $('input[name=editc_attendant]').val(data.collection.attendant + ' - ' + data.collection.shift_name + '');
                                    $('#edit_collection_form').attr('action', data.status.form_url);
                                    break;

                                case 'closeVessel':

                                    $('input[name=close_vs_vessel_name]').val(data.status.form_data.vessel_name);
                                    $('input[name=close_vs_available_volume]').val(data.status.form_data.vessel_balance);
                                    $("select[name=close_vs_remain_transfered_to]").empty().select2({
                                        placeholder: 'Select vessel',
                                        data: data.status.form_data.vessels
                                    });
                                    $('#close_vessel_form').attr('action', data.status.form_url);

                                    break;

                                case 'editPetroniteCustomer':

                                    $('input[name=edit_company_name]').val(data.status.form_data.customer_data.pc_name);
                                    $('input[name=edit_company_slogan]').val(data.status.form_data.customer_data.pc_slogan);
                                    $('textarea[name=edit_company_contact_text]').val(data.status.form_data.customer_data.pc_contact_text);
                                    $('input[name=edit_company_tin]').val(data.status.form_data.customer_data.pc_tin_number);
                                    $('input[name=edit_company_vrn]').val(data.status.form_data.customer_data.pc_vrn);

                                    $('input[name=edit_admin_full_name]').val(data.status.form_data.admin_data.user_fullname);
                                    $('input[name=edit_admin_user_name]').val(data.status.form_data.admin_data.user_name);
                                    $('input[name=edit_admin_phone]').val(data.status.form_data.admin_data.user_phone);
                                    $('input[name=edit_admin_email]').val(data.status.form_data.admin_data.user_email);
                                    $('input[name=edit_admin_address]').val(data.status.form_data.admin_data.user_address);
                                    $('#company_banner').attr('src', "<?php echo base_url(); ?>uploads/company_banners/" + data.status.form_data.customer_data.pc_logo)

                                    $('#edit_petronite_customer_form').attr('action', data.status.form_url);

                                    break;

                                case 'editUser':

                                    $('input[name=edit_full_name]').val(data.status.form_data.user.user_fullname);
                                    $('input[name=edit_user_name]').val(data.status.form_data.user.user_name);
                                    $('input[name=edit_driving_license]').val(data.status.form_data.user.user_driving_license);
                                    $('select[name=edit_user_role]').val(data.status.form_data.user.user_role).trigger('change');
                                    $('input[name=edit_user_phone]').val(data.status.form_data.user.user_phone);
                                    $('input[name=edit_user_email]').val(data.status.form_data.user.user_email);
                                    $('input[name=edit_user_address]').val(data.status.form_data.user.user_address);
                                    $('#edit_user_form').attr('action', data.status.form_url);

                                    break;

                                    // Populate Edit LPO form
                                case 'editPurchaseOrder':

                                    $('select[name=edit_po_station_id]').val(data.status.form_data.po.po_station_id).trigger('change');
                                    $('select[name=edit_po_depo_id]').val(data.status.form_data.po.po_depo_id).trigger('change');
                                    $('select[name=edit_driver_id]').val(data.status.form_data.po.po_driver_id).trigger('change');
                                    $('input[name=edit_driver_name]').val(data.status.form_data.po.po_driver_name);
                                    $('input[name=edit_diesel_qty]').val(data.status.form_data.poq.diesel_qty);
                                    $('input[name=edit_super_qty]').val(data.status.form_data.poq.super_qty);
                                    $('input[name=edit_kerosene_qty]').val(data.status.form_data.poq.kerosene_qty);
                                    $('input[name=edit_truck_number]').val(data.status.form_data.po.po_truck_number);
                                    $('input[name=edit_driver_license]').val(data.status.form_data.po.po_driver_license);
                                    $("#_edit_po_vessel_id").empty().select2({
                                        placeholder: 'Select vessel',
                                        data: data.status.form_data.vessels
                                    });
                                    $('#_edit_po_vessel_id').val(data.status.form_data.selected_vessels).trigger('change');

                                    $('#edit_order_form').attr('action', data.status.form_url);

                                    break;

                                case 'addCreditSale':
                                    $('input[name=cr_attendant_details]').val(data.att.user_name + ' (' + data.att.pump_name + ' - ' + data.att.fuel_type_generic_name + ' - ' + data.att.shift_name + ')');
                                    $('#add_credit_sale_form').attr('action', data.status.form_url);
                                    break;

                                case 'cancelPayment':

                                    $('textarea[name=pay_details]').val('Date:   ' + data.txn.txn_date + '\nCustomer:   ' + data.txn.credit_type_name + '\nAmount Paid:   ' + data.txn.txn_credit + ' <?php echo CURRENCY; ?>\nTxn Ref:   ' + data.txn.txn_reference_no + '\nTxn Method:   ' + data.txn.txn_method);
                                    $('#cancel_payment_form').attr('action', data.status.form_url);
                                    break;

                                case 'closeAttShift':
                                    credit_sales = parseFloat(data.att.credit_sales || 0) + parseFloat(data.att.return_to_tank || 0) + parseFloat(data.att.transfered_to_station || 0);

                                    $('input[name=cs_attendant]').val('' + data.att.user_name + ' - ' + data.att.shift_name + ' (' + data.att.pump_name + ' - ' + data.att.fuel_type_generic_name + ' )');
                                    $('input[name=cs_op_mtr_rdngs]').val(data.att.att_op_mtr_reading);
                                    $('input[name=cs_ctredit_ltrs]').val(credit_sales);

                                    $(document).on('keyup', 'input[name=cs_clo_mtr_rdngs]', function () {

                                        op_mtr_rdngs = parseFloat(data.att.att_op_mtr_reading);
                                        clo_mtr_rdngs = ($(this).val() || 0);

                                        throughput = clo_mtr_rdngs - op_mtr_rdngs;

                                        if (throughput >= 0) {
                                            $('input[name=cs_throughput]').val(parseFloat(throughput).toFixed(3) + " Ltrs")
                                            $('input[name=cs_throughput]').css({'background': '#0f8234', 'color': '#fff'});
                                        } else if (throughput < 0) {

                                            $('input[name=cs_throughput]').val(parseFloat(throughput).toFixed(3) + " Ltrs")
                                            $('input[name=cs_throughput]').css({'background': 'red', 'color': '#fff'});

                                        }

                                    });

                                    $('#close_att_shift_form').attr('action', data.status.form_url);

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

            var selected_value = data.value;

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

                        if (field_type == 'SELECT' && (selected_value != '' && selected_value != undefined)) {
                            $('select[name=' + field + ']').val('').trigger('change');
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

                            case "cr_customer":

                                if (data.customer.credit_type_type_description == 'TRANSIT') {
                                    $('#for_transit').show();
                                } else {
                                    $('#for_transit').hide();
                                }

                                break;

                            case 'as_pump_id':

                                $('input[name=as_shift_date]').val(data.next_shift.next_shift_date);
                                $('select[name=as_att_shift]').val(data.next_shift.next_shift_id).trigger('change');
                                $('input[name=as_op_mtr_rdngs]').val(data.next_shift.open_mtr_readings);

                                break;

                        }
                    }

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on

                    if (field_type == 'SELECT' && (selected_value != '' && selected_value != undefined)) {
                        $('select[name=' + field + ']').val('').trigger('change');
                    }

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

        const jsAmount = (x) => {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });
</script>
