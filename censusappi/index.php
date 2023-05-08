<?php
session_start();
include("./assets/php/config.php");
include("./assets/php/functions.php");

if (!isset($_GET['activate']) && !isset($_SESSION['level'])) {
  redirect("login.php");
} else {
  // $permission = ($level=="admin") ? "Administrator" : "Enumerator" ;
  if (isset($_GET['activate'])) {
    $userid = mysqli_real_escape_string($con, $_GET['activate']);
    $getInfo = mysqli_query($con, "SELECT * FROM users WHERE Refnum='$userid'");
    $userDetail = mysqli_fetch_array($getInfo);
    $username = $userDetail['username'];
    $level = $userDetail['level'];
    $permission = 'guest';
  } else {
    $username = $_SESSION['username'];
    $permission = $_SESSION['level'];
    $level = $_SESSION['level'];
  }
  //get user details
  $get_details = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND level='$level'");
  $row = mysqli_fetch_array($get_details);
  $user_id = $row['id'];
  $user_name = $row['username'];
  $user_email = $row['email'];
  $user_level = (isset($_GET['activate'])) ? "guest" : $row['level'];
  $user_ref = $row['Refnum'];
  $user_lga = $row['lga_assigned'];
  $user_acc_status = $row['status'];
  $sex = $row['gender'];

  $userImage = ($sex == "male") ? "./assets/images/avatar/male.png" : "./assets/images/avatar/female.png";

  //access control
  if ($permission == "enumerator" && $user_level == "enumerator" && $user_acc_status != 0) {
    $isEnumerator = "";
    $isSupervisor = "hidden";
    $isAdmin = "hidden";
    $isSupervisorNadmin = "hidden";
    $isAll = "";
    $dashboard = "do_census";
  } elseif ($permission == "supervisor" && $user_level == "supervisor" && $user_acc_status != 0) {
    $isEnumerator = "hidden";
    $isSupervisor = "";
    $isAdmin = "hidden";
    $isAll = "";
    $dashboard = "dashboard";
    $isSupervisorNadmin = "";
  } elseif ($permission == "admin" && $user_level == "admin" && $user_acc_status != 0) {
    $isEnumerator = "hidden";
    $isSupervisor = "hidden";
    $isAdmin = "";
    $isAll = "";
    $dashboard = "dashboard";
    $isSupervisorNadmin = "";
  } elseif ($permission == "guest" && $user_level == "guest" && $user_acc_status == 0) {
    $isEnumerator = "hidden";
    $isSupervisor = "hidden";
    $isAdmin = "hidden";
    $isAll = "hidden";
    $dashboard = "register";
    $isSupervisorNadmin = "hidden";
  } else {
    //redirect to login page
    redirect("logout.php");
  }

  #mark active page
  function page($page)
  {
    if (count($_GET) > 0) {
      $thisPage = explode('?', $_SERVER['REQUEST_URI']);
      $count = count($thisPage);
      $thisPage = explode('.', $thisPage[$count - 1]);
      return ($thisPage[0] == $page) ? "active" : "";
    }
  }


  //get the member name
  function getName()
  {
    global $username;
    include("./assets/php/config.php");
    $res = mysqli_query($con, "SELECT fname FROM users WHERE username = '$username'");
    $row = mysqli_fetch_assoc($res);
    return $row['fname'];
  }

  //get the total Enumeration
  function getTotalEnumerated($user_lga, $userlevel, $user_id)
  {
    global $con;
    $lga = ($user_lga == "") ? "" : "&& lga_assigned = '$user_lga'";
    $user = ($user_id == "") ? "" : "&& Refnum = '$user_id'";
    $allEnumerated = 0;
    $res = mysqli_query($con, "SELECT total_enum FROM users WHERE level = '$userlevel' $lga $user");
    while ($rows = mysqli_fetch_assoc($res)) {
      $allEnumerated += $rows['total_enum'];
    }
    return $allEnumerated;
  }
  //get the total approved enumeration
  function getTotalAppEnums($user_lga, $userlevel, $user_id)
  {
    global $con;
    $lga = ($user_lga == "") ? "" : "&& lga_assigned = '$user_lga'";
    $user = ($user_id == "") ? "" : "&& Refnum = '$user_id'";
    $allAppEnum = 0;
    $res = mysqli_query($con, "SELECT total_app FROM users WHERE level = '$userlevel' $lga $user");
    while ($rows = mysqli_fetch_assoc($res)) {
      $allAppEnum += $rows['total_app'];
    }
    return $allAppEnum;
  }
  //get the total disapproved enumeration
  function getTotalDisEnums($user_lga, $userlevel, $user_id)
  {
    global $con;
    $lga = ($user_lga == "") ? "" : "&& lga_assigned = '$user_lga'";
    $user = ($user_id == "") ? "" : "&& Refnum = '$user_id'";
    $allDisEnum = 0;
    $res = mysqli_query($con, "SELECT total_disputed FROM users WHERE level = '$userlevel' $lga $user");
    while ($rows = mysqli_fetch_assoc($res)) {
      $allDisEnum += $rows['total_disputed'];
    }
    return $allDisEnum;
  }
  function countEnums($user_lga, $userlevel)
  {
    global $DBH;
    $lga = ($user_lga == "") ? "" : "&& lga_assigned = '$user_lga'";
    $query = $DBH->query("SELECT username FROM users WHERE level = '$userlevel' $lga");
    return $query->rowCount();
  }

  // accuracy rate
  function getAccuracyRate($user_lga, $userlevel, $user_id)
  {
    global $con;
    $lga = ($user_lga == "") ? "" : "&& lga_assigned = '$user_lga'";
    $user = ($user_id == "") ? "" : "&& Refnum = '$user_id'";
    $total = 0;
    $res = mysqli_query($con, "SELECT total_app FROM users WHERE level = '$userlevel' $lga $user");
    while ($rows = mysqli_fetch_assoc($res)) {
      $total += $rows['total_app'];
    }
    $total2 = 0;
    $res2 = mysqli_query($con, "SELECT total_enum FROM users WHERE level = '$userlevel' $lga $user");
    while ($rows2 = mysqli_fetch_assoc($res2)) {
      $total2 += $rows2['total_enum'];
    }
    $accuracy = ($total2 == 0) ? 0 : ($total / $total2) * 100;
    return number_format($accuracy, 2);
  }

  function countWithd()
  {
    include("./assets/php/config.php");
    $query = $DBH->query("SELECT id FROM withdrawals WHERE `status`='pending'");
    return $query->rowCount();
  }
  function countDisapproved()
  {
    global $DBH;
    global $user_ref;
    $query = $DBH->query("SELECT id FROM citizen WHERE `e_status`='disputed' && `enumerator_id`='$user_ref'");
    return $query->rowCount();
  }

  // function countCorrections(){
  //   global $DBH;
  //   global $user_lga;
  //   $query = $DBH->query("SELECT id FROM citizen WHERE `e_status`='correction' && `lga`='$user_lga'");
  //   return $query->rowCount();
  // }

  function countCounts($status)
  {
    global $DBH;
    global $user_lga;
    $query = $DBH->query("SELECT id FROM citizen WHERE `e_status`='$status' && `lga`='$user_lga'");
    return $query->rowCount();
  }

?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.png">

    <title>Census App</title>

    <!-- Bootstrap v4.0.0-beta -->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/vendor_components/font-awesome/css/font-awesome.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="assets/vendor_components/Ionicons/css/ionicons.css">

    <!-- jvectormap -->
    <link rel="stylesheet" href="assets/vendor_components/jvectormap/jquery-jvectormap.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="css/master_style.css">
    <link rel="stylesheet" href="css/skins/_all-skins.css">

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="assets/vendor_components/select2/dist/css/select2.min.css">
    <!-- jQuery 3 -->
    <script src="assets/vendor_components/jquery/dist/jquery.js"></script>

  </head>

  <body class="hold-transition skin-purple sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">MAX</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Census</b> Board</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= $userImage ?>" class="user-image rounded-circle" alt="User Image">
                </a>
                <ul class="dropdown-menu scale-up">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= $userImage ?>" class="img-fluid" alt="User Image">

                    <p>
                      <?= getName() ?>
                      <small><?= $permission ?></small>
                    </p>
                  </li>
                  <div class="user-footer">
                    <div class="text-center">
                      <a href="?logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </div>
                </ul>
              </li>

            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="image">
              <img src="<?= $userImage ?>" class="rounded-circle" alt="User Image">
            </div>
            <div class="info">
              <p><?= getName() ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> <?= $permission ?></a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree" <?= $isAll ?>>
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?= page("dashboard") ?>" <?= $isSupervisorNadmin ?>><a href="?dashboard"><i class="fa fa-dashboard text-red"></i> <span>Dashboard</span></a></li>
            <!-- Enumerator links -->
            <li class="<?= page("do_census") ?>" <?= $isEnumerator ?>><a href="?do_census"><i class="fa fa-calculator text-red"></i> <span>Conduct Census</span></a></li>
            <li class="<?= page("view_disapproved") ?>" <?= $isEnumerator ?>><a href="?view_disapproved"><i class="fa fa-calculator text-red"></i> <span>Redo Disapproved <small class="label pull-right bg-red"><?= countDisapproved() ?></small></span></a></li>

            <!-- supervisor links -->
            <label for="Review Census" <?= $isSupervisor ?>>Review Census</label>

            <li class="<?= page("view_submissions") ?>" <?= $isSupervisor ?>><a href="?view_submissions"><i class="fa fa-list"></i> Recent Submission <small class="label pull-right bg-red"><?= countCounts("pending") ?></small></a></li>
            <li class="<?= page("view_corrections") ?>" <?= $isSupervisor ?>><a href="?view_corrections"><i class="fa fa-comment"></i> Corrections <small class="label pull-right bg-red"><?= countCounts("corrections") ?></small></a></li>
            <li class="<?= page("view_disputes") ?>" <?= $isSupervisor ?>><a href="?view_disputes"> <i class="fa fa-cloud"></i> Disapproved <small class="label pull-right bg-red"><?= countCounts("disputed") ?></small></a></li>
            <li class="<?= page("view_approved") ?>" <?= $isSupervisor ?>><a href="?view_approved"><i class="fa fa-check"></i> Approved <small class="label pull-right bg-red"><?= countCounts("approved") ?></small></a></li>

            <label for="Review Census" <?= $isSupervisor ?>>Your Workforce</label>
            <li class="<?= page("enumerators") ?>" <?= $isSupervisor ?>><a href="?enumerators"> <i class="fa fa-users"></i> Enumerators</a></li>
            <li class="<?= page("add_enumerator") ?>" <?= $isSupervisor ?>><a href="?add_enumerator"><i class="fa fa-user-plus"></i> Add Enumerator</a></li>

            <!-- Admin links -->
            <label for="Review Census" <?= $isAdmin ?>>Population</label>
            <li class="<?= page("view_all_enumeration") ?>" <?= $isAdmin ?>><a href="?view_all_enumeration"><i class="fa fa-globe text-red"></i> <span>All Enumerations</span></a></li>
            <li class="<?= page("population_size") ?>" <?= $isAdmin ?>><a href="?population_size"><i class="fa fa-users text-red"></i> <span>Population Size</span></a></li>


            <label for="Review Census" <?= $isAdmin ?>>Your Workforce</label>
            <li class="<?= page("supervisors") ?>" <?= $isAdmin ?>><a href="?supervisors"><i class="fa fa-users text-red"></i> <span>Supervisors</span></a></li>
            <li class="<?= page("add_supervisor") ?>" <?= $isAdmin ?>><a href="?add_supervisor"><i class="fa fa-user-plus text-red"></i> <span>Add Supervisor</span></a></li>
            <li class="" <?= $isAll ?>><a href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fa fa-lock text-red"></i> <span>Change Password</span></a></li>
          </ul>
        </section>
        <!-- /.sidebar -->
        <div class="sidebar-footer" hidden>
          <!-- item-->
          <a href="#" class="link" data-toggle="tooltip" title="" data-original-title="Settings"><i class="fa fa-cog fa-spin"></i></a>
          <!-- item-->
          <a href="#" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="fa fa-envelope"></i></a>
          <!-- item-->
          <a href="#" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="fa fa-power-off"></i></a>
        </div>
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?= pageName() ?>

            <!-- <small>Control panel</small> -->
            <?php
            if ($permission == "admin") {
              //get census status from database
              $censusStatus = mysqli_query($con, "SELECT * FROM users WHERE level = 'admin' && id='1'");
              $censusStatus = mysqli_fetch_assoc($censusStatus);
              $status = $censusStatus['session'];
              if ($status == "stop") {
                $bs1 = "btn-success";
                $bs2 = "Start Census";
              } else {
                $bs1 = "btn-danger";
                $bs2 = "Stop Census";
              }
              echo "<p class='text-center'> <button class=\"btn $bs1 btn-lg startStopBtn\">$bs2</button></p>";
            }
            ?>
          </h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Control-Block</a></li>
            <li class="breadcrumb-item active"> <?= pageName() ?></li>
          </ol>
        </section>

        <!-- Main content -->

        <?php
        if (isset($_GET['supervisors'])) {
          include("modules/supervisors.php");
        } elseif (isset($_GET['enumerators'])) {
          include("modules/enumerators.php");
        } elseif (isset($_GET['add_supervisor'])) {
          include("modules/add_supervisor.php");
        } elseif (isset($_GET['add_enumerator'])) {
          include("modules/add_enum.php");
        } elseif (isset($_GET['population_size'])) {
          include("modules/all_citizens.php");
        } elseif (isset($_GET['dashboard'])) {
          include("modules/dashboard.php");
        } elseif (isset($_GET['do_census'])) {
          include("modules/do_census.php");
        } elseif (isset($_GET['view_disapproved'])) {
          include("modules/view_disapproved.php");
        } elseif (isset($_GET['view_corrections'])) {
          include("modules/view_corrections.php");
        } elseif (isset($_GET['view_submissions'])) {
          include("modules/view_submissions.php");
        } elseif (isset($_GET['view_disputes'])) {
          include("modules/view_disputes.php");
        } elseif (isset($_GET['view_approved'])) {
          include("modules/view_approved.php");
        } elseif (isset($_GET['view_all_enumeration'])) {
          include("modules/view_all_enumeration.php");
        } elseif (isset($_GET['view_by_lga'])) {
          include("modules/view_by_lga.php");
        } elseif (isset($_GET['activate'])) {
          include("modules/register.php");
        } elseif (isset($_GET['logout'])) {
          echo "<script>window.location.assign('logout.php')</script>";
        } else {
          include("modules/$dashboard.php");
        }
        ?>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right d-none d-sm-inline-block">
          <b>Version</b> 1.2.1
        </div>Copyright &copy; 2022 Census App. All Rights Reserved.
      </footer>

      <!-- change password modal -->
      <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form novalidate name="changePassword" id="changePassword" method="POST">
                <div class="form-group">
                  <h5>Current Password <span class="text-danger">*</span></h5>
                  <div class="controls">
                    <input type="password" name="curpassword" class="form-control" required data-validation-required-message="This field is required" placeholder="enter your current password">
                  </div>
                </div>
                <div class="form-group">
                  <h5>New Password <span class="text-danger">*</span></h5>
                  <div class="controls">
                    <input type="password" name="password" class="form-control" required data-validation-required-message="This field is required">
                  </div>
                </div>
                <div class="form-group">
                  <h5>Repeat Password<span class="text-danger">*</span></h5>
                  <div class="controls">
                    <input type="password" name="password2" data-validation-match-match="password" class="form-control" required>
                  </div>
                </div>
                <div class="text-xs-right">
                  <button type="submit" class="btn btn-info">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- ./wrapper -->


    <!-- popper -->
    <script src="assets/vendor_components/popper/dist/popper.min.js"></script>

    <!-- Bootstrap v4.0.0-beta -->
    <script src="assets/vendor_components/bootstrap/dist/js/bootstrap.js"></script>
    <!-- Select2 -->
    <script src="assets/vendor_components/select2/dist/js/select2.full.js"></script>

    <script src="js/template.js"></script>

    <script src="js/demo.js"></script>
    <script src="js/pages/validation.js"></script>
    <script>
      // ! function(window, document, $) {
      //     "use strict";
      // 	$("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
      // }(window, document, jQuery);

      $(document).ready(function() {
        // validate nin to ascertain the user is a citizen
        $('.CNIN').on('keyup', function() {
          $('.DisplayResult').addClass("d-none");
          $('.displayblock').addClass("d-none");
          var CNIN = $(this).val();
          var search_param = $(this).attr('search_param');
          var toDo = $(this).attr('module');
          console.log(search_param + ":" + CNIN);
          if (CNIN.length >= 11) {
            $.ajax({
              url: './actions/ajax.crud.php?get_citizen_info',
              type: 'POST',
              data: {
                CNIN: CNIN,
                module: toDo,
                param: search_param
              },
              success: function(data) {
                $('.DisplayResult').removeClass('d-none');
                $('.DisplayResult').html(data);
              }
            });
          }
        });
        //Retrieve the fetched data from the database
        $('.displaySelected').click(function() {
          var selected = $(this).attr('data-cnin');
          var dbTbSelect = $(this).attr('data-searchIn');
          $('.DisplaySelected').removeClass('d-none');
          $('.displayblock').removeClass('d-none');
          $('.DisplaySelected').html('<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>');
          $.ajax({
            url: './actions/ajax.auth.php?check-nin',
            type: 'POST',
            data: {
              CNIN: selected,
              table: dbTbSelect
            },
            success: function(resp) {
              $('.DisplaySelected').html(resp);
            }
          });
        });

        //if stop census button is clicked
        $('.startStopBtn').click(function() {
          var btnText = $(this).text();
          if (btnText == "Stop Census") {
            $(this).text("Start Census");
            $(this).removeClass("btn-danger");
            $(this).addClass("btn-success");
            console.log("Census Stopped");
            //prompt the user to confirm the action
            var question = confirm("Are you sure you want to stop the census?");
            if (question) {
              $.ajax({
                url: './actions/ajax.crud.php?stop_census',
                type: 'POST',
                data: {
                  stop: "stop"
                },
                success: function(resp) {
                  console.log(resp);
                }
              });
            }
          } else {
            $(this).text("Stop Census");
            $(this).removeClass("btn-success");
            $(this).addClass("btn-danger");
            //prompt the user to confirm the action
            var question2 = confirm("Are you sure you want to start the census?");
            if (question2) {
              $.ajax({
                url: './actions/ajax.crud.php?stop_census',
                type: 'POST',
                data: {
                  stop: "start"
                },
                success: function(resp) {
                  console.log(resp);
                }
              });
            }
          }
        });

        //change password
        $('#changePassword').submit(function(e) {
          e.preventDefault();
          var curpassword = $('#changePassword input[name="curpassword"]').val();
          var password = $('#changePassword input[name="password"]').val();
          var password2 = $('#changePassword input[name="password2"]').val();
          if (curpassword == "" || password == "" || password2 == "") {
            alert("All fields are required");
          } else {
            $.ajax({
              url: './actions/ajax.auth.php?change_password',
              type: 'POST',
              data: {
                curpassword: curpassword,
                password: password,
                password2: password2
              },
              success: function(resp) {
                console.log(resp);
                if (resp == "1") {
                  alert("Password changed successfully");
                  $('#changePassword')[0].reset();
                  $('#changePassword').modal('hide');
                } else {
                  alert(resp);
                }
              }
            });
          }
        });


      });
    </script>
  </body>

  </html>
<?php } ?>