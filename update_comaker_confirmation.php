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
    <?php
        $member_id = $_SESSION['member_id'];
        $sql = "SELECT *
                FROM `tbl_comaker`
                WHERE member_id = $member_id";
        $sqlResult = mysqli_query($conn, $sql);
        $sqlRow = mysqli_fetch_assoc($sqlResult);
        $comaker_id = $sqlRow['comaker_id'];

        $sql2 = "SELECT *
                 FROM `tbl_members_info`
                 WHERE member_id = $member_id";
        $sql2Result = mysqli_query($conn, $sql2);
        $sql2Row = mysqli_fetch_assoc($sql2Result);
        
        $sql1 = "SELECT *, tbl_members_info.lastname, tbl_members_info.firstname, tbl_loan_type.loan_type
                 FROM `tbl_loan_list`
                 LEFT JOIN `tbl_members_info`
                 ON tbl_loan_list.member_id = tbl_members_info.member_id
                 LEFT JOIN `tbl_loan_type`
                 ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                 WHERE comaker_id = $comaker_id 
                 AND comaker_confirmation = 'pending'
                 AND `status` != 'cancelled'
                 AND `status` != 'declined'";
        $sql1Result = mysqli_query($conn, $sql1);
    
        if (mysqli_num_rows($sql1Result) > 0) { ?>
            <div class="page-heading">
                <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-'.$_SESSION["msg_type"].'">'.$_SESSION["message"].'</div>';
                        unset($_SESSION['message']);
                    }
                ?>
                <h1 class="page-title">Comaker Confirmation.</h1>
            </div>
            <?php
                while ($sql1Row = mysqli_fetch_assoc($sql1Result)) { 
            ?>
                    <!-- START PAGE CONTENT-->
                    <div class="page-content fade-in-up">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title"><?php echo ucwords($sql1Row['firstname'])." ".ucwords($sql1Row['lastname'])."'s"?> Loan Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Name:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo ucwords($sql1Row['lastname']).", ".ucwords($sql1Row['firstname'])?></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Application Number:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo $sql1Row['application_number']?></p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Loan Type:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo ucwords($sql1Row['loan_type'])?></p>
                                        </div>
                                        <div class="col-sm-2">
                                        <p class="text-sm-right"><strong>Loan Amount:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo $sql1Row['loan_amount']?></p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Payment Term:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo $sql1Row['payment_term'];?></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Monthly Payable:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo $sql1Row['monthly_payable_amount'];?></p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Interest:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left" id="text_total_interest"><?php echo ucwords($sql1Row['total_interest']);?></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Total Amount:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left" id="text_total_payable_amount"><?php echo ucwords($sql1Row['total_payable_amount']);?></p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Service Fee:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left" id="text_total_interest"><?php echo ucwords($sql1Row['total_service_fee']);?></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Share Capital:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left" id="text_total_payable_amount"><?php echo ucwords($sql1Row['total_share_capital']);?></p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Comaker:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo ucwords($sql2Row['lastname']).", ".ucwords($sql2Row['firstname'])?></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Confirmation:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo ucwords($sql1Row['comaker_confirmation'])?></p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Application Date:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo $sql1Row['application_date']?></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-sm-right"><strong>Status:</strong></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-left"><?php echo ucwords($sql1Row['status'])?></p>
                                        </div>
                                    </div>
                                    <form action="functions/update.php?action=comaker_confirmation" method="POST">
                                        <div class="row justify-content-center">
                                            <input type="hidden" id="firstname" name="firstname" value="<?php echo ucwords($sql1Row['firstname']) ?>">
                                            <input type="hidden" id="loan_id" name="loan_id" value="<?php echo $sql1Row['loan_id']?>">
                                            <button class="btn btn-danger" name="requestDecline" value="reject">Reject</button>
                                            <button class="btn btn-success ml-3" name="requestApprove" value="accept">Accept</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT-->
            <?php
                }
            ?>
    <?php
        } else { ?>
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-'.$_SESSION["msg_type"].'">'.$_SESSION["message"].'</div>';
                        unset($_SESSION['message']);
                    }
                ?>
                <h1 class="page-title">No Comaker Confirmation.</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><i class="la la-home font-20"></i></a>
                    </li>
                    <li class="breadcrumb-item">Comaker confirmation not yet availabe.</li>
                </ol>
            </div>
            <!-- END PAGE CONTENT-->
    <?php      
        }
    ?>
</div>
<?php include('include/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>