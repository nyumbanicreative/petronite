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
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addPetroniteCustomer"><i class="fa fa-plus-square"></i>&nbsp;Add Customer</button>
                </div>
            </div>
        </div>
        <br/>
        <div id="addPetroniteCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <form id="add_petronite_customer_form" class="modal-content" method="post" action="<?php echo site_url('customers/submitaddpetronitecustomer');?>">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Register Customer</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <h3 class="h5">Company Details</h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="company_name">
                                    <label>Company Name</label>
                                    <input placeholder="Enter the company name" class="form-control" name="company_name"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="company_slogan">
                                    <label>Company Slogan</label>
                                    <input placeholder="Enter the company slogan" class="form-control" name="company_slogan"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="company_tin">
                                    <label>Company TIN</label>
                                    <input placeholder="Enter the company TIN Number" class="form-control" name="company_tin"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="company_vrn">
                                    <label>Company VRN </label>
                                    <input placeholder="Enter the company VRN Number" class="form-control" name="company_vrn"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="company_contact_text">
                                    <label>Company Contact Text</label>
                                    <textarea class="form-control" name="company_contact_text" placeholder="Enter the contact text"  value=""></textarea>
                                </div>
                            </div>

                        </div>
                        <div class=" row">
                            <div class="col-12">
                                <div class="form-group" id="file">
                                    <label>Attach Company Banner</label>
                                    <div>
                                        <div class="dropzone"  id="uploadcds">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br/>
                        <h3 class="h5">Main Administrator Details</h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="admin_full_name">
                                    <label>Admin Full Name</label>
                                    <input placeholder="Enter the admin fullname" class="form-control" name="admin_full_name"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="admin_user_name">
                                    <label>Admin User Name</label>
                                    <input placeholder="Enter the admin username" class="form-control" name="admin_user_name"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="admin_phone">
                                    <label>Admin Phone Number</label>
                                    <input placeholder="Enter the admin phone number" class="form-control" name="admin_phone"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="admin_email">
                                    <label>Admin Email Address</label>
                                    <input placeholder="Enter the admin email address" class="form-control" name="admin_email"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="admin_address">
                                    <label>Admin Address</label>
                                    <textarea class="form-control" name="admin_address" placeholder="Enter the address"  value=""></textarea>
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
        <div id="editPetroniteCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <form id="edit_petronite_customer_form" class="modal-content" method="post" action="<?php echo site_url('customers/submiteditpetronitecustomer');?>">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Register Customer</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <h3 class="h5">Company Details</h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_company_name">
                                    <label>Company Name</label>
                                    <input placeholder="Enter the company name" class="form-control" name="edit_company_name"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_company_slogan">
                                    <label>Company Slogan</label>
                                    <input placeholder="Enter the company slogan" class="form-control" name="edit_company_slogan"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_company_tin">
                                    <label>Company TIN</label>
                                    <input placeholder="Enter the company TIN Number" class="form-control" name="edit_company_tin"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_company_vrn">
                                    <label>Company VRN </label>
                                    <input placeholder="Enter the company VRN Number" class="form-control" name="edit_company_vrn"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="edit_company_contact_text">
                                    <label>Company Contact Text</label>
                                    <textarea class="form-control" name="edit_company_contact_text" placeholder="Enter the contact text"  value=""></textarea>
                                </div>
                            </div>

                        </div>
                        <div class=" row">
                            <div class="col-12">
                                <div class="form-group" >
                                    <label>Company Banner</label>
                                    <div>
                                        <img style="width:100%; max-height: 100px;" id="company_banner" src="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-12">
                                <div class="form-group" id="edit_file">
                                    <label>Attach Company Banner If You Wish To Replace Existing (Optional)</label>
                                    <div>
                                        <div class="dropzone"  id="edit_uploadcds">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br/>
                        <h3 class="h5">Main Administrator Details</h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_admin_full_name">
                                    <label>Admin Full Name</label>
                                    <input placeholder="Enter the admin fullname" class="form-control" name="edit_admin_full_name"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_admin_user_name">
                                    <label>Admin User Name</label>
                                    <input readonly="readonly" placeholder="Enter the admin username" class="form-control" name="edit_admin_user_name"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_admin_phone">
                                    <label>Admin Phone Number</label>
                                    <input placeholder="Enter the admin phone number" class="form-control" name="edit_admin_phone"  value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="edit_admin_email">
                                    <label>Admin Email Address</label>
                                    <input placeholder="Enter the admin email address" class="form-control" name="edit_admin_email"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="edit_admin_address">
                                    <label>Admin Address</label>
                                    <textarea class="form-control" name="edit_admin_address" placeholder="Enter the address"  value=""></textarea>
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
                    <div class="card-body no-padding">
                        <table id="customers_table" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th nowrap="nowrap">Company TIN</th>
                                    <th nowrap="nowrap">Company VRN</th>
                                    <th>Company Contact Text</th>
                                    <th>Administrator</th>
                                    <th >Total Stations</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($customers as $i => $c) {
                                    ?>
                                    <tr>
                                        <td nowrap="nowrap"><a href="<?php echo site_url('developer/setcustomer/' . $c['pc_admin_id']); ?>"><?php echo $c['pc_name']; ?></a></td>
                                        <td><?php echo $c['pc_tin_number']; ?></td>
                                         <td><?php echo $c['pc_vrn']; ?></td>
                                          <td><?php echo $c['pc_contact_text']; ?></td>
                                          <td><?php echo $c['user_name']; ?></td>
                                        <td><?php echo $c['total_stations']; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('developer/setcustomer/' . $c['pc_admin_id']); ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-building-o"></i>&nbsp;&nbsp;Stations</a>
                                                    <a href="<?php echo site_url('customers/requesteditpetronitecustomerform/' . $c['pc_id']); ?>"  class="dropdown-item request_form"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                    <a href="<?php echo site_url('customers/deletepetronitecustomer/' . $c['pc_id']); ?>" class="dropdown-item confirm text-danger" title="delete <strong><?php echo strtoupper($c['pc_name']); ?> </strong>from petronite customers"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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

<!--  <script src="<?php echo base_url(); ?>assets/js/charts-home.js" type="text/javascript"></script>-->

<script type="text/javascript">

    Dropzone.autoDiscover = false;
    
    $(document).ready(function () {
        $('#customers_table').DataTable({
            responsive: true,
            searching: false,
            lengthChange: false,
            fixedHeader: {headerOffset: 70},
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1}
            ]
        });
        
        
        var myDropzone = new Dropzone('div#uploadcds', {url: '<?php echo site_url('utility/upload/COMPANY_BANNER'); ?>',
            parallelUploads: 100,
            maxFiles: 1,
        });

        //        Drop zone on error
        myDropzone.on("error", function (file, message, xhr) {

            var header = xhr.status + ": " + xhr.statusText;

            $(file.previewElement).find('.dz-error-message').text(message.error);

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

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
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {


                e.preventDefault();
                $.ajax({

                    type: "get",
                    url: "<?php echo base_url(); ?>index.php/utility/removetempfile/" + message.filename,
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzone.cancelUpload(file);
                myDropzone.removeFile(file);

            });

        });
        
        
        var editPcDropzone = new Dropzone('div#edit_uploadcds', {url: '<?php echo site_url('utility/upload/EDIT_COMPANY_BANNER'); ?>',
            parallelUploads: 100,
            maxFiles: 1,
        });

        //        Drop zone on error
        editPcDropzone.on("error", function (file, message, xhr) {

            var header = xhr.status + ": " + xhr.statusText;

            $(file.previewElement).find('.dz-error-message').text(message.error);

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {

                e.preventDefault();
                myDropzone.removeFile(file);

            });

        });


        editPcDropzone.on("success", function (file, message) {

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {


                e.preventDefault();
                $.ajax({

                    type: "get",
                    url: "<?php echo base_url(); ?>index.php/utility/removetempfile/" + message.filename,
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzone.cancelUpload(file);
                myDropzone.removeFile(file);

            });

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


