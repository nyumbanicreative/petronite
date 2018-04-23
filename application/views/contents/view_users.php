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

<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUser"><i class="fa fa-plus-square"></i>&nbsp;Add User</button>
                </div>
            </div>
        </div>
        <br/>

        <!--        <div class="row">
                    <div class="col-lg-12">
        
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <div class="form-group no-margin-bottom">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-keyboard-o"></i></span>
                                                    <input type="text" placeholder="Enter keyword to search" class="form-control"><span class="input-group-btn">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-search"></i></button></span>
                                                </div>
                                              </div>
                                        </div>
                                        
        
                                        <div class="col-6">
                                             <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-info"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                                                <button type="button" class="btn btn-info"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>
                                             </div>
                                        </div>
        
                                    </div>
        
                                </form>
                            </div>
                        </div>
                    </div>
                </div>-->

        <div id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <form id="user_form" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Add New User</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" id="full_name">
                                                <label>User Fullname</label>
                                                <input placeholder="Enter the user full name" class="form-control" name="full_name"  value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"  id="email">
                                                <label>User Email</label>
                                                <input placeholder="Enter the user email" class="form-control" name="email" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6" >
                                            <div class="form-group" id="phone">
                                                <label>User Phone Number</label>
                                                <input placeholder="Enter the user phone number" class="form-control" name="phone"  value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6" >
                                            <div class="form-group" id="role">
                                                <label>User Role</label>
                                                <select class="form-control" name="role" name="role" id="user_role" style="width:100%">
                                                    <option value="" ></option>
                                                    <?php
                                                    foreach ($user_roles as $role) {
                                                        ?>
                                                        <option value="<?php echo $role['option_name']; ?>"><?php echo $role['option_name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"  >
                                            <div class="form-group" id="pass1">
                                                <label>Password <i style="color: #d1d1d1;">(Default Password is 123456)</i></label>
                                                <input type="password" placeholder="Enter the user password" class="form-control" name="pass1" value="123456">
                                            </div>
                                        </div>
                                        <div class="col-md-6" >
                                            <div class="form-group" id="pass2">
                                                <label>Retype User Password</label>
                                                <input type="password" placeholder="Retype user password" class="form-control" name="pass2"  value="123456">
                                            </div>
                                        </div>
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

        <div id="temp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Approve MSISDN</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <form>
                            <div class="row">
                                <div class="col col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <p>Tumsifu Lema</p>
                                    </div>
                                </div>
                                <div class="col col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label>MSISDN</label>
                                        <p>255 765 127663</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label>College Name</label>
                                        <p>St Joseph University Of Tanzania</p>
                                    </div>
                                </div>
                                <div class="col col-md-6 col-12">
                                    <div class="form-group">
                                        <label>ID No </label>
                                        <p>117180667</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Joining Year</label>
                                        <p>2016</p>
                                    </div>
                                </div>
                                <div class="col col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label>Ending Year </label>
                                        <p>2018</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Attachment</label>
                                        <div id="thumbnails" class="yoxview">
                                            <img id="attachment" src="<?php echo base_url() . "assets/img/saut_id.jpg" ?>" style="width: 100px;cursor: -webkit-zoom-in;cursor: zoom-in;cursor: -moz-zoom-in;">
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                        <button type="button"  class="btn btn-danger">Disapprove</button>
                        <button type="button" class="btn btn-success">Approve</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body padding">
                        <table id="users_table" class="table table-striped">
                            <thead>
                                <tr>

                                    <th>Username</th>
                                    <th>Full Name</th>
                                    <th>User Phone</th>
                                    <th>User Role</th>
                                    <th>Status</th>
                                    <th>Balance Amount</th>

                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($users as $i => $user) {
                                    ?>
                                    <tr>

                                        <td>
                                            <!--<strong><?php echo $i + 1; ?>.</strong>&nbsp;&nbsp;-->
                                            <?php echo $user['user_email']; ?></td>
                                        <td><?php echo $user['user_fullname']; ?></td>
                                        <td><?php echo $user['user_phone']; ?></td>
                                        <td><?php echo $user['user_role']; ?></td>
                                        <td>
                                            <?php
                                            switch ($user['user_status']) {
                                                case 'ACTIVE':
                                                    ?>
                                                    <span class="badge badge-success badge-rounded">ACTIVE</span>
                                                    <?php
                                                    break;
                                                case 'INACTIVE':
                                                    ?>
                                                    <span class="badge badge-danger badge-rounded">INACTIVE</span>
                                                    <?php
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $balance = $user['user_balance'];
                                                if($balance < 0){
                                                    ?><span class="badge badge-danger "><?php echo hall_price_form_french($balance) .' ' . CURRENCY; ?> </span><?php
                                                }else{
                                                    ?><span class="badge badge-success large"><?php echo hall_price_form_french($balance) .' '. CURRENCY; ; ?></span><?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('user/userdetails/'.$user['user_id']); ?>" class="dropdown-item"> <i class="fa fa-search"></i>&nbsp;&nbsp;Details</a>
                                                    <a href="#" class="dropdown-item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit User</a>
                                                    <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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

        $('#user_role').select2({placeholder: 'Select user role'});

        $('#users_table').DataTable({
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1}
            ]
        });
       
       
       // Submiting New User
       $(document).on('submit', '#user_form', function (e) {

            e.preventDefault();

            //$('.disabled_field').removeAttr('disabled');

            var err = "";
            var postData = $(this).serializeArray();

            $('.field_error').remove();

            $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

            $.ajax({
                url: '<?php echo site_url('user/submituser'); ?>',
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