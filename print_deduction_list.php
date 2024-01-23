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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Deduction List</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="./assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="./assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/overwrite.css">
</head>
<style>
    @media print {
        #hidden {
            visibility: hidden;
            height: 0px;
            width: 0px;
        }
    }
</style>
<body style="background: #ffffff;" onload="print()">
    <!-- START PAGE CONTENT-->
    <div class="d-flex justify-content-center">
        <div class="pe-3">
            <img width="70px" height="70px" src="assets/img/coop logo.png">
        </div>
        <div class="d-flex flex-column align-items-center">
            <p class="m-0 small-font">Republic of the Philippines</p>
            <p class="m-0 small-font">TAGAYTAY CITY GOVERNMENT EMPLOYEE MULTI-PURPOSE COOPERATIVE</p>
            <p class="m-0 small-font">Tagaytay City</p>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <h5 class="text-center mt-4">TCGEMPC DEDUCTION FOR <?php echo strtoupper(date("F"))." ".date("Y"); ?></h5>
    </div>
    <div class="d-flex justify-content-end mr-5 mb-4" id="hidden">
        <a href="payments.php" class="btn btn-default">Go Back To Payments</a>
    </div>
    <div class="d-flex justify-content-center">
        <table class="table table-bordered">
            <thead>
                <?php
                    $query = "SELECT *, tbl_loan_list.loan_id, tbl_loan_list.application_number, tbl_loan_list.member_id, tbl_members_info.lastname, tbl_members_info.firstname
                            FROM `tbl_payment`
                            LEFT JOIN `tbl_loan_list`
                            ON tbl_payment.loan_id = tbl_loan_list.loan_id
                            LEFT JOIN `tbl_members_info`
                            ON tbl_loan_list.member_id = tbl_members_info.member_id                          
                            WHERE `payment_status` = 'unconfirmed'";
                    $result = $conn->query($query);
                ?>
                <tr>
                    <th width="30%">Application Number</th>
                    <th width="40%">Employee Name</th>
                    <th width="30%">Deduction Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($row = $result->fetch_assoc()){ 
                ?>
                <tr>
                    <td><?php echo $row['application_number']?></td>
                    <td><?php echo strtoupper($row['lastname']) , ", " , strtoupper($row['firstname'])?></td>
                    <td><?php echo $row['payment_amount']?></td>
                </tr>
                <?php 
                    } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>