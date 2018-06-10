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
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <!--<a href="<?php echo site_url('user/dashboard'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>-->
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-o"></i>&nbsp;Latest Shifts</button>-->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addVessel"><i class="fa fa-plus-square"></i>&nbsp;Add Vessel</button>
                </div>
            </div>
        </div>
        <br/>
       
        <br/>
        

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="vessels_table" class="table  table-hover table-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Vessel Name</th>
                                    <th>Product</th>
                                    <th>Laycan</th>
                                    <th>Received Date</th>
                                    <th>Order</th>
                                    <th>Added By</th>
                                    <th style="width:10px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($stock_vessels as $i => $sv) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            echo $sv['vessel_name']; 
                                            
                                            switch ($sv['vessel_status']){
                                                case 'RECEIVED':
                                                    ?><h5><span class="badge badge-rounded badge-warning">RECEIVED</span></h5><?php
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $sv['fuel_type_group_generic_name'] .' - '.$sv['fuel_type_group_name']?></td>
                                        <td><?php echo $sv['vessel_laycan']; ?></td>
                                        <td><?php echo $sv['vessel_received_on']; ?></td>
                                        <td>
                                            <?php 
                                                echo 'Ordered&nbsp;:&nbsp;&nbsp;<strong>'.$sv['vessel_ordered_volume']. '</strong><br/>';
                                                echo 'Received&nbsp;:&nbsp;<strong>'.$sv['vessel_received_volume']. '</strong>';
                                            ?>
                                        </td>
                                        <td><?php echo $sv['user_name']; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php //echo site_url('dailyentries/saledetails/' . $att['att_id']).'?url='. urlencode(current_url()) .'?'.$_SERVER['QUERY_STRING']; ?>"  class="dropdown-item edit_item text-success"> <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Details</a>
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

        s_table = $('#vessels_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: { headerOffset: 70 },
            searching: false,
            lengthChange: false,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });


        $('#search_shifts').keyup(function () {
            s_table.search($(this).val()).draw();
        });
        
        s_table.responsive.recalc();
    });

</script>
