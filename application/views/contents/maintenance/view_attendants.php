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
                <div class="btn-group pull-left" role="group" aria-label="Dashboard">
                    <a href="<?php echo site_url('user/dashboard'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Fuel Types">
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-o"></i>&nbsp;Latest Shifts</button>-->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>&nbsp;Add Attendant</button>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="attendants_table" class="table  table-hover table-striped table-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Attendant Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($attendants as $i => $a) {
                                    ?>
                                    <tr>
                                        <td><?php echo $a['user_name']; ?></td>
                                        <td><?php echo $a['user_phone']; ?></td>
                                        <td><?php echo $a['user_email']; ?></td>
                                        <td><?php echo $a['user_address'] ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php //echo site_url('dailyentries/saledetails/' . $att['att_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING']; ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Details</a>
                                                    <a href="<?php //echo site_url('inventory/edithallitem/' . $att['att_id']); ?>"  class="dropdown-item edit_item"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                    <a href="<?php //echo site_url('inventory/deletehallitem/' . $att['att_id']); ?>" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
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

    $(document).ready(function () {

        s_table = $('#attendants_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: false,
            lengthChange: false,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });



    });

</script>
