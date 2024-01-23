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
if ($user_type != 'system administrator') {
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
        <h1 class="page-title">Disbursement Voucher</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head" style="overflow-x: hidden;">
                        <div class="ibox-title">Disbursement Voucher Form</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Member's Name</label>
                                <?php
                                    $loggedinmember_id = $_SESSION['member_id'];
                                    $memberSet = $conn->query("SELECT * FROM tbl_members_info WHERE employment_status = 'Active' AND member_id != $loggedinmember_id"); 
                                ?>
                                <select name="member_name" id="member_name" class="form-control select2_demo_1 member_id" style="width: 100%;" required>
                                    <option selected disabled value="">Select</option>
                                    <?php
                                        while ($rows = $memberSet->fetch_assoc()) {
                                            $firstname = strtoupper($rows['firstname']);
                                            $lastname = strtoupper($rows['lastname']);
                                    ?>
                                    <option value="<?php echo $lastname.", ".$firstname?>"><?php echo $lastname.", ".$firstname?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Amount</label>
                                <input name="amount" id="amount" required class="form-control" type="number" placeholder="">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary" id="viewjv">Confirm</button>
                        </div>
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
        $("#viewjv").click(function() {
            const name = $('#member_name').val();
            const amount = $('#amount').val();
            const vourcher_type = "dv";
            window.location="forms/print_voucher.php?name=" + name + "&amount=" + amount + "&voucher=" + vourcher_type;
        });
    });
</script>