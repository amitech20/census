<!-- Main content -->
<section class="content">


        <div class="row">
          <!-- /.col -->
          <div class="col-xl-3 col-md-6 col">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="ion ion-person-stalker"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-number"><?=getTotalEnumerated($user_lga,"enumerator",$user_ref)?></span>
                <span class="info-box-text">Total Enumerated</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-xl-3 col-md-6 col">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="ion ion-thumbsup"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-number"><?=getTotalAppEnums($user_lga,"enumerator",$user_ref)?></span>
                <span class="info-box-text">Approved</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
  
          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>
  
          <div class="col-xl-3 col-md-6 col">
            <div class="info-box">
              <span class="info-box-icon bg-purple"><i class="ion ion-thumbsdown"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-number"><?=getTotalDisEnums($user_lga,"enumerator",$user_ref)?></span>
                <span class="info-box-text">Disapproved</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-xl-3 col-md-6 col">
          <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="ion ion-stats-bars"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-number"><?=getAccuracyRate($user_lga,"enumerator",$user_ref)?><small>%</small></span>
                <span class="info-box-text">Accuracy Rate</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
  <!-- /.row -->



  <h2 class="page-header"></h2>


  <div class="row">
    <div class="col-xl-6 col-lg-12">
      <!-- Widget: user widget style 4 -->
      <div class="box box-widget widget-user-4">
        <div class="box-footer">
          <div class="col-12">
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="card-title">Select Search parameter</h3>
                <h6 class="card-subtitle">Use birth ID for citizens under 12 years and NIN for citizens from 12 years and above.</h6>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- Nav tabs -->
                <div class="vtabs">
                  <ul class="nav nav-tabs tabs-vertical" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home4" role="tab"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">Search by Birth Id</span>
                      </a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile4" role="tab"><span class="hidden-sm-up"><i class="ion-person"></i></span> <span class="hidden-xs-down">Search by NIN/Tracking ID</span></a> </li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane active" id="home4" role="tabpanel">
                      <div class="pad">
                        <form action="#" method="post">
                          <!-- <img class="img-fluid rounded img-sm" src="./images/user4-128x128.jpg" alt="Alt Text"> -->
                          <i class="fa fa-user rounded img-sm fa-2x"></i>
                          <!-- .img-push is used to add margin to elements next to floating images -->
                          <div class="img-push">
                            <input type="text" class="form-control input-sm CNIN" placeholder="enter the citizen's BID" search_param="BID"  module="doCensus">
                          </div>
                          <div class="DisplayResult"></div>
                        </form>
                      </div>
                    </div>
                    <div class="tab-pane pad" id="profile4" role="tabpanel">
                      <form action="#" method="post">
                        <!-- <img class="img-fluid rounded img-sm" src="./images/user4-128x128.jpg" alt="Alt Text"> -->
                        <i hidden class="fa fa-user rounded img-sm fa-2x"></i>
                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <!-- <div class="img-push"> -->
                          <input type="text" class="form-control input-sm CNIN" placeholder="citizen's NIN/Tracking ID" search_param="NIN"  module="doCensus">
                        <!-- </div> -->
                        <div class="DisplayResult"></div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

        </div>

      </div>
      <!-- /.widget-user -->
    </div>
    <!-- /.col -->
    <div class="col-xl-6 col-lg-12">
      <!-- Box Comment -->
      <div class="box box-widget widget-user-4 displayblock d-none">
        <div class="box-header with-border">
          <!-- /.user-block -->
          <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
              <i class="fa fa-comments-o"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <span class="DisplaySelected"></span>
          <!-- post text -->

          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->

