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

    $user_type = $_SESSION['user_type'];
    if ($user_type != 'system administrator') {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=2.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- <link href="../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" /> -->
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
        <title>Disbursement Voucher</title>
        <link rel = "icon" type = "image/png" href = "../assets/img/coop logo.png">
    </head>
    <!-- onload="print()" -->
    <body>
        <?php
            $loan_id = $_GET['id'];
            $prev_balance = 0;
            $query = "SELECT *, tbl_members_info.lastname, tbl_members_info.firstname, tbl_loan_type.loan_type, tbl_comaker.member_id as comaker_member_id
                      FROM `tbl_loan_list`
                      LEFT JOIN `tbl_members_info`
                      ON tbl_loan_list.member_id = tbl_members_info.member_id
                      LEFT JOIN `tbl_loan_type`
                      ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                      LEFT JOIN `tbl_comaker`
                      ON tbl_loan_list.comaker_id = tbl_comaker.comaker_id
                      WHERE loan_id = $loan_id";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (!empty($row['renewed'])) {
                        $renewed_loan_id = $row['renewed'];
                        $query2 = " SELECT * FROM `tbl_payment` 
                                    WHERE `loan_id` = $renewed_loan_id
                                    ORDER BY `payment_id` DESC
                                    LIMIT 1";
                        $result2 = $conn->query($query2);
                        if ($result2->num_rows > 0) {
                            while ($row2 = $result2->fetch_assoc()) {
                                $prev_balance = number_format($row2['balance'], 2, ".", "");
                            }
                        }
                    }
        ?>
        <div class="row justify-content-end" id="backBtn">
            <div class="col-sm-4">
                <button class="btn btn-outline-success" onclick="window.print()">Print</button>
                <button class="btn btn-outline-primary" id="addrow">Add Row</button>
                <button class="btn btn-outline-secondary" onclick="history.back()">Go Back</button>
            </div>
        </div>
        <p class="mb-3" style="font-size:60%;">CDA FORM NO.</p>
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-column align-items-center">
                <p class="m-0" style="font-size:80%;"><strong>TAGAYTAY CITY GOVERNMENT EMPLOYEE MULTI-PURPOSE COOPERATIVE</strong></p>
                <p class="m-0" style="font-size:80%;">Registration/Confirmation No. LGA-2136</p>
                <p class="m-0" style="font-size:80%;">TIN 004-690-343</p>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-column align-items-center">
                <p style="font-size:120%;" class="mt-4"><strong>DISBURSEMENT VOUCHER</strong></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p style="font-size:80%;">DATE:</p>
            </div>
            <div class="col-sm-10">
                <p style="font-size:80%;"><?php echo date("m-d-Y")?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p style="font-size:80%;">PAYEE:</p>
            </div>
            <div class="col-sm-10">
                <p style="font-size:80%;"><?php echo strtoupper($row['firstname']) . " " . strtoupper($row['lastname'])?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p style="font-size:80%;">AMOUNT:</p>
            </div>
            <div class="col-sm-10">
                <?php
                    $amount = ($row['loan_amount']) - ($row['total_service_fee']) - ($row['total_share_capital']) - $prev_balance;
                ?>
                <p id="amount" class="text-decoration-underline" style="font-size:80%;"><?php echo $amount?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p style="font-size:80%;"></p>
            </div>
            <div class="col-sm-10">
                <p id="desc" style="font-size:80%;">Loan Applied as per supporting papers here to attached</p>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <table class="table table-responsive table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center" style="width:50%">ACCOUNT TITLE</th>
                        <th colspan="2" class="text-center" style="width:25%">DEBIT</th>
                        <th colspan="1" class="text-center" style="width:25%">CREDIT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right; color:transparent">-</td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center">LOANS RECEIVABLE</td>
                        <td contenteditable='true' style="text-align: right"><?php echo number_format($row['loan_amount'],2)?></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"><?php echo $payment_term = preg_replace('/[^0-9.]+/', '', $row['payment_term']); ?></td>
                        <td contenteditable='true' style="text-align: right">
                        <?php
                        if (!empty($row['renewed'])) {
                            echo number_format($prev_balance,2);
                        } else {
                            echo "-";
                        }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right; color:transparent">-</td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center">Share Capital</td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;"><?php echo number_format($row['total_share_capital'],2)?></td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center">Service Fee</td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;"><?php echo number_format($row['total_service_fee'],2)?></td>
                    </tr>
                    <tr id="interestrow">
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;">-</td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center">CASH IN BANK</td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;"><?php echo number_format($amount,2)?></td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"><?php echo number_format($row['loan_amount'],2)?></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;"><?php echo number_format($row['loan_amount'],2)?></td>
                    </tr>
                    <tr>
                        <td contenteditable="true" style="width:10%"></td>
                        <td contenteditable="true" style="text-align: center"></td>
                        <td contenteditable="true" style="text-align: right"></td>
                        <td contenteditable="true" class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable="true" style="text-align: right; color:transparent">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <p style="font-size:70%;"><strong>Prepared by:</strong></p>
            </div>
            <div class="col-sm-2">
                <p style="font-size:80%;"></p>
            </div>
            <div class="col-sm-4">
                <p style="font-size:70%;"><strong>Approved by:</strong></p>
            </div>
            <div class="col-sm-2">
                <p style="font-size:70%;"><strong>Received by:</strong></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <p id="preparedbyname" style="font-size:70%; margin: 0; font-style: italic;"><strong>RUBILINDA PEREÑA</strong></p>
            </div>
            <div class="col-sm-2">
                <p style="font-size:80%; margin: 0"></p>
            </div>
            <div class="col-sm-4">
                <p id="approvedbyname" style="font-size:70%; margin: 0; font-style: italic;"><strong>ALEX B. MENDOZA</strong></p>
            </div>
            <div class="col-sm-2">
                <p style="font-size:70%; margin: 0"><strong>____________________</strong></p>
            </div>
        </div>
        <div class="row my">
            <div class="col-sm-4">
                <p id="preparedpos" style="font-size:70%; font-style: italic;"><strong>Coop. Treasurer</strong></p>
            </div>
            <div class="col-sm-2">
                <p style="font-size:80%;"></p>
            </div>
            <div class="col-sm-4">
                <p id="approvedpos" style="font-size:70%; font-style: italic;"><strong>Manager</strong></p>
            </div>
            <div class="col-sm-2">
                <p style="font-size:70%;">(Signature over printed name)</p>
            </div>
        </div>
        <div class="row my">
            <div class="col-sm-4">
                <p style="font-size:70%;"><strong></strong></p>
            </div>
            <div class="col-sm-2">
                <p style="font-size:80%;"></p>
            </div>
            <div class="col-sm-4">
                <p id="voucherno2" style="font-size:70%;">Voucher no.</p>
            </div>
            <div class="col-sm-2">
                <p id="voucherno" style="font-size:70%;"><strong>____________________</strong></p>
            </div>
        </div>
        <?php
            }
        } else {
            header("Location: ../loan_list.php");
        }
        ?>
    </body>
</html>
<script src="../assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#preparedbyname").click(function() {
            let preparedbyname = prompt("Enter name");
            if (preparedbyname != "" && preparedbyname != null) {
                $("#preparedbyname").text(preparedbyname);
                $("#preparedbyname").css("font-weight","Bold");
            }
        });

        $("#preparedpos").click(function() {
            let preparedpos = prompt("Enter label");
            if (preparedpos != "" && preparedpos != null) {
                $("#preparedpos").text(preparedpos);
                $("#preparedpos").css("font-weight","Bold");
            }
        });
        
        $("#approvedbyname").click(function() {
            let approvedbyname = prompt("Enter name");
            if (approvedbyname != "" && approvedbyname != null) {
                $("#approvedbyname").text(approvedbyname);
                $("#approvedbyname").css("font-weight","Bold");
            }
        });

        $("#approvedpos").click(function() {
            let approvedpos = prompt("Enter label");
            if (approvedpos != "" && approvedpos != null) {
                $("#approvedpos").text(approvedpos);
                $("#approvedpos").css("font-weight","Bold");
            }
        });

        $("#voucherno").click(function() {
            let voucherno = prompt("Enter voucher number");
            if (voucherno != "" && voucherno != null) {
                $("#voucherno").text(voucherno);
                $("#voucherno").css("text-decoration","underline");
            }
        });

        $("#voucherno2").click(function() {
            let voucherno = prompt("Enter voucher number");
            if (voucherno != "" && voucherno != null) {
                $("#voucherno").text(voucherno);
                $("#voucherno").css("text-decoration","underline");
            }
        });

        $("#desc").click(function() {
            let desc = prompt("Enter text");
            if (desc != "" && desc != null) {
                $("#desc").text(desc);
            }
        });

        $("#addrow").click(function() {
            $('#interestrow').closest("tr").after(
                '<tr>'+
                    '<td contenteditable="true" style="width:10%"></td>'+
                    '<td contenteditable="true" style="text-align: center"></td>'+
                    '<td contenteditable="true" style="text-align: right"></td>'+
                    '<td contenteditable="true" class="text-right" style="width:8%; text-align: right"></td>'+
                    '<td contenteditable="true" style="text-align: right;">-</td>'+
                '</tr>'
            );
        });

        let amount = "**"+numberToWords($('#amount').text())+"**";
        $('#amount').text(amount.toUpperCase());

        $('#amount').click(function() {
            let amt = prompt("Enter amount");
            if (amt != "" && amt != null) {
                $("#voucherno").text(voucherno);
                let amount = "**"+numberToWords(amt)+"**";
                $('#amount').text(amount.toUpperCase());
            }
        });
    });
    function numberToWords(number) {  
        var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];  
        var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];  
        var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];  
        var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];  
  
        number = number.toString(); number = number.replace(/[\, ]/g, ''); if (number != parseFloat(number)) return 'not a number'; var x = number.indexOf('.'); if (x == -1) x = number.length; if (x > 15) return 'too big'; var n = number.split(''); var str = ''; var sk = 0; for (var i = 0; i < x; i++) { if ((x - i) % 3 == 2) { if (n[i] == '1') { str += elevenSeries[Number(n[i + 1])] + ' '; i++; sk = 1; } else if (n[i] != 0) { str += countingByTens[n[i] - 2] + ' '; sk = 1; } } else if (n[i] != 0) { str += digit[n[i]] + ' '; if ((x - i) % 3 == 0) str += 'hundred '; sk = 1; } if ((x - i) % 3 == 1) { if (sk) str += shortScale[(x - i - 1) / 3] + ' '; sk = 0; } } if (x != number.length) { var y = number.length; str += 'point '; for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' '; } str = str.replace(/\number+/g, ' '); return str.trim();  
  
    } 
</script>