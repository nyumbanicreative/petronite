<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>

<div id="closeDipping"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="close_dipping_form" class="modal-content" action="">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Close Dipping</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div id="cd_form">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="cd_tank">
                            <label>Dipping Tank</label>
                            <input name="cd_tank" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="cd_shift">
                            <label>Dipping Shift</label>
                            <input name="cd_shift" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="cd_opening">
                            <label>Opening Stock Dipping</label>
                            <input name="cd_opening" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="cd_closing">
                            <label>Closing Stock Dipping</label>
                            <input name="cd_closing" autocomplete="off" class="form-control volume"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Cancel</button>
                <button type="submit" class="btn btn-success">Close Dipping</button>
            </div>
        </form>
    </div>
</div>

<div id="editDipping"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="edit_dipping_form" class="modal-content" action="">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Edit Dipping</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div id="cd_form">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="ed_tank">
                            <label>Dipping Tank</label>
                            <input name="ed_tank" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="ed_shift">
                            <label>Dipping Shift</label>
                            <input name="ed_shift" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="ed_opening">
                            <label>Opening Stock Dipping</label>
                            <input name="ed_opening" class="form-control volume"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="ed_closing">
                            <label>Closing Stock Dipping</label>
                            <input name="ed_closing" autocomplete="off" class="form-control volume"/>
                        </div>
                    </div>
                </div>
                
                <p class="text-small text-info"><strong>Note:</strong> Modifying of opening or closing values may affect the opening and closing dipping values of previous and next dipping shift </p>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;&nbsp;Save Changes</button>
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
                <form  action="<?php echo site_url('dailyentries/dipping'); ?>" method="get">
                    <div class="form-group">
                        <label>Dipping Due To Date</label>
                        <div class="input-group">
                            <input type="text" name="date" value="<?php echo $date; ?>" class="form-control form-control-sm">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                <a href="<?php echo site_url('dailyentries/dipping?date=' . $prev_day); ?>" class="btn btn-info"><i class="fa fa-backward"></i></a>
                                <a href="<?php echo site_url('dailyentries/dipping?date=' . $next_day); ?>" class="btn btn-info"><i class="fa fa-forward"></i></a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>



        </div>
        <br/>
        <div class="row">
            <?php
            foreach ($fuel_types as $ft) {
                ?>
                <div class="col-12" style="margin-top: 10px;"></div>
                <div class="col-lg-12">
                    <div class="line-chart-example card">

                        <h3 class="h4"><?php echo $ft['fuel_type_name'] . ' - ' . $ft['fuel_type_generic_name']; ?></h3>
                        <div style="padding:10px 0"></div>
                        <div class="card-body no-padding">
                            <table class="table dippings_table table-hover table-striped table-light" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tank Name</th>
                                        <th style="">Shift Name</th>
                                        <th style="">Opening Stock</th>
                                        <th style="">Closing Stock</th>
                                        <th style="">Entry By</th>
                                        <th style="">Status</th>
                                        <th style="width:10px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dippings as $i => $d) {

                                        if ($d['fuel_type_id'] == $ft['fuel_type_id']) {
                                            ?>
                                            <tr>
                                                <td class="text-nowrap"><strong><?php echo strtoupper($d['fuel_tank_name']); ?></strong></td>
                                                <td><?php echo $d['shift_name']; ?></td>
                                                <td><?php echo $d['inventory_traking_phisical_op']; ?></td>
                                                <td><?php echo $d['inventory_traking_phisical_clo']; ?></td>
                                                <td><?php echo $d['user_name']; ?></td>
                                                <td>
                                                    <?php
                                                    if (strtolower($d['inventory_traking_status']) == 'closed') {
                                                        ?>
                                                        <h5><span class="badge badge-success">CLOSED</span></h5>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <h5><span class="badge badge-danger">IN-PROGRESS</span></h5>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (strtolower($d['inventory_traking_status']) == 'opened') {
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/requestclosedipping/' . $d['inventory_traking_id']); ?>"  class="btn btn-sm btn-outline-danger btn-block request_form">Close</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="<?php echo site_url('dailyentries/requesteditdipping/' . $d['inventory_traking_id']); ?>"  class="btn btn-sm btn-outline-info btn-block request_form">Edit</a>
                                                        <?php
                                                    }
                                                    ?>
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

                <?php
            }
            ?>

        </div>
    </div>
</section>

<!--  <script src="<?php echo base_url(); ?>assets/js/charts-home.js" type="text/javascript"></script>-->

<script type="text/javascript">

    $(document).ready(function () {

        s_table = $('.dippings_table').DataTable({
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
