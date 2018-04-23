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
        <li class="breadcrumb-item"><a class="text-info" href="<?php echo site_url('halls/hallslist'); ?>">Venues List</a></li>
        <li class="breadcrumb-item active"><?php echo $module_name; ?></li>
    </ul>
</div>
<section class="form">   

    <div class="container-fluid">

        <?php 
            echo validation_errors();
        ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4">Venue Details Editing Form</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo site_url('halls/submithalldetails'); ?>" method="post" class="form-horizontal">
                        
                        <input type="hidden" name="submit" value="submit"/>
                        <input type="hidden" name="details_type" value="editing"/>
                        <input type="hidden" name="hall_id" value="<?php echo $hall['hall_id'];?>"/>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Venue Name</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="hall_name" value="<?php echo !empty(set_value('submit'))? set_value('hall_name') : $hall['hall_name']; ?>" autocomplete="off" id="hall_name" placeholder="Enter the hall name" class="form-control <?php echo!empty(form_error('hall_name')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('hall_name'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Venue Description</label>
                            <div class="col-sm-9 input-field">
                                <textarea rows="5" name="hall_description"  id="hall_description" placeholder="Enter the venue description" class="form-control <?php echo!empty(form_error('hall_description')) ? 'is-invalid' : ''; ?>"><?php echo !empty(set_value('submit'))? set_value('hall_description') : $hall['hall_description']; ?></textarea>
                                <?php echo form_error('hall_description'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Venue Size<br/><small class="text-primary">Number of people</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="hall_size" value="<?php echo !empty(set_value('submit'))? set_value('hall_size') : $hall['hall_size']; ?>" id="hall_size" placeholder="Enter the hall size" class="form-control <?php echo!empty(form_error('hall_size')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('hall_size'); ?>
                            </div>
                        </div>
                        
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Booking Price</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="hall_booking_price" value="<?php echo !empty(set_value('submit'))? set_value('hall_booking_price') : $hall['hall_amount']; ?>" id="hall_booking_price" placeholder="Enter the booking price in Tsh" class="form-control <?php echo!empty(form_error('hall_booking_price')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('hall_booking_price'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Advance Percentage</label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="hall_advance" value="<?php echo !empty(set_value('submit'))? set_value('hall_advance') : $hall['hall_advance_pay_percent']; ?>" id="hall_advance" placeholder="Enter the minimum payment percentage" class="form-control <?php echo!empty(form_error('hall_advance')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('hall_advance'); ?>
                            </div>
                        </div>
                        <div class="line"></div>


                        <div class="line"></div>

                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Venue Images</label>
                            <div class="col-sm-9 input-field" >
                                <div class="dropzone"  id="uploadimages">

                                    <?php
                                    if ($hall_images) {

                                        foreach ($hall_images as $f) {
                                            ?>
                                            <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete"> 
                                                <div class="dz-image"><img data-dz-thumbnail="" alt="<?php echo $hall['hall_name']; ?>" src="<?php echo base_url() . 'uploads/'.$hall['hall_admin_id'].'/thumb_square_' . $f['hall_attachment_name'] ?>"></div>

                                                <div class="dz-details">    
<!--                                                    <div class="dz-size"><span data-dz-size=""><strong><i class="icon-file"></i></strong></span></div>  -->
                                                    <div class="dz-filename"><span data-dz-name=""><?php echo $hall['hall_name']; ?></span></div>
                                                </div>  

                                                <div class="dz-progress">
                                                    <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                                </div>

                                                <div class="dz-error-message">
                                                    <span data-dz-errormessage=""></span>
                                                </div>  
                                                <div class="dz-success-mark">    

                                                </div>

                                                <a class="removetempfile" href="<?php echo base_url() . "index.php/utility/removeuploaded/" . $f['hall_attachment_id']; ?>" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 5px 10px;border-radius: 100%;"><i class="fa fa-close"></i></a>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                    <?php
                                    if ($temp_files) {

                                        foreach ($temp_files as $f) {
                                            ?>
                                            <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete"> 
                                                <div class="dz-image"><img data-dz-thumbnail="" alt="<?php echo $f['temp_att_og_name']; ?>" src="<?php echo base_url() . 'uploads/'.$hall['hall_admin_id'].'/thumb_square_' . $f['temp_att_name'] ?>"></div>

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

                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Venue Amenities <br><small class="text-primary">Select available amenities</small></label>
                            <div class="col-sm-9">

                                <div class="row">

                                    <?php
                                    
                                    $selected_amenities = !empty(set_value('submit'))? (array)set_value('amenities') : $hall_amenites;;
                                    
                                    foreach ($amenities as $a) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="i-checks">
                                                <input <?php echo in_array($a['amenity_id'], $selected_amenities)? 'checked' : ''; ?> id="checkboxCustom<?php echo $a['amenity_id']; ?>" type="checkbox" value="<?php echo $a['amenity_id']; ?>" name="amenities[]" class="checkbox-template">
                                                <label for="checkboxCustom<?php echo $a['amenity_id']; ?>"><?php echo $a['amenity_name']; ?></label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>


                            </div>
                        </div>

                        <div class="line"></div>
                        <div class="form-group row">

                            <label class="col-sm-3 form-control-label">Venue GPS Location <br><small class="text-primary">Drop a pin on a physical location of this hall to obtain GPS Location</small></label>
                            <div class="col-sm-9 " >
                                <input type="hidden" name="hall_lat" id="hall_lat"/>
                                <input type="hidden" name="hall_lng" id="hall_lng"/>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 input-field">
                                        <input type="text" name="hall_location" id="hall_location"  class="form-control <?php echo!empty(form_error('hall_location')) ? 'is-invalid' : ''; ?>" placeholder="Type your location to set marker">
                                        <?php echo form_error('hall_location'); ?>
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
                            <label class="col-sm-3 form-control-label"> Facebook URL<br/><small class="text-primary">Facebook profile URL</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="facebook_url" value="<?php echo !empty(set_value('submit'))? set_value('facebook_url') : $hall['hall_facebook_url']; ?>" id="hall_size" placeholder="Enter the facebook profile URL" class="form-control <?php echo!empty(form_error('facebook_url')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('facebook_url'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Instagram URL<br/><small class="text-primary">Instagram profile URL</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="instagram_url" value="<?php echo !empty(set_value('submit'))? set_value('instagram_url') : $hall['hall_instagram_url']; ?>" id="hall_size" placeholder="Enter the instagram profile URL" class="form-control <?php echo!empty(form_error('instagram_url')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('instagram_url'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> Twitter URL<br/><small class="text-primary">Twitter profile URL</small></label>
                            <div class="col-sm-9 input-field">
                                <input type="text" name="twitter_url" value="<?php echo !empty(set_value('submit'))? set_value('twitter_url') : $hall['hall_twitter_url']; ?>" id="hall_size" placeholder="Enter the twitter profile URL" class="form-control <?php echo!empty(form_error('twitter_url')) ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('twitter_url'); ?>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="form-group row" style="display:none;">
                            <label class="col-sm-3 form-control-label"> Hall Manager<br/></label>
                            <div class="col-sm-9 input-field">
                                <select id="select_manager"  name="hall_manager" style="width:100%" class="">
                                    <option value="<?php echo $hall['hall_admin_id']; ?>">Manager</option>
                                </select>
                                <?php echo form_error('hall_manager'); ?>
                            </div>
                        </div>
                        <br/>
                        <div class="clearfix"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-3">
                                <button type="submit" name="" class="btn btn-primary">Save Venue Details</button>
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

        $('#hall_booking_price').numeric({negative: false, decimalPlaces: 2});
        $('#hall_advance').numeric({negative: false, decimalPlaces: 2});
        $('#hall_size').numeric({negative: false, decimal: false});

        $('#somecomponent').locationpicker({
            enableAutocomplete: true,
            scrollwheel: false,
            location: {
                latitude: <?php echo !empty(set_value('submit'))? set_value('hall_lat') : $hall['hall_gps_lat']; ?>,
                longitude: <?php echo !empty(set_value('submit'))? set_value('hall_lng') : $hall['hall_gps_lon']; ?>
            },
            zoom: 13,
            radius: 10,
            mapTypeControl: true,
            addressFormat: 'sublocality',
            inputBinding: {
                latitudeInput: $('#hall_lat'),
                longitudeInput: $('#hall_lng'),
                locationNameInput: $('#hall_location')
            },
            onchanged(currentLocation, radius, isMarkerDropped) {
                console.log(currentLocation)
            }
        });

        var myDropzone = new Dropzone('div#uploadimages', {url: '<?php echo site_url('utility/uploadDirect/HALL_IMAGE/' . $hall['hall_id']); ?>',
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
                    url: "<?php echo base_url(); ?>index.php/utility/removeuploaded/" + message.filename,
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
        
        format = {h1:false,h2:false,h3:false,h4:false,h5:false,h6:false,indent:false,outdent:false,fsize:false,sub:false,sup:false,unlink:false,hr:false,source:false,strike:false,left:false,right:false,center:false,color:false,remove:false,format:false,rule:false}

        $('#hall_description').jqte(format);




    });

</script>
