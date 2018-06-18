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
                    <!--<a href="<?php echo site_url('user/dashboard'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>-->
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-o"></i>&nbsp;Latest Shifts</button>-->
                    <!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addStockLoading"><i class="fa fa-plus-square"></i>&nbsp;Add Stock Loading</button>-->
                </div>
            </div>
        </div>
        <br/>
        
        <br/>
        <div id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form action="<?php echo site_url('depots/stockcontrolreport'); ?>" method="post" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Filter Expense Report</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="item_name">
                                    <label>Select Date Range<br/><small class="text-primary">Clear this field if you want to get report from the beginning.</small></label>
                                    <input autocomplete="off" placeholder="Select Date Range" class="form-control" name="date_range" id="_date_range" value="<?php echo set_value('date_range'); ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="fuel_type">
                                    <label>Fuel Type</label>
                                    <select style="width: 100%" id="_payment_method" name="fuel_type">
                                        <option value="0">All Types</option>
                                        <?php
                                        foreach ($fuel_types as $ft) {
                                            ?>
                                            <option <?php echo set_value('fuel_type') == $ft['fuel_type_group_id'] ? 'selected' : ''; ?> value="<?php echo $ft['fuel_type_group_id']; ?>"><?php echo $ft['fuel_type_group_generic_name'] .' - '. $ft['fuel_type_group_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" data-toggle="modal" data-target="#filter" class="btn btn-info btn-sm"><i class="fa fa-filter"></i>&nbsp;Filter</button>
                        </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Report Summary</h3>
                    </div>
                    <div class="card-body">
                        <form >
                            <div class="row">
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Report Date</label>
                                        <p><?php echo $selected_date_range; ?></p>
                                    </div>
                                </div>
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Product Type</label>
                                        <p>
                                            <?php
                                            echo $selected_fuel_type_name;
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Total Quantity Received</label>
                                        <p>
                                            <?php
                                            echo $total_volume_received;
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
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="report_table" class="table  table-hover table-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Vessel Name</th>
                                    <th>Product</th>
                                    <th>Laycan</th>
                                    <th>Received Date</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Added By</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($vessels as $i => $sv) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo $sv['vessel_name'];
                                            ?>
                                        </td>
                                        <td><?php echo $sv['fuel_type_group_generic_name'] . ' - ' . $sv['fuel_type_group_name'] ?></td>
                                        <td><?php echo $sv['vessel_laycan']; ?></td>
                                        <td><?php echo $sv['vessel_received_on']; ?></td>
                                        <td>
                                            <?php
                                            echo 'Arrived&nbsp;:&nbsp;&nbsp;<strong>' . $sv['vessel_ordered_volume'] . '</strong><br/>';
                                            echo 'Received&nbsp;:&nbsp;<strong>' . $sv['vessel_received_volume'] . '</strong>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($sv['vessel_status']) {
                                                case 'RECEIVED':
                                                    ?><h4><span class="badge badge-rounded badge-info">RECEIVED</span></h4><?php
                                                    break;

                                                case 'OPENED':
                                                    ?><h4><span class="badge badge-rounded badge-warning">OPENED</span></h4><?php
                                                    break;

                                                case 'CLOSED':
                                                    ?><h4><span class="badge badge-rounded badge-success">CLOSED</span></h4><?php
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $sv['user_name']; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('depots/vesselstockloading/' . $sv['vessel_id']). $current_url; ?>" class="btn btn-sm btn-info"><i class="fa fa-search"></i></a>
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

<script type="text/javascript">
    $(document).ready(function () {

        $('#items_table').DataTable({"ordering": false});

        $('#_payment_method').select2({placeholder: 'Select payment method'});

        $('#report_table').DataTable({
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

        $('#_date_range').daterangepicker({

            "singleDatePicker": false,
            "autoUpdateInput": false,
            "autoApply": true,
            "linkedCalendars": false,
            "startDate": "<?php echo date('m/d/Y'); ?>",
            "maxDate": "<?php echo date('m/d/Y'); ?>"

        }, function (start, end, label) {
            $('#_date_range').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });




    });
</script>
