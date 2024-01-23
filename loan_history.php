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
<?php $member_id = $_SESSION['member_id']; ?>
<?php include('include/header_sidebar.php'); ?>
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
            <h1 class="page-title">Personal Loan History</h1>
        </div>
        <div class="page-content fade-in-up">
            <div class="ibox">
                <div class="ibox-head justify-content-end mr-3">
                    <div class="ibox-title">
                        <a href="loan_request.php" class="btn btn-success"><i class="fa fa-plus"></i> Request Loan</a></a>
                    </div>
                </div>
                <div class="ibox-body" style="overflow-x: scroll;">
                    <table class="table table-striped table-bordered table-hover" id="yourLoans_table" cellspacing="0" width="100%">
                        <?php
                            $reload = 0;
                            $sql5 = "SELECT * FROM `tbl_loan_list` WHERE `member_id` = $member_id and `notification_1` = 1";
                            $rslt = $conn->query($sql5);
                            if (mysqli_num_rows($rslt) > 0) {
                                $sql4 = "UPDATE `tbl_loan_list` SET `notification_1` = '0' WHERE member_id = $member_id";
                                if ($conn->query($sql4) === TRUE) {
                                }
                                $reload = 1;
                            }
                            
                            $query = "SELECT *, tbl_loan_type.loan_type
                            FROM `tbl_loan_list`
                            LEFT JOIN `tbl_loan_type` 
                            ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                            WHERE member_id = $member_id";
                            $result = $conn->query($query);
                        ?>
                        <thead>
                            <tr>
                                <th>Application Number</th>
                                <th>Loan Type</th>
                                <th>Amount</th>
                                <th>Balance</th>
                                <th>Payment Term</th>
                                <th>Status</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()){ ?>
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
                                <td><small><?php echo strtoupper($row['application_number'])?></small></td>
                                <td><small><?php echo strtoupper($row['loan_type'])?></small></td>
                                <td><small><?php echo number_format($row['loan_amount'],2)?></small></td>
                                <td><small><?php echo number_format($row['loan_balance'],2)?></small></td>
                                <td><small><?php echo strtoupper($row['payment_term'])?></small></td>
                                <td class="text-center"><small><span class="badge badge-<?php echo $status?> badge-pill m-r-5 m-b-5"><?php echo ucwords($remarks)?></span></small></td>
                                <td class="text-center">
                                    <?php
                                    $loan_id = (($row['loan_id']) * 91824826 / 2);
                                    $salt = "cV0puOlxgX09Klm";
                                    $hashed = md5($salt . $loan_id);
                                    $VLHlink = "view_loan_history.php?loan_id=" . $loan_id . "&hashed=" . $hashed;
                                    $VPHlink = "view_payment_history.php?loan_id=" . $loan_id . "&hashed=" . $hashed;
                                    ?>
                                    <a class="btn btn-primary btn-outline-primary btn-xs m-r-5" href="<?php echo $VLHlink?>"><i class="fa fa-search"></i> Info</a>
                                    <?php
                                        if ($row['status'] == 'approved' || $row['status'] == 'complete' || $row['status'] == 'renewed') {
                                    ?>
                                        <a class="btn btn-primary btn-outline-primary btn-xs m-r-5" href="<?php echo $VPHlink?>"><i class="fa fa-money"></i> Payments</a>
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
    $(document).ready(function(){

        $('#yourLoans_table').DataTable({
            "search": {
                "search": "<?php echo $search ?>"
            },
            order:[[0,"desc"]]
        });

        var reload = <?php echo $reload ?>;

        if (reload == 1) {
            window.location="loan_history.php"
        }
        
        setTimeout(function(){
            document.getElementById("alert").style.display = "none";
        }, 5000);
    });
</script>