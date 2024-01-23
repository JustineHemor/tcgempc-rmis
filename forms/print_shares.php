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
                font-size: 10px;
            }

            @media print{
                #backBtn, #backBtn *{
                    display: none;
                }
            }
            
        </style>
        <title>Shares</title>
        <link rel = "icon" type = "image/png" href = "../assets/img/coop logo.png">
    </head>
    <!-- onload="print()" -->
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
        <?php
            if (!isset($_POST['filter'])) {
        ?>
            <h5 class="text-center">TCGEMPC TOTAL SHARES</h5>
        <?php        
            } else {
                $fromdate = strtoupper(date("F d, Y",strtotime($_POST['fromdate'])));
                $todate = strtoupper(date("F d, Y",strtotime($_POST['todate'])));
        ?>
            <h6 class="text-center">TCGEMPC TOTAL SHARES FROM <?php echo $fromdate . " TO " . $todate?></h6>
        <?php        
            }
        ?>
        <br>
        <div class="row justify-content-center py-3" id="backBtn">
            <div class="col-sm-2">
                <button class="btn btn-secondary" onclick="history.back()">Go Back To Page</button>
            </div>
        </div>
        <?php 
            if (isset($_POST['date'])) {
                $th = "Date";
            } else {
                $th = "Total Share Capital";
            }
        ?>
        <div class="row justify-content-center">
            <table style="width: max-content;" class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Remittance</th>
                        <th>Retention</th>
                        <th>OR</th>
                        <th>Withdrawal</th>
                        <th>Dividend</th>
                        <th><?php echo $th?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $ttl_remittance = 0;
                        $ttl_retention = 0;
                        $ttl_floatOR = 0;
                        $ttl_withdrawal = 0;
                        $ttl_dividend = 0;
                        $ttl_TSC = 0;
                        $num = $_POST['num'];
                        foreach ($num as $i => $value) {
                            $num = $_POST['num'][$i];
                            $name = $_POST['name'][$i];
                            $total_remitance = $_POST['total_remitance'][$i];
                            $total_retention = $_POST['total_retention'][$i];
                            $total_floatOR = $_POST['total_floatOR'][$i];
                            $total_withdrawal = $_POST['total_withdrawal'][$i];
                            $total_dividend = $_POST['total_dividend'][$i];
                            $TSC = $_POST['TSC'][$i];
                            $ttl_remittance = $ttl_remittance + $total_remitance;
                            $ttl_retention = $ttl_retention + $total_retention;
                            $ttl_floatOR = $ttl_floatOR + $total_floatOR;
                            $ttl_withdrawal = $ttl_withdrawal + $total_withdrawal;
                            $ttl_dividend = $ttl_dividend + $total_dividend;
                            if (!isset($_POST['date'])) {
                                $ttl_TSC = $ttl_TSC + $TSC;
                            }
                            
                    ?>
                    <tr>
                        <td><?php echo $num?></td>
                        <td><?php echo $name?></td>
                        <td><?php echo $total_remitance?></td>
                        <td><?php echo $total_retention?></td>
                        <td><?php echo $total_floatOR?></td>
                        <td><?php echo $total_withdrawal?></td>
                        <td><?php echo $total_dividend?></td>
                        <td><?php echo $TSC?></td>
                    </tr>
                    <?php 
                        }
                    ?>
                    <tr>
                        <th></th>
                        <th>TOTAL</th>
                        <th><?php echo $ttl_remittance?></th>
                        <th><?php echo $ttl_retention?></th>
                        <th><?php echo $ttl_floatOR?></th>
                        <th><?php echo $ttl_withdrawal?></th>
                        <th><?php echo $ttl_dividend?></th>
                        <th><?php echo $ttl_TSC?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>