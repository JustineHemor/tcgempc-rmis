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
if ($_POST['member_id'] == null) {
    header("location:javascript://history.go(-1)");
}
?>
<?php include('include/header_sidebar.php'); ?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <?php
        $member_id = $_POST['member_id'];
        $sql = "SELECT * FROM tbl_members_info WHERE `member_id` = $member_id";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $firstname = ucfirst($row['firstname']);
            $lastname = ucfirst($row['lastname']);
            $middlename = ucfirst($row['middlename']);
        }
        $middleinitial = $middlename[0];
    ?>
    <div class="page-heading">
        <h1 class="page-title"> Share History of <?php echo $firstname . " " . $lastname ?></h1>
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
            <div class="ibox-head justify-content-end" style="overflow-x: hidden;">
                <button id="printData" class="btn btn-success mx-1"><i class="fa fa-print"></i> Print</button>
                <a href="shares.php" class="btn btn-default mx-1">Go Back</a>
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
                            $total_remittance = 0;
                            $total_retention = 0;    
                            $total_or = 0;
                            $total_withdrawal = 0;
                            $total_dividend = 0;
                        ?>
                    </tbody>
                </table>
                <div id="hiddenTable">
                    <form action="forms/print_shares2.php" method="post">
                        <table>
                            <?php
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
                                    <th>dividend</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    while($row = $result->fetch_assoc()){
                                ?>
                                <tr>
                                    <input type="hidden" name="num[]" value="<?php echo $i?>">
                                    <td><input type="text" name="remittance[]" value="<?php echo $row['remittance']?>"><?php echo $row['remittance']?></td>
                                    <td><input type="text" name="retention[]" value="<?php echo $row['retention']?>"><?php echo $row['retention']?></td>
                                    <td><input type="text" name="floatOR[]" value="<?php echo $row['floatOR']?>"><?php echo $row['floatOR']?></td>
                                    <td><input type="text" name="withdrawal[]" value="<?php echo $row['withdrawal']?>"><?php echo $row['withdrawal']?></td>
                                    <td><input type="text" name="dividend[]" value="<?php echo $row['dividend']?>"><?php echo $row['dividend']?></td>
                                    <td><input type="text" name="date[]" value="<?php echo date("F j, Y", strtotime($row['date']));?>"><?php echo date("F j, Y", strtotime($row['date']));?></td>
                                </tr>
                                <?php
                                    $i++;
                                    $total_remittance = $total_remittance + $row['remittance'];
                                    $total_retention = $total_retention + $row['retention'];    
                                    $total_or = $total_or + $row['floatOR'];
                                    $total_withdrawal = $total_withdrawal + $row['withdrawal'];
                                    $total_dividend = $total_dividend + $row['dividend'];
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <input type="text" name="member_id" value="<?php echo $member_id ?>">
                        <input type="text" name="name" value="<?php echo $lastname . ", " . $firstname . " " . $middleinitial . "." ?>">
                        <input type="text" name="total_remittance" value="<?php echo $total_remittance ?>">
                        <input type="text" name="total_retention" value="<?php echo $total_retention ?>">
                        <input type="text" name="total_or" value="<?php echo $total_or ?>">
                        <input type="text" name="total_withdrawal" value="<?php echo $total_withdrawal ?>">
                        <input type="text" name="total_dividend" value="<?php echo $total_dividend ?>">
                        <input type="submit" hidden id="printBtn" value="submit">
                    </form>
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
                        $query = "SELECT * 
                                    FROM `tbl_shares`
                                    WHERE tbl_shares.date BETWEEN '$fromdate' AND '$todate'
                                    AND member_id = $member_id
                                    ORDER BY `date`";
                        $result = $conn->query($query);
                    ?>
                    <thead>
                        <tr>
                            <th class="text-center" colspan="6">SHARES FROM <?php echo strtoupper(date("F d, Y",strtotime($fromdate))) ?> TO <?php echo strtoupper(date("F d, Y",strtotime($todate))) ?></th>
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
                            $total_remittance = 0;
                            $total_retention = 0;    
                            $total_or = 0;
                            $total_withdrawal = 0;
                            $total_dividend = 0;
                        ?>
                    </tbody>
                </table>
                <div id="hiddenTable2">
                    <form action="forms/print_shares2.php" method="post">
                        <table>
                            <?php
                                $query = "SELECT * 
                                          FROM `tbl_shares`
                                          WHERE tbl_shares.date BETWEEN '$fromdate' AND '$todate'
                                          AND member_id = $member_id
                                          ORDER BY `date`";
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
                                <?php 
                                    $i = 1;
                                    while($row = $result->fetch_assoc()){
                                ?>
                                <tr>
                                    <input type="hidden" name="num[]" value="<?php echo $i?>">
                                    <td><input type="text" name="remittance[]" value="<?php echo $row['remittance']?>"><?php echo $row['remittance']?></td>
                                    <td><input type="text" name="retention[]" value="<?php echo $row['retention']?>"><?php echo $row['retention']?></td>
                                    <td><input type="text" name="floatOR[]" value="<?php echo $row['floatOR']?>"><?php echo $row['floatOR']?></td>
                                    <td><input type="text" name="withdrawal[]" value="<?php echo $row['withdrawal']?>"><?php echo $row['withdrawal']?></td>
                                    <td><input type="text" name="dividend[]" value="<?php echo $row['dividend']?>"><?php echo $row['dividend']?></td>
                                    <td><input type="text" name="date[]" value="<?php echo date("F j, Y", strtotime($row['date']));?>"><?php echo date("F j, Y", strtotime($row['date']));?></td>
                                </tr>
                                <?php
                                    $i++;
                                    $total_remittance = $total_remittance + $row['remittance'];
                                    $total_retention = $total_retention + $row['retention'];    
                                    $total_or = $total_or + $row['floatOR'];
                                    $total_withdrawal = $total_withdrawal + $row['withdrawal'];
                                    $total_dividend = $total_dividend + $row['dividend'];
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <input type="text" name="member_id" value="<?php echo $member_id ?>">
                        <input type="text" name="name" value="<?php echo $lastname . ", " . $firstname . " " . $middleinitial . "." ?>">
                        <input type="text" name="total_remittance" value="<?php echo $total_remittance ?>">
                        <input type="text" name="total_retention" value="<?php echo $total_retention ?>">
                        <input type="text" name="total_or" value="<?php echo $total_or ?>">
                        <input type="text" name="total_withdrawal" value="<?php echo $total_withdrawal ?>">
                        <input type="text" name="total_dividend" value="<?php echo $total_dividend ?>">
                        <input type="hidden" name="filter" value="1">
                        <input type="hidden" name="fromdate" value="<?php echo $fromdate ?>">
                        <input type="hidden" name="todate" value="<?php echo $todate ?>">
                        <input type="submit" hidden id="printBtn" value="submit">
                    </form>
                </div>
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
    <div id="hiddenForm">
        <form action="try" id="member_id_form" method="post">
            <input type="hidden" name="member_id" value="<?php echo $member_id?>">
            <input type="submit" id="btnSubmit" value="submit">
        </form>
    </div>
    <!-- END PAGE CONTENT-->
<?php  include('include/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function(){

        $('#hiddenTable').hide();

        $('#hiddenTable2').hide();

        $('#hiddenForm').hide();

        $('#loans_table').DataTable({});

        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != "" && to_date != "") {
                $('#member_id_form').attr('action', "shares3.php?filter="+from_date+" "+to_date);
                $( "#btnSubmit" ).trigger( "click" );
            } else {
                alert("Select date range.");
            }
        });

        $('#cancel').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != "" && to_date != "") {
                $('#member_id_form').attr('action', "shares3.php");
                $( "#btnSubmit" ).trigger( "click" );
            }
        });

        $('#printData').click(function () {
            $( "#printBtn" ).trigger( "click" );
        });
    });
</script>
<?php include ('modal/modal_add.php');?>