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
        <title>Deduction List</title>
    </head>
    <body onload="print()">
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
        <h5 class="text-center">TCGEMPC DEDUCTION FOR <?php echo strtoupper(date("F"))." ".date("Y"); ?></h5>
        <br>
        <div class="container">
            <table class="table table-responsive table-bordered">
                <thead>
                    <?php
                        $query = "SELECT *, tbl_members_info.lastname, tbl_members_info.firstname
                                    FROM `tbl_loan_list`
                                    LEFT JOIN `tbl_members_info` 
                                    ON tbl_loan_list.member_id = tbl_members_info.member_id
                                    WHERE `payment_method` = 'every end of month'
                                    OR `payment_method` = 'every half/end of month'";
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
                        <td><?php echo $row['monthly_payable_amount']?></td>
                    </tr>
                    <?php 
                        } 
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>