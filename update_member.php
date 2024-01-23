<?php include('include/db_connect.php'); ?>
<?php
session_start();
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION);
    header("Location: login.php");
}
$user_type = $_SESSION['user_type'];
if ($user_type != 'system administrator' && $user_type != 'secretary') {
    header("Location: index.php");
}
?>
<?php //Update the get variables on other pages
$memberID = 0;
$updateid  = $_GET['updateid'];
$hashed = $_GET['hashed'];
$salt = "cV0puOlxgX09Klm";
$hash = md5($salt . $updateid);
if ($hash === $hashed) {
    $memberID = round(($updateid * 2) / 91824826);
} else {
    header("Location: members_list.php");
}

$mysql = "SELECT *,tbl_department.department, tbl_position.position
            FROM `tbl_members_info` 
            LEFT JOIN tbl_department 
            ON tbl_members_info.department_id = tbl_department.department_id 
            LEFT JOIN tbl_position 
            ON tbl_members_info.position_id = tbl_position.position_id
            WHERE member_id = $memberID";
$rslt = mysqli_query($conn, $mysql);
if (mysqli_num_rows($rslt) > 0) {
    $roow = mysqli_fetch_assoc($rslt);
    $sql1 = "SELECT *
                 FROM tbl_user_accounts
                 WHERE member_id=$memberID";
    $res = mysqli_query($conn, $sql1);
    $rooow = mysqli_fetch_assoc($res);
?>
    <?php include('include/header_sidebar.php'); ?>
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div id="alert" class="alert alert-' . $_SESSION["msg_type"] . '">' . $_SESSION["message"] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <div class="page-heading">
            <h1 class="page-title">Update Member's Information</h1>
        </div>
        <div class="page-content fade-in-up">
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox">
                        <div class="ibox-head">
                            <div class="ibox-title">Member's Information</div>
                        </div>
                        <div class="ibox-body">
                            <form method="POST" action="functions/update.php?action=update_member">
                                <input hidden name="member_id" id="member_id" required class="form-control" type="text" placeholder="" value="<?php echo $memberID ?>"> <!-- GET MEMBER ID-->
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>Last Name</label>
                                        <input name="lastname" id="lastname" required class="form-control" type="text" placeholder="Last Name" value="<?php echo $roow['lastname']; ?>">
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>First Name</label>
                                        <input name="firstname" id="firstname" required class="form-control" type="text" placeholder="First Name" value="<?php echo $roow['firstname']; ?>">
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>Middle Name</label>
                                        <input name="middlename" id="middlename" required class="form-control" type="text" placeholder="Middle Name" value="<?php echo $roow['middlename']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 form-group">
                                        <label>Gender</label>
                                        <select name="gender" id="gender" class="form-control" required>
                                            <option value="<?php echo $roow['gender']; ?>" selected><?php echo ucwords($roow['gender']); ?></option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">Date of Birth</label>
                                        <input type="date" name="birth_date" id="birth_date" placeholder="Date of Birth" class="form-control" value="<?php echo $roow['birth_date']; ?>">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="" class="control-label">Address</label>
                                        <textarea class="form-control" name="address" id="address" rows="1" required><?php echo $roow['address']; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label for="" class="control-label">Department</label>
                                        <?php $departmentSet = $conn->query("SELECT department_id, department FROM tbl_department"); ?>
                                        <select name="department" id="department" class="form-control" required>
                                            <option value="<?php echo $row['department_id']; ?>" selected><?php echo $roow['department']; ?></option>
                                            <?php
                                            while ($rows = $departmentSet->fetch_assoc()) {
                                                $dept_name = $rows['department'];
                                                $dept_id = $rows['department_id'];
                                                echo "<option value='$dept_id'>$dept_name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">Phone No.</label>
                                        <input type="text" name="phonenum" id="phonenum" class="form-control" required value="<?php echo $roow['phone_num']; ?>">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">Position</label>
                                        <?php $positionSet = $conn->query("SELECT position_id, position FROM tbl_position"); ?>
                                        <select name="position" id="position" class="form-control" required>
                                            <option value="<?php echo $row['position_id']; ?>" selected><?php echo $roow['position']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label for="" class="control-label">Place of Birth</label>
                                        <textarea class="form-control" name="birthplace" id="birthplace" rows="1" required><?php echo $roow['birth_place']; ?></textarea>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">Salary</label>
                                        <input type="text" name="salary" id="salary" class="form-control" required value="<?php echo $roow['salary']; ?>">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">Other Source of Income</label>
                                        <input type="text" name="othersourceofincome" id="othersourceofincome" class="form-control" required value="<?php echo $roow['other_income_source']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">Annual Income</label>
                                        <input type="text" name="annualincome" id="annualincome" class="form-control" required value="<?php echo $roow['annual_income']; ?>">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">Religion</label>
                                        <input type="text" name="religion" id="religion" class="form-control" required value="<?php echo $roow['religion']; ?>">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="" class="control-label">TIN</label>
                                        <input type="text" name="tin" id="tin" class="form-control" required value="<?php echo $roow['tin']; ?>">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label>Civil Status</label>
                                        <select name="civilstatus" id="civilstatus" class="form-control" required>
                                            <option value="<?php echo $roow['civil_status']; ?>" selected><?php echo $roow['civil_status']; ?></option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Separated">Separated</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label for="" class="control-label">Spouse Name</label>
                                        <input type="text" name="spousename" id="spousename" class="form-control" required value="<?php echo $roow['spouse_name']; ?>">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="" class="control-label">Occupation</label>
                                        <input type="text" name="occupation" id="occupation" class="form-control" required value="<?php echo $roow['occupation']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label for="" class="control-label">Beneficiary</label>
                                        <input type="text" name="beneficiary" id="beneficiary" class="form-control" required value="<?php echo $roow['beneficiary']; ?>">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="" class="control-label">Relation</label>
                                        <input type="text" name="relation" id="relation" class="form-control" required value="<?php echo $roow['relation']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label for="" class="control-label">No. of Dependent(s)</label>
                                        <input type="text" name="dependentsnum" id="dependentsnum" class="form-control" required value="<?php echo $roow['dependents_num']; ?>">
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="" class="control-label">Member Number</label>
                                        <input type="number" readonly name="member_number" id="member_number" class="form-control" required value="<?php echo $roow['member_number']; ?>">
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>User Type</label>
                                        <select name="user_type" id="user_type" class="form-control" required>
                                            <?php
                                                if ($rooow['user_type'] == "system administrator") {
                                                    echo '<option value="system administrator">System Administrator</option>
                                                          <option value="member">Member</option>
                                                          <option value="secretary">Secretary</option>
                                                          <option value="manager">Manager</option>
                                                          <option value="credit committee">Credit Committee</option>';
                                                } elseif ($rooow['user_type'] == "member") {
                                                    echo '<option value="member">Member</option>
                                                          <option value="secretary">Secretary</option>
                                                          <option value="manager">Manager</option>
                                                          <option value="credit committee">Credit Committee</option>
                                                          <option value="system administrator">System Administrator</option>';
                                                } elseif ($rooow['user_type'] == "secretary") {
                                                    echo '<option value="secretary">Secretary</option>
                                                          <option value="member">Member</option>
                                                          <option value="manager">Manager</option>
                                                          <option value="credit committee">Credit Committee</option>
                                                          <option value="system administrator">System Administrator</option>';
                                                } elseif ($rooow['user_type'] == "manager") {
                                                    echo '<option value="manager">Manager</option>
                                                          <option value="member">Member</option>
                                                          <option value="secretary">Secretary</option>
                                                          <option value="credit committee">Credit Committee</option>
                                                          <option value="system administrator">System Administrator</option>';
                                                } elseif ($rooow['user_type'] == "credit committee") {
                                                    echo '<option value="credit committee">Credit Committee</option>
                                                          <option value="member">Member</option>
                                                          <option value="secretary">Secretary</option>
                                                          <option value="manager">Manager</option>
                                                          <option value="system administrator">System Administrator</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                if ($user_type == "system administrator") {
                                ?>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Username</label>
                                            <input type="text" readonly name="username" id="username" class="form-control" required value="<?php echo $rooow['username']; ?>">
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label>Password</label>
                                            <input type="text" readonly name="password" id="password" class="form-control" required value="<?php echo md5($rooow['password']) ?>">
                                            <input type="hidden" readonly name="passwordformat" id="passwordformat" value="hashed">
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label>Forgot Password?</label>
                                            <input type="button" name="reset_pass" id="reset_pass" class="form-control btn btn-primary" value="Generate New Password">
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <input type="hidden" readonly name="username" id="username" class="form-control" required value="<?php echo $rooow['username']; ?>">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <input type="hidden" readonly name="password" id="password" class="form-control" required value="<?php echo md5($rooow['password']) ?>">
                                            <input type="hidden" readonly name="passwordformat" id="passwordformat" value="hashed">
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="form-group text-right">
                                    <a href="members_list.php" class="btn btn-default">Cancel</a>
                                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
<?php
} else {
    header("Location: members_list.php");
}
?>

<?php include('include/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 2000);

        $('#department').change(function() {
            var department_id = $(this).val();
            $.ajax({
                url: "functions/fetch.php?action=fetch_position",
                method: "POST",
                data: {
                    department_id: department_id
                },
                success: function(data) {
                    $("#position").html(data);
                }
            });
        });

        $('#reset_pass').click(function(e) {
            e.preventDefault;
            var r = confirm("Press OK to generate new password.");
            if (r == true) {
                let lastname = $('#lastname').val();
                let num = Math.floor(100000 + Math.random() * 900000);
                $('#password').val(lastname.substring(0, 2) + num);
                $('#passwordformat').val("unhashed");
            } else {

            }
        });

        var user_type = "<?php echo $user_type?>";

        $('#user_type').click(function() {
            if (user_type == "secretary") {
                alert("Only system administrator can change user type.");
                $("#user_type").val($("#user_type option:first").val());
            }
        });

    });
</script>