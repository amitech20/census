    <!-- Main content -->
    <?php
if (isset($_GET['activate']) && $_GET['activate'] != "") {

    $userid = htmlspecialchars(mysqli_real_escape_string($con, $_GET['activate']));

    $query = mysqli_query($con, "SELECT * FROM users WHERE Refnum='$userid' && status='0'");
    if (mysqli_num_rows($query)>0) {
        $userDetail = mysqli_fetch_array($query);
        extract($userDetail);

        ?>

        <section class="content">
            <!-- Validation Forms -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="card-title">Account Activation</h3>
                    <h6 class="card-subtitle">Welcome, please verify the prefilled information and create a password to start using the Census App</h6>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form novalidate name="updateEnum" id="updateEnum" method="POST">
                                <div class="form-group">
                                    <h5>Full Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                    <input type="hidden" name="userid" class="form-control" required data-validation-required-message="This field is required" value="<?= $userid?>" readonly>
                                    <input type="text" name="fname" class="form-control" required data-validation-required-message="This field is required" value="<?= $fname?>" readonly>
                                    </div>
                                    <div class="form-control-feedback"><small>Your full name as fetched full the NIN database.</small></div>
                                </div>
                                <div class="form-group">
                                    <h5>Email Address <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="email" name="email" class="form-control" required data-validation-required-message="This field is required" value="<?= $email ?> ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5>NIN <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="nin" class="form-control" required minlength="11" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers" readonly value="<?=$nin?>">
                                    </div>
                                    <div class="form-control-feedback"><small>minimum number of characters to accepted is 11.</small></div>
                                </div>
                                <div class="form-group">
                                    <h5>Level Assigned<span class="text-danger">*</span></h5>
                                    <div class="controls">
                                    <input type="text" class="form-control"  name="level" value="<?=$level?>" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5>Assigned LGA<span class="text-danger">*</span></h5>
                                    <div class="controls">
                                    <input type="text" class="form-control"  name="lga" value="<?=get_lga($lga_assigned)?>" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5>Phone <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="tel" name="phone" class="form-control" required minlength="11" data-validation-regex-regex="(\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$)" data-validation-regex-message="Intl format, Must start with +234">
                                    </div>
                                    <div class="form-control-feedback"><small></small></div>
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
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    <?php  }
} else {
        //redirect to login page
        echo "<script>";
        echo   "window.location.assign('?logout')";
        echo "</script>";
    }
    ?>


<script>
//when submitted
$("#updateEnum").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    // password and phonew number are not empty
    if (formData.get("password") != "" && formData.get("password2") != "" && formData.get("phone") != "") {
    $.ajax({
        url: "./actions/ajax.auth.php?activateNewUser",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $("#updateEnum").css("opacity", ".5");
        },
        success: function(data) {
            $("#updateEnum").css("opacity", "");
            if (data == "1") {
                alert("Account Activated Successfully");
                window.location.assign('?logout');
            } else {
                alert("Error: " + data);
            }
        }
    });
    }
    else alert("Please fill all the required fields");
});
</script>