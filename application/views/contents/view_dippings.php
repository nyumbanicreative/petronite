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
                            <table class="table dippings_table table-hover table-striped" style="width:100%">
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
                                                        <span class="badge badge-success">CLOSED</span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="badge badge-danger">IN-PROGRESS</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                            <a href="<?php //echo site_url('inventory/edithallitem/' . $list['customer_sale_id']);    ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                            <a href="<?php //echo site_url('inventory/deletehallitem/' . $list['customer_sale_id']);    ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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
            fixedHeader: { headerOffset: 70 },
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
