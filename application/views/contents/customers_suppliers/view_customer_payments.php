<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>

<div id="cancelPayment"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="cancel_payment_form" class="modal-content" action="">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Confirm Cancel Payment</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="pay_details">
                            <label>Payment Details</label>
                            <textarea readonly="" rows="5" class="form-control" name="pay_details" placeholder="Loading Payment Details .. "></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="cancel_reason">
                            <label>Canceling Reason</label>
                            <select name="cancel_reason" style="width:100%">
                                <option value=""></option>
                                <option value="INVALID ENTRY">INVALID ENTRY</option>
                                <option value="PAYMENT RETURN">PAYMENT RETURN</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="cancel_notes">
                            <label>Canceling Notes</label>
                            <textarea class="form-control" name="cancel_notes" placeholder="Enter the cancel notes"></textarea>
                        </div>
                    </div>
                </div>
                
                <p class="text-info"><b>Note:</b> Once you cancel this payment, the process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Save</button>
            </div>
        </form>
    </div>
</div>

<section class="tables no-padding-top">  

    <div class="container-fluid" style="min-height: 500px;">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Dashboard">
                    <a href="<?php echo site_url('user/dashboard'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Fuel Types">
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-o"></i>&nbsp;Latest Shifts</button>-->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPayment"><i class="fa fa-user-plus"></i>&nbsp;Add Payment</button>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="shifts_table" class="table  table-hover table-striped table-light table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:100px;">Date</th>
                                    <th>Customer Name</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Method</th>
                                    <th>Txn Reference No</th>
                                    <th>Notes</th>
                                    <th>Location</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>

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
        
        $('select[name=cancel_reason]').select2({placeholder:'Select cancel reason'});

        $('#shifts_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 25,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('payments/ajaxcustomerpayments'); ?>",
                data: {type: ""},
                "type": "POST",
                error: function (xhr, error, thrown) {
                    alert('Something went wrong!');
                    // location.reload(false);
                }
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1},
                {
                    "targets": [1, 2, 3], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ]
        });
    });

</script>
