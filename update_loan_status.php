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

if ($user_type != 'credit committee' && $user_type != 'system administrator' && $user_type != 'manager') {
    header("Location: index.php");
}

?>
<?php
    $loan_id  = $_GET['loan_id'];
    $hashed = $_GET['hashed'];
    $salt = "cV0puOlxgX09Klm";
    $hash = md5($salt . $loan_id);
    if ($hash === $hashed) {
        $loan_id = round(($loan_id * 2) / 91824826);
    } else {
        header("Location: loan_list.php");
    }
    $sql = "SELECT *, tbl_members_info.member_id, tbl_members_info.lastname, tbl_members_info.firstname, tbl_loan_type.loan_type, tbl_loan_type.loan_interest, tbl_comaker.member_id as comaker_member_id
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
    $memberID = $loanlistRow['member_id'];
    $sql1 = "SELECT * FROM `tbl_members_info` WHERE member_id = $comaker_member_id";
    $res = mysqli_query($conn, $sql1);
    $comakerRow = mysqli_fetch_assoc($res);
?>
<?php include('include/header_sidebar.php'); ?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-heading">
        <h1 class="page-title"></h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Update Loan Status</div>
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
                            <p class="text-left" id="text_loan_amount"><?php echo ucwords($loanlistRow['loan_amount']);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Monthly Payable:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ucwords($loanlistRow['monthly_payable_amount']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Payment Term:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_payment_term"><?php echo ucwords($loanlistRow['payment_term']);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Interest:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_interest"><?php echo ucwords($loanlistRow['total_interest']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Payable Amount:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_payable_amount"><?php echo ucwords($loanlistRow['total_payable_amount']);?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Service Fee:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_interest"><?php echo ucwords($loanlistRow['total_service_fee']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong>Share Capital:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left" id="text_total_payable_amount"><?php echo ucwords($loanlistRow['total_share_capital']);?></p>
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
                            <p class="text-sm-right"><strong>Application Date:</strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"><?php echo ($loanlistRow['application_date']);?></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-sm-right"><strong></strong></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="text-left"></p>
                        </div>
                    </div>
                    <?php
                        $manager_id = $_SESSION['member_id'];
                        $sql = "SELECT *
                                FROM `tbl_user_accounts` 
                                WHERE member_id = $manager_id";
                        $res = mysqli_query($conn, $sql);
                        $usertypeRow = mysqli_fetch_assoc($res);
                        $user_type = $usertypeRow['user_type'];
                        if ($user_type == 'credit committee' || $user_type == 'system administrator') { 
                    ?>
                        <div class="row justify-content-center mb-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalEditLoan<?php echo $loan_id ?>">Edit Loan</button>
                        </div>
                    <?php
                        }  
                    ?>
                    
                    <?php
                        $payment_term = $loanlistRow['payment_term'];
                        $explodedValue = explode(' ',$payment_term);
                        $input_payment_term = $explodedValue[0];
                    ?>
                    <form action="functions/update.php?action=status_value" method="POST">
                        <div class="row justify-content-center">
                            <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type;?>">
                            <input type="hidden" name="renewed" id="renewed" value="<?php echo ($loanlistRow['renewed']);?>">
                            <input type="hidden" name="total_share_capital" id="total_share_capital" value="<?php echo ($loanlistRow['total_share_capital']);?>">
                            <input type="hidden" name="total_service_fee" id="total_service_fee" value="<?php echo ($loanlistRow['total_service_fee']);?>">
                            <input type="hidden" name="input_loan_amount" id="input_loan_amount" value="<?php echo ($loanlistRow['loan_amount']);?>">
                            <input type="hidden" name="input_payment_term" id="input_payment_term" value="<?php echo $input_payment_term?>">
                            <input type="hidden" name="total_interest" id="total_interest" value="<?php echo ($loanlistRow['total_interest']);?>">
                            <input type="hidden" name="total_payable_amount" id="total_payable_amount" value="<?php echo ($loanlistRow['total_payable_amount']);?>">
                            <input type="hidden" name="monthly_payable_amount" id="monthly_payable_amount" value="<?php echo ($loanlistRow['monthly_payable_amount']);?>">

                            <input type="hidden" id="managerID" name="managerID" value="<?php echo $_SESSION['member_id'] ?>">
                            <input type="hidden" id="loan_id" name="loan_id" value="<?php echo $loan_id?>">
                            <input type="hidden" id="member_id" name="member_id" value="<?php echo $memberID?>">
                            <button class="btn btn-danger" name="requestDecline" value="decline">Decline</button>
                            <button class="btn btn-success ml-3" name="requestApprove" value="approve">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<?php include('include/footer.php'); ?>
<?php include('modal/modal_update.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('#table').hide();

        $('#btnCalculate').click(function(e) {
            e.preventDefault();
            let P = Number($('#loan_amount').val());
            let r = $('#loan_int').val();
            let n = $('#payment_term').val();

            let monthly_payable_amount = (P / n) + (P * r);
            let principal = (P / n);
            let interest = (P * r);
            let balance = P - (P / n);

            let counter = n;

            let totalInterest = 0;
            let totalPrincipal = 0;
            let PayableAmount = 0;
            let MonthPayableAmount = monthly_payable_amount;

            while (counter > 0) {
                totalPrincipal = totalPrincipal + principal;
                totalInterest = totalInterest + interest;
                PayableAmount = P + totalInterest;

                interest = balance * r;
                principal = monthly_payable_amount - interest;
                balance = balance - principal;
                if (balance < 0) {
                    monthly_payable_amount = monthly_payable_amount + balance;
                    principal = monthly_payable_amount - interest;
                    balance = 0;
                }
                
                counter = counter - 1;
            }

            $('#table').show();
            $('#table_total_interest').text(totalInterest.toFixed(2));
            $('#table_total_payable_amount').text(PayableAmount.toFixed(2));
            $('#table_monthly_payable_amount').text(MonthPayableAmount.toFixed(2));
        });

        $('.btnEditLoan').click(function() {
            if (($('#table_total_interest').text()) == 0.00) {
                alert("Please calculate");
            } else { 

                //Form hidden
                $('#total_interest').val($('#table_total_interest').text());
                $('#total_payable_amount').val($('#table_total_payable_amount').text());
                $('#monthly_payable_amount').val($('#table_monthly_payable_amount').text());
                $('#input_loan_amount').val($('#loan_amount').val());
                $('#input_payment_term').val($('#payment_term').val());

                //Visible
                $('#text_total_interest').text($('#table_total_interest').text());
                $('#text_total_payable_amount').text($('#table_total_payable_amount').text());
                $('#text_monthly_payable_amount').text($('#table_monthly_payable_amount').text());
                $('#text_loan_amount').text($('#loan_amount').val());
                $('#text_payment_term').text($('#payment_term').val()+" Months");

                //Close Modal
                $(".btnclsEditLoan").trigger("click");
            }
        });

        $('.btnclsEditLoan,.close').click(function() {
            $('#table').hide();
            $('#table_total_interest').text("0.00");
            $('#table_total_payable_amount').text("0.00");
            $('#table_monthly_payable_amount').text("0.00");

        });

    });
</script>