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
                    <a href="<?php echo site_url('user/dashboard'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-o"></i>&nbsp;Latest Shifts</button>-->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>&nbsp;Assign Pump</button>
                </div>
            </div>
        </div>
        <br/>
        <div class="row row-border">
            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                <form  action="<?php echo site_url('dailyentries/attendantsshifts'); ?>" method="get">
                    <div class="form-group">
                        <label>Shifts Due To Date</label>
                        <div class="input-group">
                            <input type="text" name="date" value="<?php echo $date; ?>" class="form-control form-control-sm">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                <a href="<?php echo site_url('dailyentries/attendantsshifts?date=' . $prev_day); ?>" class="btn btn-info"><i class="fa fa-backward"></i></a>
                                <a href="<?php echo site_url('dailyentries/attendantsshifts?date=' . $next_day); ?>" class="btn btn-info"><i class="fa fa-forward"></i></a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 offset-lg-3 col-md-4 offset-md-2 col-sm-4 col-xs-12">

                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="text" value="" id="search_shifts" placeholder="Search keywords" class="form-control form-control-sm">
                </div>
            </div>

        </div>
        <br/>
      

        

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="shifts_table" class="table  table-hover table-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Attendants</th>
                                    <th>Shift</th>
                                    <th>Pump</th>
                                    <th>Open<br/>Mtr No</th>
                                    <th>Closing<br/>Mtr No</th>
                                    <th>Selling<br/>Price</th>
                                    <th>Amount<br/>Banked</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($atts as $i => $att) {
                                    ?>
                                    <tr>
                                        <td><?php echo $att['user_name']; ?></td>
                                        <td><?php
                                            echo $att['shift_name'] . '<br/>';
                                            if ($att['att_shift_status'] == 'Closed') {
                                                ?>
                                                <span class="badge badge-success">CLOSED</span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="badge badge-danger">IN-PROGRESS</span>
                                                <?php
                                            }
                                            ?></td>
                                        <td><?php echo $att['pump_name'] . '&nbsp;-&nbsp;' . $att['fuel_type_generic_name']; ?></td>
                                        <td><?php echo $att['att_op_mtr_reading']; ?></td>
                                        <td><?php echo $att['att_clo_mtr_reading']; ?></td>
                                        <td>
                                            <?php
                                            echo CURRENCY . '&nbsp;' . cus_price_form_french($att['att_sale_price_per_ltr']);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($att['att_shift_status'] == 'Closed') {
                                                echo CURRENCY . '&nbsp;' . cus_price_form_french($att['att_amount_banked']) . '<br/>';
                                                $amt_collected = $att['att_amount_banked'];
                                                $ltrs = $att['throughput'] - (float) $att['credit_sales'] - (float) $att['return_to_tank'] - (float) $att['transfered_to_station'];
                                                $amt_to_collect = $ltrs * $att['att_sale_price_per_ltr'];

                                                $short_excess = $amt_collected - $amt_to_collect;

                                                if ($short_excess >= 0) {
                                                    ?>
                                                    <span class="badge badge-success"><?php echo CURRENCY . '&nbsp;' . cus_price_form_french($short_excess); ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="badge badge-danger"><?php echo CURRENCY . '&nbsp;' . cus_price_form_french(abs($short_excess)); ?></span>
                                                    <?php
                                                }
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('dailyentries/saledetails/' . $att['att_id']).'?url='. urlencode(current_url()) .'?'.$_SERVER['QUERY_STRING']; ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Details</a>
                                                    <a href="<?php echo site_url('dailyentries/addcreditsale/' . $att['att_id']); ?>"  class="dropdown-item request_form text-info"> <i class="fa fa-credit-card"></i>&nbsp;&nbsp;Add Credit Sale</a>
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

        s_table = $('#shifts_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: { headerOffset: 70 },
            searching: false,
            lengthChange: false,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });


        $('#search_shifts').keyup(function () {
            s_table.search($(this).val()).draw();
        });
        
        s_table.responsive.recalc();

        $("input[name=date]").daterangepicker({

            "singleDatePicker": true,
            "autoUpdateInput": false,
            "autoApply": true,
            "linkedCalendars": false,
            "startDate": "<?php echo date('m/d/Y', strtotime($date)); ?>",
            "maxDate": "<?php echo date('m/d/Y'); ?>"

        }, function (start, end, label) {
            $("input[name=date]").val(start.format('YYYY-MM-DD'));
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    });

</script>
