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
    <div class="page-heading">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div id="alert" class="alert alert-' . $_SESSION["msg_type"] . '">' . $_SESSION["message"] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <h1 class="page-title">Member's Shares</h1>
    </div>
    <div class="page-content fade-in-up">
        <?php
            $total_remittance = 0;
            $total_retention = 0;    
            $total_or = 0;
            $total_withdrawal = 0;
            $total_dividend = 0;
        ?>
        <div class="ibox">
            <?php
                if (!isset($_GET['filter'])) {                
            ?>
                <!-- HTML code here -->
                <?php
                    if ($user_type == 'system administrator') {
                ?>
                <div class="ibox-body">
                    <div class="row justify-content-center">
                        <button id="changeSort" class="btn btn-success mx-1"><i class="fa fa-sort"></i> Sort</button>
                        <button class="btn btn-success mx-1" data-toggle="modal" data-target="#modaIndividualShare"><i class="fa fa-user"></i> Individual Member</button>
                        <button id="printData" class="btn btn-success mx-1"><i class="fa fa-print"></i> Print</button>
                        <button class="btn btn-success mx-1" data-toggle="modal" data-target="#modalUploadExcel"><i class="fa fa-upload"></i> Import File</button>
                        <button class="btn btn-success mx-1" data-toggle="modal" data-target="#modalAddShare"><i class="fa fa-plus"></i> Add Record</button>
                    </div>
                </div>
                <?php
                    }
                ?>
                <div class="ibox-body" style="overflow-x: scroll;">                       
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
                    <table class="table table-striped table-bordered table-hover" id="share_table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="9">MEMBERS SHARES</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Remittance</th>
                                <th>Retention</th>
                                <th>OR</th>
                                <th>Withdrawal</th>
                                <th>Dividend</th>
                                <th>Date</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT *, tbl_members_info.member_id
                                    FROM `tbl_shares`
                                    LEFT JOIN `tbl_members_info`
                                    ON tbl_shares.member_id = tbl_members_info.member_id";
                            $sqlResult = $conn->query($sql);
                            $i = 1;
                            while ($sqlRow = $sqlResult->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><small><?php echo $i ?></small></td>
                                    <td><small><?php echo strtoupper($sqlRow['lastname']) . ", " . strtoupper($sqlRow['firstname']) ?></small></td>
                                    <td><small><?php echo $sqlRow['remittance'] ?></small></td>
                                    <td><small><?php echo $sqlRow['retention'] ?></small></td>
                                    <td><small><?php echo $sqlRow['floatOR'] ?></small></td>
                                    <td><small><?php echo $sqlRow['withdrawal'] ?></small></td>
                                    <td><small><?php echo $sqlRow['dividend'] ?></small></td>
                                    <td><small><?php echo date("F d, Y", strtotime($sqlRow['date'])); ?></small></td>
                                    <td class="text-center"><button style="overflow-x: hidden;" class="btn btn-primary btn-outline-primary btn-xs" data-toggle="modal" data-target="#editshareModal<?php echo $sqlRow['shares_id']; ?>"><i class="fa fa-edit"></i></button></td>
                                </tr>
                                <?php include 'modal/modal_update.php'; ?>
                            <?php
                                $total_remittance = $total_remittance + $sqlRow['remittance'];
                                $total_retention = $total_retention + $sqlRow['retention'];    
                                $total_or = $total_or + $sqlRow['floatOR'];
                                $total_withdrawal = $total_withdrawal + $sqlRow['withdrawal'];
                                $total_dividend = $total_dividend + $sqlRow['dividend'];
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="hiddenTable">
                        <form action="forms/print_shares.php" method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="7">MEMBERS SHARES</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Remittance</th>
                                        <th>Retention</th>
                                        <th>OR</th>
                                        <th>Withdrawal</th>
                                        <th>Dividend</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT *, tbl_members_info.member_id
                                            FROM `tbl_shares`
                                            LEFT JOIN `tbl_members_info`
                                            ON tbl_shares.member_id = tbl_members_info.member_id
                                            WHERE tbl_members_info.employment_status = 'Active'";
                                    $sqlResult = $conn->query($sql);
                                    $i = 1;
                                    while ($sqlRow = $sqlResult->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><small><input type="hidden" name="num[]" value="<?php echo $i?>"><?php echo $i ?></small></td>
                                            <td><small><input type="hidden" name="name[]" value="<?php echo strtoupper($sqlRow['lastname']) . ", " . strtoupper($sqlRow['firstname'])?>"><?php echo strtoupper($sqlRow['lastname']) . ", " . strtoupper($sqlRow['firstname']) ?></small></td>
                                            <td><small><input type="hidden" name="total_remitance[]" value="<?php echo $sqlRow['remittance']?>"><?php echo $sqlRow['remittance'] ?></small></td>
                                            <td><small><input type="hidden" name="total_retention[]" value="<?php echo $sqlRow['retention']?>"><?php echo $sqlRow['retention'] ?></small></td>
                                            <td><small><input type="hidden" name="total_floatOR[]" value="<?php echo $sqlRow['floatOR']?>"><?php echo $sqlRow['floatOR'] ?></small></td>
                                            <td><small><input type="hidden" name="total_withdrawal[]" value="<?php echo $sqlRow['withdrawal'];?>"><?php echo $sqlRow['withdrawal'] ?></small></td>
                                            <td><small><input type="hidden" name="total_dividend[]" value="<?php echo $sqlRow['dividend'];?>"><?php echo $sqlRow['dividend'] ?></small></td>
                                            <td><small><input type="hidden" name="TSC[]" value="<?php echo $sqlRow['date'];;?>"><?php echo $sqlRow['date']; ?></small></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                                <input type="hidden" name="date" value="true">
                                <input type="submit" hidden id="printBtn" value="submit">
                            </table>
                        </form>
                    </div>
                </div>
            <?php
                } elseif (isset($_GET['filter'])) {
                    $explodedValue = explode(' ',($_GET['filter']));
                    $fromdate = $explodedValue[0];
                    $todate = $explodedValue[1];
            ?>
                <!-- HTML code here -->
                <?php
                    if ($user_type == 'system administrator') {
                ?>
                <div class="ibox-body">
                    <div class="row justify-content-center">
                        <button id="changeSort" class="btn btn-success mx-1"><i class="fa fa-sort"></i> Sort</button>
                        <button id="printData" class="btn btn-success mx-1"><i class="fa fa-print"></i> Print</button>
                        <button class="btn btn-success mx-1" data-toggle="modal" data-target="#modalUploadExcel"><i class="fa fa-upload"></i> Import File</button>
                        <button class="btn btn-success mx-1" data-toggle="modal" data-target="#modalAddShare"><i class="fa fa-plus"></i> Add Record</button>
                    </div>
                </div>
                <?php
                    }
                ?>
                <div class="ibox-body" style="overflow-x: scroll;">
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
                    <table class="table table-striped table-bordered table-hover" id="share_table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="8">MEMBERS SHARES FROM <?php echo strtoupper(date("F d, Y",strtotime($fromdate))) ?> TO <?php echo strtoupper(date("F d, Y",strtotime($todate))) ?></th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Remittance</th>
                                <th>Retention</th>
                                <th>OR</th>
                                <th>Withdrawal</th>
                                <th>Dividend</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT *, tbl_members_info.member_id
                                    FROM `tbl_shares`
                                    LEFT JOIN `tbl_members_info`
                                    ON tbl_shares.member_id = tbl_members_info.member_id
                                    WHERE tbl_shares.date BETWEEN '$fromdate' AND '$todate'
                                    AND tbl_members_info.employment_status = 'Active'";
                            $sqlResult = $conn->query($sql);
                            $i = 1;
                            while ($sqlRow = $sqlResult->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><small><?php echo $i ?></small></td>
                                    <td><small><?php echo strtoupper($sqlRow['lastname']) . ", " . strtoupper($sqlRow['firstname']) ?></small></td>
                                    <td><small><?php echo $sqlRow['remittance'] ?></small></td>
                                    <td><small><?php echo $sqlRow['retention'] ?></small></td>
                                    <td><small><?php echo $sqlRow['floatOR'] ?></small></td>
                                    <td><small><?php echo $sqlRow['withdrawal'] ?></small></td>
                                    <td><small><?php echo $sqlRow['dividend'] ?></small></td>
                                    <td><small><?php echo date("F d, Y", strtotime($sqlRow['date'])); ?></small></td>
                                </tr>
                            <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="hiddenTable2">
                        <form action="forms/print_shares.php" method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="7">MEMBERS SHARES FROM <?php echo strtoupper(date("F d, Y",strtotime($fromdate))) ?> TO <?php echo strtoupper(date("F d, Y",strtotime($todate))) ?></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Remittance</th>
                                        <th>Retention</th>
                                        <th>OR</th>
                                        <th>Withdrawal</th>
                                        <th>Dividend</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT *, tbl_members_info.member_id
                                            FROM `tbl_shares`
                                            LEFT JOIN `tbl_members_info`
                                            ON tbl_shares.member_id = tbl_members_info.member_id
                                            WHERE tbl_shares.date BETWEEN '$fromdate' AND '$todate'
                                            AND tbl_members_info.employment_status = 'Active'";
                                    $sqlResult = $conn->query($sql);
                                    $i = 1;
                                    while ($sqlRow = $sqlResult->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><small><input type="hidden" name="num[]" value="<?php echo $i?>"><?php echo $i ?></small></td>
                                            <td><small><input type="hidden" name="name[]" value="<?php echo strtoupper($sqlRow['lastname']) . ", " . strtoupper($sqlRow['firstname'])?>"><?php echo strtoupper($sqlRow['lastname']) . ", " . strtoupper($sqlRow['firstname']) ?></small></td>
                                            <td><small><input type="hidden" name="total_remitance[]" value="<?php echo $sqlRow['remittance']?>"><?php echo $sqlRow['remittance'] ?></small></td>
                                            <td><small><input type="hidden" name="total_retention[]" value="<?php echo $sqlRow['retention']?>"><?php echo $sqlRow['retention'] ?></small></td>
                                            <td><small><input type="hidden" name="total_floatOR[]" value="<?php echo $sqlRow['floatOR']?>"><?php echo $sqlRow['floatOR'] ?></small></td>
                                            <td><small><input type="hidden" name="total_withdrawal[]" value="<?php echo $sqlRow['withdrawal'];?>"><?php echo $sqlRow['withdrawal'] ?></small></td>
                                            <td><small><input type="hidden" name="total_dividend[]" value="<?php echo $sqlRow['dividend'];?>"><?php echo $sqlRow['dividend'] ?></small></td>
                                            <td><small><input type="hidden" name="TSC[]" value="<?php echo $sqlRow['date'];;?>"><?php echo $sqlRow['date']; ?></small></td>
                                        </tr>
                                    <?php
                                        $total_remittance = $total_remittance + $sqlRow['remittance'];
                                        $total_retention = $total_retention + $sqlRow['retention'];    
                                        $total_or = $total_or + $sqlRow['floatOR'];
                                        $total_withdrawal = $total_withdrawal + $sqlRow['withdrawal'];
                                        $total_dividend = $total_dividend + $sqlRow['dividend'];
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="date" value="true">
                            <input type="hidden" name="filter" value="true">
                            <input type="hidden" name="fromdate" value="<?php echo $fromdate ?>">
                            <input type="hidden" name="todate" value="<?php echo $todate ?>">
                            <input type="submit" hidden id="printBtn" value="submit">
                        </form>
                    </div>
                </div>
            <?php 
                }
            ?>
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
                    </thead>
                    <tbody>
                        <td><?php echo $total_remittance?></td>
                        <td><?php echo $total_retention?></td>
                        <td><?php echo $total_or?></td>
                        <td><?php echo $total_withdrawal?></td>
                        <td><?php echo $total_dividend?></td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
<?php  include('include/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        $('#hiddenTable').hide();

        $('#hiddenTable2').hide();

        $('#share_table').DataTable({});

        $('#printData').click(function () {
            $( "#printBtn" ).trigger( "click" );
        });

        $('#changeSort').click(function () {
            window.location="shares.php"
        });

        setTimeout(function(){
            document.getElementById("alert").style.display = "none";
        }, 3000);

        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != "" && to_date != "") {
                window.location="shares2.php?filter="+from_date+" "+to_date;
            } else {
                alert("Select date range.");
            }
        });

        $('#cancel').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != "" && to_date != "") {
                window.location="shares2.php";
            } else {
                
            }
        });
    });
</script>
<?php include ('modal/modal_add.php');?>