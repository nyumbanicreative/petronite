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



        <!-- Javascript files-->
        <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js" type="text/javascript"></script>


        <script src="<?php echo base_url(); ?>assets/vendor/popper.js/umd/popper.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery.cookie/jquery.cookie.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/front.js"></script>


        <!-- Datatables -->
        <!--    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
                <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
        -->

        <script src="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/js/dataTables.responsive.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/css/responsive.dataTables.css" rel="stylesheet" type="text/css"/>

        <!-- Viewer -->
        <script src="<?php echo base_url(); ?>assets/vendor/viewer-master/dist/viewer.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/viewer-master/dist/viewer.css" rel="stylesheet" type="text/css"/>


        <!-- Confirm -->
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-confirm-master/dist/jquery-confirm.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/jquery-confirm-master/dist/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>


        <!-- Date Range Picker -->
        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/daterange/daterangepicker.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/daterange/daterangepicker.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/dropzone/dropzone.css">
        <script src="<?php echo base_url(); ?>assets/vendor/dropzone/dropzone.js" type="text/javascript"></script>


        <!-- Location picker -->

        <script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAUVnVdhs1B7jKC2FqtRi8iqLhPd9s4-uQ'></script>

        <script src="<?php echo base_url(); ?>assets/vendor/map/dist/locationpicker.jquery.js" type="text/javascript"></script>

        <link href="<?php echo base_url(); ?>assets/vendor/select2/css/select2.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/select2/js/select2.full.js" type="text/javascript"></script>


        <!--- Select 2 -->


        <!-- Numeric JS -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.numeric.js" type="text/javascript"></script>

        <!-- Ratings -->
        <script src="<?php echo base_url(); ?>assets/vendor/rate/jquery.rateyo.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/rate/jquery.rateyo.css" rel="stylesheet" type="text/css"/>


        <!-- Tooltipstar -->
        <script src="<?php echo base_url(); ?>assets/vendor/tooltipster-master/dist/js/tooltipster.bundle.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/tooltipster-master/dist/css/tooltipster.bundle.min.css" rel="stylesheet" type="text/css"/>



        <!-- Block UI -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js" type="text/javascript"></script>

        <!-- Simple Calendar -->
        <link href="<?php echo base_url(); ?>assets/vendor/simplecal/css/dncalendar-skin.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/simplecal/js/dncalendar.js" type="text/javascript"></script>


        <!-- Text Editor -->
        <script src="<?php echo base_url(); ?>assets/vendor/jte/jquery-te-1.4.0.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/jte/jquery-te-1.4.0.css" rel="stylesheet" type="text/css"/>


        <script type="text/javascript">

            $(document).ready(function () {


                $('#attachment').viewer();

                $('#daterange').daterangepicker();

                $('.confirm').click({
                    title: 'Confirm!',
                    content: 'Are you sure you want to disapprove this subscriber!',
                    buttons: {
                        confirm: function () {
                            //$.alert('Confirmed!');
                        },
                        cancel: function () {
                            //$.alert('Canceled!');
                        }
                        /*somethingElse: {
                         text: 'Something else',
                         btnClass: 'btn-blue',
                         keys: ['enter', 'shift'],
                         action: function(){
                         $.alert('Something else?');
                         }
                         }*/
                    }
                });



                $('.input-field').click(function () {

                    $(this).children('.form-control').removeClass('is-invalid');
                    $(this).children('.rmv_error').remove();

                });

                $('.rate').rateYo({starWidth: "20px"});
                $('.rate').tooltipster({side: 'right'});

                $('.rate_side').rateYo({starWidth: "20px"});
                $('.rate_side').tooltipster({side: 'right'});

                //Remove Field Errors
                $(document).on("click", ".remove_error", function () {
                    $(this).children(".field_error").remove();
                    $(this).children('.form-control').removeClass("is-invalid");
                });

            });
        </script>

        <style type="text/css">
            img{
                width:100%;
            }
            table.dataTable thead th, table.dataTable thead td{
                padding: 10px 20px 10px 10px;
            }
            .fill{
                min-height: 100%;
                height: 100%;
            }

            td.danger{
                background: #ffefef;
            }
            
            td.info{
                background: #effbff;;
            }
        </style>


    </head>
    <body>
        <div class=" <?php echo isset($page_class) ? $page_class : ""; ?>">