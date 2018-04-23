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
    <div class="container-fluid">
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
                                        <a  href="<?php echo site_url('halls/addhall'); ?>"  class="btn btn-info"><i class="fa fa-plus-square"></i>&nbsp;Add New Hall</a>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>-->


        <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
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
                    <div class="card-body">
                        <table id="datatable" class="table " style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width:10px;">No</th>
                                    <th style="width: 190px">Image</th>
                                    <th>Hall Details</th>
                                    <th>Price</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($halls as $i => $hall) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i + 1; ?></th>
                                        <td>
                                            <div class="">
                                                <img src ="<?php echo base_url() . 'uploads/' . $hall['hall_admin_id'] . '/thumb_rectangle_' . $hall['hall_attachment_name']; ?>"/>
                                            </div>
                                        </td>
                                        <td>
                                            <h3><?php echo $hall['hall_name']; ?></h3>
                                            <p class="no-margin-bottom"><i class="fa fa-map-marker"></i>&nbsp;<?php echo $hall['hall_address_description']; ?></p>

                                            <?php
                                            if (!empty($hall['ratings'])) {
                                                ?>
                                                <div class="rate" title="<?php echo round($hall['ratings'], 1); ?>" style="margin-bottom: 5px;" data-rateyo-read-only="true" data-rateyo-star-width="20px" data-rateyo-rating="<?php echo round($hall['ratings'], 1) ?>"> </div>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <h4 class="text-info"><?php echo $hall['currency_short_name'] . '&nbsp;' . hall_price_form_french($hall['hall_amount']); ?></h4>
    <!--                                            <p><i class="fa fa-clock-o"></i>&nbsp;Per Hour</p>-->
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <?php
                                                    switch ($user_role) {
                                                        case 'HALLMANAGERROLE':
                                                            ?>
                                                            <a href="<?php echo site_url('booking/hallschedules/' . $hall['hall_id']); ?>" class="dropdown-item text-info"> <i class="fa fa-calendar"></i>&nbsp;&nbsp;Hall Schedules</a>
                                                            <a href="<?php echo site_url('halls/manageredithall/' . $hall['hall_id']); ?>" class="dropdown-item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Details</a>
                                                            <?php
                                                            break;

                                                        case 'ADMINROLE':
                                                            ?>
                                                            <a href="<?php echo site_url('halls/edithall/' . $hall['hall_id']); ?>" class="dropdown-item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Details</a>
                                                            <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete Hall</a>
                                                            <?php
                                                            break;
                                                    }
                                                    ?>

                                                    
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
        $('#datatable').DataTable();
    });

</script>
