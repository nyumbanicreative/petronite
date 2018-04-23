<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<!-- Breadcrumb-->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active"><?php echo $module_name; ?></li>
    </ul>
</div>
<?php echo $error_msg . $success_msg; ?>
<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height: 500px;">

        <br/>
        <div id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form action="<?php echo site_url('reports/paymentsreport'); ?>" method="post" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Filter Payment Report</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="item_name">
                                    <label>Select Date Range<br/><small class="text-primary">Clear this field if you want to get report from the beginning.</small></label>
                                    <input placeholder="Select Date Range" class="form-control" name="date_range" id="_date_range" value="<?php echo set_value('date_range'); ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="item_name">
                                    <label>Payment Method</label>
                                    <select style="width: 100%" id="_payment_method" name="payment_method">
                                        <option value="0">All Payments</option>
                                        <?php
                                        foreach ($payment_methods as $pm) {
                                            ?>
                                            <option <?php echo set_value('payment_method') == $pm['option_id'] ? 'selected' : ''; ?> value="<?php echo $pm['option_id']; ?>"><?php echo $pm['option_name']; ?></option>
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
                <div class="line-chart-example card">
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
                                        <label>Payment Method</label>
                                        <p>
                                            <?php
                                            echo $selected_payment_method_name;
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Total Amount Collected</label>
                                        <p><?php echo hall_price_form_french($total_amount); ?> Tsh</p>
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
                    <div class="card-body padding">
                        <table id="items_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:10px">#</th>
                                    <th>Date</th>
                                    <th>Event Name</th>
                                    <th>Received Amount</th>
                                    <th>Payment Method</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($payment_report as $i => $r) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i + 1; ?></th>
                                        <td><?php echo hall_nice_timestamp($r['bp_timestamp']); ?></td>
                                        <td><?php echo $r['booking_event_name']; ?></td>
                                        <td><?php echo hall_price_form_french($r['bp_amount']); ?> Tsh</td>
                                        <td><?php echo $r['option_name']; ?></td>
                                        <td><?php echo $r['bp_notes']; ?></td>
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



        // Submiting Add Hall Item
        $(document).on('submit', '#add_hall_item_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('inventory/submitaddhallitem'); ?>',
                type: 'post',
                data: postData,

                success: function (data, status) {

                    $.unblockUI();

                    // Check if response have server error
                    if (data.status.error == true) {

                        // Check type of error, display or pop 
                        if (data.status.error_type == 'display') {

                            // Display Errors 
                            for (var key in data.status.form_errors) {
                                console.log(key);
                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key).append("<p class=\"field_error invalid-feedback\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    $('#' + key).addClass("remove_error");
                                    $('#' + key).children('.form-control').addClass("is-invalid");
                                }
                            }
                            $('html, body').animate({
                                scrollTop: $(".remove_error").offset().top - 10
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop and error
                            alert(data.status.error_msg);
                        }
                    } else {
                        window.location.href = data.url;
                    }

                },
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);


                    $.unblockUI();

                    /*
                     $.alert({
                     title: 'Ooops!',
                     content: 'Something went wrong!' + '<br/><br/>' + 'Please try again.',
                     confirm: function () {
                     // $.alert('Confirmed!'); // shorthand.
                     }
                     });
                     */

                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        });

        $(document).on('click', '.edit_item', function (e) {

            e.preventDefault();

            url = $(this).attr('href');

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait ... </p>'});

            $.ajax({
                url: url,
                type: 'post',

                success: function (data, status) {

                    $.unblockUI();

                    console.log(data);

                    // Check if response have server error
                    if (data.status.error == true) {

                        // Check type of error, display or pop 
                        if (data.status.error_type == 'pop') {
                            alert(data.status.error_msg);
                        }

                    } else {

                        $('input[name=edit_item_name]').val(data.item_data.item_name);
                        $('input[name=edit_item_id]').val(data.item_data.item_id);

                        $('#editHallItem').modal('show');
                    }

                },
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);


                    $.unblockUI();

                    /*
                     $.alert({
                     title: 'Ooops!',
                     content: 'Something went wrong!' + '<br/><br/>' + 'Please try again.',
                     confirm: function () {
                     // $.alert('Confirmed!'); // shorthand.
                     }
                     });
                     */

                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        });

        $(document).on('submit', '#edit_hall_item_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('inventory/submitedithallitem'); ?>',
                type: 'post',
                data: postData,

                success: function (data, status) {

                    $.unblockUI();

                    // Check if response have server error
                    if (data.status.error == true) {

                        // Check type of error, display or pop 
                        if (data.status.error_type == 'display') {

                            // Display Errors 
                            for (var key in data.status.form_errors) {
                                console.log(key);
                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key).append("<p class=\"field_error invalid-feedback\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    $('#' + key).addClass("remove_error");
                                    $('#' + key).children('.form-control').addClass("is-invalid");
                                }
                            }
                            $('html, body').animate({
                                scrollTop: $(".remove_error").offset().top - 10
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop and error
                            alert(data.status.error_msg);
                        }
                    } else {
                        window.location.href = data.url;
                    }

                },
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);


                    $.unblockUI();

                    /*
                     $.alert({
                     title: 'Ooops!',
                     content: 'Something went wrong!' + '<br/><br/>' + 'Please try again.',
                     confirm: function () {
                     // $.alert('Confirmed!'); // shorthand.
                     }
                     });
                     */

                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        });

        $(document).on('submit', '#add_stock_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('inventory/submitaddstock'); ?>',
                type: 'post',
                data: postData,

                success: function (data, status) {

                    $.unblockUI();

                    // Check if response have server error
                    if (data.status.error == true) {

                        // Check type of error, display or pop 
                        if (data.status.error_type == 'display') {

                            // Display Errors 
                            for (var key in data.status.form_errors) {
                                console.log(key);
                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key).append("<p class=\"field_error invalid-feedback\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    $('#' + key).addClass("remove_error");
                                    $('#' + key).children('.form-control').addClass("is-invalid");
                                }
                            }
                            $('html, body').animate({
                                scrollTop: $(".remove_error").offset().top - 10
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop and error
                            alert(data.status.error_msg);
                        }
                    } else {
                        window.location.href = data.url;
                    }

                },
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);


                    $.unblockUI();

                    /*
                     $.alert({
                     title: 'Ooops!',
                     content: 'Something went wrong!' + '<br/><br/>' + 'Please try again.',
                     confirm: function () {
                     // $.alert('Confirmed!'); // shorthand.
                     }
                     });
                     */

                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        });
    });
</script>
