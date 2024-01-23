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
        <title>Journal Voucher</title>
        <link rel = "icon" type = "image/png" href = "../assets/img/coop logo.png">
    </head>
    <!-- onload="print()" -->
    <body>
        <?php
            $name = $_GET['name'];
            $amount = $_GET['amount'];
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
                <?php
                    $voucher_type = "";
                    if (($_GET['voucher']) == "jv") {
                        $voucher_type = "JOURNAL";
                    } elseif (($_GET['voucher']) == "dv") {
                        $voucher_type = "DISBURSEMENT";
                    }
                ?>
                <p style="font-size:120%;" class="mt-4"><strong><?php echo $voucher_type?> VOUCHER</strong></p>
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
                <p style="font-size:80%;"><?php echo $name ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p style="font-size:80%;">AMOUNT:</p>
            </div>
            <div class="col-sm-10">
                <p id="amount" class="text-decoration-underline" style="font-size:80%;"><?php echo $amount ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p style="font-size:80%;"></p>
            </div>
            <div class="col-sm-10">
                <p id="desc" style="font-size:80%;">Click to edit text.</p>
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
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right">-</td>
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
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;">-</td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;">-</td>
                    </tr>
                    <tr>
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;">-</td>
                    </tr>
                    <tr id="interestrow">
                        <td contenteditable='true' style="width:10%"></td>
                        <td contenteditable='true' style="text-align: center"></td>
                        <td contenteditable='true' style="text-align: right"></td>
                        <td contenteditable='true' class="text-right" style="width:8%; text-align: right"></td>
                        <td contenteditable='true' style="text-align: right;">-</td>
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
                <p id="voucherno2" style="font-size:70%;"><strong>Voucher No.</strong></p>
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
                <p id="voucherno" style="font-size:70%; margin: 0"><strong>Click to edit text</strong></p>
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
                <p style="font-size:70%;"></p>
            </div>
        </div>
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
                $("#voucherno").css("font-weight","Bold");
            }
        });

        $("#voucherno2").click(function() {
            let voucherno = prompt("Enter voucher number");
            if (voucherno != "" && voucherno != null) {
                $("#voucherno").text(voucherno);
                $("#voucherno").css("font-weight","Bold");
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