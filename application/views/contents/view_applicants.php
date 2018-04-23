<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<!-- Breadcrumb-->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-info" href="<?php echo site_url('user/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active"><?php echo $module_name;?></li>
    </ul>
</div>
<section class="tables no-padding-top">   
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <a href="" class="btn btn-info btn-sm pull-right"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a>
            </div>
        </div>
        <br/>
        <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 id="exampleModalLabel" class="modal-title">Approve MSISDN</h4>
                  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                  
                  <form>
                    <div class="row">
                        <div class="col col-md-6 col-12">
                            <div class="form-group">
                              <label>Full Name</label>
                              <p>Tumsifu Lema</p>
                            </div>
                        </div>
                        <div class="col col-md-6 col-12">
                            <div class="form-group">
                              <label>MSISDN</label>
                              <p>255 765 127663</p>
                            </div>
                        </div>
                    </div>
                      
                    <div class="row">
                        <div class="col col-md-6 col-12">
                            <div class="form-group">
                              <label>College Name</label>
                              <p>St Joseph University Of Tanzania</p>
                            </div>
                        </div>
                        <div class="col col-md-6 col-12">
                            <div class="form-group">
                              <label>ID No </label>
                              <p>117180667</p>
                            </div>
                        </div>
                    </div>
                      
                    <div class="row">
                        <div class="col col-md-6 col-12">
                            <div class="form-group">
                              <label>Joining Year</label>
                              <p>2016</p>
                            </div>
                        </div>
                        <div class="col col-md-6 col-12">
                            <div class="form-group">
                              <label>Ending Year </label>
                              <p>2018</p>
                            </div>
                        </div>
                    </div>
                      
                    <div class="row">
                        <div class="col col-md-6 col-12">
                            <div class="form-group">
                              <label>Attachment</label>
                              <div id="thumbnails" class="yoxview">
                                  <img id="attachment" src="<?php echo base_url() ."assets/img/saut_id.jpg"?>" style="width: 100px;cursor: -webkit-zoom-in;cursor: zoom-in;cursor: -moz-zoom-in;">
                              </div>
                           
                            </div>
                        </div>
                        
                    </div>
                      
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                  <button type="button"  class="btn btn-danger">Disapprove</button>
                  <button type="button" class="btn btn-success">Approve</button>
                </div>
              </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>MSISDN</th>
                                    <th>College</th>
                                    <th>ID Number</th>
                                    <th>Year</th>
                                    <th>Status</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark Doe</td>
                                    <td>255764192010</td>
                                    <td>St. Joseph University In Tanzania</td>
                                    <td>117180223</td>
                                    <td>2014 - 2018</td>
                                    <td><span class="badge badge-danger badge-rounded">PENDING</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" data-toggle="modal" data-target="#myModal" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approve</a>
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Ashura Jumanne</td>
                                    <td>255764112233</td>
                                    <td>University Of Dodoma</td>
                                    <td>UDOM0193381</td>
                                    <td>2017 - 2020</td>
                                    <td><span class="badge badge-success badge-rounded">ACTIVE</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Issack Sanga</td>
                                    <td>255755406677</td>
                                    <td>University Of Dodoma</td>
                                    <td>192031221</td>
                                    <td>2015 - 2019</td>
                                    <td><span class="badge badge-danger badge-rounded">PENDING</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" data-toggle="modal" data-target="#myModal" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approve</a>
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Mpendakazi Sanga</td>
                                    <td>255755182129</td>
                                    <td>University Of Dar Es Salaam</td>
                                    <td>192801928</td>
                                    <td>2016 - 2020</td>
                                    <td><span class="badge badge-success badge-rounded">ACTIVE</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Zainab Juma</td>
                                    <td>255764182712</td>
                                    <td>St. Augustine University</td>
                                    <td>188720198</td>
                                    <td>2014 - 2018</td>
                                    <td><span class="badge badge-success badge-rounded">ACTIVE</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">6</th>
                                    <td>Mark Doe</td>
                                    <td>255764192010</td>
                                    <td>St. Joseph University In Tanzania</td>
                                    <td>117180223</td>
                                    <td>2014 - 2018</td>
                                    <td><span class="badge badge-danger badge-rounded">PENDING</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" data-toggle="modal" data-target="#myModal" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approve</a>
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>Ashura Jumanne</td>
                                    <td>255764112233</td>
                                    <td>University Of Dodoma</td>
                                    <td>UDOM0193381</td>
                                    <td>2017 - 2020</td>
                                   <td><span class="badge badge-success badge-rounded">ACTIVE</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8</th>
                                    <td>Issack Sanga</td>
                                    <td>255755406677</td>
                                    <td>University Of Dodoma</td>
                                    <td>192031221</td>
                                    <td>2015 - 2019</td>
                                  <td><span class="badge badge-success badge-rounded">ACTIVE</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">9</th>
                                    <td>Mpendakazi Sanga</td>
                                    <td>255755182129</td>
                                    <td>University Of Dar Es Salaam</td>
                                    <td>192801928</td>
                                    <td>2016 - 2020</td>
                                    <td><span class="badge badge-success badge-rounded">ACTIVE</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">10</th>
                                    <td>Mark Doe</td>
                                    <td>255764192010</td>
                                    <td>St. Joseph University In Tanzania</td>
                                    <td>117180223</td>
                                    <td>2014 - 2018</td>
                                    <td><span class="badge badge-danger badge-rounded">PENDING</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                <a href="#" data-toggle="modal" data-target="#myModal" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approve</a>
                                                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                                <a href="#" class="dropdown-item edit text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
