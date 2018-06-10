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
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('dailyentries/purchases'); ?>"class="btn btn-primary btn-sm"><i class="fa fa-chevron-circle-left"></i>&nbsp;Purchases</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addPurchaseOrder"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Create New Order</button>
                    <!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>&nbsp;Assign Pump</button>-->
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">

            <div class="col-12" style="margin-top: 10px;"></div>
            <div class="col-lg-12">
                <div class="line-chart-example card">
                    <div style="padding:10px 0"></div>
                    <div class="card-body no-padding">
                        <table id="po_table" class="table table-hover table-striped table-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order Nuber</th>
                                    <th style="">Product Type</th>
                                    <th style="">Volume (Ltrs)</th>
                                    <th style="">Driver Name</th>
                                    <th style="">Truck Number</th>
                                    <th style="">Order Status</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($purchase_orders as $i => $po) {
                                    ?>
                                    <tr>
                                        <td class="text-nowrap"><?php echo cus_nice_date($po['po_date']); ?></td>
                                        <td class="text-nowrap"><?php echo $po['po_number']; ?></td>
                                        <td><?php echo $po['fuel_type_group_generic_name'] . ' - ' . $po['fuel_type_group_name']; ?></td>
                                        <td><?php echo $po['po_volume']; ?></td>

                                        <td>
                                            <?php
                                            echo $po['po_driver_name'];
                                            if (!empty($po['po_driver_license'])) {
                                                echo '<br/>' . $po['po_driver_license'];
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $po['po_truck_number']; ?></td>
                                        <td>
                                            <?php
                                            switch ($po['po_status']) {
                                                case 'NEW':
                                                    ?>
                                                    <h4><span class="badge badge-info">NEW</span></h4>
                                                    <?php
                                                    break;

                                                case 'UNRELEASED':
                                                    ?>
                                                    <h4><span class="badge badge-warning">UNRELEASED</span></h4>
                                                    <?php
                                                    break;
                                                case 'RELEASED':
                                                    ?>
                                                    <h4><span class="badge badge-info">RELEASED</span></h4>
                                                    <?php
                                                    break;
                                                case 'LOADED':
                                                    ?>
                                                    <h4><span class="badge badge-success">LOADED</span></h4>
                                                    <?php
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <?php
                                                    if ($po['po_status'] == 'UNRELEASED') {
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/releaseorder/' . $po['po_id']); ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-list"></i>&nbsp;&nbsp;Release Order</a>
                                                        <a href="<?php //echo site_url('inventory/edithallitem/' . $list['customer_sale_id']);         ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                        <?php
                                                    } elseif (in_array ($po['po_status'], ['RELEASED','LOADED'])) {
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/pdfreleaseinstruction/' . $po['po_id']); ?>" target="_blank" class="dropdown-item edit_item text-info"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Release Instruction</a>
                                                        <?php
                                                    }
                                                    ?>


                                                    <a href="<?php //echo site_url('inventory/deletehallitem/' . $list['customer_sale_id']);         ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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

        po_table = $('#po_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: false,
            lengthChange: false,
            info: false,
            paging: false,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: -2},
                {responsivePriority: 4, targets: 1}
            ]
        });


        $('#search_shifts').keyup(function () {
            po_table.search($(this).val()).draw();
        });


    });

</script>
