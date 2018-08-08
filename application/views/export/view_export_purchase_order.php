<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Fuel Order No. <?php echo $po['po_number']; ?></title>
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

            .order_info td, .order_info th{
                border: 1px solid #000;
                padding: 10px;
                text-align: left;

            }
            .order_info td{
                vertical-align: top;
            }
        </style>
    </head>
    <body>
        <div>
            
            <div style="text-align: center;">
                <img src="<?php echo base_url() . 'uploads/company_banners/'.$customer['pc_logo']; ?>" style="height:80px;"/>
            </div>

            <p style="text-align:center; font-size: 13px;"><?php echo $contact_text; ?></p>
            
            

            <hr/>
            <h4 style="text-decoration: underline;text-align: center;">FUEL ORDER</h4>
            <table style="overflow: hidden; margin-top: 10px; width: 100%;font-size:15px;">
                <tr>
                    <td class="align_left width-50 padding-10-0" style="font-size:18px;"><h4>No. <?php echo $po['po_number']; ?></h4></td>
                    <td class="align_right width-50"><h4>DATE: <?php echo date('d/m/Y', strtotime($po['po_date'])); ?></h4></td>
                </tr>
                <tr>
                    <td class="align_left width-50 padding-10-0"><h4><span style="font-weight: normal">M/S:</span>&nbsp;&nbsp;<?php echo strtoupper($po['depo_name']); ?></h4></td>
                    <td class="align_right width-50"><b>VRN:&nbsp;</b><?php echo $po['pc_vrn'] ?><br/><b>TIN:&nbsp;</b><?php echo $po['pc_tin_number'] ?></td>
                </tr>
            </table>

            <br/>
            <table class="order_info" style="width: 100%; border:1px solid #000; border-collapse: collapse; font-size: 14px;" >
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>FUEL</th>
                        <th>QTY (ltrs)</th>
                        <th>PARTICULARS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $order_qty = [];

                    if (cus_is_json('[' . $po['order_qty'] . ']')) {
                        $order_qty = json_decode('[' . $po['order_qty'] . ']');
                    }
                    ?>
                    <tr>
                        <td>1</td>
                        <td nowrap="nowrap">DIESEL</td>
                        <td nowrap="nowrap">
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                $total += $oq->poq_volume;
                                if (AGO == $oq->poq_ftg_id) {
                                    
                                    echo round($oq->poq_volume);
                                }
                            }
                            ?>
                        </td>
                        <td rowspan="4" >
                            <b>TRUCK NO.</b>&nbsp;&nbsp;<?php echo $po['po_truck_number']; ?><br/>
                            <?php
                            if (!empty($qty_in_words)) {
                                ?>
                                <br/>
                                <p><?php echo $qty_in_words; ?></p>
                                <?php
                            }
                            ?>

                            <br/>

                            <b>DRIVER.</b>&nbsp;&nbsp;<?php echo $po['po_driver_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>SUPER</td>
                        <td>
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                if (PMS == $oq->poq_ftg_id) {
                                    echo round($oq->poq_volume);
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>KEROSENE</td>
                        <td>
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                if (IK == $oq->poq_ftg_id) {
                                    echo round($oq->poq_volume);
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Total</td>
                        <td>
                            <?php echo $total;?>
                        </td>
                    </tr>
                </tbody>

            </table>
            <br/>
            <br/>
            <p>Signature&nbsp;&nbsp;.........................</p>

        </div>
    </body>
</html>