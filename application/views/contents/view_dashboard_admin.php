
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Dashboard</h2>
    </div>
</header>
<?php echo $alert; ?>

<!--  <div style="min-height:500px"></div>-->

<section class="" style="min-height:650px;padding: 20px 0;">
    <div class="container-fluid ">
        <div class="card no-margin-bottom">
            <div class="card-header d-flex align-items-center" style="box-shadow: none; border: none">
                <h3 class="h5">Fuel Tanks</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    foreach ($tanks as $key => $t) {
                        ?>
                        <div class="col-lg-4 col-sm-6 col-md-6 col-12" style="margin-bottom:0px">
                            <div class="card no-padding">

                                <div class="card-body no-padding">
                                    <div class="row">
                                        <div class="col-5" style="text-align: center;">
                                            <input type="text" data-displayInput="false" value="<?php echo $t['fuel_tank_latest_volume']; ?>" data-fgColor="<?php echo $t['fuel_type_color_code']; ?>" readonly class="dial" data-width="100%" data-min="0" data-thickness=.1 data-max="<?php echo $t['fuel_tank_capacity']; ?>">
                                        </div>
                                        <div class="col-7">
                                            <div style="height: 100%" class="d-flex align-items-center">
                                                <table style="width:100%" >

                                                    <tr>
                                                        <td colspan="2" style="font-size: 12px;"><strong><?php echo $t['fuel_tank_name']; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="font-size: 12px;" >Type</td>
                                                        <td  style="min-width:50%; padding-left:10px;font-size: 12px;"><strong><?php echo $t['fuel_type_generic_name']; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="font-size: 12px;" >Vol</td>
                                                        <td  style="min-width:50%; padding-left:10px;font-size: 12px;"><strong><?php echo $t['fuel_tank_latest_volume']; ?>&nbsp;ltrs</strong></td>
                                                    </tr>
                    <!--                                            <tr>
                                                        <td  style="font-size: 12px;" >Tank&nbsp;Vol</td>
                                                        <td style="padding-left:10px;font-size: 12px;"><strong>30000&nbsp;Ltrs</strong></td>
                                                    </tr>-->
    <!--                                                    <tr>
                                                        <td style="font-size: 12px;" >Water&nbsp;Vol</td>
                                                        <td style="padding-left:10px;font-size: 12px;"><strong>30&nbsp;Ltrs</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 12px;" >Temp</td>
                                                        <td style="padding-left:10px;font-size: 12px;"><strong>20&deg;</strong></td>
                                                    </tr>-->
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                </div></div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Line Charts-->
            <div class="col-lg-12">
                <div class="line-chart-example card">

                    <div class="card-header d-flex align-items-center" style="box-shadow: none; border: none">
                        <h3 class="h5">Sales Graph</h3>
                    </div>
                    <div class="card-body">
                        <div >
                            <canvas id="line_chart_report" height="90"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!--  <script src="<?php echo base_url(); ?>assets/js/charts-home.js" type="text/javascript"></script>-->

<script type="text/javascript">

    var ctx = document.getElementById("line_chart_report").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        responsive: false,
        maintainAspectRatio: false,
        data: {
            labels: ['<?php echo implode("','", $graph_labels) ?>'],
            datasets: [
<?php
foreach ($fuel_types as $f => $ft) {
    ?>
                    {
                        label: '<?php echo $ft['fuel_type_generic_name']; ?>',
                        data: [<?php echo implode(',', $graph_data[$f]); ?>],
    <?php echo "borderColor: '" . $ft['fuel_type_color_code'] . "b8',
                                           backgroundColor: '" . $ft['fuel_type_color_code'] . "52',
                                           pointBorderColor: '" . $ft['fuel_type_color_code'] . "',
                                           pointBackgroundColor: '" . $ft['fuel_type_color_code'] . "',
                                           pointBorderWidth: 1"; ?>,
                        borderWidth: 1
                    },
    <?php
}
?>
            ]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
    $(document).ready(function () {

        $(".dial").knob({
            'format': function (value) {
                return value + ' lt';
            },
            'draw': function (v) {
                $(this.i).css('font-size', '9pt'); //.css('transform', 'rotate(180deg)')
            }
        });
    });

</script>


