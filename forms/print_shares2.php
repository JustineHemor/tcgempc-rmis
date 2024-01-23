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
            <h5 class="text-center">TCGEMPC MEMBER TOTAL SHARES</h5>
        <?php        
            } else {
                $fromdate = strtoupper(date("F d, Y",strtotime($_POST['fromdate'])));
                $todate = strtoupper(date("F d, Y",strtotime($_POST['todate'])));
        ?>
            <h6 class="text-center">TCGEMPC MEMBER TOTAL SHARES FROM <?php echo $fromdate . " TO " . $todate?></h6>
        <?php        
            }
        ?>
        <br>
        <div class="row justify-content-center py-3" id="backBtn">
            <div class="col-sm-2">
                <button class="btn btn-secondary" id="btnGoBack">Go Back To Page</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php
                if (!isset($_POST['filter'])) {
            ?>
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
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $num = $_POST['num'];
                        foreach ($num as $i => $value) {
                            $num = $_POST['num'][$i];
                            $name = $_POST['name'];
                            $remittance = $_POST['remittance'][$i];
                            $retention = $_POST['retention'][$i];
                            $floatOR = $_POST['floatOR'][$i];
                            $withdrawal = $_POST['withdrawal'][$i];
                            $dividend = $_POST['dividend'][$i];
                            $date = $_POST['date'][$i];
                            $total_remittance = $_POST['total_remittance'];
                            $total_retention = $_POST['total_retention'];
                            $total_or = $_POST['total_or'];
                            $total_withdrawal = $_POST['total_withdrawal'];
                            $total_dividend = $_POST['total_dividend'];
                    ?>
                    <tr>
                        <td><?php echo $num?></td>
                        <td><?php echo $name?></td>
                        <td><?php echo $remittance?></td>
                        <td><?php echo $retention?></td>
                        <td><?php echo $floatOR?></td>
                        <td><?php echo $withdrawal?></td>
                        <td><?php echo $dividend?></td>
                        <td><?php echo $date?></td>
                    </tr>
                    <?php 
                        }
                    ?>
                    <tr>
                        <td></td>
                        <th>Total</th>
                        <td><?php echo $total_remittance?></td>
                        <td><?php echo $total_retention?></td>
                        <td><?php echo $total_or?></td>
                        <td><?php echo $total_withdrawal?></td>
                        <td><?php echo $total_dividend?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php
                } else {
            ?>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Remittance</th>
                        <th>Retention</th>
                        <th>OR</th>
                        <th>Withdrawal</th>
                        <th>Dividend</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $num = $_POST['num'];
                        foreach ($num as $i => $value) {
                            $num = $_POST['num'][$i];
                            $name = $_POST['name'];
                            $remittance = $_POST['remittance'][$i];
                            $retention = $_POST['retention'][$i];
                            $floatOR = $_POST['floatOR'][$i];
                            $withdrawal = $_POST['withdrawal'][$i];
                            $dividend = $_POST['dividend'][$i];
                            $date = $_POST['date'][$i];
                            $total_remittance = $_POST['total_remittance'];
                            $total_retention = $_POST['total_retention'];
                            $total_or = $_POST['total_or'];
                            $total_withdrawal = $_POST['total_withdrawal'];
                            $total_dividend = $_POST['total_dividend'];
                    ?>
                    <tr>
                        <td><?php echo $num?></td>
                        <td><?php echo $name?></td>
                        <td><?php echo $remittance?></td>
                        <td><?php echo $retention?></td>
                        <td><?php echo $floatOR?></td>
                        <td><?php echo $withdrawal?></td>
                        <td><?php echo $dividend?></td>
                        <td><?php echo $date?></td>
                    </tr>
                    <?php 
                        }
                    ?>
                    <tr>
                        <td></td>
                        <th>Total</th>
                        <td><?php echo $total_remittance?></td>
                        <td><?php echo $total_retention?></td>
                        <td><?php echo $total_or?></td>
                        <td><?php echo $total_withdrawal?></td>
                        <td><?php echo $total_dividend?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php
                }
            ?>
        </div>
        <div id="hiddenform">
            <form action="../shares3.php" method="post">
                <input type="hidden" name="member_id" value="<?php echo $_POST['member_id']?>">
                <input type="submit" hidden id="formbtnBack" value="submit">
            </form>
        </div>
    </body>
</html>
<script src="../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btnGoBack').click(function () {
            $( "#formbtnBack" ).trigger( "click" );
        });
    });
</script>