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
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-plus-o"></i>&nbsp;Add Expenditure</button>
                    <!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>&nbsp;Assign Pump</button>-->
                </div>
            </div>
        </div>
        <br/>
        <div class="row row-border">
            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                <form  action="<?php echo site_url('dailyentries/expenditure'); ?>" method="get">
                    <div class="form-group">
                        <label>Expenditure Due To Date</label>
                        <div class="input-group">
                            <input type="text" name="date" value="<?php echo $date; ?>" class="form-control form-control-sm">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                <a href="<?php echo site_url('dailyentries/expenditure?date=' . $prev_day); ?>" class="btn btn-info"><i class="fa fa-backward"></i></a>
                                <a href="<?php echo site_url('dailyentries/expenditure?date=' . $next_day); ?>" class="btn btn-info"><i class="fa fa-forward"></i></a>
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
                                    <th>Expenditure Notes</th>
                                    <th>Expenditure Amount</th>
                                    <th>Expense Type</th>
                                    <th>Shift Details</th>
                                    <th>Approval Status</th>
                                    <th>Added By</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($expenditures as $i => $e) {
                                    ?>
                                    <tr >
                                        <td><?php echo $e['general_expenditure_notes']; ?></td>
                                        <td><?php echo cus_price_form_french($e['general_expenditure_amount']). '&nbsp;' . CURRENCY; ?></td>
                                        <td><?php echo $e['expenditure_type_title']; ?></td>
                                        <td><?php echo $e['shift_name']; ?></td>
                                        <td><?php
                                            if ($e['approval_status'] == '1') {
                                                ?>
                                                <p><?php echo $e['approved_by']; ?><br/><?php echo cus_nice_timestamp($e['approval_time']); ?></p>
                                                <span class="badge badge-success badge-rounded">APPROVED</span>
                                                <?php
                                            } elseif ($e['approval_status'] == '0') {
                                                ?>
                                                <span class="badge badge-danger badge-rounded">PENDING APPROVAL</span>
                                                <?php
                                            }
                                            ?></td>
                                        <td><?php echo $e['added_by']; ?></td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php //echo site_url('dailyentries/saledetails/' . $e['general_expenditure_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING']; ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Details</a>
                                                    <a href="<?php //echo site_url('inventory/edithallitem/' . $e['general_expenditure_id']); ?>"  class="dropdown-item edit_item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                    <a href="<?php //echo site_url('inventory/deletehallitem/' . $e['general_expenditure_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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

        $("input[name=date]").daterangepicker({
            isCustomDate: function (date) {

                var formatted = date.format('MM/DD/YYYY');
                if (["<?php echo implode('","', $expenditure_dates) ?>"].indexOf(formatted) > -1) {
                    return 'bg-success text-light';
                } else {
                    return ''
                }
            },
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
