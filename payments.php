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
                <h1 class="page-title">Payments History</h1>
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
                                $query = "SELECT *, tbl_loan_list.application_number, tbl_members_info.firstname, tbl_members_info.lastname
                                          FROM `tbl_payment`
                                          LEFT JOIN `tbl_loan_list`
                                          ON tbl_payment.loan_id = tbl_loan_list.loan_id
                                          LEFT JOIN `tbl_members_info`
                                          ON tbl_loan_list.member_id = tbl_members_info.member_id
                                          ORDER BY STR_TO_DATE(`tbl_payment`.`payment_date`, '%Y-%m-%d') DESC";
                                $result = $conn->query($query);
                            ?>
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Member Name</th>
                                    <th>Principal</th>
                                    <th>Interest</th>
                                    <th>Payment</th>
                                    <th>Balance</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    while($row = $result->fetch_assoc()){ 
                                ?>
                                <tr>
                                    <td><?php echo $row['application_number']?></td>
                                    <td><?php echo strtoupper($row['lastname']) , ", " , strtoupper($row['firstname'])?></td>
                                    <td><?php echo number_format($row['principal'],2)?></td>
                                    <td><?php echo number_format($row['interest'],2)?></td>
                                    <td><?php echo number_format($row['payment_amount'],2)?></td>
                                    <td><?php echo number_format($row['balance'],2)?></td>
                                    <td><?php echo date("F j, Y", strtotime($row['payment_date']));?></td>
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

        $('#payments_table').DataTable({
            ordering: false
        });

        setTimeout(function(){
            document.getElementById("alert").style.display = "none";
        }, 3000);

        $('#interest_rate_input').hide();

        $('#showIntRate').click(function (e) {
            e.preventDefault();
            $('#interest_rate_input').show();
            $('#interest_rate').attr("required", "true");
        });

    });
</script>
<?php include 'modal/modal_add.php';?>
