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
        <li class="breadcrumb-item"><a href="<?php echo site_url('booking/hallschedules'); ?>">Venues Schedules</a></li>
        <li class="breadcrumb-item active"><?php echo $module_name; ?></li>
    </ul>
</div>

<?php echo $error_msg . $success_msg; ?>




<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px; ">
        <br/>


        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class=" btn btn-info btn-sm"><i class="fa fa-gears"></i>&nbsp;Options</button>
                            <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                                <a href="#" data-toggle="modal" data-target="#addSubscription" class="dropdown-item edit"> <i class="fa fa-calendar-plus-o"></i>Add Subscription</a>
                                <a href="#" data-toggle="modal" data-target="#addPayment" class="dropdown-item edit"> <i class="fa fa-money"></i>Add Payment</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Details</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Name</label>
                                        <p><?php echo $business['business_name']; ?></p>
                                    </div>
                                </div>
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Description</label>
                                        <p><?php echo $business['business_description']; ?></p>
                                    </div>
                                </div>
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Phone</label>
                                        <p><?php echo $business['business_phone']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Email</label>
                                        <p><?php echo $business['business_email']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Date Registered</label>
                                        <p><?php echo date('Y-m-d', strtotime($business['business_timestamp'])); ?></p>
                                    </div>
                                </div>



                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Category</label>
                                        <p><?php echo $business['option_name']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Address</label>
                                        <p><?php
                                            echo $business['business_address'];
                                            ;
                                            ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-8">
                                    <div class="form-group">
                                        <label>Business Attachments</label>
                                        <p>
                                            <?php
                                            foreach ($attachments as $i => $att) {
                                                ?>
                                                <a target="_blank" href="<?php echo base_url() . 'uploads/' . $att['ba_name']; ?>">Attachment <?php echo ($i + 1); ?></a>,
                                                <?php
                                            }
                                            ;
                                            ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label> Amount</label>
                                        <div>
                                            <p style="font-size: 20px;" class="badge <?php echo ($business['business_balance'] <= 0 ) ? 'badge-danger' : 'badge-success'; ?>"><?php echo hall_price_form_french($business['business_balance']) . ' ' . CURRENCY; ?></p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label> Status</label>
                                        <div>
                                            <?php
                                            switch ($business['business_status']) {
                                                case 'NEW':
                                                    ?>
                                                    <p style="font-size: 20px;" class="badge badge-info">NEW</p>
                                                    <?php
                                                    break;

                                                case 'SUBSCRIBED':
                                                    ?>
                                                    <p style="font-size: 20px;" class="badge badge-success">SUBSCRIBED</p>
                                                    <?php
                                                    break;
                                            }
                                            ?>    
                                        </div>

                                    </div>
                                </div>



                                <?php
                                if (!empty($business['business_subscription_end_date'])) {
                                    ?>
                                    <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                        <div class="form-group">
                                            <label> Subscription End Date</label>
                                            <div>
                                                <p style="font-size: 20px;" class="badge <?php echo (strtotime($business['business_subscription_end_date']) <= time() ) ? 'badge-danger' : 'badge-success'; ?>"><?php echo hall_nice_date($business['business_subscription_end_date']); ?></p>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>


                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">
                    <!--                    <div class="card-close">
                                            <div class="dropdown">
                                                <button type="button" data-toggle="modal" data-target="#addPayment" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Payment</button>
                                            </div>
                                        </div>-->
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Payments</h3>
                    </div>
                    <div class="card-body no-padding">
                        <?php
                        if ($payments) {
                            ?>
                            <table id="services_table" class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px;">Date</th>
                                        <th>Method</th>
                                        <th>Payment Notes</th>
                                        <th>Attachment</th>
                                        <th style="width:200px" class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_py_amount = 0;
                                    foreach ($payments as $i => $p) {
                                        $total_py_amount += $p['p_amount'];
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo hall_nice_timestamp($p['p_timestamp']); ?></td>
                                            <td><?php echo $p['payment_method']; ?></td>
                                            <td><?php echo $p['p_notes']; ?></td>
                                            <td></td>
                                            <td class="text-right">
                                                <?php echo hall_price_form_french($p['p_amount']); ?> Tsh
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr>
                                        <th colspan="4">Total Payment Amount</th>
                                        <th class="text-right">
                                            <?php echo hall_price_form_french($total_py_amount); ?> Tsh
                                        </th>
                                    </tr>

                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <p style="padding:20px 0 10px;" class="text-center">No payment has been made yet</p>
                            <?php
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">
                    <!--                    <div class="card-close">
                                            <div class="dropdown">
                                                <button type="button" data-toggle="modal" data-target="#addPayment" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Payment</button>
                                            </div>
                                        </div>-->
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Subscriptions</h3>
                    </div>
                    <div class="card-body no-padding">
                        <?php
                        if ($subscriptions) {
                            ?>
                            <table id="services_table" class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px;">Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Added By</th>
                                        <th style="width:200px" class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_subs_amount = 0;
                                    foreach ($subscriptions as $i => $s) {
                                        $total_subs_amount += $s['subs_amount'];
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo hall_nice_timestamp($s['subs_timestamp']); ?></td>
                                            <td><?php echo $s['subs_start_date']; ?></td>
                                            <td><?php echo $s['subs_end_date']; ?></td>
                                            <td><?php echo $s['user_fullname']; ?></td>
                                            <td class="text-right">
                                                <?php echo hall_price_form_french($s['subs_amount']); ?> Tsh
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr>
                                        <th colspan="4">Total Subscription Amount</th>
                                        <th class="text-right">
                                            <?php echo hall_price_form_french($total_subs_amount); ?> Tsh
                                        </th>
                                    </tr>

                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <p style="padding:20px 0 10px;" class="text-center">No payment has been made yet</p>
                            <?php
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>


        <div id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_payment_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Add Payment</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div id="add_payment_business_id">
                            <input name="add_payment_business_id" type="hidden" value="<?php echo $business['business_id']; ?>"/>
                        </div>

                        <div class="row">
                            <div class="col col-12">

                                <div class="form-group" id="amount_paid">
                                    <label>Amount Paid</label>
                                    <input type="text" value="" name="amount_paid" placeholder="Enter the amount paid" class="form-control"/>
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col col-12">
                                <div class="form-group" id="payment_method">
                                    <label>Payment Method</label>
                                    <select id="select_payment_method" style="width:100%" name="payment_method">
                                        <option value=""></option>
                                        <?php
                                        foreach ($payment_methods as $pay) {
                                            ?>
                                            <option value="<?php echo $pay['option_id']; ?>"><?php echo $pay['option_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col col-12">

                                <div class="form-group" id="payment_notes">
                                    <label>Payment Notes</label>
                                    <textarea name="payment_notes" placeholder="Enter the payment notes"  class="form-control"></textarea>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit"  class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Payment</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="addSubscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_subscription_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Add Subscription</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div id="add_payment_booking_id">
                            <input name="business_id" type="hidden" value="<?php echo $business['business_id']; ?>"/>
                        </div>

                        <div class="row">
                            <div class="col col-12">

                                <div class="form-group" id="months">
                                    <label>Subscription Months</label>
                                    <input type="text" value="" name="months" placeholder="Enter total months" class="form-control"/>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit"  class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Payment</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>




<script type="text/javascript">

    $(document).ready(function () {

        $('input[name=months]').numeric({negative: false, decimal: false});

        $('#select_payment_method').select2({placeholder: 'Select Payment Method'});
        $('input[name=service_amount],input[name=amount_paid]').numeric({negative: false, decimalPlaces: 2});

        // Submiting Add Service To Business
        $(document).on('submit', '#add_subscription_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('business/submitaddsubscription'); ?>',
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

                            if (data.status.redirect == true) {
                                window.location.href = data.url;
                            }
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


        // Submiting Add Payment To Business
        $(document).on('submit', '#add_payment_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('business/submitaddpaymenttobusiness'); ?>',
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
