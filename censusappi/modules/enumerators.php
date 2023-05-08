    <!-- Main content -->
    <section class="content">

        <!-- /.row -->
  
        <!-- =========================================================== -->
  
  
        <h2 class="page-header">All Enumerators</h2>
  
        <div class="row">
    <?php
        $get_enumerators= mysqli_query($con, "SELECT * FROM users WHERE `status` = '1' && `level` = 'enumerator' && `lga_assigned` = '$user_lga'");
        while ($enumarators = mysqli_fetch_assoc($get_enumerators)) {
            extract($enumarators);
            echo
            "<div class='col-xl-4 col-lg-6 col-12'>
            <!-- Widget: user widget style 1 -->
            <div class='box box-widget widget-user-2'>
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class='widget-user-header bg-purple'>
                <!-- /.widget-user-image -->
                <h3 class='widget-user-username'>$fname </h3>
                <h6 class='widget-user-desc'>$phone</h6>
                
              </div>
              <div class='box-footer no-padding'>
                <ul class='nav d-block nav-stacked'>
                <li class='nav-item'><a href='#' class='nav-link'>Enumerator NIN <span class='pull-right '>$nin</span></a></li>
                <li class='nav-item'><a href='#' class='nav-link'>Total Enumerated <span class='pull-right badge bg-blue'>$total_enum</span></a></li>
                  <li class='nav-item'><a href='#' class='nav-link'>Total Approved <span class='pull-right badge bg-green'>$total_app</span></a></li>
                  <li class='nav-item'><a href='#' class='nav-link'>Total Disputed <span class='pull-right badge bg-red'>$total_disputed</span></a></li>
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->
";

        }
        ?>      
            
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
  
      </section>
      <!-- /.content -->
  