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
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addExpense"><i class="fa fa-money"></i>&nbsp;Add Expense</button>
                </div>
            </div>
        </div>
        <br/>

        <div id="addExpense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="add_hall_expense_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title"> Add Expense</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="expense_date">
                                    <label>Expense Date</label>
                                    <input placeholder="Enter the expense date" id="_expense_date" class="form-control" name="expense_date"  value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="expense_type_id">
                                    <label>Expense Type</label>
                                    <select style="width: 100%" id="_expense_type_id" name="expense_type_id">
                                        <option value=""></option>
                                        <?php
                                        foreach ($hall_expense_types as $et) {
                                            ?>
                                            <option value="<?php echo $et['het_id']; ?>"><?php echo $et['het_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="amount_spent">
                                    <label>Expense Amount</label>
                                    <input placeholder="Enter Quantity Received" id="_amount_spent" class="form-control" name="amount_spent"  value="">
                                </div>
                            </div>
                        </div>

                        <div class=" row">
                            <div class="col-lg-12">
                                <div class="form-group" id="attachments">
                                    <label>Receipt Attachment</label>
                                    <div >
                                        <div class="dropzone"  id="uploadimages">

                                            <?php
                                            if ($temp_files) {

                                                foreach ($temp_files as $f) {
                                                    ?>
                                                    <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete"> 
                                                        <div class="dz-image"><img data-dz-thumbnail="" alt="<?php echo $f['temp_att_og_name']; ?>" src="<?php echo base_url() . 'uploads/' . $user_id . '/thumb_square_' . $f['temp_att_name'] ?>"></div>

                                                        <div class="dz-details">    
                                                            <div class="dz-size"><span data-dz-size=""><strong><i class="icon-file"></i></strong></span></div>  
                                                            <div class="dz-filename"><span data-dz-name=""><?php echo $f['temp_att_og_name']; ?></span></div>
                                                        </div>  

                                                        <div class="dz-progress">
                                                            <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                                        </div>

                                                        <div class="dz-error-message">
                                                            <span data-dz-errormessage=""></span>
                                                        </div>  
                                                        <div class="dz-success-mark">    

                                                        </div>

                                                        <a class="removetempfile" href="<?php echo base_url() . "index.php/utility/removeupload/" . $f['temp_att_name']; ?>" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 5px 10px;border-radius: 100%;"><i class="fa fa-close"></i></a>

                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                        <?php echo form_error('hall_images'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="expense_notes">
                                    <label>Expense Notes</label>
                                    <textarea placeholder="Enter the expense notes" rows="4" class="form-control" name="expense_notes"  value=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Save Expense</button>
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
                                    <th style="width120px">Date</th>
                                    
                                    <th>Expense Type</th>
                                    <th style="width: 150px">Amount Spent</th>
                                    <th>Expense Notes</th>
                                    <th style="width: 100px">Status</th>
                                    <th style="width: 10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($hall_expenses as $i => $exp) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $exp['he_date']; ?></th>
                                        
                                        <td><?php echo $exp['het_name']; ?></td>
                                        <td><?php echo hall_price_form_french($exp['he_amount']); ?> Tsh</td>
                                        <td><?php echo $exp['he_notes']; ?></td>
                                        <td>
                                            <?php 
                                                switch ($exp['he_status']){
                                                    case 'NEW';
                                                        ?><span class="badge badge-info">NEW</span><?php
                                                    break;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('expense/edithallexpensetype/' . $exp['he_attachment']); ?>" target="_blank" class="dropdown-item"> <i class="fa fa-paperclip"></i>&nbsp;&nbsp;View Attachment</a>
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

    Dropzone.autoDiscover = false;

    $(document).ready(function () {

        $('#items_table').DataTable({"bSort": false});

        $('#_expense_type_id').select2({placeholder: 'Select the expense type'});

        $('#_amount_spent').numeric({decimalPlaces: 2, negative: false});

        $('#_expense_date').daterangepicker({

            "singleDatePicker": true,
            "autoUpdateInput": false,
            "autoApply": true,
            "linkedCalendars": false,
            "startDate": "<?php echo date('m/d/Y'); ?>",
            "maxDate": "<?php echo date('m/d/Y'); ?>"

        }, function (start, end, label) {
            $('#_expense_date').val(start.format('YYYY-MM-DD'));
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        // Submiting Add Hall Item
        $(document).on('submit', '#add_hall_expense_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('expense/submitaddexpense'); ?>',
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



        var myDropzone = new Dropzone('div#uploadimages', {url: '<?php echo site_url('utility/upload/EXPENSE_ATTACHMENT'); ?>',
            parallelUploads: 100,
            maxFiles: 1,
        });

        myDropzone.on("error", function (file, message, xhr) {

            var header = xhr.status + ": " + xhr.statusText;

            $(file.previewElement).find('.dz-error-message').text(message.error);

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 5px 10px;border-radius: 100%;"><i class="fa fa-close"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {

                e.preventDefault();
                myDropzone.removeFile(file);

            });

        });


        myDropzone.on("success", function (file, message) {

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 5px 10px;border-radius: 100%;"><i class="fa fa-close"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {

                e.preventDefault();
                $.ajax({

                    type: "get",
                    url: "<?php echo base_url(); ?>index.php/utility/removeupload/" + message.filename,
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzone.cancelUpload(file);
                myDropzone.removeFile(file);

            });

        });


        myDropzone.on("addedfile", function (file) {

            /*
             
             // Create the cancel link
             var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" style="display:block;text-align:center;">Remove File</a>');
             
             // Add the cancel link to the preview element
             // If you want it to replace another element, you can do that your way of course.
             file.previewElement.appendChild(cancelLink);
             
             // Now the most important part: attach the event listener here:
             cancelLink.addEventListener("click", function(e) {
             
             e.preventDefault();
             // Referencing file here as closure
             myDropzone.cancelUpload(file);
             myDropzone.removeFile(file);
             
             });
             
             */


        });




        $('.removetempfile').click(function (e) {

            e.preventDefault();
            mother = $(this).parents('.dz-preview');
            url = $(this).attr('href');

            $.ajax({
                type: "get",
                url: url,
                success: function (data)
                {
                    mother.remove();
                }

            });
        });

    });
</script>
