<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Purchase Order No. <?php echo $po['po_number']; ?></title>
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
                <img src="<?php echo base_url() . 'uploads/company_banners/' . $customer['pc_logo']; ?>" style="height:80px;"/>
            </div>

            <p style="text-align:center; font-size: 13px;"><?php echo $contact_text; ?></p>



            <hr/>
            <h4 style="text-decoration: underline;text-align: center;">PURCHASE ORDER</h4>
            

            <table style="overflow: hidden; margin-top: 10px; width: 100%;font-size:14px;border-collapse: collapse;" class="order_info top_desc">
                <tr>
                    <td class="align_left padding-10-0" nowrap="nowrap" rowspan="3" width="50%">
                        Supplier:
                        <br/><br/>
                        <h4>
                            <?php
                            echo strtoupper($po['supplier_name']);
                            ?>
                        </h4>
                        <h4>
                            <?php
                            if(!empty($po['supplier_address'])){
                                echo '<span style="font-weight:normal">Address:</span>&nbsp;&nbsp;'.$po['supplier_address']; 
                               
                            }
                            ?>
                        </h4>
                        <h4>
                            <?php
                            if(!empty($po['supplier_phone'])){
                                echo '<span style="font-weight:normal">Phone:</span>&nbsp;&nbsp;' .$po['supplier_phone']; 
                               
                            }
                            ?>
                        </h4>
                        <h4>
                            <?php
                            if(!empty($po['supplier_email'])){
                                echo '<span style="font-weight:normal">Email:</span>&nbsp;&nbsp;' . $po['supplier_email']; 
                               
                            }
                            ?>
                        </h4>
                        <h4>
                            <?php
                            if(!empty($po['supplier_fax'])){
                                echo'<span style="font-weight:normal">Fax:</span>&nbsp;&nbsp;' . $po['supplier_fax']; 
                               
                            }
                            ?>
                        </h4>
                    </td>
                    <td class="align_left">
                        Order No:
                        <h4>
                            <?php
                            echo $po['po_number'];
                            ?>
                        </h4>
                    </td>
                    <td class="align_left">
                        Date:
                        <h4>
                            <?php
                            echo $po['po_date'];
                            ?>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td class="align_left  padding-10-0">
                        Driver Name:
                        <h4>
                            <?php
                            echo $po['po_driver_name'];
                            ?>
                        </h4>
                    </td>
                    <td class="align_right" >
                        Driver Licence No.
                        <h4>
                            <?php
                            echo $po['po_driver_license_number'];
                            ?>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td class="align_left padding-10-0">
                        Truck Number.
                        <h4>
                            <?php
                            echo $po['po_truck_number'];
                            ?>
                        </h4>
                    </td>
                    <td class="align_right">
                        
                    </td>
                </tr>
            </table>

            <br/>
            <table class="order_info" style="width: 100%; border:1px solid #000; border-collapse: collapse; font-size: 14px;" >
                <thead>
                    <tr>
                        <th style="width: 10px;">NO.</th>
                        <th>Fuel</th>
                        <th style="width: 20px;" nowrap="nowrap">Qty (ltrs)</th>
                        <th style="width: 20px;" nowrap="nowrap">Rate</th>
                        <th style="width: 10px;" nowrap="nowrap">Per</th>
                        <th style="width: 30px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $total_amount = 0;
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
                        <td nowrap="nowrap">
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                if (AGO == $oq->poq_ftg_id) {
                                    echo cus_price_form_french(round($oq->poq_unit_price));
                                }
                            }
                            ?>
                        </td>
                        <td>Ltr</td>
                        <td nowrap="nowrap">
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                $total_amount += $oq->poq_volume * $oq->poq_unit_price;
                                if (AGO == $oq->poq_ftg_id) {
                                    echo cus_price_form_french(round($oq->poq_volume * $oq->poq_unit_price));
                                }
                            }
                            ?>
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
                        <td>
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                if (PMS == $oq->poq_ftg_id) {
                                    echo cus_price_form_french(round($oq->poq_unit_price));
                                }
                            }
                            ?>
                        </td>
                        <td>Ltr</td>
                        <td>
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                if (PMS == $oq->poq_ftg_id) {
                                    echo cus_price_form_french(round($oq->poq_volume * $oq->poq_unit_price));
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
                                    echo cus_price_form_french(round($oq->poq_unit_price));
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                if (IK == $oq->poq_ftg_id) {
                                    echo round($oq->poq_volume );
                                }
                            }
                            ?>
                        </td>
                        <td>Ltr</td>
                        <td>
                            <?php
                            foreach ($order_qty as $j => $oq) {
                                if (IK == $oq->poq_ftg_id) {
                                    echo cus_price_form_french(round($oq->poq_volume * $oq->poq_unit_price));
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Total</td>
                        <td>
                            <?php echo $total; ?>
                        </td>
                        <td></td>
                        <td></td>
                        <td><?php echo cus_price_form_french($total_amount);?></td>
                    </tr>
                    <tr>
                        <td colspan="6">
                           PARTICULARS: <br/>
                           <?php
                            if (!empty($qty_in_words)) {
                                ?>
                                <br/>
                                <p><?php echo $qty_in_words; ?></p>
                                <?php
                            }
                            ?>
                        </td>
                        </td>
                    </tr>
                </tbody>

            </table>
            <br/>
            <br/>
            <p>Authorised Signatory&nbsp;&nbsp;.....................................</p>

        </div>
    </body>
</html>