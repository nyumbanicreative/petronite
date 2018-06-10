<!-- Side Navbar -->
<nav class="side-navbar sidebar-menu">
    <!-- Side bar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/user.png" alt="..." class="img-fluid rounded-circle "></div>
        <div class="title">
            <h1 class="h4"><?php echo !empty($user_fullname) ? $user_fullname: $user_name; ?></h1>
            <p><?php echo $user_depo_name; ?></p>
            <span class="badge badge-info badge-pill"><?php echo $user_depo_role; ?></span>
        </div>
    </div>
    <!-- Side bar Navigation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
       
        <li class="<?php echo ($curr_menu == 'STOCK_CONTROL') ? "active" : "" ?>"><a href="#daily" aria-expanded="<?php echo ($curr_menu == 'STOCK_CONTROL') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-flask"></i>Stock Control </a>
            <ul id="daily" class="<?php echo ($curr_sub_menu == 'STOCK_CONTROL') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('depots/stockvessels'); ?>">Stock Vessels</a></li>
                <li><a href="<?php echo site_url('depots/stockloading'); ?>">Stock Loading</a></li>
            </ul>
        </li>
        
        <li class="<?php echo ($curr_menu == 'REPORT') ? "active" : "" ?>"><a href="#stn" aria-expanded="<?php echo ($curr_menu == 'REPORT') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-line-chart"></i>Reports </a>
            <ul id="stn" class="<?php echo ($curr_sub_menu == 'REPORT') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('depots'); ?>">Stock Control Report</a></li>
            </ul>
        </li>
       
        
        <li class="<?php echo ($curr_menu == 'DEPOTS') ? "active" : "" ?>"><a href="#depo" aria-expanded="<?php echo ($curr_menu == 'DEPOTS') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-building-o"></i>Depots </a>
            <ul id="depo" class="<?php echo ($curr_sub_menu == 'DEPOTS') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('depots'); ?>">Depots Selection</a></li>
            </ul>
        </li>
        <?php 
            if($user_system_role == 'developer'){
                ?>
                <li class="<?php echo ($curr_menu == 'CUSTOMERS') ? "active" : "" ?>"> <a href="<?php echo site_url('developer/customers'); ?>"><i class="fa fa-group"></i>Petronite Customers</a></li>
                <?php
            }
        ?>
    </ul>

</nav>
<div class="content-inner">