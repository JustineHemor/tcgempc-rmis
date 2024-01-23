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
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div id="alert" class="alert alert-' . $_SESSION["msg_type"] . '">' . $_SESSION["message"] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <h1 class="page-title">Loan Renew</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head" style="overflow-x: hidden;">
                        <div class="ibox-title">Loan Renew Form</div>
                        <div class="ibox-tools">
                            <a id="back"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form method="POST" action="functions/insert.php?action=renew_loan">
                            <?php
                            $member_id = $_SESSION['member_id'];
                            $sql = "SELECT *
                                    FROM `tbl_members_info` 
                                    WHERE member_id = $member_id";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            ?>
                            <div class="row">
                                <input type="hidden" id="date_today" name="date_today" value="<?php echo date('Y-m-d') ?>">
                                <input type="hidden" id="membership_date" name="membership_date" value="<?php echo $row['membership_date'] ?>">
                                <input type="hidden" name="member_id" id="member_id" required class="form-control" value="<?php echo $member_id; ?>">
                                <div class="col-sm-12 form-group">
                                    <label>Select Loan</label>
                                    <?php $loanlistSet = $conn->query("SELECT *, tbl_loan_type.loan_type_id
                                                                       FROM tbl_loan_list
                                                                       LEFT JOIN tbl_loan_type
                                                                       ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                                                                       WHERE `status` = 'approved'
                                                                       AND `member_id` = $member_id"); 
                                    ?>
                                    <select name="loan_type_id" id="loan_type_id" class="form-control loan_type_id select2_demo_1" style="width: 100%;" required>
                                        <option selected disabled value="">Application Number || Loan Type || Amount || Balance || Payment Term</option>
                                        <?php
                                        $loan_interest = 0;
                                        while ($rows = $loanlistSet->fetch_assoc()) {
                                            $loan_type = $rows['loan_type'];
                                            $loan_type_id = $rows['loan_type_id'];
                                            $loan_interest = $rows['loan_interest'];
                                            $loan_id = $rows['loan_id'];
                                            $application_number = $rows['application_number'];
                                            $loan_amount = $rows['loan_amount'];
                                            $loan_balance = $rows['loan_balance'];
                                            $payment_term = $rows['payment_term'];
                                            $service_fee = $rows['service_fee'];
                                            $share_capital = $rows['share_capital'];
                                        ?>
                                            <option value="<?php echo $loan_type_id ?>,<?php echo $loan_interest ?>,<?php echo $loan_id ?>,<?php echo $loan_balance ?>,<?php echo $service_fee ?>,<?php echo $share_capital ?>"><?php echo $application_number . " || " . $loan_type . " || " . $loan_amount . " || " . round($loan_balance,2) . " || " . $payment_term?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>Loan Amount</label>
                                    <input name="loan_amount" id="loan_amount" required class="form-control" type="number" placeholder="Loan Amount">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>Payment Term</label>
                                    <select name="payment_term" id="payment_term" class="form-control select2_demo_1" style="width: 100%;" required>
                                        <option selected value="">Select</option>
                                        <?php
                                        $i = 1;
                                        while ($i <= 36) {
                                            echo "<option value='$i'>$i Months</option>";
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>Co-maker</label>
                                    <?php $memberSet = $conn->query(
                                        "SELECT *, tbl_members_info.member_id
                                            FROM tbl_comaker
                                            LEFT JOIN tbl_members_info
                                            ON tbl_comaker.member_id = tbl_members_info.member_id
                                            WHERE tbl_comaker.member_id != $member_id
                                            AND tbl_members_info.employment_status = 'Active'"
                                    ); ?>
                                    <select name="comaker_id" id="comaker_id" class="form-control select2_demo_1" required>
                                        <option selected disabled value="">Select</option>
                                        <?php
                                        while ($rows = $memberSet->fetch_assoc()) {
                                            $comaker_id = $rows['comaker_id'];
                                            $lastname = strtoupper($rows['lastname']);
                                            $firstname = strtoupper($rows['firstname']);
                                            echo "<option value='$comaker_id'>$lastname, $firstname</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center my-3">
                                <button class="btn btn-primary" id="btnCalculate">Calculate</button>
                            </div>
                            <div class="row justify-content-center" id="table">
                                <table style="width:75%">
                                    <tr>
                                        <th width="30%" class="text-center">Total Interest</th>
                                        <th width="30%" class="text-center">Total Payable Amount</th>
                                        <th width="30%" class="text-center">Monthly Payable Amount</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center" id="table_total_interest">0.00</td>
                                        <td class="text-center" id="table_total_payable_amount">0.00</td>
                                        <td class="text-center" id="table_monthly_payable_amount">0.00</td>
                                    </tr>
                                </table>
                                <table class="mt-3" style="width:75%">
                                    <tr>
                                        <th width="50%" class="text-center">Service Fee</th>
                                        <th width="50%" class="text-center">Share Capital</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center" id="table_service_fee">0.00</td>
                                        <td class="text-center" id="table_share_capital">0.00</td>
                                    </tr>
                                </table>
                                <input type="hidden" name="total_service_fee" id="total_service_fee">                               
                                <input type="hidden" name="total_share_capital" id="total_share_capital">
                                <input type="hidden" name="total_interest" id="total_interest">                               
                                <input type="hidden" name="total_payable_amount" id="total_payable_amount">
                                <input type="hidden" name="monthly_payable_amount" id="monthly_payable_amount">
                                <input type="hidden" name="payment_count" id="payment_count">
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" id="btnSubmit" class="btn btn-primary mt-4">Submit</button>
                            </div>
                        </form>
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

        $('#back').click(function () {
            window.location="loan_request.php";
        });

        setTimeout(function(){
            document.getElementById("alert").style.display = "none";
        }, 5000);

        $('#table').hide();
        $('#btnSubmit').hide();

        $('#btnCalculate').click(function(e) {
            e.preventDefault();
            if (($('#loan_amount').val() == "")) {
                alert("Please enter value.");
            } else if (($('#loan_type_id').val() == "")) {
                alert("Please enter value.");
            } else if (($('#payment_term').val() == "")) {
                alert("Please enter value.");
            } else {
                $('#btnSubmit').show();
                let P = (Number($('#loan_amount').val()));
                let r = $('#loan_type_id').val().split(',')[1];
                let service_fee = $('#loan_type_id').val().split(',')[4];
                let share_capital = $('#loan_type_id').val().split(',')[5];
                let n = $('#payment_term').val();

                let total_service_fee = P * service_fee;
                let total_share_capital = P * share_capital;

                let monthly_payable_amount = (P / n) + (P * r);
                let principal = (P / n);
                let interest = (P * r);
                let balance = P - (P / n);

                let counter = n;

                let totalInterest = 0;
                let totalPrincipal = 0;
                let PayableAmount = 0;
                let payment_count = 1;
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

                    if (principal > 0) {
                        payment_count++;
                    }                  
                    
                    counter = counter - 1;
                }

                $('#table').show();
                $('#table_total_interest').text(totalInterest.toFixed(2));
                $('#table_total_payable_amount').text(PayableAmount.toFixed(2));
                $('#table_monthly_payable_amount').text(MonthPayableAmount.toFixed(2));
                $('#table_service_fee').text(total_service_fee.toFixed(2));
                $('#table_share_capital').text(total_share_capital.toFixed(2));
                $('#total_service_fee').val(total_service_fee.toFixed(2));
                $('#total_share_capital').val(total_share_capital.toFixed(2));
                $('#total_interest').val(totalInterest.toFixed(2));
                $('#total_payable_amount').val(PayableAmount.toFixed(2));
                $('#monthly_payable_amount').val(MonthPayableAmount.toFixed(2));
                $('#payment_count').val(payment_count);
            }
        });

    });
</script>