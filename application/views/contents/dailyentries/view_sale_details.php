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
                    <a href="<?php echo site_url('user/dashboard'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
            </div>
        </div>

        <br/>
        <br/>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class=" btn btn-info btn-sm"><i class="fa fa-gears"></i>&nbsp;Options</button>
                            <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                                <a href="#" data-toggle="modal" data-target="#rechedule" class="dropdown-item edit"> <i class="fa fa-calendar-o"></i>Reschedule</a>
                                <a href="#" data-toggle="modal" data-target="#editbooking" class="dropdown-item edit"> <i class="fa fa-edit"></i>Edit Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Details</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Attendant</label>
                                        <p><?php echo $sale['user_name']; ?></p>
                                    </div>
                                </div>
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <p><?php echo $sale['shift_name']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Shift Date</label>
                                        <p><?php echo cus_nice_date($sale['att_date']); ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Pump</label>
                                        <p><?php echo $sale['pump_name'] . '&nbsp;-&nbsp;' . $sale['fuel_type_generic_name']; ?></p>
                                    </div>
                                </div>



                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Opening Meter No</label>
                                        <p><?php echo $sale['att_op_mtr_reading']; ?></p>
                                    </div>
                                </div>
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <p>
                                            <?php
                                            if ($sale['att_shift_status'] == 'Closed') {
                                                ?>
                                                <span class="badge badge-success">CLOSED</span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="badge badge-danger">IN-PROGRESS</span>
                                                <?php
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>

                                <?php
                                if (strtolower($sale['att_shift_status'] == 'closed')) {
                                    ?>


                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Closing Meter No</label>
                                            <p><?php echo $sale['att_clo_mtr_reading']; ?></p>
                                        </div>
                                    </div>



                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Total Cash Sales</label>

                                            <div>
                                                <p><?php
                                                    $cash_sales = ($sale['throughput'] - (float) $sale['credit_sales'] - (float) $sale['return_to_tank'] - (float) $sale['transfered_to_station']);
                                                    echo $cash_sales;
                                                    ?>&nbsp;Ltr<sub>(s)</sub></p>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Total Credit Sales</label>
                                            <div>
                                                <p><?php echo (float) $sale['credit_sales']; ?>&nbsp;Ltr<sub>(s)</sub></p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Amount To Be Collected</label>
                                            <div>
                                                <p>
                                                    <?php
                                                    $amt_to_collect = ($cash_sales * $sale['att_sale_price_per_ltr']);
                                                    echo CURRENCY . ' ' . cus_price_form_french($amt_to_collect);
                                                    ?>
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Amount Collected</label>
                                            <div>
                                                <p><?php
                                                    $amt_collected = ($sale['att_amount_banked']);
                                                    echo CURRENCY . ' ' . cus_price_form_french($amt_collected);
                                                    ?></sub></p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Short/Excess</label>
                                            <div>
                                                <?php
                                                $short_excess = $amt_collected - $amt_to_collect;
                                                ?>
                                                <p style="font-size: 16px;" class="badge <?php echo ($short_excess >= 0 ) ? 'badge-success' : 'badge-danger'; ?>"><?php echo CURRENCY . ' ' . cus_price_form_french(abs($short_excess)); ?></p>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col col-12">
                                        <p class="text-danger"><strong>Note:</strong>&nbsp; Full details will be available after closing of this shift</p>
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

        <?php
//Credit sales

        $credit_list = [];

        if (cus_is_json('[' . $sale['credit_list'] . ']')) {
            $credit_list = json_decode('[' . $sale['credit_list'] . ']');
        }
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">

                    <h3 class="h4">Credit Sales</h3>
                    <div style="padding:10px 0"></div>
                    <div class="card-body no-padding">

                        <table class="table credit_sales table-hover table-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th style="">Volume</th>
                                    <th style="" class="text-right">Amount</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_amount = 0;
                                foreach ($credit_list as $i => $list) {
                                    $list = (array) $list;

                                    if ($list['customer_sale_rtt'] == '0' && $list['customer_sale_tts'] == '0') {
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo $list['credit_type_name']; ?></td>
                                            <td><?php echo $list['customer_sale_ltrs']; ?></td>
                                            <td class="text-right">
                                                <?php echo cus_price_form_french($list['customer_sale_ltrs'] * $sale['att_sale_price_per_ltr']) . '&nbsp;' . CURRENCY; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                    <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                        <a href="<?php echo site_url('inventory/edithallitem/' . $list['customer_sale_id']); ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                        <a href="<?php echo site_url('inventory/deletehallitem/' . $list['customer_sale_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">

                    <h3 class="h4">Stock Transfer</h3>
                    <div style="padding:10px 0"></div>
                    <div class="card-body no-padding">
                        <table class="table credit_sales table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th style="">Volume</th>
                                    <th style="" class="text-right">Amount</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_amount = 0;
                                foreach ($credit_list as $i => $list) {
                                    $list = (array) $list;

                                    if ($list['customer_sale_rtt'] == '0' && $list['customer_sale_tts'] == '1') {
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo $list['credit_type_name']; ?></td>
                                            <td><?php echo $list['customer_sale_ltrs']; ?></td>
                                            <td class="text-right">
                                                <?php echo cus_price_form_french($list['customer_sale_ltrs'] * $sale['att_sale_price_per_ltr']) . '&nbsp;' . CURRENCY; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                    <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                        <a href="<?php echo site_url('inventory/edithallitem/' . $list['customer_sale_id']); ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                        <a href="<?php echo site_url('inventory/deletehallitem/' . $list['customer_sale_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">

                    <h3 class="h4">Returned To Tank</h3>
                    <div style="padding:10px 0"></div>
                    <div class="card-body no-padding">

                        <table class="table credit_sales table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th style="">Volume</th>
                                    <th style="" class="text-right">Amount</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_amount = 0;
                                foreach ($credit_list as $i => $list) {
                                    $list = (array) $list;

                                    if ($list['customer_sale_rtt'] == '1' && $list['customer_sale_tts'] == '0') {
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo $list['credit_type_name']; ?></td>
                                            <td><?php echo $list['customer_sale_ltrs']; ?></td>
                                            <td class="text-right">
                                                <?php echo cus_price_form_french($list['customer_sale_ltrs'] * $sale['att_sale_price_per_ltr']) . '&nbsp;' . CURRENCY; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                    <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                        <a href="<?php echo site_url('inventory/edithallitem/' . $list['customer_sale_id']); ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                        <a href="<?php echo site_url('inventory/deletehallitem/' . $list['customer_sale_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
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

<script type="text/javascript">

    $(document).ready(function () {


        $('.credit_sales').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: false,
            lengthChange: false,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1}
            ]
        });

        $('#select_service').select2({placeholder: 'Select service'});
        $('#select_item_id').select2({placeholder: 'Select item'});


    });

</script>
