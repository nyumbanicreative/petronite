<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>

<div id="assignPump"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="close_vessel_form" class="modal-content" action="<?php echo site_url('dailyentries/submitassignshift');?>">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Assign Pump To Attendant</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="as_form">
                            
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="as_attendant">
                            <label>Attendant</label>
                            <select style="width: 100%;" name="as_attendant">
                                <option value=""></option>
                                <?php
                                foreach ($attendants as $attendant) {
                                    ?>
                                    <option value="<?php echo $attendant['user_id'] ?>"><?php echo $attendant['user_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="as_pump_id">
                            <label>Pump</label>
                            <select style="width: 100%;" name="as_pump_id">
                                <option value=""></option>
                                <?php
                                foreach ($pumps as $p) {
                                    if (!in_array($p['pump_id'], $opened_pumps)) {
                                        ?>
                                        <option value="<?php echo $p['pump_id'] ?>"><?php echo $p['pump_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="as_shift_date">
                            <label>Attendance Date</label>
                            <input readonly="" type="text"placeholder="Attendance Date" name="as_shift_date" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="as_att_shift">
                            <label>Shift</label>
                            <select disabled="disabled" style="width: 100%;" name="as_att_shift" class="form-control">
                                <option value=""></option>
                                <?php
                                foreach ($shifts as $s) {
                                        ?>
                                        <option value="<?php echo $s['shift_id'] ?>"><?php echo $s['shift_name']; ?></option>
                                        <?php
                                    
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="as_op_mtr_rdngs">
                            <label>Opening Meter Readings</label>
                            <input type="text" name="as_op_mtr_rdngs"  placeholder="Opening Meter Readings" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Assign</button>
            </div>
        </form>
    </div>
</div>

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
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#assignPump"><i class="fa fa-plus-square"></i>&nbsp;Assign Pump</button>
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
                        <table id="shifts_table" class="table  table-hover table-light table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Attendants</th>
                                    <th>Shift</th>
                                    <th>Pump</th>
                                    <th>Open<br/>Mtr No</th>
                                    <th>Closing<br/>Mtr No</th>
                                    <th>Selling<br/>Price</th>
                                    <th>Amount<br/>Collected</th>
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
                                            if ($att['att_shift_status'] == 'Closed' AND $att['att_posted_to_ledger'] == '0') {
                                                ?>
                                                <span class="badge badge-warning">PENDING LEDGER</span>
                                                <?php
                                            } elseif ($att['att_shift_status'] == 'Closed' AND $att['att_posted_to_ledger'] == '1') {
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
                                        <td>
                                            <?php 
                                            
                                            if($att['att_shift_status'] == 'Opened'){
                                                echo 'N/A';
                                            }else{
                                            echo $att['att_clo_mtr_reading']; 
                                            }
                                            ?>
                                        </td>
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
                                                    <a href="<?php echo site_url('dailyentries/saledetails/' . $att['att_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING']; ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Details</a>
                                                    <?php
                                                    if ($att['att_shift_status'] == 'Closed' AND $att['att_posted_to_ledger'] == '0') {
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/posttoledger/' . $att['att_id']); ?>"  class="dropdown-item text-danger confirm" title="post sale details to account ledgers. <br/>Process can not be revert"> <i class="fa fa-list-alt"></i>&nbsp;&nbsp;Post To Ledger</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <?php
                                                    }
                                                    
                                                    if($att['att_shift_status'] == 'Opened'){
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/requestcloseshiftform/' . $att['att_id']); ?>"  class="dropdown-item request_form text-danger"> <i class="fa fa-clock-o"></i>&nbsp;&nbsp;Close Shift</a>
                                                        <?php
                                                    }
                                                    ?>
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

        $('select[name=as_attendant]').select2({placeholder: 'Select an attendant'});
        $('select[name=as_pump_id]').select2({
            placeholder: 'Select Pump',
            language: {
                noResults: function () {
                    return "No result found";
                }
            },
        });
        $('select[name=as_att_shift]').select2({placeholder: 'Select Shift', readonly:true});

        s_table = $('#shifts_table').DataTable({
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
