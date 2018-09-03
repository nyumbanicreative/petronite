<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>

<div id="addCollection"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="add_collection_form" class="modal-content" action="">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Add Attendant Collection</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="" id="as_form">

                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="addc_date">
                            <label>Collection Date</label>
                            <input name="addc_date" class="form-control" readonly="readonly" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="addc_attendant">
                            <label>Attendant & Shift</label>
                            <input name="addc_attendant" class="form-control" readonly="readonly" />
                        </div>
                    </div>
                </div>
                
              
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="addc_amount_to_collect">
                            <label>Amount To Be Collected</label>
                            <input  class="form-control" name="addc_amount_to_collect" readonly="readonly" />
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="addc_amount_collected">
                            <label>Amount Collected</label>
                            <input autocomplete="off" type="text" name="addc_amount_collected"  placeholder="Enter the amount collected"  class="form-control amount"/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="addc_loss_gain">
                            <label>Loss/Gain</label>
                            <input type="text" name="addc_loss_gain"  placeholder="Loss Or Gain" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Collection</button>
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
                    <!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>&nbsp;Assign Pump</button>-->
                </div>
            </div>
        </div>
        <br/>
        <div class="row row-border">
            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                <form  action="<?php echo site_url('dailyentries/attendantscollections'); ?>" method="get">
                    <div class="form-group">
                        <label>Credits Due To Date</label>
                        <div class="input-group">
                            <input type="text" name="date" value="<?php echo $date; ?>" class="form-control form-control-sm">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                <a href="<?php echo site_url('dailyentries/attendantscollections?date=' . $prev_day); ?>" class="btn btn-info"><i class="fa fa-backward"></i></a>
                                <a href="<?php echo site_url('dailyentries/attendantscollections?date=' . $next_day); ?>" class="btn btn-info"><i class="fa fa-forward"></i></a>
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
                                    <th>Attendant</th>
                                    <th>Shift</th>
                                    <th>Amount To Collect</th>
                                    <th>Collection Status</th>
                                    <th>Amount Collected</th>
                                    <th>Loss/Gain</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($attendant_collections as $i => $attc) {
                                    $amount_to_collect = $attc['througput_amount'] - (float) $attc['credit_sales_amount'];
                                    $loss_gain = $attc['attc_amount']  - $amount_to_collect;
                                    ?>
                                    <tr>
                                        <td nowrap="nowrap"><?php echo $attc['attendant']; ?></td>
                                        <td><?php echo $attc['shift_name']; ?></td>
                                        <td nowrap="nowrap"><?php echo cus_price_form_french($amount_to_collect).' '.CURRENCY; ?></td>
                                        <td>
                                            <?php
                                            if (empty($attc['attc_id'])) {
                                                ?>
                                                <h4><span class="badge badge-danger">PENDING</span></h4>
                                                <?php
                                            } else {
                                                ?>
                                                <h4><span class="badge badge-success">COLLECTED</span></h4>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (empty($attc['attc_id'])) {
                                                ?>
                                                N/A
                                                <?php
                                            } else {
                                                echo cus_price_form_french($attc['attc_amount']) .' '.CURRENCY;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (empty($attc['attc_id'])) {
                                                ?>
                                                N/A
                                                <?php
                                            } else {
                                                echo $loss_gain > 0 ? '<h4><span class="badge badge-success">'.cus_price_form_french($loss_gain).' '.CURRENCY.'</span></h4>':'<h4><span class="badge badge_danger">'. cus_price_form_french(abs($loss_gain)).' '.CURRENCY.'</span></h4>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <?php
                                                    if (empty($attc['attc_id'])) {
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/requestaddcollectionform/' . $attc['att_employee_id']) . '?date=' . urlencode($attc['att_date']) . '&shift=' . urlencode($attc['att_shift_id']) . '&attendant=' . urlencode($attc['att_employee_id']) . '&url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING']; ?>"  class="dropdown-item text-info request_form"> <i class="fa fa-money"></i>&nbsp;&nbsp;Add Collection</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/saledetails/' . $attc['att_employee_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING']; ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Collection</a>
                                                        <?php
                                                    }
                                                    ?>
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
