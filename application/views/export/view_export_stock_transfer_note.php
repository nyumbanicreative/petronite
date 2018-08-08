<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Stock Transfer Note: <?php echo $stn['stn_number']; ?></title>
        <style type="text/css">
            *{
                padding: 0;
                margin: 0;
            }
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

            .particulars  td, .particulars th{
                padding:20px 10px;
            }
            .normal-text{
                font-weight: normal;
            }
            .td{
                border: 1px solid #000;
                border-style: inset;
                padding: 3px 20px;
            }
        </style>
    </head>
    <body>
        <div>

            <div style="text-align: center; margin-top: 0;padding-top: 0;">
                <img src="<?php echo base_url() . 'uploads/company_banners/'.$customer['pc_logo']; ?>" style="height:50px;"/>
            </div>

            <p style="text-align:center;"><?php echo $stn['contact_text']; ?></p>

            <table style="border:1px solid #000;width: 100%; overflow: hidden;border-spacing: 0;">
                <tr>
                    <td colspan="7" class="td">
                        <table style="width: 100%;" >
                            <tr>
                                <td class="align_left padding-10-0">
                                    <h2>TIN No. 112-112-123</h2>
                                    <br/>
                                    <br/>
                                    <h2>No. <span class="normal-text"><?php echo $stn['stn_number']; ?></span></h2>

                                </td>
                                <td nowrap="nowrap" style="text-align:center;"><h1>STOCK TRANSFER NOTE</h1></td>
                                <td class="align_right">
                                    <h2>VAT NO. 40-011306-Y</h2><br/>
                                    <h4>LOADING DATE: <?php echo date('d/m/Y', strtotime($stn['stn_timestamp'])); ?><br/>LOADING DEPOT: <?php $arr = explode(' ',trim($stn['depo_name'])); echo $arr[0]; ?></h4>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="td" colspan="3">
                        From<br/><br/><br/><br/>
                    </td>
                    <td class="td" colspan="4">
                        To<br/><br/><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td class="td">Compatment No</td>
                    <td class="td">Product</td>
                    <td class="td">Quantity</td>
                    <td class="td">Delivered To</td>
                    <td class="td">Tank</td>
                    <td class="td">Date Of Delivery</td>
                    <td class="td">Manager Signature</td>
                </tr>
                <tr>
                    <td class="td">1</td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                </tr>
                <tr>
                    <td class="td">2</td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                </tr>
                <tr>
                    <td class="td">3</td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                </tr>
                <tr>
                    <td class="td">4</td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                </tr>
                <tr>
                    <td class="td">5</td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                </tr>
                <tr>
                    <td class="td">6</td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                </tr>

            </table>

        </div>
    </body>
</html>