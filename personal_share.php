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
?>
<?php include('include/header_sidebar.php');?>
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title"> Your Share History</h1>
            </div>
            <div class="page-content fade-in-up">
                <?php
                    $total_remittance = 0;
                    $total_retention = 0;    
                    $total_or = 0;
                    $total_withdrawal = 0;
                    $total_dividend = 0;
                    $total_share_capital = 0;
                ?>
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

                                $member_id = $_SESSION['member_id'];
                                $query = "SELECT * 
                                          FROM `tbl_shares`
                                          WHERE member_id = $member_id";
                                $result = $conn->query($query);
                            ?>
                            <thead>
                                <tr>
                                    <th>Remittance</th>
                                    <th>Retention</th>
                                    <th>OR</th>
                                    <th>Withdrawal</th>
                                    <th>Dividend</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $row['remittance']?></td>
                                    <td><?php echo $row['retention']?></td>
                                    <td><?php echo $row['floatOR']?></td>
                                    <td><?php echo $row['withdrawal']?></td>
                                    <td><?php echo $row['dividend']?></td>
                                    <td><?php echo date("F j, Y", strtotime($row['date']));?></td>
                                </tr>
                                <?php
                                    $total_remittance = $total_remittance + $row['remittance'];
                                    $total_retention = $total_retention + $row['retention'];    
                                    $total_or = $total_or + $row['floatOR'];
                                    $total_withdrawal = $total_withdrawal + $row['withdrawal'];
                                    $total_dividend = $total_dividend + $row['dividend'];
                                    } 
                                ?>
                                <tr>
                                    <th><?php echo $total_remittance?></th>
                                    <th><?php echo $total_retention?></th>
                                    <th><?php echo $total_or?></th>
                                    <th><?php echo $total_withdrawal?></th>
                                    <th><?php echo $total_dividend?></th>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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
                                $member_id = $_SESSION['member_id'];
                                $query = "SELECT * 
                                          FROM `tbl_shares`
                                          WHERE tbl_shares.date BETWEEN '$fromdate' AND '$todate'
                                          AND member_id = $member_id
                                          ORDER BY `date`";
                                $result = $conn->query($query);
                            ?>
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="6">YOUR SHARES FROM <?php echo strtoupper(date("F d, Y",strtotime($fromdate))) ?> TO <?php echo strtoupper(date("F d, Y",strtotime($todate))) ?></th>
                                </tr>
                                <tr>
                                    <th>Remittance</th>
                                    <th>Retention</th>
                                    <th>OR</th>
                                    <th>Withdrawal</th>
                                    <th>Dividend</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $row['remittance']?></td>
                                    <td><?php echo $row['retention']?></td>
                                    <td><?php echo $row['floatOR']?></td>
                                    <td><?php echo $row['withdrawal']?></td>
                                    <td><?php echo $row['dividend']?></td>
                                    <td><?php echo date("F j, Y", strtotime($row['date']));?></td>
                                </tr>
                                <?php
                                    $total_remittance = $total_remittance + $row['remittance'];
                                    $total_retention = $total_retention + $row['retention'];    
                                    $total_or = $total_or + $row['floatOR'];
                                    $total_withdrawal = $total_withdrawal + $row['withdrawal'];
                                    $total_dividend = $total_dividend + $row['dividend'];
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <?php
                            }              
                        ?>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-body" style="overflow-x: scroll;">
                        <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <th>Total Remittance</th>
                                <th>Total Retention</th>
                                <th>Total OR</th>
                                <th>Total Withdrawal</th>
                                <th>Total Dividend</th>
                                <th>Total Share Capital</th>
                            </thead>
                            <tbody>
                                <td><?php echo $total_remittance?></td>
                                <td><?php echo $total_retention?></td>
                                <td><?php echo $total_or?></td>
                                <td><?php echo $total_withdrawal?></td>
                                <td><?php echo $total_dividend?></td>
                                <?php
                                    $total_share_capital = $total_remittance + $total_retention + $total_or + $total_dividend - $total_withdrawal;
                                ?>
                                <td><?php echo $total_share_capital?></td>
                            </tbody>
                        </table>
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
                window.location="personal_share.php?filter="+from_date+" "+to_date;
            } else {
                alert("Select date range.");
            }
        });

        $('#cancel').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != "" && to_date != "") {
                window.location="personal_share.php";
            } else {
                
            }
        });
    });
</script>

