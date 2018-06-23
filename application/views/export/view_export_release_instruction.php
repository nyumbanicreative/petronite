<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $ri['customer_name']; ?> Release Instruction</title>
        <style type="text/css">
            table{
                width: 100%;
                font-size: 12px;
            }
            .align_left{
                text-align: left;
            }
            .align_right{
                text-align:right;
            }
            .padding-10-0{
                padding: 8px 0;
            }
            .width-50{
                width: 50%;
            }

            .particulars{
                border: 1px solid #000;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .particulars td, .particulars th{
                border: 1px solid #000;
                padding:10px;
                text-align: left;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div>

            <div style="text-align: center;">
                <img src="<?php echo base_url(); ?>assets/img/afroiltopbanner.jpg" style="height:100%;"/>
            </div>

            <p style="text-align:center;"><?php echo $contact_text; ?></p>

            <hr/>

            <table style="overflow: hidden; margin-top: 50px;width: 100%;">
                <tr>
                    <td class="align_left width-50 padding-10-0"><h4>RELEASE INSTRUCTION No.: <?php echo $ri['ri_number']; ?></h4></td>
                    <td class="align_right width-50"><h4>LOADING DATE: <?php echo date('d/m/Y', strtotime($ri['ri_loading_date'])); ?></h4></td>
                </tr>
                <tr>
                    <td class="align_left width-50 padding-10-0"><h4><span style="font-weight: normal">Seller:</span> <?php echo strtoupper($ri['seller_name']); ?></h4></td>
                    <td class="align_right width-50"></td>
                </tr>
                <tr>
                    <td class="align_left width-50 padding-10-0"><h4><span style="font-weight: normal">Receiver:</span> <?php echo strtoupper($ri['customer_name']); ?></h4></td>
                    <td class="align_right width-50"></td>
                </tr>

                <?php
                if ($ri_vessels) {
                    foreach ($ri_vessels as $vs) {
                        ?>
                        <tr>
                            <td class="align_left width-50 padding-10-0"><h4><span style="font-weight: normal">Vessel:</span> <?php echo strtoupper($vs['vessel_name'] . ' - ' . $vs['fuel_type_group_name']); ?></h4></td>
                            <td class="align_right width-50"></td>
                        </tr>
                        <?php
                    }
                }
                ?>

                <tr>
                    <td class="align_left width-50 padding-10-0"><h4><span style="font-weight: normal">Depot:</span> <?php echo strtoupper($ri['depo_name']); ?></h4></td>
                    <td class="align_right width-50"></td>
                </tr>
            </table>

            <p>Kindly authorize the following release to above mentioned receiver:</p>
            <br/>
            <br/>
            <?php
            if ($ri_orders) {
                ?>
                <table class="particulars" style="width:100%">
                    <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Order Date</th>
                            <th>Driver</th>
                            <th nowrap="nowrap">Truck No</th>
                            <?php
                            foreach ($ri_fuel_types as $i => $rift) {
                                $total[$i] = 0;
                                ?>
                                <th><?php echo strtoupper($rift['fuel_type_group_name']); ?></th>
                                <?php
                            }
                            ?>
                            <th>Delivery Point</th>
                            <?php
                            if (in_array($ri['ri_status'], ['NEW'])) {
                                ?>
                                <th style="width:10px;"></th>
                                <?php
                            }
                            ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ri_orders as $po) {

                            $volume = "";
                            $delivery = "";
                            $status = "";
                            $order_qty = [];

                            if (cus_is_json('[' . $po['order_qty'] . ']')) {
                                $order_qty = json_decode('[' . $po['order_qty'] . ']');
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
                            ?>
                            <tr>
                                <td><?php echo $po['po_number']; ?></td>
                                <td nowrap="nowrap"><?php echo $po['po_date']; ?></td>
                                <td nowrap="nowrap"><?php echo $po['po_driver_name'] . '<br/>' . $po['po_driver_license']; ?></td>
                                <td nowrap="nowrap"><?php echo $po['po_truck_number']; ?></td>
                                <?php
                                foreach ($ri_fuel_types as $i => $rift) {
                                    ?>
                                    <td>
                                        <?php
                                        foreach ($order_qty as $j => $oq) {
                                            if ($rift['fuel_type_group_id'] == $oq->poq_ftg_id) {
                                                $total[$i] += $oq->poq_volume;
                                                ;
                                                echo $oq->poq_volume;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <?php
                                }
                                ?>
                                <td nowrap="nowrap"><?php echo $delivery; ?></td>
                                <?php
                                if (in_array($ri['ri_status'], ['NEW'])) {
                                    ?>
                                    <td>

                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="<?php echo site_url('station/requesteditpoform/' . $po['po_id']); ?>"  class="dropdown-item text-info request_form"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit LPO</a>
                                                <a href="<?php echo site_url('station/removepofromri/' . $po['po_id']); ?>" class="dropdown-item edit text-danger confirm" title="Remove purchase order from release instruction"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>


                                    </td>
                                    <?php
                                }
                                ?>

                            </tr>
                            <?php
                        }
                        ?>

                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <?php
                            foreach ($ri_fuel_types as $i => $rift) {

                                echo '<th>' . $total[$i] . '</th>';
                            }
                            ?>
                            <th></th>
                            <?php
                            if (in_array($ri['ri_status'], ['NEW'])) {
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>

                        </tr>
                    </tfoot>


                    </tbody>
                </table>
                <?php
            } else {
                ?>
                <p style="border:1px solid #000; padding:  100px 10px; text-align: center">

                    This release instruction has no order added in it yet.

                </p>
                <?php
            }
            ?>
            <br/>
            <br/>
            <br/>
            <br/>
            <p style="font-size: 13px;">AUTHORISED SIGNATURE<br/>(<?php echo strtoupper($ri['auth_name']); ?>)</p>
        </div>
    </body>
</html>