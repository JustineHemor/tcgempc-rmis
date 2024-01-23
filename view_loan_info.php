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
if ($user_type == 'member') {
    header("Location: index.php");
}
?>
<?php
    $loan_id  = $_GET['loan_id'];
    $encrypted_loan_id = $_GET['loan_id'];
    $hashed = $_GET['hashed'];
    $salt = "cV0puOlxgX09Klm";
    $hash = md5($salt . $loan_id);
    if ($hash === $hashed) {
        $loan_id = round(($loan_id * 2) / 91824826);
    } else {
        header("Location: loan_list.php");
    }
    $sql = "SELECT *, tbl_members_info.lastname, tbl_members_info.firstname, tbl_loan_type.loan_type, tbl_comaker.member_id as comaker_member_id
            FROM `tbl_loan_list`
            LEFT JOIN `tbl_members_info`
            ON tbl_loan_list.member_id = tbl_members_info.member_id
            LEFT JOIN `tbl_loan_type`
            ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
            LEFT JOIN `tbl_comaker`
            ON tbl_loan_list.comaker_id = tbl_comaker.comaker_id
            WHERE loan_id = $loan_id";
    $result = mysqli_query($conn, $sql);
    $loanlistRow = mysqli_fetch_assoc($result);
    $comaker_member_id = $loanlistRow['comaker_member_id'];
    $sql1 = "SELECT * FROM `tbl_members_info` WHERE member_id = $comaker_member_id";
    $res = mysqli_query($conn, $sql1);
    $comakerRow = mysqli_fetch_assoc($res);
?>
<?php include('include/header_sidebar.php'); ?>
<?php include('modal/modal_update.php'); ?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-heading">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div id="alert" class="alert alert-' . $_SESSION["msg_type"] . '">' . $_SESSION["message"] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <h1 class="page-title"></h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Member's Loan Information</div>
                <div class="ibox-tools">
                    <a href="loan_list.php"><i class="fa fa-close"></i></a>
                </div>
            </div>
            <div class="ibox-body">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Name:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['lastname']),", ",ucfirst($loanlistRow['firstname']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Application Number:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo $loanlistRow['application_number'];?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Loan Type:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['loan_type']);?></p>
                        </div>
                        <div class="col-sm-2">
                        <p class="text-sm-right"><strong>Loan Amount:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo number_format($loanlistRow['loan_amount'],2);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Monthly Payable:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo number_format($loanlistRow['monthly_payable_amount'],2);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Loan Balance:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo number_format($loanlistRow['loan_balance'],2);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Interest:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_interest"><?php echo number_format($loanlistRow['total_interest'],2);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Payable Amount:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_payable_amount"><?php echo number_format($loanlistRow['total_payable_amount'],2);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Service Fee:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_interest"><?php echo number_format($loanlistRow['total_service_fee'],2);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Share Capital:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_payable_amount"><?php echo number_format($loanlistRow['total_share_capital'],2);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Application Date:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ($loanlistRow['application_date']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Payment Term:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['payment_term']);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Comaker:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($comakerRow['lastname']),", ",ucwords($comakerRow['firstname']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Confirmation:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['comaker_confirmation']);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Status:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['status']);?></p>
                        </div>
                        <?php
                            if ($loanlistRow['status'] == "approved" || $loanlistRow['status'] == "renewed" || $loanlistRow['status'] == "complete") {
                        ?>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Approval Date:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['approval_date']);?></p>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong></strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"></p>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <?php
                    if ($loanlistRow['check_number'] != '') {
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Check Number:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['check_number']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong></strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"></p>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($loanlistRow['status'] == 'approved' || $loanlistRow['status'] == 'renewed' || $loanlistRow['status'] == 'complete') {
                    ?>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button class="btn btn-info" data-toggle="modal" data-target="#modalChangeChecknum<?php echo $loan_id ?>">Edit Check Number</button>
                                <button id="viewdv" class="btn btn-info">Disbursement Voucher</button>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
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
        }, 3000);

        $("#viewdv").click(function() {
            window.location="forms/print_disbursement_voucher.php?id=<?php echo $loan_id?>";
        });

    });
</script>