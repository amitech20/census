<?php
session_start();
require("../assets/php/config.php");
require("../assets/php/functions.php");
// get user details
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $level = $_SESSION['level'];
  // $level = "enumerator";

  //get user details
  $get_details = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND level='$level'");
  $row = mysqli_fetch_array($get_details);
  $user_id = $row['id'];
  $user_name = $row['username'];
  $user_email = $row['email'];
  $user_level = $row['level'];
  $user_ref = $row['Refnum'];
  $user_lga = $row['lga_assigned'];
  $user_acc_status = $row['status'];

//Get citizen info based on the nin or bid supplied
  if (isset($_REQUEST['get_citizen_info'])) {
    $cnin = mysqli_escape_string($con, $_POST['CNIN']);
    $module = mysqli_escape_string($con, $_POST['module']);
    $param = mysqli_escape_string($con, $_POST['param']);
    $searchIn = ($param == "NIN") ? "retrieved_nin" : "retrieved_bid";
    $actionPage = ($module == "doCensus") ? "get_citizen4Census" : "get_citizen4User";
    $rowIn = ($param == "NIN") ? "nin" : "bid";
    // $nin_OR_bid=$$rowIn;


    $get_citi = mysqli_query($con, "SELECT * FROM $searchIn WHERE $rowIn = '$cnin' ");
    echo '<ul class="list-group">';
    if (mysqli_num_rows($get_citi) > 0) {
      while ($row = mysqli_fetch_array($get_citi)) {
        extract($row);
        //if gender is female and photo is empty, put female avater else put male avarter
        if ($sex == "female") {
          $photo = "<img class='img-fluid rounded img-sm' src='./assets/images/avatar/female.png' alt='photo'>";
        } elseif ($sex == "male") {
          $photo = "<img class='img-fluid rounded img-sm' src='./assets/images/avatar/male.png' alt='photo'>";
        }
        $ninshow = ($param == "NIN") ? "NIN: " . $nin : "BID: " . $bid;
        $content = "
            <div class='img-push'>
                <b class='text-primary'>$name ($ninshow)</b>
            </div>";
        echo "
           <li class='list-group-item'><a class='displaySelected' style='cursor:pointer' data-cnin='$cnin' data-searchIn='$searchIn' >$photo $content</a></li>";
      }
      echo displaySelectedCitizen_Ajax("$actionPage");
    } else {
      echo "<li class='list-group-item'>No results found</li>";
    }
    echo '</ul>';
  }
//Retrieve the cizizen  details into a form for census or for update 
  if (isset($_REQUEST['get_citizen4Census'])) {
    $cnin = mysqli_escape_string($con, $_POST['CNIN']);
    $dbTbSelect = mysqli_escape_string($con, $_POST['table']);
    $rowIn = ($dbTbSelect == "retrieved_nin") ? "nin" : "bid";
    $IDused = strtoupper($rowIn);

    $get_citi = mysqli_query($con, "SELECT * FROM citizen WHERE nin='$cnin' || bid='$cnin'");
    if (mysqli_num_rows($get_citi) > 0) {
      while ($row = mysqli_fetch_array($get_citi)) {
        extract($row);
        function isSelected($selected){
        global $educBg;
          return $educBg == $selected ? 'selected' : '';
        }
        if ($sex == "female") {
          $photo = "<img class='rounded-circle' src='./assets/images/avatar/female.png' alt='photo'>";
        } elseif ($sex == "male") {
          $photo = "<img class='rounded-circle' src='./assets/images/avatar/male.png' alt='photo'>";
        }
        //get users lga
        $getLga = mysqli_query($con, "SELECT * FROM lgas WHERE id='$lga'");
        $rowLga = mysqli_fetch_array($getLga);
        $lgaName = $rowLga['lga_name'];
        if ($sex == 'male') {
          $male = 'checked';
          $female = '';
        } else {
          $male = '';
          $female = 'checked';
        }
        if ($e_status == "approved") {
          $isDisabled = "disabled";
          $btnName = "Approved";
        } elseif ($e_status == "disputed") {
          $isDisabled = "";
          $btnName = "Renumerate";
        } elseif ($e_status == "pending"||$e_status == "correction") {
          $isDisabled = "disabled";
          $btnName = "Submitted";
        } else {
          $isDisabled = "";
          $btnName = "Submit";
        }
        $nin_OR_bid = $$rowIn;
        sleep(1);
        echo "
        <div class=\"box box-warning\">
        <div class=\"box-header with-border\">
            <h3 class=\"box-title\">Enumerate Citizen</h3>
        </div>
        <!-- /.box-header -->
        <div class=\"box-body\">
        <form role=\"form\" method=\"post\" id=\"updateCensusForm\" action=\"./actions/ajax.crud.php?updateCensus\">
                <!-- text input -->
                <div class=\"form-group\">
                    <label>Full Name</label>
                    <input type=\"hidden\" class=\"form-control\" name=\"citizen_id\" value=\"$citizen_id\" required readonly>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"fname\" value=\"$name\" required readonly>
                </div>
                <div class=\"form-group\">
                    <label>NIN</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"nin\" value=\"$nin\" required readonly>
                </div>
                <div class=\"form-group\">
                    <label>BID</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"bid\" value=\"$bid\" required readonly>
                </div>
                <div class=\"form-group\">
                    <label>Date of Birth</label>
                    <input type=\"date\" class=\"form-control\" placeholder=\"Enter ...\" name=\"dob\" value=\"$dob\" required readonly>
                </div>
                <!-- radio -->
                <div class=\"form-group\">
                <label for=\"sex\">Sex</label>
                <div class=\"radio\">
                        <input type=\"radio\" id=\"Option_1\" name=\"sex\" value=\"$sex\" required $male $female readonly>
                        <label for=\"Option_1\">$sex</label>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label>LGA of Residence</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"lga\" value='" . get_lga($lga) . "' required readonly>
                </div>
    
                <!-- textarea -->
                <div class=\"form-group\">           
                    <label>Home Address</label>
                    <textarea class=\"form-control\" rows=\"3\" placeholder=\"Enter Home Address...\" name=\"h_address\" required>$homeAdd</textarea>
                </div>
    
                <div class=\"form-group\">
                    <label>Residential Address</label>
                    <textarea class=\"form-control\" rows=\"3\" placeholder=\"Enter Residential Address...\" name=\"r_address\" required>$residentialAdd</textarea>
                </div>
    
                <!-- input states -->
                <div class=\"form-group\">
                    <label>Occupation</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"occupation\" value=\"$occupation\" required>
                </div>
                <div class=\"form-group\">
                  <label>Educational Background</label>
                  <select class=\"form-control\" name=\"educBg\">
                      <option value=\"uneducated\"". isSelected('uneducated').">Uneducated</option>
                      <option value=\"Primary\"". isSelected('Primary').">Primary School</option>
                      <option value=\"Secondary\"". isSelected('Secondary').">Secondary School (WASSCE)</option>
                      <option value=\"Diploma\"". isSelected('Diploma').">National Diploma/NCE</option>
                      <option value=\"Degree\"". isSelected('Degree').">First Degree (Bachelor/HND)</option>
                      <option value=\"Advanced\"". isSelected('Advanced').">Masters</option>
                      <option value=\"Vetneran\"". isSelected('Vetneran').">Phd</option>
                  </select>
                </div>
            <div class=\"form-group\">
            <label>Family Structure</label>
            <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"family_s\" value=\"$familyStructure\" required>
        </div>
          <div class=\"form-group\">
          <button type=\"submit\" class=\"btn btn-info pull-right doNupdateCensusNow\" $isDisabled>$btnName</button>
          </div>
    
            </form>
        </div>
        <!-- /.box-body -->
    </div>
            ";
      }
    } else {
      $occupation = "";
      $educBg = "";
      $familyStructure = "";
      $residentialAdd = "";
      $homeAdd = "";

      //get data from nin/bid table
      $getBioData = mysqli_query($con, "SELECT * FROM $dbTbSelect WHERE $rowIn='$cnin'");
      if (mysqli_num_rows($getBioData) > 0) {
        $rowBio = mysqli_fetch_array($getBioData);
        extract($rowBio);
        if ($sex == 'male') {
          $male = 'checked';
          $female = '';
        } else {
          $male = '';
          $female = 'checked';
        }
        $nin_OR_bid = $$rowIn;
        sleep(1);
        // build a form for the enumarator to enter/update user data
        echo "<div class=\"box box-warning\">
        <div class=\"box-header with-border\">
            <h3 class=\"box-title\">Enumerate Citizen</h3>
        </div>
        <!-- /.box-header --> 
        <div class=\"box-body\">
            <form role=\"form\" method=\"post\" id=\"doCensusForm\" action=\"./actions/ajax.crud.php?carryOutCensus\">
            <!-- text input -->
                <div class=\"form-group\">
                    <label>Full Name</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"fname\" value=\"$name\" required readonly>
                </div>
                <div class=\"form-group\">
                    <label>$IDused</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"$rowIn\" value=\"$nin_OR_bid\" required readonly>
                </div>
                <div class=\"form-group\">
                    <label>Date of Birth</label>
                    <input type=\"date\" class=\"form-control\" placeholder=\"Enter ...\" name=\"dob\" value=\"$dob\" required readonly>
                </div>
                <!-- radio -->
                <div class=\"form-group\">
                <label for=\"sex\">Sex</label>
                <div class=\"radio\">
                        <input type=\"radio\" id=\"Option_1\" name=\"sex\" value=\"$sex\" required $male $female readonly>
                        <label for=\"Option_1\">$sex</label>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label>LGA of Residence</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"lga\" value='" . get_lga($lga) . "' required readonly>
                </div>

                <!-- textarea -->
                <div class=\"form-group\">           
                    <label>Home Address</label>
                    <textarea class=\"form-control\" rows=\"3\" placeholder=\"Enter Home Address...\" name=\"h_address\" required>$homeAdd</textarea>
                </div>

                <div class=\"form-group\">
                    <label>Residential Address</label>
                    <textarea class=\"form-control\" rows=\"3\" placeholder=\"Enter Residential Address...\" name=\"r_address\" required>$residentialAdd</textarea>
                </div>

                <!-- input states -->
                <div class=\"form-group\">
                    <label>Occupation</label>
                    <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"occupation\" value=\"$occupation\" required>
                </div>
                <div class=\"form-group\">
                <label>Educational Background</label>
                <select class=\"form-control\" name=\"educBg\">
                    <option value=\"uneducated\">Uneducated</option>
                    <option value=\"Primary\">Primary School</option>
                    <option value=\"Secondary\">Secondary School (WASSCE)</option>
                    <option value=\"Diploma\">National Diploma/NCE</option>
                    <option value=\"Degree\">First Degree (Bachelor/HND)</option>
                    <option value=\"Advanced\">Masters</option>
                    <option value=\"Vetneran\">Phd</option>
                </select>
          </div>
            <div class=\"form-group\">
            <label>Family Structure</label>
            <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"family_s\" value=\"$familyStructure\" required>
        </div>
          <div class=\"form-group\">
          <button type=\"submit\" class=\"btn btn-info pull-right doNupdateCensusNow\">Submit</button>
          </div>

            </form>
        </div>
        </div>";
      }
    }
    echo doNupdateCensusNow_Ajax();
  }

//Carry out census proper
  if (isset($_REQUEST['carryOutCensus'])) {
    if ($level == "enumerator" && $user_acc_status != 0) {
      // get form data and escape them
      $citizen_Id = "C" . time();
      $c_name = mysqli_escape_string($con, $_POST['fname']);
      if (isset($_POST['nin'])) {
        $nin_OR_bid = mysqli_escape_string($con, $_POST['nin']);
        $idUsed = "nin";
        $colsInsert = "`nin`, `bid`";
        $rowsInsert = "'$nin_OR_bid',''";
      } elseif (isset($_POST['bid'])) {
        $nin_OR_bid = mysqli_escape_string($con, $_POST['bid']);
        $idUsed = "bid";
        $colsInsert = "`nin`, `bid`";
        $rowsInsert = "'','$nin_OR_bid'";
      }
      $c_dob = mysqli_escape_string($con, $_POST['dob']);
      $c_sex = mysqli_escape_string($con, $_POST['sex']);
      $lga = mysqli_escape_string($con, $_POST['lga']);
      $c_h_address = mysqli_escape_string($con, $_POST['h_address']);
      $c_r_address = mysqli_escape_string($con, $_POST['r_address']);
      $c_occupation = mysqli_escape_string($con, $_POST['occupation']);
      $c_family_s = mysqli_escape_string($con, $_POST['family_s']);
      $c_educBg = mysqli_escape_string($con, $_POST['educBg']);
      $c_lga = getLgaID($lga);


      // enumerate by inserting into citizens database
      $query = mysqli_query($con, "INSERT IGNORE INTO citizen (`citizen_id`, $colsInsert , `name`, `dob`, `sex`, `educBg`, `familyStructure`, `occupation`, `lga`, `residentialAdd`, `homeAdd`, `e_status`, `enumerator_id`) VALUES ('$citizen_Id',$rowsInsert,'$c_name','$c_dob','$c_sex','$c_educBg','$c_family_s','$c_occupation','$c_lga','$c_r_address','$c_h_address','pending','$user_ref')");

      //increment the number of citizens enumerated by the enumerator
      if ($query) {
        $query2 = mysqli_query($con, "UPDATE users SET `total_enum`=`total_enum`+1 WHERE `Refnum`='$user_ref'");
        echo ($query2) ? 1 : "failed";
      } else {
        echo "failed";
      }
    } else {
      //if the user is not an enumerator
      echo "you're not permited to perform this task";
    }
  }

  //Update the census
  if (isset($_REQUEST['updateCensus'])) {
    //make sure the user is an enumerator and is active
    if ($level == "enumerator" && $user_acc_status != 0) {
      // get form data and escape them
      $citizen_id = mysqli_escape_string($con, $_POST['citizen_id']);
      $c_name = mysqli_escape_string($con, $_POST['fname']);
      $nin = mysqli_escape_string($con, $_POST['nin']);
      $bid = mysqli_escape_string($con, $_POST['bid']);
      $c_dob = mysqli_escape_string($con, $_POST['dob']);
      $c_sex = mysqli_escape_string($con, $_POST['sex']);
      $lga = mysqli_escape_string($con, $_POST['lga']);
      $c_h_address = mysqli_escape_string($con, $_POST['h_address']);
      $c_r_address = mysqli_escape_string($con, $_POST['r_address']);
      $c_occupation = mysqli_escape_string($con, $_POST['occupation']);
      $c_family_s = mysqli_escape_string($con, $_POST['family_s']);
      $c_educBg = mysqli_escape_string($con, $_POST['educBg']);
      $c_lga = getLgaID($lga);

      //get the previous status of the citizen
      $get_status = mysqli_query($con, "SELECT * FROM citizen WHERE citizen_id='$citizen_id'");
      $row = mysqli_fetch_array($get_status);
      $status = $row['e_status'];
      $e_status = (($status == "disputed") ? "correction" : "$status");
      // update enumertion by updating citizens database
      $query = mysqli_query($con, "UPDATE citizen SET `nin`= '$nin',`name`='$c_name',`dob`='$c_dob', `sex`= '$c_sex', `educBg` ='$c_educBg', `familyStructure`='$c_family_s', `occupation`='$c_occupation', `lga`='$c_lga', `residentialAdd`='$c_r_address', `homeAdd`='$c_h_address', `e_status`='$e_status' WHERE `citizen_id` ='$citizen_id' ");

      echo ($query) ? "2" : mysqli_errno($con);
    } else {
      //if the user is not an enumerator
      echo "you're not permited to perform this task";
    }
  }

  //  approve or disapprove enumeration
  if (isset($_POST['action'])) {
    if ($level == "supervisor" && $user_acc_status != 0) {
      $citizen_id = mysqli_escape_string($con, $_POST['citizen']);
      $status = mysqli_escape_string($con, $_POST['status']);
      $remark = mysqli_escape_string($con, $_POST['remark']);
      //get previous remark
      $get_remark = mysqli_query($con, "SELECT * FROM citizen WHERE citizen_id='$citizen_id'");
      $row = mysqli_fetch_array($get_remark);
      $prev_remark = $row['remark'];
      $new_remark = ($prev_remark == "") ? "<i><b>Supervisor</b> @" . date('d/m/y h:ia') . " </b>-> " . $remark : $prev_remark . "<br><i><b>Supervisor</b> @" . date('d/m/y h:ia') . " </b>-> " . $remark;
      $query = mysqli_query($con, "UPDATE citizen SET `e_status`='$status', `remark`='$new_remark' WHERE `citizen_id` ='$citizen_id' ");

      //update the number of enumerations approved or disapproved by the supervisor && update the number of enumerations approved or disapproved by the supervisor
      if ($query) {
        //check the status of the enumeration
        $isStatus = ($status == "approved") ? "`total_app`=`total_app`+1" : "`total_disputed`=`total_disputed`+1";
        //update the number of enumerations approved or disapproved by the supervisor
        $query2 = mysqli_query($con, "UPDATE users SET $isStatus WHERE `Refnum`='$user_ref'");

        //get the enumerator who enumerated the citizen
        $get_enumerator = mysqli_query($con, "SELECT * FROM citizen WHERE citizen_id='$citizen_id'");
        $row = mysqli_fetch_array($get_enumerator);
        $enumerator = $row['enumerator_id'];
        //update the number of enumerations approved or disapproved by the enumerator
        $query3 = mysqli_query($con, "UPDATE users SET $isStatus WHERE `Refnum`='$enumerator'");
        echo ($query2 && $query3) ? 1 : "failed";
      } else {
        echo "failed";
      }
    }
  }

  # ======= validate user NIN before creating enumerator or supervisor account ============ #
  if (isset($_REQUEST['get_citizen4User'])) {
    //get level of logged user
    $level = $_SESSION['level'];
    if ($level == 'supervisor') {
      $lga = getLga($_SESSION['username']);
      $formAttach1 = "<input type=\"hidden\" class=\"form-control\" placeholder=\"Enter ...\" name=\"lga\" value=\"$lga\" required readonly>";
      $formAttach2 = "<input type=\"hidden\" class=\"form-control\" placeholder=\"Enter ...\" name=\"level\" value=\"enumerator\" required readonly>";
    } elseif ($level == 'admin') {
      $formAttach1 = "<div class=\"form-group\">
      <h5>Assign LGA<span class=\"text-danger\">*</span></h5>
      <div class=\"controls\">
           <select class=\"form-control select2\" style=\"width: 100%;\" name=\"lga\">
               <option selected=\"selected\">Select LGA</option>" .

        $sql = "SELECT * FROM lgas";
      $result = $con->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $formAttach1 .='<option value="' . $row['id'] . '">' . $row['lga_name'] . '</option>';
        }
      }
      $formAttach1 .= "</select>
      </div>
      </div>";
          $formAttach2 = "<input type=\"hidden\" class=\"form-control\" placeholder=\"Enter ...\" name=\"level\" value=\"supervisor\" required readonly>";
        }
        $cnin = mysqli_escape_string($con, $_POST['CNIN']);
        $dbTbSelect = mysqli_escape_string($con, $_POST['table']);
        $rowIn = ($dbTbSelect == "retrieved_nin") ? "nin" : "bid";
        $IDused = strtoupper($rowIn);

        $getBioData = mysqli_query($con, "SELECT * FROM $dbTbSelect WHERE $rowIn='$cnin'");
        if (mysqli_num_rows($getBioData) > 0) {
          $rowBio = mysqli_fetch_array($getBioData);
          extract($rowBio);
          if ($sex == 'male') {
            $male = 'checked';
            $female = '';
          } else {
            $male = '';
            $female = 'checked';
          }
          $nin_OR_bid = $$rowIn;
          sleep(1);
          // build a form for the enumarator to enter/update user data
          echo "<div class=\"box box-warning\">
    <div class=\"box-header with-border\">
        <h3 class=\"box-title\">Enumerate Citizen</h3>
    </div>
    <!-- /.box-header --> 
    <div class=\"box-body\">
        <form role=\"form\" method=\"post\" id=\"addEnum\" action=''>
        <!-- text input -->
            <div class=\"form-group\">
                <label>Full Name</label>
                <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"fname\" value=\"$name\" required readonly>
            </div>
            <div class=\"form-group\">
                <label>$IDused</label>
                <input type=\"text\" class=\"form-control\" placeholder=\"Enter ...\" name=\"$rowIn\" value=\"$nin_OR_bid\" required readonly>
            </div>
            <!-- radio -->
            <div class=\"form-group\">
            <label for=\"sex\">Sex</label>
            <div class=\"radio\">
                    <input type=\"radio\" id=\"Option_1\" name=\"sex\" value=\"$sex\" required $male $female readonly>
                    <label for=\"Option_1\">$sex</label>
                </div>
            </div>
            <div class=\"form-group\">
                <label>Email</label>
                <input type=\"email\" class=\"form-control\" placeholder=\"Enter ...\" name=\"email\" required data-validation-required-message=\"This field is required\">
            </div>
            $formAttach1
            $formAttach2
      <div class=\"form-group\">
      <button type=\"submit\" class=\"btn btn-info pull-right\">Submit</button>
      </div>

        </form>
    </div>
    </div>";
    }?>
    <script>
          //Creation of Enumerator/supervisor's account
          $("#addEnum").on("submit", function(e) {
          e.preventDefault();
          console.log($(this).serialize());
          var level = $("input[name='level']").val();
          //disable the submit button
          $("button[type='submit']").attr("disabled", true);
          $.ajax({
            url: "./actions/ajax.auth.php?addNewUser",
            // 	async:false,
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(msg) {
              if (msg == 1) {
                alert(level+"'s account was created successfully.");
                location.href = "?"+level+"s";
              } else if (msg == 20) {
                  //enable the submit button
                $("button[type='submit']").attr("disabled", false);
                alert("Email already exists");
              } else if (msg == 19) {
                alert("The user with this nin already exist");
                //enable the submit button
                $("button[type='submit']").attr("disabled", false);
              } else if (msg == 55) {
                alert("The user was added but we could not send the email, please check your internet connection");
                //enable the submit button
                $("button[type='submit']").attr("disabled", false);
              } else {
                //enable the submit button
                $("button[type='submit']").attr("disabled", false);
                alert("Error: Failed.");
                console.log(msg);
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              console.log(xhr);
            },

          });
        });

    </script>

<?php } 
  // stop_census
  if (isset($_REQUEST['stop_census'])) {
    $status=mysqli_real_escape_string($con,$_POST['stop']);
    $stop_census = mysqli_query($con, "UPDATE users SET `session`='$status' WHERE `level`='admin' && id='1'");
    if ($stop_census) {
      echo 1;
    } else {
      echo 0;
    }
  }

}
function getLga($username){
  $userId=$_SESSION['id'];
  global $DBH;
  $query = $DBH->prepare("SELECT lga_assigned FROM users WHERE id = ? && username = ?");
  $query->execute(array($userId,$username));
  $row = $query->fetch(PDO::FETCH_ASSOC);
  return $row['lga_assigned'];
}
