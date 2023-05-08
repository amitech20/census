<?php
if ($permission == "supervisor") {
  $canAdd="enumerator";
  $lga_condition="&& `lga_assigned` = '$user_lga'";
  $appendText="Enum.";
}
elseif ($permission == "admin") {
  $canAdd="supervisor";
  $lga_condition="";
  $appendText="Procd.";

  $level1header="Statistics";
}

//fuction to get the total number of educational level
function getNumEdu($eduLevel) {
  global $con;
  $query= mysqli_query($con, "SELECT * FROM citizen WHERE `educBg` = '$eduLevel' ");

  return mysqli_num_rows($query);
}

?>
 
 
 <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
      <div class="row">
          <div class="col-xl-3 col-md-6 col">
          <div class="info-box">
              <span class="info-box-icon bg-red"><i class="ion ion-person"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-number"><?=countEnums($user_lga,"enumerator")?></span>
                <span class="info-box-text"> Enumerators</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-xl-3 col-md-6 col">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="ion ion-person-stalker"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-number"><?=getTotalEnumerated($user_lga,"enumerator","")?></span>
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
                <span class="info-box-number"><?=getTotalAppEnums($user_lga,"enumerator","")?></span>
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
                <span class="info-box-number"><?=getTotalDisEnums($user_lga,"enumerator","")?></span>
                <span class="info-box-text">Disapproved</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>

        <!-- /.row -->
    
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-lg-12 col-xl-8">		  
                         
            
  
            <!-- TABLE: LATEST ORDERS -->
            <?php
                        if ($permission=="admin") { ?>
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"><?=$level1header?></h3>
  
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-responsive no-margin">
                    <thead>
                    <tr>
                      <th colspan="3">Category</th>
                      <th>Population</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td colspan="3"><a href="#">Uneducated</a></td>
                      <td>
                        <div class="sparkbar" data-color="#7460ee" data-height="20"><?=getNumEdu("uneducated")?></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><a href="#">Stopped at or Finished Primary school</a></td>
                      <td>
                        <div class="sparkbar" data-color="#7460ee" data-height="20"><?=getNumEdu("Primary")?></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><a href="#">Stopped at or Finished Secondary School</a></td>
                      <td>
                        <div class="sparkbar" data-color="#7460ee" data-height="20"><?=getNumEdu("Secondary")?></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><a href="#">Stopped at or Finished ND/NCE course</a></td>
                      <td>
                        <div class="sparkbar" data-color="#7460ee" data-height="20"><?=getNumEdu("Diploma")?></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><a href="#">Stopped at or Finished First Degree (Bachelor/HND) course</a></td>
                      <td>
                        <div class="sparkbar" data-color="#7460ee" data-height="20"><?=getNumEdu("Degree")?></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><a href="#">Stopped at or Finished a Masters degree course</a></td>
                      <td>
                        <div class="sparkbar" data-color="#7460ee" data-height="20"><?=getNumEdu("Advanced")?></div>
                      </td>
                      <tr>
                      <td colspan="3"><a href="#">Stopped at or Finished a Phd course</a></td>
                      <td>
                        <div class="sparkbar" data-color="#7460ee" data-height="20"><?=getNumEdu("Vetneran")?></div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>
                      <?php  }?>
            <!-- /.box -->
          </div>
          <!-- /.col -->
  
          <div class="col-lg-12 col-xl-4">           
                        
            <!-- USERS LIST -->
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title"><?=ucfirst($canAdd)."s"?></h3>
  
                    <div class="box-tools pull-right">
                      <a href="?add_<?=$canAdd?>" class="label bg-aqua">Add new</a>
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                    <?php
                    //select all from users
                    $get_enumerators= mysqli_query($con, "SELECT * FROM users WHERE `status` = '1' && `level` = '$canAdd'  $lga_condition");
                    if (mysqli_num_rows($get_enumerators) > 0) {
                        echo'
                                      <div class="box-body no-padding">
                                        <ul class="users-list clearfix">';
                        while ($row = mysqli_fetch_assoc($get_enumerators)) {
                            extract($row);
                            $userImage=($gender=="male") ? "./assets/images/avatar/male.png" : "./assets/images/avatar/female.png";
                            echo"
                                          <li>
                                            <img class=\"round\" src=\"$userImage\" alt=\"$fname\">
                                            <a class=\"users-list-name\" href=\"#\">$fname</a>
                                            <span class=\"users-list-date\">$total_enum $appendText</span>
                                          </li>";
                        }
                        echo  '</ul>
                                        <!-- /.users-list -->
                                      </div>';
                    }
                    ?>
                  <!-- /.box-body -->
                  <div class="box-footer text-center">
                    <a href="?<?=$canAdd."s"?>" class="uppercase">View All <?=ucfirst($canAdd)."s"?></a>
                  </div>
                  <!-- /.box-footer -->
                </div>
                <!--/.box -->
            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
  