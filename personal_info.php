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
?>
<?php include('include/header_sidebar.php'); ?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-heading">
        <h1 class="page-title">Profile</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php"><i class="la la-home font-20"></i></a>
            </li>
            <li class="breadcrumb-item">Personal profile page</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                            <?php
                                if (($row['gender']) == 'male') {
                                    echo '<img src="./assets/img/user-man.png" width="70px" />';
                                } else {
                                    echo '<img src="./assets/img/user-woman.png" width="70px" />';
                                }
                            ?>
                        </div>
                        <h5 class="font-strong m-b-10 m-t-10"><?php echo ucwords($row['lastname'] . ", " . $row['firstname']) . " " . substr(ucwords($row['middlename']), 0, 1) . "."; ?></h5>
                        <div class="m-b-20"><?php echo ucwords($row['position']); ?></div>
                        <div class="profile-social m-b-20">
                            <hr>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="row text-center m-b-20">
                            <div class="col-6">
                                <div class="font-24 profile-stat-count">₱ <?php echo number_format($row['salary'], 2); ?></div>
                                <div class="text-muted">Salary</div>
                            </div>
                            <div class="col-6">
                                <div class="font-24 profile-stat-count">₱ <?php echo number_format($row['annual_income'], 2); ?></div>
                                <div class="text-muted">Annual Income</div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-center text-muted">Department</p>
                        <p class="text-center"><?php echo ucwords($row['department']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <ul class="nav nav-tabs tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab-1" data-toggle="tab"><i class="ti-bar-chart"></i> About</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-1">
                                <div class="row">
                                    <div class="col-md-6" style="border-right: 1px solid #eee;">
                                        <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-user"></i> Personal Information</h5>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p><strong>Address</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['address']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Phone Number</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['phone_num']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Birth Date</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['birth_date']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Birth Place</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['birth_place']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Civil Status</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['civil_status']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Gender</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['gender']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Spouse Name</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['spouse_name']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Spouses' Occupation</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['occupation']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Beneficiary</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['beneficiary']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Relation</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['relation']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Dependents Number</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['dependents_num']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-address-card"></i> Other Information</h5>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p><strong>Username</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $username; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Member Number</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['member_number']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Other Source of Income</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucwords($row['other_income_source']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>TIN Number</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['tin']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Membership Date</strong></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['membership_date']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    });
    
</script>