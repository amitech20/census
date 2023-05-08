    <!-- Main content -->
    <section class="content">
  
        <!-- =========================================================== -->
  
  
        <h2 class="page-header">Supervisors</h2>
  
        <div class="row">
    <?php
        $get_enumerators= mysqli_query($con, "SELECT * FROM users WHERE /* `status` = '1' &&  */`level` = 'supervisor'");
        while ($enumarators = mysqli_fetch_assoc($get_enumerators)) {
            extract($enumarators);
            $get_his_lga= mysqli_query($con, "SELECT * FROM lgas WHERE `id` = '$lga_assigned' ");
            $his_lga = mysqli_fetch_assoc($get_his_lga);
            $lga_name = $his_lga['lga_name'];
            $lga_map = $his_lga['gmaps'];
            $fname=(empty($fname)) ? "Newly Registered" : $fname;
            echo
            "<div class='col-xl-4 col-lg-6 col-12'>
            <!-- Widget: user widget style 1 -->
            <div class='box box-widget widget-user-2'>
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class='widget-user-header bg-purple'>
              <iframe src='$lga_map' width='300' height='200' style='border:0;' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>
                <!-- /.widget-user-image -->
                <h3 class='widget-user-username'>$fname </h3>
                <h6 class='widget-user-desc'>nin: $nin </h6>
                
              </div>
              <div class='box-footer no-padding'>
                <ul class='nav d-block nav-stacked'>
                <li class='nav-item'><a href='#' class='nav-link'>LGA assigned <span class='pull-right '>$lga_name</span></a></li>
                <li class='nav-item'><a href='#' class='nav-link'>Enumerators <span class='pull-right badge bg-blue'>".countEnums($lga_assigned,'enumerator')."</span></a></li>
                  <li class='nav-item'><a href='#' class='nav-link'>Total Approved <span class='pull-right badge bg-green'>$total_app</span></a></li>
                  <li class='nav-item'><a href='#' class='nav-link'>Total Disaproved <span class='pull-right badge bg-red'>$total_disputed</span></a></li>
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>";
        }
        ?>      
          <!-- /.col --> 

            
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
  
      </section>
      <!-- /.content -->
  