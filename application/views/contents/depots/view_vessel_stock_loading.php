<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>


<?php echo $alert; ?>

<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px; ">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo $this->input->get('url'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-arrow-circle-left"></i>&nbsp;Back</a>
                </div>

                <div class="pull-right">
                    <a href="<?php echo site_url('depots/excelvesselstockloading/' . $vessel['vessel_id']); ?>" target="_blank" class="btn btn-secondary btn-sm" ><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export Excel</a>
                </div>
            </div>
        </div>

        <br/>
        <br/>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">

                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Details</h3>
                    </div>

                    <div class="card-close">

                        <?php
                        if ($vessel['vessel_status'] == 'OPENED') {
                            ?>
                            <a href="#" data-toggle="modal" data-target="#addStockLoadingSingle" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i>&nbsp;&nbsp;Add Loading</a>
                            <?php
                        }
                        ?>

                    </div>

                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Vessel Name</label>
                                        <p><?php echo $vessel['vessel_name'] . ' - '. $vessel['fuel_type_group_name'] ; ?></p>
                                    </div>
                                </div>
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Laycan</label>
                                        <p><?php echo cus_nice_date($vessel['vessel_laycan']); ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Date Received</label>
                                        <p><?php echo cus_nice_date($vessel['vessel_received_on']); ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Added By</label>
                                        <p><?php echo $vessel['user_name']; ?></p>
                                    </div>
                                </div>
                                
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Vessel Opening Balance</label>
                                        <p><?php echo $opening_balance; ?></p>
                                    </div>
                                </div>


                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Vessel Satatus</label>
                                        <?php
                                        switch ($vessel['vessel_status']) {
                                            case 'RECEIVED':
                                                ?>
                                                <h4><span class="badge badge-warning">RECEIVED</span></h4>
                                                <?php
                                                break;

                                            case 'OPENED':
                                                ?>
                                                <h4><span class="badge badge-info">OPENED</span></h4>
                                                <?php
                                                break;

                                            case 'CLOSED':
                                                ?>
                                                <h4><span class="badge badge-success">CLOSED</span></h4>
                                                    <?php
                                                    break;

                                                default:
                                                    ?>
                                                <h4><span class="badge badge-info"><?php echo $vessel['vessel_status']; ?></span></h4>
                                                <?php
                                                break;
                                        }
                                        ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">

                    <h3 class="h4">Stock Loading</h3>
                    <div style="padding:10px 0"></div>
                    <div class="card-body no-padding">

                        <?php
                        if ($stock_loading) {
                            ?>
                            <table  id="stock_loading_table" class="table table-striped credit_sales table-hover table-light" style="width:100%; font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>Loading Date</th>
                                        <th>Truck Number</th>
                                        <th>Volume Ordered</th>
                                        <th><?php ?> Invoice Number</th>
                                        <th>OBS Volume Loaded</th>
                                        <th>Conversion Factor</th>
                                        <th>Volume Loaded</th>
                                        <th>Avaialbe Volume</th>
                                        <th>Transfer Note</th>
                                        <th>Delivery</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($stock_loading as $sl) {
                                        ?>
                                        <tr>
                                            <td nowrap="nowrap"><?php echo $sl['sl_date']; ?></td>
                                            <td nowrap="nowrap"><?php echo $sl['po_truck_number'] .'<br/>'.$sl['po_driver_name']; ?></td>
                                            <td nowrap="nowrap"><?php echo $sl['po_volume']; ?></td>
                                            <td nowrap="nowrap"><?php echo $sl['sl_invoice_number']; ?></td>
                                            
                                            <td nowrap="nowrap"><?php echo $sl['sl_volume_loaded']; ?></td>
                                            <td nowrap="nowrap"><?php echo $sl['sl_conversion_factor']; ?></td>
                                            <td nowrap="nowrap"><?php echo ($sl['sl_conversion_factor'] * $sl['sl_volume_loaded']); ?></td>
                                            <td nowrap="nowrap"><?php echo $sl['sl_balance_after']; ?></td>
                                            <td></td>
                                            <td nowrap="nowrap">
                                                <?php 
                                                echo $sl['station_name']; 
                                                
                                                if($sl['po_status'] != 'DELIVERED'){
                                                    echo '<br/>' . '<h5><span class="badge badge-warning">IN-TRANSIT</span></h5>';
                                                }else{
                                                    echo '<br/>' . '<h5><span class="badge badge-success">DELIVERED</span></h5>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <p style="padding: 100px 0;" class="text-center has-shadow">Currently there is no loading performed from this vessel</p>
                            <?php
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>



    </div>
</section>

<script type="text/javascript">

    $(document).ready(function () {
        $('#stock_loading_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: false,
            lengthChange: false,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });

    });

</script>
