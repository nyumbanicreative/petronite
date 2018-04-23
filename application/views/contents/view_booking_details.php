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
                                <a href="#" data-toggle="modal" data-target="#rechedule" class="dropdown-item edit"> <i class="fa fa-calendar-o"></i>Reschedule</a>
                                <a href="#" data-toggle="modal" data-target="#editbooking" class="dropdown-item edit"> <i class="fa fa-edit"></i>Edit Details</a>
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
                                        <label>Full Name</label>
                                        <p><?php echo $booking['booking_full_name']; ?></p>
                                    </div>
                                </div>
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <p><?php echo $booking['booking_phone_number']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Booked On </label>
                                        <p><?php echo $booking['booking_timestamp']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Event Date</label>
                                        <p><?php echo date('Y-m-d', strtotime($booking['booking_event_date'])); ?></p>
                                    </div>
                                </div>



                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Groom Name</label>
                                        <p><?php echo $booking['booking_groom_name']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Bride Name</label>
                                        <p><?php
                                            echo $booking['booking_bride_name'];
                                            ;
                                            ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Balance Amount</label>
                                        <div>
                                            <p style="font-size: 20px;" class="badge <?php echo ($booking['booking_balance'] <= 0 ) ? 'badge-success' : 'badge-danger'; ?>"><?php echo hall_price_form_french($booking['booking_balance']); ?> Tsh</p>
                                        </div>

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
                <div class="line-chart-example card">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" data-toggle="modal" data-target="#addservice" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Service</button>

                        </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Booking Services</h3>
                    </div>
                    <div class="card-body no-padding">
                        <?php
                        if ($services) {
                            ?>
                            <table id="services_table" class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px;">Date</th>
                                        <th>Service Name</th>
                                        <th style="width:200px" class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_amount = 0;
                                    foreach ($services as $i => $s) {
                                        $total_amount += $s['bs_amount'];
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo hall_nice_timestamp($s['bs_timestamp']); ?></td>
                                            <td><?php echo $s['hall_service_name']; ?></td>
                                            <td class="text-right">
                                                <?php echo hall_price_form_french($s['bs_amount']); ?> Tsh
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr>
                                        <th colspan="2">Total Service Amount</th>
                                        <th class="text-right">
                                            <?php echo hall_price_form_french($total_amount); ?> Tsh
                                        </th>
                                    </tr>

                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <p style="padding:20px 0 10px;" class="text-center">No service has been made yet</p>
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
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" data-toggle="modal" data-target="#additem" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Stock</button>

                        </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Booking Stock</h3>
                    </div>
                    <div class="card-body no-padding">
                        <?php
                        if ($items) {
                            ?>
                            <table id="services_table" class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px;">Date</th>
                                        <th>Item Name</th>
                                        <th style="width:100px">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_amount = 0;
                                    foreach ($items as $i => $item) {
                                        
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo hall_nice_timestamp($item['bi_timestamp']); ?></td>
                                            <td><?php echo $item['item_name']; ?></td>
                                            <td >
                                                <?php echo $item['bi_qty']; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

<!--                                    <tr>
                                        <th colspan="2">Total Service Amount</th>
                                        <th class="text-right">
                                            <?php echo hall_price_form_french($total_amount); ?> Tsh
                                        </th>
                                    </tr>-->

                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <p style="padding:20px 0 10px;" class="text-center">No item stock has been added to this booking yet</p>
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
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" data-toggle="modal" data-target="#addPayment" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Payment</button>
                        </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Booking Payments</h3>
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
                                        $total_py_amount += $p['bp_amount'];
                                        ?>
                                        <tr>
                                           <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                            <td><?php echo hall_nice_timestamp($p['bp_timestamp']); ?></td>
                                            <td><?php echo $p['payment_method']; ?></td>
                                            <td><?php echo $p['bp_notes']; ?></td>
                                            <td></td>
                                            <td class="text-right">
                                                <?php echo hall_price_form_french($p['bp_amount']); ?> Tsh
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

        <div id="rechedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form class="modal-content" method="post" action="<?php echo site_url(''); ?>" id="reschedule_form">



                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Reschedule Booking</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id'] ?>" />
                        <div id="booking_id">

                        </div>

                        <div class="row">
                            <div class="col col-12">
                                <div class="form-group" id="event_date">
                                    <label>Event Date</label>
                                    <input type="text" id="date_range_event_date" value="<?php echo date('Y-m-d', strtotime($booking['booking_event_date'])); ?>" name="event_date" placeholder="Enter the event date"  class="form-control"/>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit"  class="btn btn-success"><i class="fa fa-calendar-plus-o"></i>&nbsp;Reschedule</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="editbooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="edit_booking_form" role="form" method="post" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Edit Booking Details</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body padding">


                        <div id="booking_id">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id'] ?>" />
                        </div>

                        <div class="row">

                            <div class="col col-xs-12" >
                                <div class="form-group" id="full_name">
                                    <label>Full Name</label>
                                    <input type="text" value="<?php echo $booking['booking_full_name']; ?>" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="full_name" placeholder="Enter Full Name"/>
                                </div>
                            </div>


                        </div>

                        <div class="row" >
                            <div class="col col-xs-12" >
                                <div class="form-group" id="phone_number">
                                    <label>Phone Number</label>
                                    <input type="text" value="<?php echo $booking['booking_phone_number']; ?>" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="phone_number" placeholder="Enter The Phone Number"/>
                                </div>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col col-xs-12" >
                                <div class="form-group" id="bride_name">
                                    <label>Bride Name</label>
                                    <input type="text" value="<?php echo $booking['booking_bride_name']; ?>" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="bride_name" placeholder="Enter The Bride Name"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-xs-12" >
                                <div class="form-group" id="groom_name">
                                    <label>Groom Name</label>
                                    <input type="text" value="<?php echo $booking['booking_groom_name']; ?>" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="groom_name" placeholder="Groom Name"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                        <button type="submit"  class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save Details</button>
                    </div>
                </form>
            </div>
        </div>


        <div id="addservice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_service_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Add Service To Booking</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div id="add_service_booking_id">
                            <input name="add_service_booking_id" type="hidden" value="<?php echo $booking['booking_id']; ?>"/>
                        </div>

                        <div class="row">
                            <div class="col col-12">
                                <div class="form-group" id="service_id">
                                    <label>Service</label>
                                    <select id="select_service" style="width:100%" name="service_id">
                                        <option value=""></option>
                                        <?php
                                        foreach ($hall_services as $s) {
                                            ?>
                                            <option value="<?php echo $s['hall_service_id']; ?>"><?php echo $s['hall_service_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col col-12">

                                <div class="form-group" id="service_amount">
                                    <label>Service Amount</label>
                                    <input type="text" value="" name="service_amount" placeholder="Enter the service amount" class="form-control"/>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12">

                                <div class="form-group" id="service_notes">
                                    <label>Service Notes</label>
                                    <textarea name="service_notes" placeholder="Enter the service notes"  class="form-control"></textarea>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Service</button>
                    </div>
                </form>
            </div>
        </div>
        
        
        <div id="additem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_item_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Add Item Stock To Booking</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div id="add_item_booking_id">
                            <input name="add_item_booking_id" type="hidden" value="<?php echo $booking['booking_id']; ?>"/>
                        </div>

                        <div class="row">
                            <div class="col col-12">
                                <div class="form-group" id="item_id">
                                    <label>Item</label>
                                    <select id="select_item_id" style="width:100%" name="item_id">
                                        <option value=""></option>
                                        <?php
                                        foreach ($hall_items as $i) {
                                            ?>
                                            <option value="<?php echo $i['item_id']; ?>"><?php echo $i['item_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col col-12">

                                <div class="form-group" id="item_qty">
                                    <label>Qty Provided</label>
                                    <input type="text" value="" name="item_qty" placeholder="Enter the quantity provided" class="form-control"/>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12">

                                <div class="form-group" id="stock_notes">
                                    <label> Notes</label>
                                    <textarea name="stock_notes" placeholder="Enter notes for this transaction"  class="form-control"></textarea>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add Item Stock</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_payment_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Add Payment To This Booking</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div id="add_payment_booking_id">
                            <input name="add_payment_booking_id" type="hidden" value="<?php echo $booking['booking_id']; ?>"/>
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

    </div>
</section>

<script type="text/javascript">

    $(document).ready(function () {
        //$('#services_table').DataTable();

        $('#select_service').select2({placeholder: 'Select service'});
        $('#select_item_id').select2({placeholder: 'Select item'});
        
        $('#select_payment_method').select2({placeholder: 'Select Payment Method'});
        $('input[name=service_amount],input[name=amount_paid]').numeric({negative: false, decimalPlaces: 2});
        $('input[name=item_qty]').numeric({negative: false, decimals: false});

        $('#date_range_event_date').daterangepicker({

            "singleDatePicker": true,
            "autoUpdateInput": false,
            "autoApply": true,
            "linkedCalendars": false,
            "startDate": "<?php echo date('m/d/Y', strtotime('tomorrow')); ?>",
            "minDate": "<?php echo date('m/d/Y', strtotime('tomorrow')); ?>",
            isInvalidDate: function (date) {

                var formatted = date.format('MM/DD/YYYY');
                return [<?php echo $booked_dates; ?>].indexOf(formatted) > -1;
            },
            isCustomDate: function (date) {

                var formatted = date.format('MM/DD/YYYY');
                if ([].indexOf(formatted) > -1) {
                    return 'pending_date disabled';
                } else {
                    return ''
                }
            }
        }, function (start, end, label) {
            $('#date_range_event_date').val(start.format('YYYY-MM-DD'));
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });


        // Submiting New Reschedule
        $(document).on('submit', '#reschedule_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('booking/submitreschedulebooking'); ?>',
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

        // Submiting Edit Booking Details 
        $(document).on('submit', '#edit_booking_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('booking/submiteditbooking'); ?>',
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

        // Submiting Add Service To Booking
        $(document).on('submit', '#add_service_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('booking/submitaddservicetobooking'); ?>',
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
        
        // Submiting Add Service To Booking
        $(document).on('submit', '#add_item_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('booking/submitaddstocktobooking'); ?>',
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

        // Submiting Add Payment To Booking
        $(document).on('submit', '#add_payment_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('booking/submitaddpaymenttobooking'); ?>',
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
