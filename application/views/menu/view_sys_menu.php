<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Side bar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/user.png" alt="..." class="img-fluid rounded-circle "></div>
        <div class="title">
            <h1 class="h4"><?php echo $user_fullname; ?></h1>
            <p><?php echo $user_role == 'HALLMANAGERROLE' ? '<b>' . $manager_hall_name . '</b><br><span class="badge badge-info">' . $manager_role . '</span>' : '<span class="badge badge-info">' . $user_role_name . '</span>'; ?></p>
        </div>
    </div>
    <!-- Side bar Navigation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <li class="<?php echo ($curr_menu == 'DASHBOARD') ? "active" : "" ?>"> <a href="<?php echo site_url('user/dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="<?php echo ($curr_menu == 'REVENUE') ? "active" : "" ?>"> <a href="<?php echo site_url('accounts/revenue'); ?>"><i class="fa fa-shopping-bag"></i>Revenue</a></li>
        <li class="<?php echo ($curr_menu == 'REVENUE') ? "active" : "" ?>"> <a href="<?php echo site_url('accounts/expense'); ?>"><i class="fa fa-money"></i>Expense</a></li>
        <?php
        if ($user_role == 'ADMINROLE') {
            ?>

            <li class="<?php echo ($curr_menu == 'USERS') ? "active" : "" ?>"><a href="#users" aria-expanded="<?php echo ($curr_menu == 'USERS') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-group"></i>Users Management </a>
                <ul id="users" class="<?php echo ($curr_sub_menu == 'USERS') ? "" : "collapse" ?> list-unstyled">
                    <li><a href="<?php echo site_url('user/userslist'); ?>">Users List</a></li>
                </ul>
            </li>

            <li class="<?php echo ($curr_menu == 'UTILITY') ? "active" : "" ?>"><a href="#utility" aria-expanded="<?php echo ($curr_menu == 'UTILITY') ? "true" : "false" ?>" data-toggle="collapse"> <i class="fa fa-gears"></i>Utility</a>
                <ul id="utility" class="<?php echo ($curr_sub_menu == 'UTILITY') ? "" : "collapse" ?> list-unstyled">
                    <li><a href="<?php echo site_url('utility/businesscats'); ?>">Business Categories</a></li>
                </ul>
            </li>
            <?php
        }
        ?>

        

        <?php
        if ($user_role == 'SALES') {
            ?>


            <?php
        }
        ?>

        </li>
    </ul>

</nav>
<div class="content-inner">