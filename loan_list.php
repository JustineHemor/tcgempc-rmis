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
<?php $loggedinmember_id = $_SESSION['member_id']; ?>
<?php include('include/header_sidebar.php'); ?>
<?php include('modal/modal_add.php'); ?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <?php
    $search = "";
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    }
    ?>
    <div class="page-heading">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div id="alert" class="alert alert-' . $_SESSION["msg_type"] . '">' . $_SESSION["message"] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <h1 class="page-title">Loan List</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head justify-content-end" style="overflow-x: hidden;">
                <div class="ibox-title">
                    <?php
                    if ($user_type == 'system administrator' || $user_type == 'secretary') {
                    ?>
                        <div class="row" style="overflow-x: hidden;">
                            <button class="btn btn-success m-r-5" data-toggle="modal" data-target="#modalMemberLoanRequest"><i class="fa fa-plus"></i> Request Loan</button>
                            <a href="loan_renewal.php" class="btn btn-success m-r-5"><i class="fa fa-plus"></i> Renew Loan</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="ibox-body" style="overflow-x: scroll;">
                <table class="table table-striped table-bordered table-hover" id="loans_table" cellspacing="0" width="100%">
                    <?php
                    $query = "SELECT tbl_loan_list.loan_id, tbl_loan_list.application_number, tbl_members_info.member_number, tbl_members_info.lastname, tbl_members_info.firstname, tbl_loan_type.loan_type, tbl_loan_list.loan_amount, tbl_loan_list.loan_balance, tbl_loan_list.payment_term, tbl_loan_list.status 
                              FROM `tbl_loan_list`
                              LEFT JOIN `tbl_members_info` 
                              ON tbl_loan_list.member_id = tbl_members_info.member_id
                              LEFT JOIN `tbl_loan_type` 
                              ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id";
                    $result = $conn->query($query);
                    ?>
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Name</th>
                            <th width="15%">Loan Type</th>
                            <th width="10%">Amount</th>
                            <th width="10%">Balance</th>
                            <th width="15%">Payment Term</th>
                            <th width="10%">Status</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <?php
                            $status = '';
                            $remarks = '';
                            if ($row['status'] == 'for approval') {
                                $status = 'warning';
                                $remarks = $row['status'];
                            } elseif ($row['status'] == 'declined') {
                                $status = 'danger';
                                $remarks = $row['status'];;
                            } elseif ($row['status'] == 'approved') {
                                $status = 'success';
                                $remarks = 'active';
                            } elseif ($row['status'] == 'complete') {
                                $status = 'info';
                                $remarks = $row['status'];
                            } elseif ($row['status'] == 'cancelled') {
                                $status = 'secondary';
                                $remarks = $row['status'];
                            } elseif ($row['status'] == 'renewed') {
                                $status = 'primary';
                                $remarks = $row['status'];
                            }
                            ?>
                            <tr>
                                <td><small><?php echo strtoupper($row['application_number']) ?></small></td>
                                <td><small><?php echo strtoupper($row['lastname']), ", ", strtoupper($row['firstname']) ?></small></th>
                                <td><small><?php echo strtoupper($row['loan_type']) ?></small></td>
                                <td><small><?php echo number_format($row['loan_amount'],2) ?></small></td>
                                <td><small><?php echo number_format($row['loan_balance'],2) ?></small></td>
                                <td><small><?php echo strtoupper($row['payment_term']) ?></small></td>
                                <td class="text-center"><small><span class="badge badge-<?php echo $status ?> badge-pill m-r-5 m-b-5"><?php echo ucwords($remarks) ?></span></small></td>
                                <td class="text-center">
                                    <?php
                                    $loan_id = (($row['loan_id']) * 91824826 / 2);
                                    $salt = "cV0puOlxgX09Klm";
                                    $hashed = md5($salt . $loan_id);
                                    $VLIlink = "view_loan_info.php?loan_id=" . $loan_id . "&hashed=" . $hashed;
                                    $LPHlink = "loan_payment_history.php?loan_id=" . $loan_id . "&hashed=" . $hashed;
                                    $ULSlink = "update_loan_status.php?loan_id=" . $loan_id . "&hashed=" . $hashed;
                                    ?>
                                    <a class="btn btn-primary btn-outline-primary btn-xs m-r-5" href="<?php echo $VLIlink?>"><i class="fa fa-search"></i> View</a>

                                    <?php
                                    if ($user_type == 'manager' || $user_type == 'credit committee' || $user_type == 'system administrator') {
                                        if ($row['status'] == 'for approval') {
                                            if ($row['status'] != 'cancelled') {
                                    ?>
                                                <a class="btn btn-primary btn-outline-primary btn-xs m-r-5" href="<?php echo $ULSlink?>"><i class="fa fa-edit"></i> Edit</a>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>

                                    <?php
                                    if ($row['status'] == 'approved' || $row['status'] == 'complete' || $row['status'] == 'renewed') {
                                    ?>
                                        <a class="btn btn-primary btn-outline-primary btn-xs m-r-5" href="<?php echo $LPHlink?>"><i class="fa fa-money"></i> Payments</a>
                                    <?php
                                    }
                                    ?>
                                    </th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<?php include('include/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#loans_table').DataTable({
            "search": {
                "search": "<?php echo $search ?>"
            },
            order:[[0,"desc"]]
        });

        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 5000);

        $('.member_id').change(function() {
            var member_id = $(this).val();
            $.ajax({
                url: "functions/fetch.php?action=fetch_members",
                method: "POST",
                data: {
                    member_id: member_id
                },
                success: function(data) {
                    $("#comaker_id").html(data);
                }
            });
        });

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
                let P = Number($('#loan_amount').val());
                let r = $('#loan_type_id').val().split(',')[1];
                let service_fee = $('#loan_type_id').val().split(',')[2];
                let share_capital = $('#loan_type_id').val().split(',')[3];
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