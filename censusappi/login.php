<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="assets/images/favicon.png">

  <title>Census Board</title>

  <!-- Bootstrap v4.0.0-beta -->
  <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/vendor_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/vendor_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="css/master_style.css">


  <link rel="stylesheet" href="css/skins/_all-skins.css">

  <!-- google font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

</head>

<body class="hold-transition login-page" style="background-image:url(./assets/images/nigeria.webp);">
  <div class="login-box bg-dark">
    <div class="login-logo">
      <a href="./"><img src="./assets/images/logo.png" alt=""></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post" class="form-element" id="loginForm">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="det1" placeholder="NIN">
          <span class="ion ion-email form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="det2" class="form-control" placeholder="Password">
          <span class="ion ion-locked form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-info btn-block btn-flat margin-top-10">SIGN IN</button>
          </div>
          <div class="col-12 text-center">
            <!-- /.col -->
          </div>
      </form>
      <br>
      <br>

      <!-- open modal when i click on forgot password -->
      <a href="#" data-toggle="modal" data-target="#forgoPasswordModal">Forgot Password?</a><br>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- forgot password modal -->
  <div class="modal fade" id="forgoPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" class="form-element" id="forgotForm">
            <div class="form-group has-feedback">
              <input type="text" class="form-control" name="det1" placeholder="NIN or Email">
              <span class="ion ion-email form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-block btn-flat margin-top-10">Retrieve Password</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery 3 -->
  <script src="assets/vendor_components/jquery/dist/jquery.min.js"></script>

  <!-- popper -->
  <script src="assets/vendor_components/popper/dist/popper.min.js"></script>

  <!-- Bootstrap v4.0.0-beta -->
  <script src="assets/vendor_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function(e) {
      $("#loginForm").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
          url: "./actions/ajax.auth.php?login",
          type: "POST",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(msg) {
            if (msg == 1) {
              window.location.assign("./");
            } else if (msg == 22) {
              alert("The enumeration excercise has not started yet");
              console.log(msg);
            } else {
              alert("Wrong details. Check your creditentials and try again");
              console.log(msg);
            }
          }
        });
      });
      // forgot password
      $("#forgotForm").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
          url: "./actions/ajax.auth.php?forgotPassword",
          type: "POST",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(msg) {
            if (msg == 1) {
              alert("Password reset link has been sent to your email");
              window.location.assign("./");
            } else if (msg == 0) {
              alert("Something went wrong. Try again, If you have received a password please ignore it and request for a new one");
              console.log(msg);
              // window.location.assign("./");
            } else if (msg == 2) {
              alert("Wrong details. Check your creditentials and try again");
              // window.location.assign("./");
            } else {
              alert("Failed, please try again later.");
              console.log(msg);
            }
          }
        });
      });
    })
  </script>

</body>

</html>