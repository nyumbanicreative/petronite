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
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addservice"><i class="fa fa-plus-square"></i>&nbsp;Add Service</button>
                </div>
            </div>
        </div>
        <br/>
        <div id="addservice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_hall_service_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Add Hall Service</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col col-12">
                                <div class="form-group" id="service_name">
                                    <label>Service Name</label>
                                    <input type="text" name="service_name" value="" autocomplete="off" placeholder="Enter service name" class="form-control"/>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="editHallService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="edit_hall_service_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Edit Hall Service</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="edit_service_id">
                            <input type="hidden" name="edit_service_id"/>
                        </div>
                        <div class="row">
                            <div class="col col-12">
                                <div class="form-group" id="edit_service_name">
                                    <label>Service Name</label>
                                    <input type="text" name="edit_service_name" autocomplete="off"  value="" placeholder="Enter service name" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body padding">
                        <table id="items_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:20px">#</th>
                                    <th>Service Name</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($hall_services as $i => $service) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i + 1; ?></th>
                                        <td><?php echo $service['hall_service_name']; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" <?php echo $service['hall_service_type'] == 'BOOKING' ?  'disabled' : ''; ?> id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('inventory/edithallservice/' . $service['hall_service_id']); ?>" class="dropdown-item edit_service"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                    <a href="<?php echo site_url('inventory/deletehallservice/'. $service['hall_service_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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

        $('#items_table').DataTable();

        // Submiting Add Hall Service
        $(document).on('submit', '#add_hall_service_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('inventory/submitaddhallservice'); ?>',
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

        $(document).on('click', '.edit_service', function (e) {

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
                        if(data.status.error_type == 'pop'){
                            alert(data.status.error_msg);
                        }
                        
                    } else {
                        
                        $('input[name=edit_service_name]').val(data.service_data.hall_service_name);
                        $('input[name=edit_service_id]').val(data.service_data.hall_service_id);
                        
                        $('#editHallService').modal('show');
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
        
        $(document).on('submit', '#edit_hall_service_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('inventory/submitedithallservice'); ?>',
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
