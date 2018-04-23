<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<!-- Breadcrumb-->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-info" href="<?php echo site_url('user/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active"><?php echo $module_name; ?></li>
    </ul>
</div>
<?php echo $success_msg . $error_msg;?>
<section class="form">   

    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card">
               
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4">Business Registration Form</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo site_url('business/submitbusinessdetails'); ?>" method="post" class="form-horizontal">
                        <input type="hidden" name="details_type" value="adding"/>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Name</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="busi_name" value="<?php echo set_value('busi_name'); ?>" autocomplete="off" id="hall_name" placeholder="Enter the business name" class="form-control <?php echo!empty(form_error('busi_name')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('busi_name'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Description<br><small class="text-primary">Include payment information (Operator, Phone Number And Display Name)</small></label>
                            <div class="col-sm-9 input-field">
                                <textarea rows="5" name="busi_descr"  id="hall_description" placeholder="Enter the the business description" class="form-control <?php echo!empty(form_error('busi_descr')) ? 'is-invalid' : ''; ?>"><?php echo set_value('busi_descr'); ?></textarea>
                                <?php echo form_error('busi_descr'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Category<br/></label>
                            <div class="col-sm-9 input-field">
                                <select id="select_busi_cat"  name="busi_cat" style="width:100%" class="">
                                    <option   value=""></option>
                                    <?php
                                    $busi_cat = set_value('busi_cat');

                                    foreach ($business_categories as $bc) {
                                        ?>
                                        <option <?php echo ($busi_cat == $bc['option_id']) ? 'selected' : ''; ?> value="<?php echo $bc['option_id']; ?>"><?php echo $bc['option_name'] ; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('busi_cat'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Phone Number</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="busi_phone_number" value="<?php echo set_value('busi_phone_number'); ?>" id="hall_size" placeholder="Enter the business phone number" class="form-control <?php echo!empty(form_error('busi_phone_number')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('busi_phone_number'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Email Address</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="busi_email" value="<?php echo set_value('busi_email'); ?>" id="hall_size" placeholder="Enter the business email address" class="form-control <?php echo!empty(form_error('busi_email')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('busi_email'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        
                        
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Owner Full Name</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="busi_owner_name" value="<?php echo set_value('busi_owner_name'); ?>"  placeholder="Enter the business owner  name" class="form-control <?php echo!empty(form_error('busi_owner_name')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('busi_owner_name'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Owner Phone Number</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="busi_owner_phone_number" value="<?php echo set_value('busi_owner_phone_number'); ?>" placeholder="Enter the business owner phone number" class="form-control <?php echo!empty(form_error('busi_owner_phone_number')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('busi_owner_phone_number'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Business Email Address</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="busi_owner_email" value="<?php echo set_value('busi_owner_email'); ?>"  placeholder="Enter the business owner email address" class="form-control <?php echo!empty(form_error('busi_owner_email')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('busi_owner_email'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Attached Scanned Copy</label>
                            <div class="col-sm-9 input-field" >
                                <div class="dropzone"  id="uploadimages">

                                    <?php
                                    if ($temp_files) {

                                        foreach ($temp_files as $f) {
                                            ?>
                                            <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete"> 
                                                <div class="dz-image"><img data-dz-thumbnail="" alt="<?php echo $f['temp_att_og_name']; ?>" src="<?php echo base_url() . 'assets/images/placeholderfile'.c_get_file_extension($f['temp_att_name']).'.png'; ?>"></div>

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
                                <?php echo form_error('busi_attachment'); ?>
                            </div>
                        </div>

                        <div class="line"></div>
                        

                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Business Location <br><small class="text-primary">Drop a pin on a physical location of this hall to obtain GPS Location</small></label>
                            <div class="col-sm-9 " >
                                <input type="hidden" name="busi_lat" id="busi_lat"/>
                                <input type="hidden" name="busi_lng" id="busi_lng"/>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 input-field">
                                        <input type="text" name="busi_location" id="busi_location"  class="form-control <?php echo!empty(form_error('busi_location')) ? 'is-invalid' : ''; ?>" placeholder="Type your location to set marker">
                                        <?php echo form_error('busi_location'); ?>
                                    </div>
                                </div>

                                <br/>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div id="somecomponent" style="width: 100%; height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> N-Biashara Url<br/><small class="text-primary">N-Biashara Suggested URL</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="busi_nb_url" value="<?php echo set_value('busi_nb_url'); ?>" id="hall_size" placeholder="Enter the N-Biashara Suggested URL" class="form-control <?php echo!empty(form_error('nb_url')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('busi_nb_url'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Facebook URL<br/><small class="text-primary">Facebook profile URL</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="facebook_url" value="<?php echo set_value('facebook_url'); ?>" id="hall_size" placeholder="Enter the facebook profile URL" class="form-control <?php echo!empty(form_error('facebook_url')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('facebook_url'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Instagram URL<br/><small class="text-primary">Instagram profile URL</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="instagram_url" value="<?php echo set_value('instagram_url'); ?>" id="hall_size" placeholder="Enter the instagram profile URL" class="form-control <?php echo!empty(form_error('instagram_url')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('instagram_url'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Twitter URL<br/><small class="text-primary">Twitter profile URL</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="twitter_url" value="<?php echo set_value('twitter_url'); ?>" id="hall_size" placeholder="Enter the twitter profile URL" class="form-control <?php echo!empty(form_error('twitter_url')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('twitter_url'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        
                        <div class="line"></div>
                        <br/>
                        <div class="clearfix"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-3">
                                <button type="submit" class="btn btn-primary">Save Business Details</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

<script type="text/javascript">

    Dropzone.autoDiscover = false;

    $(document).ready(function () {

        
      
        $('#select_busi_cat').select2({placeholder: 'Select business category'});

        $('#somecomponent').locationpicker({
            enableAutocomplete: true,
            scrollwheel: false,
            location: {
                latitude: -6.791001,
                longitude: 39.208628
            },
            zoom: 13,
            radius: 10,
            addressFormat: 'sublocality',
            mapTypeControl: true,
            fullscreenControl: true,
            inputBinding: {
                latitudeInput: $('#busi_lat'),
                longitudeInput: $('#busi_lng'),
                locationNameInput: $('#busi_location')
            },
            onchanged(currentLocation, radius, isMarkerDropped) {
                console.log(currentLocation)
            }
        });

        var myDropzone = new Dropzone('div#uploadimages', {url: '<?php echo site_url('utility/upload/HALL_IMAGE'); ?>',
            parallelUploads: 100,
            maxFiles: 100,
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


        format = {h1: false, h2: false, h3: false, h4: false, h5: false, h6: false, indent: false, outdent: false, fsize: false, sub: false, sup: false, unlink: false, hr: false, source: false, strike: false, left: false, right: false, center: false, color: false, remove: false, format: false, rule: false}

        $('#hall_description').jqte(format);



    });

</script>
