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
<?php 
$member_id = $_SESSION['member_id'];
$loan_id  = $_GET['loan_id'];
$hashed = $_GET['hashed'];
$salt = "cV0puOlxgX09Klm";
$hash = md5($salt . $loan_id);
if ($hash === $hashed) {
    $loan_id = round(($loan_id * 2) / 91824826);
} else {
    header("Location: loan_history.php");
}
?>
<?php include('include/header_sidebar.php'); ?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-heading">
        <h1 class="page-title">Loan Payment History</h1>
    </div>
    <?php
        $data = 0;
    ?>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head justify-content-end mr-3">
                <div class="ibox-title">
                    <a class="btn btn-default " href="loan_history.php"><i class="fa fa-close"></i></a>
                </div>
            </div>
            <div class="ibox-body" id="info" style="overflow-x: scroll;">
                <div class="row">
                    <div class="col-sm-2">
                        <p><strong>Name of Member :</strong></p>
                    </div>
                    <div class="col-sm-3">
                        <p id="member_name"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p><strong>Co-Maker :</strong></p>
                    </div>
                    <div class="col-sm-3">
                        <p id="comaker_name"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p><strong>Application Number :</strong></p>
                    </div>
                    <div class="col-sm-3">
                        <p id="application_number"></p>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover" id="paymentTable" cellspacing="0" width="100%">
                    <?php
                        $query = "SELECT *, tbl_loan_list.loan_id, tbl_members_info.member_id
                                FROM `tbl_payment`
                                LEFT JOIN `tbl_loan_list` 
                                ON tbl_payment.loan_id = tbl_loan_list.loan_id
                                LEFT JOIN `tbl_members_info` 
                                ON tbl_loan_list.member_id = tbl_members_info.member_id
                                WHERE tbl_payment.loan_id = $loan_id";
                        $result = $conn->query($query);
                    ?>
                    <thead>
                        <tr>
                            <th colspan="1">Terms</th>
                            <th colspan="1">PRINCIPAL</th>
                            <th class="font-italic" colspan="3">TOTAL LOANS RECEIVABLE</th>
                            <th colspan="1"></th>
                            <th class="text-center" colspan="1">Period</th>
                        </tr>
                        <tr>
                            <th>months</th>
                            <th></th>
                            <th class="text-center">Principal</th>
                            <th class="text-center">Interest</th>
                            <th class="text-center"> Total Payment</th>
                            <th class="text-center">Balance</th>
                            <th class="text-center">Covered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_principal = 0;
                            $total_interest = 0;
                            $total_payment = 0;
                            $comaker_member_id = "";
                            while ($row = $result->fetch_assoc()) {
                                if ($row['payment_id'] != "") {
                                    $data = 1;
                                }
                                $comaker_member_id = $row['comaker_id'];
                                $payment_term = preg_replace('/[^0-9.]+/', '', $row['payment_term']);
                                $principal = number_format($row['loan_amount'],2);
                                $application_number = $row['application_number'];
                                $member_name = strtoupper($row['lastname']) . ", " . strtoupper($row['firstname']) . " " . substr($row['middlename'],0,1) . ".";
                                $i = 1;
                                $total_principal = $total_principal + $row['principal'];
                                $total_interest = $total_interest + $row['interest'];
                                $total_payment = $total_payment + $row['payment_amount'];
                        ?>
                            <tr>
                                <td class="text-right" id="pt<?php echo $i ?>"></td>
                                <td class="text-right" id="prin<?php echo $i ?>"></td>
                                <td class="text-right"><?php echo number_format($row['principal'],2) ?></td>
                                <td class="text-right"><?php echo number_format($row['interest'],2) ?></td>
                                <td class="text-right"><?php echo number_format($row['payment_amount'],2) ?></td>
                                <td class="text-right"><?php echo number_format($row['balance'],2) ?></td>
                                <td class="text-right"><?php echo date("F - Y", strtotime($row['payment_date'])); ?></td>
                            </tr>
                        <?php
                            $i++;
                            }
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <th class="text-right"><?php echo number_format($total_principal,2)?></th>
                                <th class="text-right"><?php echo number_format($total_interest,2) ?></th>
                                <th class="text-right"><?php echo number_format($total_payment,2) ?></th>
                                <td></td>
                                <td></td>
                            </tr>
                    </tbody>
                    <?php
                    if ($comaker_member_id != "") {
                        $query = "SELECT *, tbl_members_info.member_id
                              FROM `tbl_comaker`
                              LEFT JOIN `tbl_members_info` 
                              ON tbl_comaker.member_id = tbl_members_info.member_id
                              WHERE comaker_id = $comaker_member_id";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $comaker_name = strtoupper($row['lastname']) . ", " . strtoupper($row['firstname']) . " " . substr($row['middlename'],0,1) . ".";
                        }
                    }
                    
                    ?>
                </table>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<?php include('include/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#pt1').html('<?php echo $payment_term?>');
        $('#prin1').html('<?php echo $principal?>');
        $('#application_number').text('<?php echo $application_number?>');
        $('#comaker_name').text('<?php echo $comaker_name?>');
        $('#member_name').text('<?php echo $member_name?>');
    });
</script>