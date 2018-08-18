<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Credit Customer Statement</title>
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

            <p style="text-align:center; font-size: 13px;"><?php echo $customer['pc_contact_text']; ?></p>

            <hr/>
            <h4 style="text-decoration: underline;text-align: center;">CREDIT CUSTOMER STATEMENT</h4>
            <table style="overflow: hidden; margin-top: 10px; width: 100%;font-size:15px;">
                <tr>
                    <td class="align_left width-50 padding-10-0" style="font-size:18px;"><h4><span style="font-weight: normal">M/S:</span>&nbsp;&nbsp;<?php echo strtoupper($cc['credit_type_name']); ?></h4></td>
                    <td class="align_right width-50"><b>VRN:&nbsp;</b><?php echo $customer['pc_vrn'] ?></td>
                </tr>
                <tr>
                    <td class="align_left width-50 padding-10-0" nowrap="nowrap"><h4><span style="font-weight:normal;">Balance To Be Paid:</span>&nbsp;&nbsp;<strong><?php echo cus_price_form($cc['credit_type_balance']) . ' ' . CURRENCY; ?></h4></strong></td>
                    <td class="align_right width-50"><b>TIN:&nbsp;</b><?php echo $customer['pc_tin_number'] ?></td>
                </tr>
            </table>

            <br/>
            <table class="order_info" style="width: 100%; border:1px solid #000; border-collapse: collapse; font-size: 14px;" >
                <thead>
                    <tr>
                        <th>Transaction Date</th>
                        <th>Particular</th>
                        <th>Transaction Type</th>
                        <th>Debit (<?php echo CURRENCY;?>)</th>
                        <th>Credit (<?php echo CURRENCY;?>)</th>
                        
                        <th>Balance (<?php echo CURRENCY;?>)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($txns as $key => $txn) {
                        ?>
                        <tr>
                            <td><?php echo $txn['txn_timestamp'] ?></td>
                            <td>
                                <?php
                                if ($txn['txn_balance_after'] <= 0) {
                                    echo cus_price_form(abs($txn['txn_balance_after'])) . ' Cr';
                                } else {
                                    echo cus_price_form($txn['txn_balance_after']) . ' Dr';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($txn['txn_type'] == 'CREDIT_SALE') {
                                    echo 'CREDIT SALE';
                                } elseif ($txn['txn_type'] == 'CREDIT_PAYMENT') {
                                    echo 'RECEIPT';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo cus_price_form_french($txn['txn_debit']);
                                ?>
                            </td>
                            <td>
                                <?php
                                echo cus_price_form_french($txn['txn_credit']);
                                ?>
                            </td>
                            <td><?php echo $txn['txn_notes']; ?></td>
                            
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

            </table>
            <br/>
            <br/>
            <p>Signature&nbsp;&nbsp;.........................</p>

        </div>
    </body>
</html>