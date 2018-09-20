<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>
<section class="tables no-padding-top">   
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('station/purchaseorders'); ?>" class="btn btn-info btn-sm"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Purchase Orders</a>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <form id="create_order_form"  action="<?php echo site_url('station/submitcreateorderhq'); ?>">
                    <h1 class="h5">Order Information</h1>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="order_date">
                                <label>Order Date</label>
                                <input autocomplete="off" readonly="" placeholder="Select the order date" id="_order_date" class="form-control max_date" name="order_date"  value="">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="supplier_id">
                                <label>Supplier</label>
                                <select style="width: 100%" name="supplier_id">
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
                        <!--
                        <div class="col-md-4 col-sm-6">
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
                        </div>-->
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="truck_number">
                                <label>Truck Number</label>
                                <input autocomplete="off" placeholder="Enter the truck number"  class="form-control" name="truck_number"  value="">
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="driver_name">
                                <label>Driver Name</label>
                                <input autocomplete="off" placeholder="Enter the driver name" class="form-control" name="driver_name"  value="">
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="license_number">
                                <label>License Number</label>
                                <input autocomplete="off" placeholder="Enter the license number" class="form-control" name="license_number"  value="">
                            </div>
                        </div>
                    </div>
                    <br/>
                    <h1 class="h5">Order &amp; Quantity</h1>
                    <div class="row p">
                        <div class="col-md-4">
                            <div class="form-group" id="product">
                            </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="form-group" id="qty">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="price">
                                </div>
                        </div>
                    </div>
                    <?php
                    foreach ($ftgs as $ftg) {
                        ?>
                        <div class="row p">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Product</label>
                                    <div class="input-group">
                                        <select name="product[]" class="po_product form-control" style="width: 100%">
                                            <option value="<?php echo $ftg['fuel_type_group_id'] ?>"><?php echo strtoupper($ftg['fuel_type_group_name']) . ' - ' . strtoupper($ftg['fuel_type_group_generic_name']); ?></option>
                                        </select>
                                        <button type="button" class="input-group-addon btn btn-danger remove_row"><i class="fa fa-remove"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" >
                                    <label><?php echo ucwords($ftg['fuel_type_group_generic_name']) ?> Quantity (Ltrs)</label>
                                    <input autocomplete="off" placeholder="Enter volume ordered for <?php echo strtolower($ftg['fuel_type_group_generic_name']) ?>"  class="form-control volume" name="qty[]"  value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo ucwords($ftg['fuel_type_group_generic_name']) ?>Unit Price</label>
                                    <input autocomplete="off" placeholder="Enter the unit price for <?php echo strtolower($ftg['fuel_type_group_generic_name']) ?>"  class="form-control amount" name="price[]"  value="">
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" id="lpo_notes">
                                <label>Purchase Order Notes</label>
                                <textarea placeholder="Enter purchase order notes" class="form-control" name="lpo_notes"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save LPO</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</section>

<script type="text/javascript">

    $(document).ready(function () {
        $('.po_product').select2({placeholder: 'Select product type'});
        $('.remove_row').click(function () {
            $(this).parents('.p').remove();
        });
    });
</script>
