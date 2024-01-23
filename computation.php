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
?>
<?php include('include/header_sidebar.php');?>
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <?php
            
            $P = 25000;
            $r = 0.0275;
            $n = 10;

            $monthly_payable_amount = ($P / $n) + ($P * $r);
            $principal = ($P / $n);
            $interest = ($P * $r);
            $balance = $P - ($P / $n);

            $counter = $n;
        ?>
        <table class="table table-striped table-bordered table-hover">
            <br>
            <br>
            <h3>Loan Amount: <?php echo $P;?></h3>
            <h3>Payment Term (months): <?php echo $n;?></h3>
            <h3>Interest Rate: <?php echo $r;?></h3>
            <tr>
                <th>No.</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Monthly Payment</th>
                <th>Balance</th>
            </tr>
            <?php
                $totalInterest = 0;
                $totalPrincipal = 0;
                $PayableAmount = 0;
                $payment_count = 1;
                $MonthPayableAmount = $monthly_payable_amount;
                $i = 1;
                while($counter > 0){

                    $totalPrincipal = $totalPrincipal + $principal;
                    $totalInterest = $totalInterest + $interest;
                    $PayableAmount = $P + $totalInterest;
            ?>
            <tr>
                <td><?php echo $i?></td>
                <td><?php echo $principal ?></td>
                <td><?php echo $interest ?></td>
                <td><?php echo $monthly_payable_amount ?></td>
                <td><?php echo $balance ?></td>            
            </tr>
            <?php
                    $i++;
                    $interest = $balance * $r;
                    $principal = $monthly_payable_amount - $interest;
                    $balance = $balance - $principal;
                    if ($balance < 0) {
                        $monthly_payable_amount = $monthly_payable_amount + $balance;
                        $principal = $monthly_payable_amount - $interest;
                        $balance = 0;
                    }

                    if ($principal > 0) {
                        $payment_count++;
                    }
                    
                    $counter = $counter - 1;
                }
            ?>
        </table>
        <h3>Total Interest: <?php echo $totalInterest;?></h3>
        <h3>Total Payable Amount: <?php echo $PayableAmount;?></h3>
        <h3>Monthly Payable Amount: <?php echo $MonthPayableAmount;?></h3>
        <h3>Payment Count: <?php echo $payment_count?></h3>
        <!-- END PAGE CONTENT-->
    </div>
<?php include('include/footer.php');?>
<script type="text/javascript">

</script>