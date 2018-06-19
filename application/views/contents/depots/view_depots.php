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

<?php echo $alert; ?>


<section class="" style="min-height:550px;">
    <div class="container-fluid">
        
        <div class="row">
            <?php
            foreach ($depots as $key => $d) {
                ?>
                <div class="col-md-4 col-lg-3 col-sm-6 col-6">
                    <a href="<?php echo site_url('depots/setdepot/' . $d['depo_id']); ?>" class="card" style="border: 1px solid #f1f1f1;">
                        <img class="card-img-top" src="<?php echo base_url() . 'assets/img/depot.JPG' ?>" alt="Depot Image">
                        <div class="card-body" style="background: #fdfdfd;">
                            <h5 class="card-title"><?php echo ucwords(strtoupper($d['depo_name'])); ?></h5>
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

<script type="text/javascript">

    $(document).ready(function () {
        
    });

</script>
