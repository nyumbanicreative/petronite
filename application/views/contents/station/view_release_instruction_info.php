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
                    <a href="<?php echo site_url('station/releaseinstructions'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-arrow-circle-left"></i>&nbsp;Back</a>
                </div>

                <div class="pull-right">
                    <?php
                    if ($ri['ri_status'] == 'NEW') {
                        ?>
                        <a href="<?php echo site_url('station/markriasreleased/' . $ri['ri_id']); ?>"  class="btn btn-sm btn-primary confirm" title="Mark This Release Instruction As Released"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Mark As Released</a>
                        <?php
                    }
                    ?>
                    <a href="<?php echo site_url('station/pdfreleaseinstructioninfo/' . $ri['ri_id']); ?>" target="_blank" class="btn btn-danger btn-sm" ><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF</a>
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
                        if ($ri['ri_status'] == 'NEW') {
                            ?>
                            <a href="#" data-toggle="modal" data-target="#addPoInRi" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i>&nbsp;&nbsp;Add LPO in RI</a>
                            <?php
                        }
                        ?>

                    </div>

                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Release Inst. No</label>
                                        <p><?php echo $ri['ri_number']; ?></p>
                                    </div>
                                </div>
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Loading Date</label>
                                        <p><?php echo $ri['ri_loading_date']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Depot</label>
                                        <p><?php echo $ri['depo_name']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Seller</label>
                                        <p><?php echo strtoupper($ri['seller_name']); ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <p><?php echo strtoupper($ri['customer_name']); ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>RI Status</label>
                                        <?php
                                        switch ($ri['ri_status']) {
                                            case 'NEW':
                                                ?>
                                                <h4><span class="badge badge-info">NEW</span></h4>
                                                <?php
                                                break;

                                            case 'RELEASED':
                                                ?>
                                                <h4><span class="badge badge-success">RELEASED</span></h4>
                                                <?php
                                                break;

                                            default:
                                                ?>
                                                <h4><span class="badge badge-info"><?php echo $ri['ri_status']; ?></span></h4>
                                                <?php
                                                break;
                                        }
                                        ?>
                                        </p>
                                    </div>
                                </div>

                                <?php
                                if ($ri_vessels) {
                                    ?>
                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Vessel(s)</label>
                                            <p>
                                                <?php
                                                foreach ($ri_vessels as $key => $v) {
                                                    echo $v['vessel_name'] . ' - ' . $v['fuel_type_group_name'] . '<br/>';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">

                    <h3 class="h4">Purchase Orders</h3>
                    <div style="padding:10px 0"></div>
                    <div class="card-body no-padding">

                        <?php
                        if ($ri_orders) {
                            ?>
                            <table id="purchase_orders" class="table table-striped credit_sales table-hover table-light" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Order Date</th>
                                        <th>Driver</th>
                                        <th nowrap="nowrap">Truck No</th>
                                        <?php
                                        foreach ($ri_fuel_types as $i => $rift) {
                                            $total[$i] = 0;
                                            ?>
                                            <th><?php echo strtoupper($rift['fuel_type_group_name']); ?></th>
                                            <?php
                                        }
                                        ?>
                                        <th>Delivery Point</th>
                                        <?php
                                        if (in_array($ri['ri_status'], ['NEW'])) {
                                            ?>
                                            <th style="width:10px;"></th>
                                            <?php
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($ri_orders as $po) {
                                        ?>
                                        <tr>
                                            <td><?php echo $po['po_number']; ?></td>
                                            <td nowrap="nowrap"><?php echo $po['po_date']; ?></td>
                                            <td nowrap="nowrap"><?php echo $po['po_driver_name'] . '<br/>' . $po['po_driver_license']; ?></td>
                                            <td nowrap="nowrap"><?php echo $po['po_truck_number']; ?></td>
                                            <?php
                                            foreach ($ri_fuel_types as $i => $rift) {
                                                ?>
                                                <td>
                                                    <?php
                                                    if ($rift['fuel_type_group_id'] == $po['fuel_type_group_id']) {
                                                        $total[$i] += $po['po_volume'];
                                                        echo $po['po_volume'];
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                            <td nowrap="nowrap"><?php echo $po['station_name']; ?></td>
                                            <?php
                                            if (in_array($ri['ri_status'], ['NEW'])) {
                                                ?>
                                                <td>
                                                    <a href="<?php echo site_url('station/removepofromri/' . $po['po_id']); ?>" class="btn btn-outline-danger btn-sm confirm" title="Remove Purchase Order From Release Instruction."><i class="fa fa-trash-o"></i></a>
                                                </td>
                                                <?php
                                            }
                                            ?>

                                        </tr>
                                        <?php
                                    }
                                    ?>

                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <?php
                                        foreach ($ri_fuel_types as $i => $rift) {

                                            echo '<th>' . $total[$i] . '</th>';
                                        }
                                        ?>
                                        <th></th>
                                        <?php
                                        if (in_array($ri['ri_status'], ['NEW'])) {
                                            ?>
                                            <th></th>
                                            <?php
                                        }
                                        ?>

                                    </tr>
                                </tfoot>


                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <p style="padding: 100px 0;" class="text-center has-shadow">Release instruction has no order added yet</p>
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


    });

</script>
