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
    if ($user_type != 'system administrator') {
        header("Location: index.php");
    }
?>
<?php include('include/header_sidebar.php');?>
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div id="alert" class="alert alert-'.$_SESSION["msg_type"].'">'.$_SESSION["message"].'</div>';
                        unset($_SESSION['message']);
                    }
                ?>
                <h1 class="page-title">Payments</h1>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head justify-content-end">
                        <div class="ibox-tools">
                            <button class="btn btn-success mx-1" data-toggle="modal" data-target="#modalUploadPayment"><i class="fa fa-upload"></i> Import File</button>
                            <button type="button" id="btn_add_payment" class="btn btn-success mr-3" data-toggle="modal" data-target="#paymentModal"><i class="fa fa-plus"></i> Add Payment</a></button>
                        </div>
                    </div> 
                    <div class="ibox-body" style="overflow-x: scroll;">
                        <table class="table table-striped table-bordered table-hover" id="payments_table" cellspacing="0" width="100%">
                            <?php
                                $query = "SELECT *, tbl_members_info.lastname, tbl_members_info.firstname, tbl_loan_type.loan_type_id
                                          FROM `tbl_loan_list`
                                          LEFT JOIN `tbl_members_info` 
                                          ON tbl_loan_list.member_id = tbl_members_info.member_id
                                          LEFT JOIN `tbl_loan_type` 
                                          ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                                          WHERE `status` = 'approved'";
                                $result = $conn->query($query);
                            ?>
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Member Name</th>
                                    <th>Principal Amount</th>
                                    <th>Interest Amount</th>
                                    <th>Payment Amount</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    while($row = $result->fetch_assoc()){ 
                                        $interest_rate = 0;
                                        $interest = 0;
                                        $loan_balance = 0;
                                        $principal = 0;
                                        if ($row['loan_balance'] < $row['monthly_payable_amount']) {
                                            $interest_rate = $row['loan_interest']; // e.g 0.0275
                                            $loan_balance = $row['loan_balance']; 
                                            $interest = $interest_rate * $loan_balance;
                                            $principal = $loan_balance;
                                            $monthly_payable_amount = $loan_balance + $interest;
                                            $loan_balance = 0;
                                        } else {
                                            $monthly_payable_amount = $row['monthly_payable_amount'];
                                            $interest_rate = $row['loan_interest']; // e.g 0.0275
                                            $loan_balance = $row['loan_balance'];
                                            $interest = $interest_rate * $loan_balance;
                                            $principal = $monthly_payable_amount - $interest;
                                            $loan_balance = $loan_balance - $principal;
                                        } 
                                ?>
                                <tr>
                                    <td><?php echo $row['application_number']?></td>
                                    <td><?php echo strtoupper($row['lastname']) , ", " , strtoupper($row['firstname'])?></td>
                                    <td><?php echo number_format($principal,2)?></td>
                                    <td><?php echo number_format($interest,2)?></td>
                                    <td><?php echo number_format($monthly_payable_amount,2)?></td>
                                    <td><?php echo number_format($loan_balance,2)?></td>
                                </tr>
                                <?php } ?>
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

        $('#payments_table').DataTable({});

        setTimeout(function(){
            document.getElementById("alert").style.display = "none";
        }, 3000);

    });
</script>
<?php include 'modal/modal_add.php';?>
