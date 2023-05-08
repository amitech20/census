<?php
session_start();
require("../assets/php/config.php");

# ================ login.php ===================== #

if (isset($_REQUEST['login'])) {
    $det1 = $_REQUEST['det1'];
    // $det2 = md5(strtolower($_REQUEST['det2']));
    $det2 = $_REQUEST['det2'];
    $data = array($det1, $det2/* ,$det1,$det2,$det1,$det2 */);
    $stmt = "SELECT username,level,id FROM users WHERE /* (email = ? && `password` = ?) || */ (username = ? && `password` = ?) /* || (uphone = ? && `password` = ?) */";
    $query = $DBH->prepare($stmt);
    $query->execute($data);
    if ($query->rowCount() == 1) {
        $row = $query->fetch(PDO::FETCH_ASSOC);

        //check if census has been stopped
        $censusStatus = mysqli_query($con, "SELECT * FROM users WHERE level = 'admin' && id='1'");
        $censusStatus = mysqli_fetch_assoc($censusStatus);
        $cStatus = $censusStatus['session'];

        if ($cStatus == "stop" && $row['level'] == "enumerator") {
            echo 22;
            exit();
        } else {
            $_SESSION = array('username' => $row['username'], 'level' => $row['level'], 'id' => $row['id'], 'user_login_status' => 1);
            echo 1;
            exit();
        }
    } else {
        echo 0;
    }
}

# ================ add_enum.php ===================== #
if (isset($_REQUEST['activateNewUser'])) {
    // retrieve form data
    $userid = mysqli_real_escape_string($con, $_POST['userid']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password2 = mysqli_real_escape_string($con, $_POST['password2']);

    //make sure the password match with the confirm password
    if ($password != $password2) {
        echo "Passwords do not match";
        exit();
    }
    //else update the user
    else {
        $updateUser = mysqli_query($con, "UPDATE users SET phone='$phone', email='$email', `password`='$password',`status`='1' WHERE Refnum='$userid' ");

        echo ($updateUser) ? 1 : mysqli_errno($con);
    }
}

//Add an enumerator or a supervisor
if (isset($_GET['addNewUser'])) {

    $fname = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['fname'])));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
    $nin = htmlspecialchars(mysqli_real_escape_string($con, $_POST['nin']));
    $level = htmlspecialchars(mysqli_real_escape_string($con, $_POST['level']));
    $sex = htmlspecialchars(mysqli_real_escape_string($con, $_POST['sex']));
    $ref = ($level == 'enumerator') ? "ENU_" . mt_rand(1000, 9999) : "SUP_" . mt_rand(1000, 9999);
    $lga = mysqli_real_escape_string($con, $_POST['lga']);

    $check_email = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    $count = mysqli_num_rows($check_email);
    if ($count != 0) {
        echo 20; //"Email already exists";
    } else {
        $check_username = mysqli_query($con, "SELECT * FROM users WHERE nin='$nin'");
        $count = mysqli_num_rows($check_username);
        if ($count != 0) {
            echo 19; //"Username already exists";
        } else {
            $query = mysqli_query($con, "INSERT IGNORE INTO users (Refnum,fname,username,email,nin,`level`,`gender`,lga_assigned) VALUES ('$ref','$fname','$nin','$email','$nin','$level','$sex','$lga')");
            if ($query) {
                $text="You are hereby invited to join the Census as $level. Click <a href='http://localhost/mycode.php/censusappi?activate=$ref'><b style='color:#17a2b8;'>Here to activate your Account</b></a> or copy the url below and paste it into a new browser tab <br><b style='color:#17a2b8;'>URL: http://localhost/mycode.php/censusappi?activate=$ref </b>"; 
                $subject = 'Welcome to Census App';
                require_once ('../assets/php/send_mail.php');
                echo ($mail->send())?1:55; //55 is for mail erro
            } else {
                echo mysqli_error($con);
                echo 0; //"Error adding enumerator";
            }
        }
    }
}
// reset password (forgot password)
if (isset($_REQUEST['forgotPassword'])) {
    $det1 = $_REQUEST['det1'];
    $stmt = "SELECT fname,email FROM users WHERE email = ? OR username = ? OR nin = ? ";
    $query = $DBH->prepare($stmt);
    $query->execute(array($det1, $det1, $det1));
    if ($query->rowCount() == 1) {
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $alphanum = implode("", range("a", "z")) . "23456789";
        $rand = substr(str_shuffle($alphanum), 0, 10);
        $fname = $row['fname'];
        $email = $row['email'];
        $subject = "Census App: Password Reset";
        $eol = "\r\n";
        $text="
        <p>
        Your request to reset your password on the census app has been carried out successfully. <br/>
        Your new password is: <b style='color:#17a2b8;'>$rand</b> <br/> 
        You can now login and change your password to your preferred keywords.<br/>
        Please help us keep the census app safe by securing your password and keeping it personal with you.<br/>
    </p>
    <h4>Tips to creating a strong password</h4> 
    <p>
        {$eol}-Use combinantion of alphanumerals and special characters like: #+$^*! <br/>
        {$eol}-Do not use your year of birth.<br/> 
        {$eol}-Do not use a word that you are popularly known with such as nickname. <br/> 
        {$eol}-Make sure the length of the keyword is above 7. <br/>
        {$eol}-Above all make sure you will remember the keyword you used.
    </p>";
        require_once ('../assets/php/send_mail.php');
        if ($mail->send()) {
            $update = $DBH->query("UPDATE users SET `password` = '$rand' WHERE email = '$email'");
            echo $update ? 1 : 0;
            } else {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
          }
    } else {
        echo 2;
    }
}

//change password
if (isset($_REQUEST['change_password'])) {
    $old = $_REQUEST['curpassword'];
    $new = $_REQUEST['password'];
    $new2 = $_REQUEST['password2'];
    $userid = $_SESSION['username'];
    if ($new != $new2) {
        echo "Confirm password does not match";
    } else {
        $stmt = "SELECT * FROM users WHERE username = ? AND `password` = ?";
        $query = $DBH->prepare($stmt);
        $query->execute(array($userid, $old));
        if ($query->rowCount() == 1) {
            $update = $DBH->query("UPDATE users SET `password` = '$new' WHERE username = '$userid'");
            echo $update ? 1 : "Unable to change password";
        } else {
            echo "Unauthorized request";
        }
    }
}