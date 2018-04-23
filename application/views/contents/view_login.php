<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo SYSTEM_NAME; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
        <!-- Fontastic Custom icon font-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontastic.css">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css">
        <!-- Google fonts - Poppins -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.sea.css" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
        <!-- Favicon-->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.png">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <body>
        <div class="page login-page">
            <div class="container d-flex align-items-center">
                <div class="form-holder">
                    <div class="row">
                        <!-- Logo & Information Panel-->
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5 col-md-6">
                            <div class="info d-flex align-items-center">
                                <div class="content" style="display:block;width:100%;" >
                                    <div class="" style="width:230px;margin: 0 auto">
                                        <img style="width:100%" src="<?php echo base_url(); ?>assets/img/petronite.png"/>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Form Panel    -->
                        <div class="col-lg-5 col-md-6 bg-white">
                            <div class="form d-flex align-items-center">
                                <div class="content">


                                    <form id="login-form" method="post" action="<?php echo site_url('user/submitlogin'); ?>">

                                        <?php echo $alert; ?>
                                        <div class="form-group">
                                            <input autocomplete="off" id="login-username" type="text" name="loginUsername" required="" value="<?php echo set_value('loginUsername'); ?>" class="input-material">
                                            <label for="login-username" class="label-material <?php
                                            if (set_value('loginUsername')) {
                                                echo 'active';
                                            }
                                            ?>">User Name</label>
                                                   <?php echo form_error('loginUsername'); ?>
                                        </div>
                                        <div class="form-group">
                                            <input id="login-password" autocomplete="off" type="password" name="loginPassword" required="" class="input-material">
                                            <label for="login-password" class="label-material">Password</label>
                                            <?php echo form_error('loginPassword'); ?>
                                        </div><button type="submit" id="login" class="btn btn-block btn-primary">Login</button>
                                        <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                                    </form><a href="#" class="forgot-pass">Forgot Password?</a><br>
                                    <!--<small>Do not have an account? </small><a href="register.html" class="signup">Signup</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyrights text-center">
                <p><a href="https://nyumbanicreative.com" class="external">&copy; Nyumbani Creative Ltd</a></p>
                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>
        </div>
        <!-- Javascript files-->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/popper.js/umd/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery.cookie/jquery.cookie.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/front.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('.form-group').click(function () {
                    $(this).children('.rmv_error').remove();
                });
            });
        </script>
    </body>
</html>