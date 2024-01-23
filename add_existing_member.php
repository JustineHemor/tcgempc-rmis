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
        <h1 class="page-title">Add Member</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Applicant's Information</div>
                    </div>
                    <div class="ibox-body">
                        <form method="POST" action="functions/insert.php?action=insert_existing_member">
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>Last Name</label>
                                    <input name="lastname" id="lastname" required class="form-control" type="text">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>First Name</label>
                                    <input name="firstname" id="firstname" required class="form-control" type="text">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>Middle Name</label>
                                    <input name="middlename" id="middlename" required class="form-control" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label>Gender</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="" hidden selected>Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">Date of Birth</label>
                                    <input type="date" name="birth_date" id="birth_date" placeholder="Date of Birth" class="form-control">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="" class="control-label">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="1" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="" class="control-label">Department</label>
                                    <?php $departmentSet = $conn->query("SELECT * FROM tbl_department WHERE dept_status = 'activated'"); ?>
                                    <select name="department" id="department" class="form-control" required>
                                        <option value="" selected>Select</option>
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
                                    <input type="number" name="phonenum" id="phonenum" class="form-control" required value="">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">Position</label>
                                    <select name="position" id="position" class="form-control" required>
                                        <option value="" selected>Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="" class="control-label">Place of Birth</label>
                                    <textarea class="form-control" name="birthplace" id="birthplace" rows="1" required></textarea>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">Salary</label>
                                    <input type="number" name="salary" id="salary" class="form-control" required value="">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">Other Source of Income</label>
                                    <input type="text" name="othersourceofincome" id="othersourceofincome" class="form-control" required value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">Annual Income</label>
                                    <input type="number" name="annualincome" id="annualincome" class="form-control" required value="">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">Religion</label>
                                    <input type="text" name="religion" id="religion" class="form-control" required value="">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">TIN</label>
                                    <input type="text" name="tin" id="tin" class="form-control" required value="-">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label>Civil Status</label>
                                    <select name="civilstatus" id="civilstatus" class="form-control" required>
                                        <option disabled selected>Select</option>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="separated">Separated</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="widowed">Widowed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="" class="control-label">Spouse Name</label>
                                    <input type="text" name="spousename" id="spousename" class="form-control" required value="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="" class="control-label">Occupation</label>
                                    <input type="text" name="occupation" id="occupation" class="form-control" required value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="" class="control-label">Beneficiary</label>
                                    <input type="text" name="beneficiary" id="beneficiary" class="form-control" required value="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="" class="control-label">Relation</label>
                                    <input type="text" name="relation" id="relation" class="form-control" required value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="" class="control-label">No. of Dependent(s)</label>
                                    <input type="number" name="dependentsnum" id="dependentsnum" class="form-control" required value="">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <?php
                                    $addmemberSql = "SELECT * FROM tbl_members_info ORDER BY member_id DESC LIMIT 1";
                                    $addmemberResult = mysqli_query($conn, $addmemberSql);
                                    $lastnum = 0;
                                    while ($addmemberRow = mysqli_fetch_assoc($addmemberResult)) {
                                        $last_member_number = $addmemberRow['member_number'];
                                    }
                                    if (substr($last_member_number, 0, 4) == date("Y")) { // Check if last member number's year is equal to current year
                                        if (substr($last_member_number, 4, 2) == date("m")) { // Check if last member number's month is equal to current month
                                            $lastnum = substr($last_member_number, 6);
                                            if (substr($lastnum, 0, 1) == 0) {
                                                $lastnum = "0" . ($lastnum + 1);
                                            } else {
                                                $lastnum = $lastnum + 1;
                                            }
                                            $firstpart = substr($last_member_number, 0, 6);
                                            $member_number = $firstpart . $lastnum;
                                        } else {
                                            $lastnum = substr($last_member_number, 6);
                                            if (substr($lastnum, 0, 1) == 0) {
                                                $lastnum = "0" . ($lastnum + 1);
                                            } else {
                                                $lastnum = $lastnum + 1;
                                            }
                                            $member_number = date("Y") . date("m") . $lastnum;
                                        }
                                    } else {
                                        $lastnum = substr($last_member_number, 6);
                                        if (substr($lastnum, 0, 1) == 0) {
                                            $lastnum = "0" . ($lastnum + 1);
                                        } else {
                                            $lastnum = $lastnum + 1;
                                        }
                                        $member_number = date("Y") . date("m") . $lastnum;
                                    }
                                    ?>
                                    <label for="" class="control-label">Member Number</label>
                                    <input type="number" name="member_number" id="member_number" class="form-control" required value="<?php echo $member_number ?>">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label>Membership Date</label>
                                    <input type="date" name="membership_date" id="membership_date" class="form-control" value="<?php echo date("Y-m-d") ?>">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label>User Type</label>
                                    <select name="user_type" id="user_type" class="form-control" required>
                                        <option value="member">Member</option>
                                        <option value="secretary">Secretary</option>
                                        <option value="manager">Manager</option>
                                        <option value="credit committee">Credit Committee</option>
                                        <option value="system administrator">System Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label for="" class="control-label">Share Capital</label>
                                    <input type="number" name="share_capital" id="share_capital" class="form-control" required value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Username</label>
                                    <input type="text" readonly name="username" id="username" class="form-control" required value="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Password</label>
                                    <input type="text" readonly name="password" id="password" class="form-control" required value="">
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <a href="members_list.php" class="btn btn-default">Cancel</a>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

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

        $('#firstname').on('input', function() {
            let lname = $('#lastname').val();
            let fname = $('#firstname').val();
            let fnames = (fname.split(' '));
            let i = 0;
            let name = "";

            while (i < fnames.length) {
                name = name + ((fname.split(' ')[i]).substr(0, 1));
                i++;
            }

            $('#username').val(name.toLowerCase() + ((lname.toLowerCase()).replace(/ /g, "").replace(".", "")));
        });

        $('#lastname').on('input', function() {
            let lname = $('#lastname').val();
            let fname = $('#firstname').val();
            let fnames = (fname.split(' '));
            let i = 0;
            let name = "";

            while (i < fnames.length) {
                name = name + ((fname.split(' ')[i]).substr(0, 1));
                i++;
            }

            let num = Math.floor(100000 + Math.random() * 900000);

            $('#password').val(lname.substring(0, 2) + num);
            $('#username').val(name.toLowerCase() + ((lname.toLowerCase()).replace(/ /g, "").replace(".", "")));
        });

    });
</script>