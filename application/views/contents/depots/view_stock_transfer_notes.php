<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>
<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px; ">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <!--<a href="<?php echo $this->input->get('url'); ?>"class="btn btn-primary btn-sm" data-target="#myModal"><i class="fa fa-arrow-circle-left"></i>&nbsp;Back</a>-->
                </div>

                <div class="pull-right">
                </div>
            </div>
        </div>

        <br/>
        <br/>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">
                    <div style="padding:10px 0"></div>
                    <div class="card-body no-padding">

                        <table id="purchase_orders" class="table table-striped table-light table-sm" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Transfer Note No.</th>
                                    <th>Order Volume (Ltr)</th>
                                    <th>Driver</th>
                                    <th>Truck Number</th>
                                    <th>Order Status</th>
                                    <th>Delivery</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($transfer_notes as $key => $tn) {

                                    $status = "<div class='text-nowrap'>";
                                    $driver = "";
                                    $volume = "<div class='text-nowrap'>";
                                    $delivery = "<div class='text-nowrap'>";
                                    $order_qty = [];
                                    $can_edit = FALSE;

                                    if (cus_is_json('[' . $tn['order_qty'] . ']')) {
                                        $order_qty = json_decode('[' . $tn['order_qty']. ']');
                                    }

                                    foreach ($order_qty as $i => $oq) {
                                        if ($i > 0) {
                                            $volume .= '<br/>';
                                        }
                                        $volume .= $oq->product . ' - ' . $oq->poq_volume;
                                    }

                                    foreach ($order_qty as $i => $oq) {
                                        if ($i > 0) {
                                            $delivery .= '<br/>';
                                        }
                                        $delivery .= $oq->product . ' - ' . $oq->station_name;
                                    }

                                    $volume .= "</div>";
                                    $delivery .= "</div>";

                                    $driver .= "<div class='text-nowrap'>";
                                    $driver .= $tn['po_driver_name'];
                                    $driver .= !empty($tn['po_driver_license']) ? '<br/>' . $tn['po_driver_license'] : '';
                                    $driver .= "</div>";

                                    foreach ($order_qty as $i => $oq) {

                                        switch ($oq->poq_status) {

                                            case 'NEW':
                                                $status .= "<h5><span class='badge badge-info'>" . $oq->product . " - NEW</span></h5>";
                                                $can_edit = TRUE;
                                                break;
                                            case 'LOADED':
                                                $status .= "<h5><span class='badge badge-info'>" . $oq->product . " - LOADED</span></h5>";
                                                break;
                                            case 'UNRELEASED':
                                                $status .= "<h5><span class='badge badge-danger'>" . $oq->product . " - UNRELEASED</span></h5>";
                                                $can_edit = TRUE;
                                                break;
                                            case 'RELEASED':
                                                $status .= "<h5><span class='badge badge-warning'>" . $oq->product . " - RELEASED</span></h5>";
                                                break;
                                            case 'DELIVERED':
                                                $status .= "<h5><span class='badge badge-success'>" . $oq->product . " - DELIVERED</span></h5>";
                                                break;
                                        }
                                    }

                                    $status .= "</div>";
                                    ?>
                                    <tr>
                                        <td><?php echo $tn['stn_number']; ?></td>
                                        <td><?php echo $volume; ?></td>
                                        <td><?php echo $driver; ?></td>
                                        <td><?php echo $tn['po_truck_number']; ?></td>
                                        <td><?php echo $status;?></td>
                                        <td><?php echo $delivery; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('depots/pdfstocktransernote/'.$tn['stn_id']);?>" target="_blank" class="btn btn-outline-info btn-sm"><i class="fa fa-file-pdf-o"></i></a>
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

<script type="text/javascript">

    $(document).ready(function () {
        $('#purchase_orders').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 25,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });

    });

</script>
