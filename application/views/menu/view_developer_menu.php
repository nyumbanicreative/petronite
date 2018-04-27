<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Side bar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/user.png" alt="..." class="img-fluid rounded-circle "></div>
        <div class="title">
            <h1 class="h4"><?php echo !empty($user_fullname) ? $user_fullname : $user_name; ?></h1>
            <p><?php echo $user_system_role; ?></p>
        </div>
    </div>
    <!-- Side bar Navigation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <li class="<?php echo ($curr_menu == 'CUSTOMERS') ? "active" : "" ?>"> <a href="<?php echo site_url('developer/customers'); ?>"><i class="fa fa-group"></i>Customers</a></li>
        <li class="<?php echo ($curr_menu == 'LOGS') ? "active" : "" ?>"> <a href="<?php echo site_url('developer/logs'); ?>"><i class="fa fa-list-alt"></i>System Logs</a></li>
    </ul>

</nav>
<div class="content-inner">