<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<!-- Breadcrumb-->
<!--<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        
        <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active"><?php echo $module_name; ?></li>
    </ul>
</div>-->

<?php echo $error_msg . $success_msg; ?>


<section class="" style="min-height:550px;">
    <div class="container-fluid">
        <div class="row">
            <?php
            foreach ($stations as $key => $s) {
                ?>
                <div class="col-md-4 col-lg-3 col-sm-6 col-6">
                    <a href="#" class="card" style="border: 1px solid #f1f1f1;">
                        <img class="card-img-top" src="<?php echo base_url() . 'assets/img/logo.jpg' ?>" alt="Station Image">
                        <div class="card-body" style="background: #fdfdfd;">
                            <h5 class="card-title"><?php echo ucwords(strtolower($s['station_name'])); ?></h5>
                            <!--<a href="#" class="btn btn-primary">Sign in</a>-->
                        </div>
                        
                    </a>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</section>

<!--<section class="tables no-padding-top">   
    <div class="container-fluid">
        <br/>
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
                                    <th>Station</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
<?php
foreach ($stations as $i => $s) {
    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i + 1; ?></th>
                                            <td>
                                                <div class="">
                                                    <img src ="<?php echo base_url() . 'uploads/' . $hall['hall_admin_id'] . '/thumb_rectangle_' . $hall['hall_attachment_name']; ?>"/>
                                                </div>
                                            </td>
                                            <td>
                                                <h3><?php echo $s['station_name']; ?></h3>
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                    <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                        <a href="<?php echo site_url('booking/hallschedules/' . $s['station_id']); ?>" class="dropdown-item text-info"> <i class="fa fa-calendar"></i>&nbsp;&nbsp;Hall Schedules</a>
                                                        <a href="<?php echo site_url('halls/manageredithall/' . $s['station_id']); ?>" class="dropdown-item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Details</a>

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
</section>-->

<script type="text/javascript">

    $(document).ready(function () {
        $('#datatable').DataTable();
    });

</script>
