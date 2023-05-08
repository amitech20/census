<?php

// function to get lga name using lga id
function get_lga($lga_id)
{
    global $con;
    $sql = "SELECT lga_name FROM lgas WHERE id = '$lga_id'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['lga_name'];
}

//function to get lga id using lga name
function getLgaID($lga)
{
    global $con;
    $sql = "SELECT id FROM lgas WHERE lga_name = '$lga'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['id'];
}

//ajax call to do or update the enumeration
function doNupdateCensusNow_Ajax()
{
    return
    "<script>
    $(document).ready(function(){
        
        $('.doNupdateCensusNow').click(function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            var formData = new FormData(form[0]);
            var occupation = formData.get('occupation');
            var h_address = formData.get('h_address');
            var r_address = formData.get('r_address');
            var family_s = formData.get('family_s');
            console.log(r_address)
            if(family_s !='' && occupation !='' && h_address !='' &&r_address !=''){
    
            console.log(formData)
            var confirmAction = confirm('The user data will be recorded. Are you sure you want to continue?');
        if(confirmAction){
            $('.DisplaySelected').html('<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>');
            var url = form.attr('action');
            $.ajax({
                url: url,
                // url: './actions/ajax.crud.php?carryOutCensus',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    if(data == '1'){
                        alert('Census Data Submitted Successfully');
                       location.reload();
                    } else if(data == '2'){
                        alert('Census Data modified Successfully');
                       location.reload();
                    }else{
                        alert(data);
                    }
                }
            });
          }
        }
        else{alert('Please fill the form')}
        });
    });
    </script> ";
}

//ajax call to get citizen details using nin or bid
function displaySelectedCitizen_Ajax($actionPage)
{
    return
    "   <script>
        $(document).ready(function(){
            $('.displaySelected').click(function(){
              var selected = $(this).attr('data-cnin');
              var dbTbSelect = $(this).attr('data-searchIn');
            $('.DisplaySelected').removeClass('d-none'); 
            $('.displayblock').removeClass('d-none'); 
            $('.DisplaySelected').html('<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>');
            $.ajax({
                url: './actions/ajax.crud.php?$actionPage',
                type: 'POST',
                data: {
                    CNIN: selected,
                    table: dbTbSelect
                },
                success: function(resp){
                    $('.DisplaySelected').html(resp);
                }
            });
        });
    });
    </script>";
}

    //function to retrieve all disapproved dtata in a table
function getCitizens($status,$enum_id,$user_lga){
    global $con;
    $status = ($status == 'all') ? "`e_status` !=''" : "`e_status` ='$status'";
    $user_lga = ($user_lga == 'all') ? "`lga` !=''" : "lga='$user_lga'";
    $condition= ($enum_id=="supervisor"||$enum_id=="admin")?"":"&& `enumerator_id` ='$enum_id'";

    //select data from citizen table
    $getMatching_data = mysqli_query($con, "SELECT * FROM citizen WHERE $status $condition && $user_lga");
    if (mysqli_num_rows($getMatching_data) > 0) {
      $my_table='
    <tbody>';
      while ($matching_data = mysqli_fetch_assoc($getMatching_data)) {
        //get enumerator name using enum_id
        // $enum_id = $matching_data['enumerator_id'];
        extract($matching_data);
        $getEnumDetails = mysqli_query($con, "SELECT * FROM users WHERE `Refnum` ='$enumerator_id'");
        $enumDetails=mysqli_fetch_assoc($getEnumDetails);
        $enum_name = $enumDetails['fname'];
        $enumGender=($enumDetails['gender']=="male")?"he":"she";
        if ($e_status=='pending') {
            $action="<a href='#' class='btn btn-danger btn-sm remarkBtn' data-citizen='$citizen_id' data-enumName='$enum_name' data-enumGender='$enumGender'><i class='fa fa-times'></i></a> 
            <a href='#' class='btn btn-success btn-sm takeAction' data-citizen='$citizen_id' data-action='makeApproval' ><i class='fa fa-check'></i></a>";
            $remark="$enum_name";
        }
        elseif ($status=='approved') {
              $action="<button class='btn btn-success btn-sm'><i class='fa fa-check'></i></button>";
          }
        elseif ($e_status=='disputed') {
            $action="<a href='./?do_census' class='btn btn-warning ReturnEnum' data-citizen='$citizen_id'>Renumerate</a>";
        }
        elseif ($e_status=='correction') {
            $action="<a href='#' class='btn btn-danger btn-sm remarkBtn' data-citizen='$citizen_id' data-enumName='$enum_name' data-enumGender='$enumGender'><i class='fa fa-times'></i></a> 
            <a href='#' class='btn btn-success btn-sm takeAction' data-citizen='$citizen_id' data-action='makeApproval' ><i class='fa fa-check'></i></a>";
        }
      if ($e_status=='disputed' && $enum_id=="supervisor") {
       $action=$remark;
       $remark=$enum_name;
      }
      elseif ($e_status=='approved' && $enum_id=="supervisor") {
        $action="Approved";
        $remark=$enum_name;
       }
       elseif ($status !='' && $enum_id=="admin") {
        $action=$e_status;
        $remark=$enum_name;
       } 
        $my_table.= " 
     <tr>
        <td>$name</td>
        <td>$citizen_id</td>
        <td>".get_lga($lga)."</td>
        <td>$enum_date</td>
        <td>$residentialAdd</td>
        <td>$remark</td>
        <td>$action</td>
     </tr> ";
      }
      $my_table.='</tbody>';
    } else {
      $my_table = '';
    }
    return $my_table;
  
}

  //ajax call to disapprove or approve enumeration
function enumAction_ajax() {
    return 
        "<script>
                $(document).ready(function() {
                //click on makeApproval
                $(document).on('click', '.takeAction', function() {
                    var action = $(this).attr('data-action');
                    if (action == 'makeApproval') {
                        var info = 'Are you sure you want to approve this enumeration?';
                        var result='Enumeration approved successfully';
                        var id = $(this).attr('data-citizen');
                        var remark = '';
                        var  status = 'approved';
                    } 
                    if (action == 'makeDispute') {
                        var info = 'Are you sure you want to disapprove this enumeration?';
                        var result='Enumeration disapproved successfully';
                        var id = $('#citizen_id').val();
                        var remark = $('#remark').val();
                        var  status = 'disputed';
                    } 
                    console.log(id, action);
                    if (confirm(info)) {
                        $.ajax({
                            url: './actions/ajax.crud.php',
                            method: 'POST',
                            data: {
                                citizen: id,
                                remark,
                                action,
                                status,
                            },
                            success: function(data) {
                                if (data == '1') {
                                    alert(result);
                                    location.reload();
                                } else {
                                    console.log(data);
                                    alert('Action Failed');
                                }
                            }
                        });
                    } else {
                        return false;
                    }
                });
                //click on remarkBtn
                $(document).on('click', '.remarkBtn', function() {
                    var id = $(this).attr('data-citizen');
                    var enumName = $(this).attr('data-enumName');
                    var enumGender = $(this).attr('data-enumGender');
                    $('#citizen_id').val(id);
                    //bind to html class
                    $('.enumName').html(enumName);
                    $('.enumGender').html(enumGender);

                    //show modal
                    $('#modal-default').modal('show');
                });
                });
        </script>";
}
// return remark modal
function remarkModal() {
    return '
    <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tell what <span class="enumName"></span> what <span class="enumGender"></span> did wrongly?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group
          ">
            <label for="remark">Remark</label>
            <textarea class="form-control" id="remark" rows="3" placeholder="Enter ..."required></textarea>
            <input type="text" name="citizen_id" id="citizen_id" hidden>
            <span class="userId"></span>
          </div>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary takeAction" data-action="makeDispute">Disapprove Enumeration</button>
          </div>
      </div>
      <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>';
}

    //function to retrieve all disapproved dtata in a table
  function getPopSize(){
    global $con;
    //select data from citizen table
    $getMatching_data = mysqli_query($con, "SELECT * FROM lgas");
    if (mysqli_num_rows($getMatching_data) > 0) {
      $my_table='
    <tbody>';
      while ($matching_data = mysqli_fetch_assoc($getMatching_data)) {
        //get all the enumerations performed in each lga
        extract($matching_data);
        $lga_id = $matching_data['id'];
        $getEnumLga = mysqli_query($con, "SELECT * FROM citizen WHERE lga ='$lga_id'");
        $lgaEnum=mysqli_fetch_assoc($getEnumLga);
        $lgaEnumCount=mysqli_num_rows($getEnumLga);
       
        $my_table.= " 
     <tr>
        <td>$lga_name</td>
        <td>$lgaEnumCount citizens</td>
        <td><a href='?view_by_lga=$lga_id' class='label label-success'>View Citizens</a></td>
     </tr> ";
      }
      $my_table.='</tbody>';
    } else {
      $my_table = '';
    }
    return $my_table;
  
  }

  //alert function
function alert($msg){
    echo "<script>";
    echo "alert('".$msg."')";
    echo "</script>";
}
//reload page on call
function reload(){
    echo "<script>";
    echo "location.reload()";
    echo "</script>";
}
function redirect($page){
    echo "<script>";
    echo "window.location = '{$page}'";
    echo "</script>";
}
function pageName(){
    if (count($_GET) > 0) {
    foreach ($_GET as $key => $value) {
        //replace _ with ' ' if any exist
        $key = str_replace('_', ' ', $key);
        return ucfirst($key);
    }
    } else {
        return "";
    }
}
function pageNameClass(){
    if (count($_GET) > 0) {
    foreach ($_GET as $key => $value) {
if ($key!='dashboard') {
    return $key;
}
    }
    } else {
        return "";
    }
}
