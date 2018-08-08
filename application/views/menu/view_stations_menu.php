<!-- Side Navbar -->
<nav class="side-navbar sidebar-menu">
    <!-- Side bar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/user.png" alt="..." class="img-fluid rounded-circle "></div>
        <div class="title">
            <h1 class="h4"><?php echo!empty($user_fullname) ? $user_fullname : $user_name; ?></h1>
            <p><span class="badge badge-info badge-rounded"><?php echo $user_system_role; ?></span></p>
        </div>
    </div>
    <!-- Side bar Navigation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <?php
        if ($user_system_role == 'developer') {
            ?>
            <li class="<?php echo ($curr_menu == '') ? "active" : "" ?>"> <a href="<?php echo site_url('developer/customers'); ?>"><i class="fa fa-group"></i>Petronite Customers</a></li>
            <?php
        }
        ?>
        <li class="<?php echo ($curr_menu == 'STATIONS') ? "active" : "" ?>"> <a href="<?php echo site_url('station'); ?>"><i class="fa fa-building-o"></i>Stations</a></li>
        <li class="<?php echo ($curr_menu == 'DEPOTS') ? "active" : "" ?>"> <a href="<?php echo site_url('depots'); ?>"><i class="fa fa-ship"></i>Depots</a></li>
        <li class="<?php echo ($curr_menu == 'CUSTOMERS') ? "active" : "" ?>"><a href="#customers" aria-expanded="<?php echo ($curr_menu == 'CUSTOMERS') ? "true" : "false" ?>" data-toggle="collapse"> <i class="fa fa-group"></i>Customers &amp; Suppliers</a>
            <ul id="customers" class="<?php echo ($curr_sub_menu == 'CUSTOMERS') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('customers');   ?>">Credit Customers</a></li>
                <li><a href="<?php echo site_url('customers/customerpayments');   ?>">Customer Payments</a></li>
                <li><a href="<?php echo site_url('customers/customersbalance');  ?>">Customers Balance</a></li>
                <li><a href="<?php echo site_url('suppliers');   ?>">Suppliers</a></li>
            </ul>
        </li>
        <li class="<?php echo ($curr_menu == 'PURCHASE') ? "active" : "" ?>"><a href="#purchase" aria-expanded="<?php echo ($curr_menu == 'PURCHASE') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-money"></i>Purchase Entries</a>
            <ul id="purchase" class="<?php echo ($curr_sub_menu == 'PURCHASE') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('station/purchaseorders'); ?>">Purchase Orders</a></li>
                <li><a href="<?php echo site_url('station/releaseinstructions'); ?>">Release Instructions</a></li>
                <!--<li><a href="<?php //echo site_url('station/orderdelivery'); ?>">Order Delivery</a></li>-->
            </ul>
        </li>
        <li class="<?php echo ($curr_menu == 'REPORTS') ? "active" : "" ?>"><a href="#rpts" aria-expanded="<?php echo ($curr_menu == 'REPORTS') ? "true" : "false" ?>" data-toggle="collapse"> <i class="fa fa-bar-chart"></i>Combined Reports</a>
            <ul id="rpts" class="<?php echo ($curr_sub_menu == 'REPORTS') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php //echo site_url('utility/businesscats');  ?>">Combined Sales Report</a></li>
            </ul>
        </li>
        
        <li class="<?php echo ($curr_menu == 'ADMIN') ? "active" : "" ?>"><a href="#admin" aria-expanded="<?php echo ($curr_menu == 'ADMIN') ? "true" : "false" ?>" data-toggle="collapse"> <i class="fa fa-gear"></i>Administrator</a>
            <ul id="admin" class="<?php echo ($curr_sub_menu == 'ADMIN') ? "" : "collapse" ?> list-unstyled">
                <li><a href="<?php echo site_url('admin/usersmanagement');   ?>">Users Management</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div class="content-inner">