
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Dashboard</h2>
    </div>
</header>
<?php echo $error_msg . $success_msg; ?>

<!--  <div style="min-height:500px"></div>-->

<!--<section class="dashboard-header">

    <div class="container-fluid">

        <div class="row">
             Statistics 
            <div class="statistics col-lg-4 col-12">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-info"><i class="fa fa-calendar"></i></div>
                    <div class="text"><strong>12</strong><br><small><a href="<?php echo site_url('user/approved'); ?>" class="text-info">Bookings This Month</a></small></div>
                </div>
            </div>

            <div class="statistics col-lg-4 col-12">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-success"><i class="fa fa-check"></i></div>
                    <div class="text"><strong>4,232,00 Tsh</strong><br><small><a href="<?php echo site_url('user/approved'); ?>" class="text-success">Earned This Month</a></small></div>
                </div>
            </div>

            <div class="statistics col-lg-4 col-12">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-warning"><i class="fa fa-exclamation"></i></div>
                    <div class="text"><strong>1,200,00 Tsh</strong><br><small><a href="<?php echo site_url('user/pending'); ?>" class="text-warning">Pending This Month</a></small></div>
                </div>
            </div>
                        <div class="statistics col-lg-4 col-12">
                            <div class="statistic d-flex align-items-center bg-white has-shadow">
                                <div class="icon bg-red"><i class="fa fa-question"></i></div>
                                <div class="text"><strong>320</strong><br><small><a href="<?php echo site_url('user/rejected'); ?>" class="text-danger">Rejected</a></small></div>
                            </div>
                        </div>

        </div>
    </div>
</section>-->

<section class=" dashboard-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card">
                    <!--                    <div class="card-close">
                                            <div class="dropdown">
                                                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                                            </div>
                                        </div>-->
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Booking Calendar</h3>
                    </div>
                    <div class="card-body no-padding">
                        <div id="dncalendar-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="add_booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="book_form" role="form" action="<?php echo site_url('booking/manageraddbooking'); ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Add Booking</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body padding">
               
                    <div id="hall_id"></div>
                    
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col col-xs-12" >
                            <div class="form-group" id="event_date">
                                <label>Event Date</label>
                                <input id="event_day"  type="text" style="margin-bottom: 2px" readonly autocomplete="off" class="form-control event_date" name="event_date" placeholder="Event Date" />
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col col-xs-12" >
                            <div class="form-group" id="full_name">
                                <label>Full Name</label>
                                <input type="text" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="full_name" placeholder="Enter Full Name"/>
                            </div>
                        </div>


                    </div>

                    <div class="row" >
                        <div class="col col-xs-12" >
                            <div class="form-group" id="phone_number">
                                <label>Phone Number</label>
                                <input type="text" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="phone_number" placeholder="Enter The Phone Number"/>
                            </div>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col col-xs-12" >
                            <div class="form-group" id="bride_name">
                                <label>Bride Name</label>
                                <input type="text" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="bride_name" placeholder="Enter The Bride Name"/>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col col-xs-12" >
                            <div class="form-group" id="groom_name">
                                <label>Groom Name</label>
                                <input type="text" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="groom_name" placeholder="Groom Name"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col col-xs-12" >
                            <div class="form-group" id="groom_name">
                                <label>Amount Paid</label>
                                <input type="text" style="margin-bottom: 2px" class="form-control" autocomplete="off" name="groom_name" placeholder="Enter paid amount"/>
                            </div>
                        </div>
                    </div>
                    

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                <button type="button" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add</button>
            </div>
        </form>
    </div>
</div>


<div style="height: 100px;"></div>
<!--  <script src="<?php echo base_url(); ?>assets/js/charts-home.js" type="text/javascript"></script>-->

<script type="text/javascript">

    $(document).ready(function () {


        var my_calendar = $("#dncalendar-container").dnCalendar({
            minDate: "<?php echo date('Y-m-d'); ?>",
            //maxDate: "2016-12-02",
            defaultDate: "<?php echo date('Y-m-d'); ?>",
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
            dayNames: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            dataTitles: {defaultDate: 'Today', today: ''},
            notes: [
<?php
foreach ($schedules as $s) {
    ?>
                    {"date": "<?php echo date('Y-m-d', strtotime($s['booking_event_date'])); ?>", "note": ["<a href='<?php echo site_url('booking/bookingdetails/' . $s['booking_id']); ?>'><?php echo $s['booking_bride_name'] . ' &amp; ' . $s['booking_groom_name']; ?></a>"]},
    <?php
}
?>
            ],
            showNotes: true,
            startWeek: 'monday',
            dayClick: function (date, view) {

                if ($(this).hasClass('note'))
                    return;
                
                $('#event_day').val(date.getFullYear()+'-'+(date.getMonth() + 1)+'-' + date.getDate());
                $('#add_booking').modal('show');

                console.log();
                //alert(date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear());
            }
        });

        // init calendar
        my_calendar.build();


        // update calendar
        // my_calendar.update({
        // 	minDate: "2016-01-05",
        // 	defaultDate: "2016-05-04"
        // });
    });

</script>


