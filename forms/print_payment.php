<?php include('../include/db_connect.php');?>
<?php
    session_start();  
    if(!isset($_SESSION['member_id'])){
        header("Location: ../login.php");
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION);
        header("Location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=2.0">
        <link href="../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="share-capital.css">
        <style>
            table, th, td {
                font-size: 12px;
            }
            @media print{
                #backBtn, #backBtn *{
                    display: none;
                }
            }
            
        </style>
        <title>Payments</title>
    </head>
    <!-- onload="print()" -->
    <body>
        <div class="d-flex justify-content-center me-4">
            <div class="pe-3">
                <img width="70px" height="70px" src="coop logo.png">
            </div>
            <div class="d-flex flex-column align-items-center">
                <p class="m-0 small-font">Republic of the Philippines</p>
                <p class="m-0 small-font">TAGAYTAY CITY GOVERNMENT EMPLOYEE MULTI-PURPOSE COOPERATIVE</p>
                <p class="m-0 small-font">Tagaytay City</p>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end" id="backBtn">
            <div class="col-sm-2">
                <button class="btn btn-secondary" onclick="history.back()">Go Back To Page</button>
            </div>
        </div>
        <br>
        <br>
        <table class="mb-2">
            <tr>
                <th style="width:200px">Name of Member :</th>
                <td style="width:200px" id="member_name">0</td>
            </tr>
            <tr>
                <th style="width:200px">Co-Maker :</th>
                <td style="width:200px" id="comaker_name">0</td>
            </tr>
            <tr>
                <th style="width:200px">Application Number :</th>
                <td style="width:200px" id="application_number">0</td>
            </tr>
        </table>
        <div class="d-flex justify-content-center">
            <table class="table table-responsive table-bordered">
                <?php
                    $loan_id = $_GET['id'];
                    $query = "SELECT *, tbl_loan_list.loan_id, tbl_members_info.member_id
                            FROM `tbl_payment`
                            LEFT JOIN `tbl_loan_list` 
                            ON tbl_payment.loan_id = tbl_loan_list.loan_id
                            LEFT JOIN `tbl_members_info` 
                            ON tbl_loan_list.member_id = tbl_members_info.member_id
                            WHERE tbl_payment.loan_id = $loan_id";
                    $result = $conn->query($query);
                ?>
                <thead>
                    <tr>
                        <th colspan="1">Terms</th>
                        <th colspan="1">PRINCIPAL</th>
                        <th class="font-italic" colspan="3">TOTAL LOANS RECEIVABLE</th>
                        <th colspan="1"></th>
                        <th class="text-center" colspan="1">Period</th>
                    </tr>
                    <tr>
                        <th>months</th>
                        <th></th>
                        <th class="text-center">Principal</th>
                        <th class="text-center">Interest</th>
                        <th class="text-center"> Total Payment</th>
                        <th class="text-center">Balance</th>
                        <th class="text-center">Covered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_principal = 0;
                        $total_interest = 0;
                        $total_payment = 0;
                        $comaker_member_id = "";
                        while ($row = $result->fetch_assoc()) {
                            if ($row['payment_id'] != "") {
                                $data = 1;
                            }
                            $comaker_member_id = $row['comaker_id'];
                            $payment_term = preg_replace('/[^0-9.]+/', '', $row['payment_term']);
                            $principal = number_format($row['loan_amount'],2);
                            $application_number = $row['application_number'];
                            $member_name = strtoupper($row['lastname']) . ", " . strtoupper($row['firstname']) . " " . substr($row['middlename'],0,1) . ".";
                            $i = 1;
                            $total_principal = $total_principal + $row['principal'];
                            $total_interest = $total_interest + $row['interest'];
                            $total_payment = $total_payment + $row['payment_amount'];
                    ?>
                        <tr>
                            <td class="text-right" id="pt<?php echo $i ?>"></td>
                            <td class="text-right" id="prin<?php echo $i ?>"></td>
                            <td class="text-right"><?php echo number_format($row['principal'],2) ?></td>
                            <td class="text-right"><?php echo number_format($row['interest'],2) ?></td>
                            <td class="text-right"><?php echo number_format($row['payment_amount'],2) ?></td>
                            <td class="text-right"><?php echo number_format($row['balance'],2) ?></td>
                            <td class="text-right"><?php echo date("F - Y", strtotime($row['payment_date'])); ?></td>
                        </tr>
                    <?php
                        $i++;
                        }
                    ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <th class="text-right"><?php echo number_format($total_principal,2)?></th>
                            <th class="text-right"><?php echo number_format($total_interest,2) ?></th>
                            <th class="text-right"><?php echo number_format($total_payment,2) ?></th>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
                <?php
                if ($comaker_member_id != "") {
                    $query = "SELECT *, tbl_members_info.member_id
                            FROM `tbl_comaker`
                            LEFT JOIN `tbl_members_info` 
                            ON tbl_comaker.member_id = tbl_members_info.member_id
                            WHERE comaker_id = $comaker_member_id";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        $comaker_name = strtoupper($row['lastname']) . ", " . strtoupper($row['firstname']) . " " . substr($row['middlename'],0,1) . ".";
                    }
                }
                
                ?>
            </table>
        </div>
    </body>
</html>
<script src="../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#pt1').html('<?php echo $payment_term?>');
        $('#prin1').html('<?php echo $principal?>');
        $('#application_number').text('<?php echo $application_number?>');
        $('#comaker_name').text('<?php echo $comaker_name?>');
        $('#member_name').text('<?php echo $member_name?>');
        window.print(); 
    });
</script>