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
            <h1 style="display: inline-block; text-align:center;margin: 0;padding: 0; font-size:32px; "><img src="<?php echo base_url(); ?>assets/img/<?php echo $ri['pc_logo']; ?>" style="width: 90px;"/>&nbsp;&nbsp;<?php echo strtoupper($ri['customer_name']); ?></h1><?php
            if (!empty($ri['pc_slogan'])) {
                echo '<p style="padding:0;margin: 0; text-align: center;">"' . strtoupper($ri['pc_slogan']) . '"</p>';
            }
            ?>
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
                <table class="particulars">
                    <thead>
                        <tr>
                            <th>Loading<br/>Order No.</th>
                            <th>Driver's Name</th>
                            <th>Driving License</th>
                            <th nowrap="nowrap">Truck No/<br/>Trailer No</th>
                            <?php
                            foreach ($ri_fuel_types as $i => $rift) {
                                $total[$i] = 0;
                                ?>
                                <th><?php echo strtoupper($rift['fuel_type_group_name']); ?></th>
                                <?php
                            }
                            ?>
                            <th>Delivery Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ri_orders as $po) {
                            ?>
                            <tr>
                                <td><?php echo $po['po_number']; ?></td>
                                <td nowrap="nowrap"><?php echo $po['po_driver_name']; ?></td>
                                <td nowrap="nowrap"><?php echo $po['po_driver_license']; ?></td>
                                <td nowrap="nowrap"><?php echo $po['po_truck_number']; ?></td>
                                <?php
                                foreach ($ri_fuel_types as $i => $rift) {
                                    ?>
                                    <td>
                                        <?php
                                        if ($rift['fuel_type_group_id'] == $po['fuel_type_group_id']) {
                                            $total[$i] += $po['po_volume'];
                                            echo $po['po_volume'];
                                        }
                                        ?>
                                    </td>
                                    <?php
                                }
                                ?>
                                <td nowrap="nowrap"><?php echo $po['station_name']; ?></td>
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
            <p style="font-size: 13px;">AUTHORISED SIGNATURE<br/>(<?php echo strtoupper($ri['user_name']); ?>)</p>
        </div>
    </body>
</html>