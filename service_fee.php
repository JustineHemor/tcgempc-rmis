<?php include('include/db_connect.php');?>
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
    if ($user_type != 'system administrator' && $user_type != 'secretary') {
        header("Location: index.php");
    }
?>
<?php include('include/header_sidebar.php');?>
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Service Fees</h1>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                    </div>
                    <div class="ibox-body" style="overflow-x: scroll;">
                        <?php
                            if (!isset($_GET['filter'])) {                
                        ?>
                        <div class="row justify-content-center mx-1">
                            <label class="my-sm-2">Select Range</label>
                            <input type="date" placeholder="From Date" id="from_date" class="form-control mb-3 ml-md-3 col-md-5">
                            <label class="my-sm-2 ml-3">To</label>
                            <input type="date" placeholder="To Date" id="to_date" class="form-control mb-3 ml-md-3 col-md-5">
                        </div>
                        <div class="row justify-content-end mx-3">
                            <button id="cancel" style="overflow-x: hidden;" class="btn btn-default btn-outline-default col-sm-1 mb-3 mr-sm-2"><i class="fa fa-close"></i> Cancel</button>
                            <button style="overflow-x: hidden;" class="btn btn-primary btn-outline-primary col-sm-1 mb-3" id="filter"><i class="fa fa-filter"></i> Filter</button>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="loans_table" cellspacing="0" width="100%">
                            <?php
                                $total_service_fee = 0;
                                $query = "SELECT *, tbl_loan_list.loan_id, tbl_members_info.member_id
                                          FROM `tbl_service_fees`
                                          LEFT JOIN `tbl_loan_list` 
                                          ON tbl_service_fees.loan_id = tbl_loan_list.loan_id
                                          LEFT JOIN `tbl_members_info` 
                                          ON tbl_loan_list.member_id = tbl_members_info.member_id";
                                $result = $conn->query($query);
                            ?>
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Member Name</th>
                                    <th>Service Fee</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $row['application_number']?></td>
                                    <td><?php echo strtoupper($row['lastname']) . ", " . strtoupper($row['firstname']) . " " . substr(strtoupper($row['middlename']), 0, 1) . ".";?></td>
                                    <td><?php echo $row['service_fee_amount']?></td>
                                    <td><?php echo date("F j, Y", strtotime($row['date']));?></td>
                                </tr>
                                <?php
                                    $total_service_fee = $total_service_fee + $row['service_fee_amount'];
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50%">TOTAL SERVICE FEE</th>
                                            <th width="50%" class="text-center"><?php echo $total_service_fee?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <?php
                            } else {
                                $explodedValue = explode(' ',($_GET['filter']));
                                $fromdate = $explodedValue[0];
                                $todate = $explodedValue[1];        
                        ?>
                        <table class="table table-striped table-bordered table-hover" id="loans_table" cellspacing="0" width="100%">
                            <div class="row justify-content-center mx-1">
                                <label class="my-sm-2">Select Range</label>
                                <input type="date" placeholder="From Date" id="from_date" value="<?php echo $fromdate ?>" class="form-control mb-3 ml-md-3 col-md-5">
                                <label class="my-sm-2 ml-3">To</label>
                                <input type="date" placeholder="To Date" id="to_date" value="<?php echo $todate ?>" class="form-control mb-3 ml-md-3 col-md-5">
                            </div>
                            <div class="row justify-content-end mx-3">
                                <button id="cancel" class="btn btn-default btn-outline-default col-sm-1 mb-3 mr-sm-2"><i class="fa fa-close"></i> Cancel</button>
                                <button class="btn btn-primary btn-outline-primary col-sm-1 mb-3" id="filter"><i class="fa fa-filter"></i> Filter</button>
                            </div>
                            <?php
                                $total_service_fee = 0;
                                $query = "SELECT *, tbl_loan_list.loan_id, tbl_members_info.member_id
                                          FROM `tbl_service_fees`
                                          LEFT JOIN `tbl_loan_list` 
                                          ON tbl_service_fees.loan_id = tbl_loan_list.loan_id
                                          LEFT JOIN `tbl_members_info` 
                                          ON tbl_loan_list.member_id = tbl_members_info.member_id
                                          WHERE tbl_service_fees.date BETWEEN '$fromdate' AND '$todate'";
                                $result = $conn->query($query);
                            ?>
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="5">SERVICE FEES FROM <?php echo strtoupper(date("F d, Y",strtotime($fromdate))) ?> TO <?php echo strtoupper(date("F d, Y",strtotime($todate))) ?></th>
                                </tr>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Member Name</th>
                                    <th>Service Fee</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $row['application_number']?></td>
                                    <td><?php echo strtoupper($row['lastname']) . ", " . strtoupper($row['firstname']) . " " . substr(strtoupper($row['middlename']), 0, 1) . ".";?></td>
                                    <td><?php echo $row['service_fee_amount']?></td>
                                    <td><?php echo date("F j, Y", strtotime($row['date']));?></td>
                                </tr>
                                <?php
                                    $total_service_fee = $total_service_fee + $row['service_fee_amount'];
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50%">TOTAL SERVICE FEE</th>
                                            <th width="50%" class="text-center"><?php echo $total_service_fee?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <?php
                            }              
                        ?>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
<?php include('include/footer.php');?>

<script type="text/javascript">
    $(document).ready(function(){

        $('#loans_table').DataTable({});

        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != "" && to_date != "") {
                window.location="service_fee.php?filter="+from_date+" "+to_date;
            } else {
                alert("Select date range.");
            }
        });

        $('#cancel').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != "" && to_date != "") {
                window.location="service_fee.php";
            } else {
                
            }
        });
    });
</script>

