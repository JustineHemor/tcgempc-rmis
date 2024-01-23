<?php
    include('include/db_connect.php');
    $member_id = $_SESSION['member_id'];
    $sql = "SELECT *,tbl_department.department, tbl_position.position
            FROM `tbl_members_info`
            LEFT JOIN tbl_department 
            ON tbl_members_info.department_id = tbl_department.department_id 
            LEFT JOIN tbl_position 
            ON tbl_members_info.position_id = tbl_position.position_id
            WHERE member_id = $member_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $username = '';
    $sql1 = "SELECT *
             FROM `tbl_user_accounts` 
             WHERE member_id = $member_id";
    $res = mysqli_query($conn, $sql1);
    while ($row1 = mysqli_fetch_assoc($res)) {
        $username = $row1['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>TCGEMPC</title>
    <link rel = "icon" type = "image/png" href = "./assets/img/logo.png">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="./assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
    <link href="./assets/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="./assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="./assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/overwrite.css">
    <?php
        $theme = '';
        if ($user_type == 'system administrator') {
            $theme = 'blue-light';
        } elseif ($user_type == 'manager' || $user_type == 'credit committee') {
            $theme = 'orange-light';
        } elseif ($user_type == 'secretary') {
            $theme = 'purple-light';
        } elseif ($user_type == 'member') {
            $theme = 'green-light';
        }
    ?>
    <link href='assets/css/themes/<?php echo $theme?>.css' rel='stylesheet' id='theme-style' >
    <!-- PAGE LEVEL STYLES-->
</head>
<body id="body" class="fixed-navbar fixed-layout">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="index.php">
                    <span class="brand">
                       TCGEMPC
                    </span>
                    <span class="brand-mini"><img src="assets/img/logo.png"></span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar flex-nowrap">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar flex-nowrap">
                    <?php
                        $sql = "SELECT *
                                FROM `tbl_comaker`
                                WHERE member_id = $member_id";
                        $sqlResult = mysqli_query($conn, $sql);
                        $sqlRow = mysqli_fetch_assoc($sqlResult);
                        $comaker_id = $sqlRow['comaker_id'];
                        
                        $sql1 = "SELECT *
                                 FROM `tbl_loan_list`
                                 WHERE comaker_id = $comaker_id 
                                 AND comaker_confirmation = 'pending'
                                 AND `status` != 'cancelled'
                                 AND `status` != 'declined'";
                        $sql1Result = mysqli_query($conn, $sql1);
                        $comaker_notif = 0;
                        
                        if (mysqli_num_rows($sql1Result) > 0) {
                            while ($sql1Row = mysqli_fetch_assoc($sql1Result)) {
                                $comaker_notif ++;
                            }
                        }
                        $sql2 = "SELECT * 
                                 FROM `tbl_loan_list` 
                                 WHERE `member_id` = $member_id";
                        $sql2Result = mysqli_query($conn, $sql2);
                        $loan_status = "";
                        if (mysqli_num_rows($sql2Result) > 0) {
                            while ($sql2Row = mysqli_fetch_assoc($sql2Result)) {
                                $loan_status = $sql2Row['status'];
                            }
                        }

                        $sql3 = "SELECT * FROM `tbl_loan_list` WHERE `member_id` = $member_id AND `notification_1` = '1'";
                        $sql3Result = mysqli_query($conn, $sql3);
                        $loan_notif = 0;
                        $loan_stat = "";
                        if (mysqli_num_rows($sql3Result) > 0) {
                            while ($sql3Row = mysqli_fetch_assoc($sql3Result)) {
                                $loan_notif = $sql3Row['notification_1'];
                                $loan_stat = $sql3Row['status'];
                            }
                        }
                    ?>
                    <?php
                        if ($comaker_notif > 0 || $loan_notif > 0) {
                    ?>
                        <li class="dropdown dropdown-notification">
                            <a class="nav-link dropdown-toggle" style="padding: 0;" data-toggle="dropdown">
                                <i class="fa fa-bell-o rel">
                                    <span class="notify-signal"></span>
                                </i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                                <li class="dropdown-menu-header">
                                    <div>
                                        <span><strong>New</strong> Notifications</span>
                                    </div>
                                </li>
                                <?php
                                    if ($comaker_notif > 0) {
                                ?>
                                <li class="list-group list-group-divider" data-height="60px" data-color="#71808f">
                                    <div>
                                        <a href="update_comaker_confirmation.php" class="list-group-item text-dark">
                                            <div class="media">
                                                <div class="media-img">
                                                    <span class="badge badge-info badge-big"><i class="fa fa-info"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-13">You have <?php echo $comaker_notif ?> comaker confirm notification.</div>
                                                </div>
                                            </div>
                                        </a>                         
                                    </div>
                                </li>
                                <?php 
                                    }
                                    if ($loan_notif > 0) {
                                        if ($loan_stat == 'complete') {
                                            $loan_stat = 'completed';
                                        }
                                ?>
                                <li class="list-group list-group-divider" data-height="60px" data-color="#71808f">
                                    <div>
                                        <a href="loan_history.php" class="list-group-item text-dark">
                                            <div class="media">
                                                <div class="media-img">
                                                    <span class="badge badge-info badge-big"><i class="fa fa-info"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-13">Your loan request has been <?php echo $loan_stat ?>.</div>
                                                </div>
                                            </div>
                                        </a>                         
                                    </div>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
                    <?php 
                        } else {
                    ?>
                        <li class="dropdown dropdown-notification">
                            <a class="nav-link dropdown-toggle" style="padding: 0;" data-toggle="dropdown">
                                <i class="fa fa-bell-o rel">
                                </i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                                <li class="dropdown-menu-header">
                                    <div>
                                        <span><strong>No New</strong> Notifications</span>
                                    </div>
                                </li>
                            </ul>
                        </li> 
                    <?php
                        }
                    ?>
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <?php
                                if (($row['gender']) == 'male') {
                                    echo '<img src="./assets/img/user-man.png" width="45px" />';
                                } else {
                                    echo '<img src="./assets/img/user-woman.png" width="45px" />';
                                }
                            ?>
                            <span></span><i class="fa fa-user"></i><i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="personal_info.php"><i class="fa fa-user"></i>Personal Info</a>
                            <a class="dropdown-item" href="change_pass.php"><i class="fa fa-key"></i>Change Pass</a>
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="index.php?logout=true"><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <?php
                            if (($row['gender']) == 'male') {
                                echo '<img src="./assets/img/user-man.png" width="45px" />';
                            } else {
                                echo '<img src="./assets/img/user-woman.png" width="45px" />';
                            }
                        ?>
                    </div>
                    <div class="admin-info">
                        <div class="font-strong"><?php echo ucwords($row['firstname']);?></div><small><?php echo ucwords($user_type);?></small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <!-- class="<?php // if($page == 'index'){echo 'active';}?>" -->
                        <a href="index.php"><i class="sidebar-item-icon fa fa-tachometer"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="heading">FEATURES</li>
                    <?php
                        if ($user_type == 'member') {
                    ?>
                        <!-- HTML code -->
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-user"></i>
                                <span class="nav-label">Profile</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="personal_info.php">Personal Info</a>
                                </li>
                                <li>
                                    <a href="change_pass.php">Change Password</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label">Loan</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="loan_history.php">Your Loan History</a>
                                </li>
                                <li>
                                    <a href="loan_request.php">Request Loan</a>
                                </li>
                                <li>
                                    <a href="loan_renew.php">Renew Loan</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-exchange"></i>
                                <span class="nav-label">Transaction</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="update_comaker_confirmation.php">Comaker Confirmation</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                                <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="personal_share.php">Your Share</a>
                                </li>
                            </ul>
                        </li>
                    <?php
                        } elseif ($user_type == 'secretary') {
                    ?>
                        <!-- HTML code -->
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-user"></i>
                                <span class="nav-label">Profile</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="personal_info.php">Personal Info</a>
                                </li>
                                <li>
                                    <a href="change_pass.php">Change Password</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-users"></i>
                                <span class="nav-label">Member</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="members_list.php">Members List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label">Loan</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="loan_list.php">Loan List</a>
                                </li>
                                <li>
                                    <a href="loan_history.php">Your Loan History</a>
                                </li>
                                <li>
                                    <a href="loan_request.php">Request Loan</a>
                                </li>
                                <li>
                                    <a href="loan_renew.php">Renew Loan</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-exchange"></i>
                                <span class="nav-label">Transaction</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="update_comaker_confirmation.php">Comaker Confirmation</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                                <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="shares.php">Remittance</a>
                                </li>
                                <li>
                                    <a href="service_fee.php">Service Fees</a>
                                </li>
                                <li>
                                    <a href="personal_share.php">Your Share</a>
                                </li>
                            </ul>
                        </li>
                    <?php
                        } elseif ($user_type == 'manager' || $user_type == 'credit committee') {
                    ?>
                        <!-- HTML code -->
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-user"></i>
                                <span class="nav-label">Profile</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="personal_info.php">Personal Info</a>
                                </li>
                                <li>
                                    <a href="change_pass.php">Change Password</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label">Loan</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="loan_list.php">Loan List</a>
                                </li>
                                <li>
                                    <a href="loan_history.php">Your Loan History</a>
                                </li>
                                <li>
                                    <a href="loan_request.php">Request Loan</a>
                                </li>
                                <li>
                                    <a href="loan_renew.php">Renew Loan</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-exchange"></i>
                                <span class="nav-label">Transaction</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="update_comaker_confirmation.php">Comaker Confirmation</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                                <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="personal_share.php">Your Share</a>
                                </li>
                            </ul>
                        </li>
                    <?php
                        } elseif ($user_type == 'system administrator') {
                    ?>
                        <!-- HTML code -->
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-user"></i>
                                <span class="nav-label">Profile</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="personal_info.php">Personal Info</a>
                                </li>
                                <li>
                                    <a href="change_pass.php">Change Password</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-users"></i>
                                <span class="nav-label">Member</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="members_list.php">Members List</a>
                                </li>
                                <li>
                                    <a href="department_list.php">Departments</a>
                                </li>
                                <li>
                                    <a href="position_list.php">Positions</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label">Loan</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="loan_list.php">Loan List</a>
                                </li>
                                <li>
                                    <a href="loan_types.php">Loan Types</a>
                                </li>
                                <li>
                                    <a href="loan_history.php">Your Loan History</a>
                                </li>
                                <li>
                                    <a href="loan_request.php">Request Loan</a>
                                </li>
                                <li>
                                    <a href="loan_renew.php">Renew Loan</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-exchange"></i>
                                <span class="nav-label">Transaction</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="update_comaker_confirmation.php">Comaker Confirmation</a>
                                </li>
                                <li>
                                    <a href="journal_voucher.php">Journal Voucher</a>
                                </li>
                                <li>
                                    <a href="disbursement_voucher.php">Disbursement Voucher</a>
                                </li>
                                <li>
                                    <a href="payments.php">Payments</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                                <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="shares.php">Shares</a>
                                </li>
                                <li>
                                    <a href="service_fee.php">Service Fees</a>
                                </li>
                                <li>
                                    <a href="personal_share.php">Your Share</a>
                                </li>
                            </ul>
                        </li>
                    <?php    
                        }
                    ?>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <?php } ?>