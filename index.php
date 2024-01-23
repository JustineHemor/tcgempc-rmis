<?php
    session_start();  
    if(!isset($_SESSION['member_id'])){
        header("Location: login.php");
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION);
        header("Location: login.php");
    }
    $user_type = $_SESSION['user_type'];
    $page = 'index';
?>
<?php include('include/header_sidebar.php');?>
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-content fade-in-up">
            <?php
                $member_id = $_SESSION['member_id'];
                if ($user_type == 'member') {
            ?>
                <!-- HTML code -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <h2 class="m-b-5 font-strong"><?php echo $comaker_notif ?></h2>
                                <div class="m-b-5">COMAKER REQUEST</div>
                                <i class="fa fa-users widget-stat-icon"></i>
                                <span>
                                    <a href="update_comaker_confirmation.php" class="btn btn-success border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-primary color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'approved' AND `member_id` = $member_id";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $active_loans= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $active_loans += 1;
                                        }
                                    } else {
                                        $active_loans= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $active_loans ?></h2>
                                <div class="m-b-5">YOUR ACTIVE LOANS</div>
                                <i class="fa fa-line-chart widget-stat-icon"></i>
                                <span>
                                    <a href="loan_history.php?search=active" class="btn btn-primary border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'for approval' AND `member_id` = $member_id";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $pending= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $pending += 1;
                                        }
                                    } else {
                                        $pending= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $pending ?></h2>
                                <div class="m-b-5"> YOUR PENDING REQUEST</div><i class="fa fa-clock-o widget-stat-icon"></i>
                                <span>
                                    <a href="loan_history.php?search=for approval" class="btn btn-warning border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_shares WHERE member_id = $member_id";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $remittance= 0;
                                    while ($row = mysqli_fetch_assoc ($query_run)) {
                                        $remittance += $row['remittance'];
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong">₱ <?php echo $remittance ?></h2>
                                <div class="m-b-5">YOUR SHARE</div><i class="fa fa-money widget-stat-icon"></i>
                                <span>
                                    <a href="personal_share.php" class="btn btn-danger border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                } elseif ($user_type == 'secretary') {
            ?>
                <!-- HTML code -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_members_info WHERE employment_status = 'Active'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $employment_status= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $employment_status += 1;
                                        }
                                    } else {
                                        $employment_status= 0;
                                    }         
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $employment_status ?></h2>
                                <div class="m-b-5">ACTIVE MEMBERS</div>
                                <i class="fa fa-users widget-stat-icon"></i>
                                <span>
                                    <a href="members_list.php" class="btn btn-success border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-primary color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'approved'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $active_loans= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $active_loans += 1;
                                        }
                                    } else {
                                        $active_loans= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $active_loans ?></h2>
                                <div class="m-b-5">ACTIVE LOANS</div>
                                <i class="fa fa-line-chart widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=active" class="btn btn-primary border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'for approval'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $pending= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $pending += 1;
                                        }
                                    } else {
                                        $pending= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $pending ?></h2>
                                <div class="m-b-5">PENDING REQUEST</div><i class="fa fa-clock-o widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=for approval" class="btn btn-warning border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_shares";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $remittance= 0;
                                    while ($row = mysqli_fetch_assoc ($query_run)) {
                                        $remittance += $row['remittance'];
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong">₱<?php echo $remittance ?></h2>
                                <div class="m-b-5">TOTAL SHARE</div><i class="fa fa-money widget-stat-icon"></i>
                                <span>
                                    <a href="shares.php" class="btn btn-danger border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                } elseif ($user_type == 'manager' || $user_type == 'credit committee') {
            ?>
                <!-- HTML code -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'complete'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $completed_loans= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $completed_loans += 1;
                                        }
                                    } else {
                                        $completed_loans= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $completed_loans ?></h2>
                                <div class="m-b-5">COMPLETED LOANS</div>
                                <i class="fa fa-check widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=complete" class="btn btn-success border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-primary color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'approved'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $active_loans= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $active_loans += 1;
                                        }
                                    } else {
                                        $active_loans= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $active_loans ?></h2>
                                <div class="m-b-5">ACTIVE LOANS</div>
                                <i class="fa fa-line-chart widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=active" class="btn btn-primary border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'for approval'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $pending= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $pending += 1;
                                        }
                                    } else {
                                        $pending= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $pending ?></h2>
                                <div class="m-b-5">PENDING REQUEST</div><i class="fa fa-clock-o widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=for approval" class="btn btn-warning border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'declined'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $declined_application = 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $declined_application += 1;
                                        }
                                    } else {
                                        $declined_application= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $declined_application ?></h2>
                                <div class="m-b-5">DECLINED APPLICATION</div><i class="fa fa-close widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=declined" class="btn btn-danger border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                } elseif ($user_type == 'system administrator') {
            ?>
                <!-- HTML code -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    
                                    $query = "SELECT * FROM tbl_members_info WHERE employment_status = 'Active'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $employment_status= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $employment_status += 1;
                                        }
                                    } else {
                                        $employment_status= 0;
                                    }         
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $employment_status ?></h2>
                                <div class="m-b-5">ACTIVE MEMBERS</div>
                                <i class="fa fa-users widget-stat-icon"></i>
                                <span>
                                    <a href="members_list.php" class="btn btn-success border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-primary color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'approved'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $active_loans= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $active_loans += 1;
                                        }
                                    } else {
                                        $active_loans= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $active_loans ?></h2>
                                <div class="m-b-5">ACTIVE LOANS</div>
                                <i class="fa fa-line-chart widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=active" class="btn btn-primary border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_loan_list WHERE `status` = 'for approval'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $pending= 0;
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $pending += 1;
                                        }
                                    } else {
                                        $pending= 0;
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong"><?php echo $pending ?></h2>
                                <div class="m-b-5">PENDING REQUEST</div><i class="fa fa-clock-o widget-stat-icon"></i>
                                <span>
                                    <a href="loan_list.php?search=for approval" class="btn btn-warning border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_shares";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $remittance= 0;
                                    while ($row = mysqli_fetch_assoc ($query_run)) {
                                        $remittance += $row['remittance'];
                                    }
                                ?>
                                <h2 class="m-b-5 font-strong">₱<?php echo $remittance ?></h2>
                                <div class="m-b-5">TOTAL SHARE</div><i class="fa fa-money widget-stat-icon"></i>
                                <span>
                                    <a href="shares.php" class="btn btn-danger border-white rounded" type="button">View List</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="ibox">
                            <div class="ibox-head" style="overflow: hidden;">
                                <?php
                                    $i = 6;
                                    $months = '';
                                    $labels = '';
                                    $values = '';
                                    while ($i >= 1) {
                                        $months = (date('F', strtotime('-'.$i.' months')));
                                        $monthwithyear = (date('Y-m', strtotime('-'.$i.' months')));
                                        $datestart = $monthwithyear."-01";
                                        $dateend = $monthwithyear."-31";
                                        $query = "SELECT * FROM tbl_payment WHERE `payment_date` BETWEEN '$datestart' AND '$dateend'";
                                        $query_run = mysqli_query($conn, $query);
                                        $payment = 0;
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $payment += $row['payment_amount'];
                                        }
                                        $values .= "'$payment',";
                                        $labels .= "'$months',";
                                        $i--;
                                        $payment = 0;
                                    }
                                    $labels = substr($labels, 0, -1);
                                    $values = substr($values, 0, -1);
                                    $values = $values.", 5000";
                                ?>
                                <div class="ibox-title">Payments For The Last 6 Months</div>
                            </div>
                            <div class="ibox-body" style="overflow: hidden;">
                                <div>
                                    <canvas id="myBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ibox">
                            <div class="ibox-head" style="overflow: hidden;">
                                <?php
                                    $query = "SELECT * FROM tbl_members_info WHERE employment_status = 'Active'";
                                    $query_run = mysqli_query($conn, $query);
                                    
                                    $male = 0;
                                    $female = 0;
                                    $gender = '';
                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc ($query_run)) {
                                            $gender = $row['gender'];
                                            if ($gender == 'male') {
                                                $male++;
                                            } else {
                                                $female++;
                                            }
                                        }
                                    }       
                                ?>
                                <div class="ibox-title">Member's Gender Chart</div>
                            </div>
                            <div class="ibox-body" style="overflow: hidden;">
                                <div>
                                    <canvas id="myPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php    
                }
            ?>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
<?php include('include/footer.php');?>
<script src="assets/package/dist/chart.js"></script>
<script>
    const labels = [<?php echo $labels?>];

    const dataBar = {
        labels: labels,
        datasets: [
            {
                label: 'Payments',
                backgroundColor: 'rgb(255, 205, 86)',
                borderColor: 'rgb(52,152,219)',
                data: [<?php echo $values?>],
            },
        ]
    };

    const configBar = {
        type: 'bar',
        data: dataBar,
        options: {}
    };

    const myBarChart = new Chart(
        document.getElementById('myBarChart'),
        configBar
    );

    const dataPie = {
        labels: [
            'Female',
            'Male',
        ],
        datasets: [{
            label: 'Male and Female Chart',
            data: [<?php echo $female?>, <?php echo $male?>],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            ],
            hoverOffset: 4
        }]
    };

    const configPie = {
        type: 'pie',
        data: dataPie,
    };

    const myPieChart = new Chart(
        document.getElementById('myPieChart'),
        configPie
    );
    
</script>