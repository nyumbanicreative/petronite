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
        <li class="breadcrumb-item"><a href="<?php echo site_url('halls/hallslist'); ?>">Venues List</a></li>
        <li class="breadcrumb-item active"><?php echo $module_name; ?></li>
    </ul>
</div>
<?php echo $error_msg . $success_msg; ?>
<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add_schedule"><i class="fa fa-plus-square"></i>&nbsp;Add Schedule</button>
                </div>
            </div>
        </div>
        <br/>
        <div class="project">
            <div class="row bg-white has-shadow">
                <div class="left-col col-lg-9 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">

                        <div class="text">
                            <h3 class="h4"><?php echo $hall['hall_name']; ?></h3><small><i class="fa fa-map-marker"></i>&nbsp;<?php echo $hall['hall_address_description']; ?></small>
                        </div>
                    </div>
                    <div class="project-date">

                        <?php
                        if (!empty($hall['ratings'])) {
                            ?>
                            <div class="rate" title="<?php echo round($hall['ratings'], 1); ?>" style="margin-bottom:0px" data-rateyo-read-only="true" data-rateyo-star-width="20px" data-rateyo-rating="<?php echo round($hall['ratings'], 1) ?>"> </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="right-col col-lg-3 d-flex align-items-center">
                    <div class="time text-info"><?php echo $hall['currency_short_name'] . '&nbsp;' . hall_price_form_french($hall['hall_amount']); ?></div>
<!--                    <div class="comments"><i class="fa fa-clock-o"></i>&nbsp;Per Hour</div>-->

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="sheduletable" class="table table-striped">
                            <thead>
                                <tr>
                                    <!--<th style="width:10px;">#</th>-->
                                    <th>Event Date</th>
                                    <th>Customer Name</th>
                                    <th>Bride Name</th>
                                    <th>Groom Name</th>
                                    <th>Phone Number</th>

                                    <th style="width:100px;">Booking</th>
                                    <th>Balance</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($schedules as $i => $s) {
                                    ?>
                                    <tr>
                                        <!--<th scope="row"><?php // echo $i + 1;  ?></th>-->
                                        <td><?php echo date('Y-m-d', strtotime($s['booking_event_date']));
                                ; ?></td>
                                        <td><?php echo $s['booking_full_name'];
                                ; ?></td>
                                        <td><?php echo $s['booking_bride_name'];
                                ; ?></td>
                                        <td><?php echo $s['booking_groom_name'];
                                ; ?></td>
                                        <td><?php echo $s['booking_phone_number'];
                                        ; ?></td>
                                        <td>
                                            <?php
                                            if ($s['booking_paid_status'] == 1) {
                                                ?>
                                                <span class="badge badge-success">Paid</span>
                                                <?php
                                            } elseif ($s['booking_paid_status'] == 0) {
                                                ?>
                                                <span class="badge badge-warning">Pending</span>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <?php
                                            if ($s['booking_balance'] > 0) {
                                                ?>
                                                <h2 class="badge badge-danger"><?php echo hall_price_form($s['booking_balance']) . ' Tsh'; ?></h2>
                                                <?php
                                            } else {
                                                ?>
                                                <h2 class="badge badge-danger"><?php echo hall_price_form($s['booking_balance']) . ' Tsh'; ?></h2>
        <?php
    }
    ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('booking/bookingdetails/' . $s['booking_id']); ?>" id="closeCard2"  aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                                            <!--                                            <div class="dropdown">
                                                                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                                                                <a href="<?php echo site_url('booking/bookingdetails/' . $s['booking_id']); ?>"   class="dropdown-item text-info"> <i class="fa fa-eye"></i>&nbsp;&nbsp;Open</a>
                                                                                                <a href="#" data-toggle="modal" data-target="#editAmenity" class="dropdown-item text-violet"> <i class="fa fa-calendar"></i>&nbsp;&nbsp;Reschedule</a>
                                                                                                <a href="#" data-toggle="modal" data-target="#editAmenity" class="dropdown-item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Details</a>
                                                                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-times-circle"></i>&nbsp;&nbsp;Cancel</a>
                                                                                            </div>
                                                                                        </div>-->
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


<div id="add_schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <form id="add_schedule_form" class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Add Schedule</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" id="event_name">
                            <label>Event Name</label>
                            <input placeholder="Enter the event name" class="form-control" name="event_name"  value="">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group" id="event_date">
                            <label>Event Date</label>
                            <input placeholder="Enter the event date"  class="form-control" name="event_date" id="_event_date" value="">
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" id="full_name">
                            <label>Customer Full Name</label>
                            <input placeholder="Enter customer full name" class="form-control" name="full_name"  value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="phone_number">
                            <label>Customer Phone Number</label>
                            <input placeholder="Enter the customer phone number"  class="form-control" name="phone_number"  value="">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" id="bride_name">
                            <label>Bride Name</label>
                            <input placeholder="Enter the bride name"  class="form-control" name="bride_name"  value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="groom_name">
                            <label>Groom Name</label>
                            <input placeholder="Enter the groom name"  class="form-control" name="groom_name"  value="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                <button type="submit" class="btn btn-success"><i class="fa fa-calendar-plus-o"></i>&nbsp;Add Schedule</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        
        $('#sheduletable').DataTable({
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1}
            ]
        });
        
        
       
        
        $('#_event_date').daterangepicker({
            
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
            $('#_event_date').val(start.format('YYYY-MM-DD'));
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
        
        
        $(document).on('submit', '#add_schedule_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('booking/submitaddschedule'); ?>',
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
