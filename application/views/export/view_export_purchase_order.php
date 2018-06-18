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
                
            }
            .order_info td{
                vertical-align: top;
            }
        </style>
    </head>
    <body>
        <div>
            <h4 style="text-decoration: underline;text-align: center;">FUEL ORDER</h4>
            <div style="text-align: center;">
                <img src="<?php echo base_url(); ?>assets/img/afroiltopbanner.jpg" style="height:100%;"/>
            </div>
            
            <p style="text-align:center; font-size: 11px;"><?php echo $contact_text; ?></p>
            
            
            <hr/>

            <table style="overflow: hidden; margin-top: 10px; width: 100%;font-size:13px;">
                <tr>
                    <td class="align_left width-50 padding-10-0"><h4>No. <?php echo $po['po_number']; ?></h4></td>
                    <td class="align_right width-50"><h4>DATE: <?php echo date('d/m/Y', strtotime($po['po_date'])); ?></h4></td>
                </tr>
                <tr>
                    <td class="align_left width-50 padding-10-0" colspan="2"><h4><span style="font-weight: normal">M/S:</span>&nbsp;&nbsp;<?php echo strtoupper($po['depo_name']); ?></h4></td>
                </tr>
            </table>
            
            <br/>
            <p style="text-align: center;"><b>TIN:&nbsp;</b><?php echo $po['pc_tin_number']?></p>
            <table class="order_info" style="width: 100%; border:1px solid #000; border-collapse: collapse; font-size: 14px;" >
                <thead>
                    <tr>
                        <th>FUEL</th>
                        <th>QTY</th>
                        <th>PARTICULARS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo strtoupper($po['fuel_type_group_generic_name']); ?></td>
                        <td><?php echo $po['po_volume'];?></td>
                        <td nowrap="nowrap">
                            <b>TRUCK NO.</b>&nbsp;&nbsp;<?php echo $po['po_truck_number'];?><br/><br/>
                            <p><?php echo $qty_in_words; ?></p>
                            <br/>
                            
                            <b>DRIVER.</b>&nbsp;&nbsp;<?php echo $po['po_driver_name'];?>
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