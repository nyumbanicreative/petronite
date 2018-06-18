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
                    <a href="<?php echo site_url('station'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-building-o"></i>&nbsp;Station Selection</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Fuel Types">
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-o"></i>&nbsp;Latest Shifts</button>-->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUser"><i class="fa fa-user-plus"></i>&nbsp;Add User</button>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <h5 class="h4">Station Users</h5>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="users_table" class="table  table-hover table-striped table-light table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th style="max-width: 500px;">Customer Stations</th>
                                    <th>User Status</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($stations_users as $i => $u) {
                                    ?>
                                    <tr>
                                        <td><?php echo $u['user_name']; ?></td>
                                        <td><?php echo $u['stations']; ?></td>
                                        <td>
                                            <?php
                                            if ($u['user_active'] == 1) {
                                                ?>
                                                <span class="badge badge-success">ACTIVE</span>
                                                <?php
                                            } elseif ($u['user_active'] == 0) {
                                                ?>
                                                <span class="badge badge-danger">IN-ACTIVE</span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('admin/manageuserstations/' . $u['user_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING'];             ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-user-secret"></i>&nbsp;&nbsp;Manage User's Stations</a>
                                                    <a href="#<?php //echo site_url('dailyentries/saledetails/' . $att['att_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING'];             ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Details</a>
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
        <h5 class="h4">Drivers</h5>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="drivers_table" class="table  table-hover table-striped table-light table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Driver Name</th>
                                    <th style="max-width: 500px;">Driver License</th>
                                    <th>User Status</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($customer_drivers as $i => $d) {
                                    ?>
                                    <tr>
                                        <td><?php echo $d['user_name']; ?></td>
                                        <td><?php echo $d['user_driving_license']; ?></td>
                                        <td>
                                            <?php
                                            if ($d['user_active'] == 1) {
                                                ?>
                                                <span class="badge badge-success">ACTIVE</span>
                                                <?php
                                            } elseif ($d['user_active'] == 0) {
                                                ?>
                                                <span class="badge badge-danger">IN-ACTIVE</span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php //echo site_url('admin/manageuserstations/' . $d['user_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING'];             ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-user-secret"></i>&nbsp;&nbsp;Deactivate Driver</a>
                                                    <a href="#<?php //echo site_url('dailyentries/saledetails/' . $att['att_id']) . '?url=' . urlencode(current_url()) . '?' . $_SERVER['QUERY_STRING'];             ?>"  class="dropdown-item edit_item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Details</a>
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

        s_table = $('#users_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 10,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });
        
        s_table = $('#drivers_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 10,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });



    });

</script>
