<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>
<section class="tables no-padding-top">   
    <div class="container-fluid">
        
        <div id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form action="<?php echo site_url('customers/customersstatement/' . $cc['credit_type_id']); ?>" method="post" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Filter Settlement Date Range</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="item_name">
                                    <label>Select Date Range</label>
                                    <input placeholder="Select Date Range" autocomplete="off" class="form-control" name="date_range" id="_date_range" value="<?php echo !empty(set_value('sbt')) ?set_value('date_range') : $date_string; ?>">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <input type="submit" value="Submit" name='sbt' class="btn btn-success"/>
                    </div>
                </form>
            </div>
        </div>
        
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('user/dashboard'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                    <a href="<?php echo site_url('customers/customersbalance'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-arrow-circle-left"></i>&nbsp;Back</a>
                </div>
                
                <div class="pull-right">
                    <a href="<?php echo site_url('user/pdfcustomerinvoice/'.$cc['credit_type_id']); ?>" class="btn btn-secondary btn-sm"  target="_blank"><i class="fa fa-file-pdf-o"></i>&nbsp;Current Invoice</a>
                    <a href="<?php echo site_url('customers/pdfcustomerstatement/'.$cc['credit_type_id'].'?datefrom='.$datefrom.'&dateto='.$dateto); ?>" class="btn btn-secondary btn-sm" target="_blank"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF Statement</a>
                </div>
            </div>
        </div>

        <br/>
        <br/>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">
                    <div class="card-close">
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#filter"><i class="fa fa-calendar-o"></i>&nbsp;Filter Date Range</button>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Details</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <p><?php echo $cc['credit_type_name']; ?></p>
                                    </div>
                                </div>
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Statement Date Range</label>
                                        <p><?php echo $date_string; ?></p>
                                    </div>
                                </div>
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Customer Balance</label>
                                        <?php
                                        if ($cc['credit_type_balance'] <= 0) {
                                            echo "<h4><span class='badge badge-success'>" . cus_price_form($cc['credit_type_balance']) . ' ' . CURRENCY . "</span></h4>";
                                        } else {
                                            echo "<h4><span class='badge badge-danger'>" . cus_price_form($cc['credit_type_balance']) . ' ' . CURRENCY . "</span></h4>";
                                        }
                                        ?>
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
                        <table id="statement_table" class="table  table-hover table-striped table-light table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($txns as $key => $txn) {
                                    ?>
                                    <tr>
                                        <td><?php echo $txn['txn_timestamp'] ?></td>
                                        <td>
                                            <?php
                                            if ($txn['txn_type'] == 'CREDIT_SALE') {
                                                echo 'CREDIT SALE';
                                            } elseif ($txn['txn_type'] == 'CREDIT_PAYMENT') {
                                                echo 'RECEIPT';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($txn['txn_type'] == 'CREDIT_SALE') {
                                                echo cus_price_form_french($txn['txn_debit']);
                                            } elseif ($txn['txn_type'] == 'CREDIT_PAYMENT') {
                                                echo cus_price_form_french($txn['txn_credit']);
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $txn['txn_notes']; ?></td>
                                        <td><?php echo cus_price_form_french($txn['txn_balance_after']); ?></td>
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
        
        
        $('#statement_table').DataTable({
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
