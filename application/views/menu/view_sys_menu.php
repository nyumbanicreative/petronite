<!-- Side Navbar -->
<nav class="side-navbar sidebar-menu">
    <!-- Side bar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/user.png" alt="..." class="img-fluid rounded-circle "></div>
        <div class="title">
            <h1 class="h4"><?php echo !empty($user_fullname) ? $user_fullname: $user_name; ?></h1>
            <p><?php echo $user_station_name; ?></p>
            <span class="badge badge-info badge-pill"><?php echo $user_station_role; ?></span>
        </div>
    </div>
    <!-- Side bar Navigation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <li class="<?php echo ($curr_menu == 'DASHBOARD') ? "active" : "" ?>"> <a href="<?php echo site_url('user/dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        
        <li class="<?php echo ($curr_menu == 'DAILY') ? "active" : "" ?>"><a href="#daily" aria-expanded="<?php echo ($curr_menu == 'DAILY') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-truck"></i>Daily Entries </a>
            <ul id="daily" class="<?php echo ($curr_sub_menu == 'DAILY') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('dailyentries/attendantsshifts'); ?>">Attendant Shifts</a></li>
                <li><a href="<?php echo site_url('dailyentries/creditsales'); ?>">Credit Sales</a></li>
                <li><a href="<?php echo site_url('dailyentries/stocktransfer'); ?>">Stock Transfer</a></li>
                <li><a href="<?php echo site_url('dailyentries/expenditure'); ?>">Expenditure</a></li>
                <li><a href="<?php echo site_url('dailyentries/dipping'); ?>">Dipping</a></li>
                <li><a href="<?php echo site_url('dailyentries/purchases'); ?>">Purchases</a></li>
            </ul>
        </li>
        
        <li class="<?php echo ($curr_menu == 'MAINTENANCE') ? "active" : "" ?>"><a href="#maintenance" aria-expanded="<?php echo ($curr_menu == 'MAINTANANCE') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-gears"></i>Maintanance </a>
            <ul id="maintenance" class="<?php echo ($curr_sub_menu == 'MAINTENANCE') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('maintenance/fuel'); ?>"> Fuel Types &amp; Pricing</a></li>
                <li><a href="<?php echo site_url('maintenance/tanks'); ?>">Fuel Tanks</a></li>
                <li><a href="<?php echo site_url('maintenance/pumps'); ?>">Pumps</a></li>
                <li><a href="<?php echo site_url('maintenance/attendants'); ?>">Attendants</a></li>
                <li><a href="<?php echo site_url('maintenance/shifts'); ?>">Shifts</a></li>
            </ul>
        </li>
        
        <li class="<?php echo ($curr_menu == 'REPORTS') ? "active" : "" ?>"><a href="#reports" aria-expanded="<?php echo ($curr_menu == 'REPORTS') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-line-chart"></i>Reports </a>
            <ul id="reports" class="<?php echo ($curr_sub_menu == 'REPORTS') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php //echo site_url('dailyentries/attendantsshifts'); ?>"> Daily Collection Report</a></li>
                <li><a href="<?php //echo site_url('dailyentries/creditsales'); ?>">Daily Sales Stock</a></li>
                <li><a href="<?php //echo site_url('dailyentries/stocktransfer'); ?>">Management Report</a></li>
                <li><a href="<?php //echo site_url('dailyentries/expenditure'); ?>">Sales Report</a></li>
                <li><a href="<?php //echo site_url('dailyentries/dipping'); ?>">Sales Graph Reports</a></li>
                <li><a href="<?php //echo site_url('dailyentries/dipping'); ?>">Fuel Reconciliation Report</a></li>
                <li><a href="<?php //echo site_url('dailyentries/dipping'); ?>">Tanks Reconciliation Report</a></li>
                <li><a href="<?php //echo site_url('dailyentries/dipping'); ?>">Margin Analysis Report</a></li>
            </ul>
        </li>
        
        <li class="<?php echo ($curr_menu == 'STATIONS') ? "active" : "" ?>"><a href="#stn" aria-expanded="<?php echo ($curr_menu == 'STATIONS') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-building-o"></i>Stations </a>
            <ul id="stn" class="<?php echo ($curr_sub_menu == 'STATIONS') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('station'); ?>">Station Selection</a></li>
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