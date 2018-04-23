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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body padding">
                        <table id="businesses_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <!--<th style="width:20px">#</th>-->
                                    <th>Business Name</th>
                                    <th>Category</th>
                                    <th>Time Added</th>
                                    <th style="width: 100px">Added By</th>
                                    <th>Status</th>
                                    <th>Balance Amount</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($businesses as $i => $busi) {
                                    ?>
                                    <tr>
                                        <!--<th scope="row"><?php echo $i + 1; ?></th>-->
                                        <td><?php echo $busi['business_name']; ?></td>
                                        <td><?php echo $busi['option_name']; ?></td>
                                        <td><?php echo c_time_ago(strtotime($busi['business_timestamp'])); ?></td>
                                        <td><?php echo $busi['user_fullname']; ?></td>
                                        <td><?php
                                            switch ($busi['business_status']) {
                                                case 'NEW':
                                                    ?>
                                                    <span class="badge badge-info">NEW</span>
                                                    <?php
                                                    break;
                                                
                                                case 'SUBSCRIBED':
                                                    ?>
                                                    <span class="badge badge-success">SUBSCRIBED</span>
                                                    <?php
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $busi['business_balance'] >= 0 ? '<span class="badge badge-success">Tsh. '.$busi['business_balance'] .'</span>':'<span class="badge badge-danger">Tsh. '.$busi['business_balance'].'</span>'; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('business/businessdetails/' . $busi['business_id']); ?>"  class="dropdown-item text-info"> <i class="fa fa-search"></i>&nbsp;&nbsp;Details</a>
                                                    <a href="<?php echo site_url('business/editbusiness/' . $busi['business_id']); ?>"  class="dropdown-item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                    <a href="<?php echo site_url('inventory/deletehallitem/' . $busi['business_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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

<script type="text/javascript">
    $(document).ready(function () {

        $('#businesses_table').DataTable({
            "order": [],
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1}
            ]
        });

        $('#_add_item_id').select2({placeholder: 'Select stock item'});

        $('#_stock_qty').numeric({decimal: false, negative: false});

        $('#_stock_date').daterangepicker({

            "singleDatePicker": true,
            "autoUpdateInput": false,
            "autoApply": true,
            "linkedCalendars": false,
            "startDate": "<?php echo date('m/d/Y'); ?>",
            "maxDate": "<?php echo date('m/d/Y'); ?>"

        }, function (start, end, label) {
            $('#_stock_date').val(start.format('YYYY-MM-DD'));
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
