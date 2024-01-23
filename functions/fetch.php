<?php
    session_start();
    include('../include/db_connect.php');
    include('../include/function.php');

    $action = $_GET['action'];

    if($action == 'fetch_position'){ //fetch values on tbl_position to add_member.php
        $output = '';
        $department_id = $_POST['department_id'];
        
        $sql = "SELECT * FROM `tbl_position` WHERE `department_id` = $department_id AND `position_status` = 'activated' ORDER BY position";
        $result = mysqli_query($conn, $sql);
        $output .= '<option value="" selected>Select</option>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="'.$row["position_id"].'">'.$row["position"].'</option>';
        }
        echo $output;
    }
    
    if ($action == 'fetch_members') { //fetch values on modal modalMemberLoanRequest to loan_list.php
        $output = '';
        $member_id = $_POST['member_id'];

        $sql = "SELECT *, tbl_members_info.member_id
                FROM tbl_comaker
                LEFT JOIN tbl_members_info
                ON tbl_comaker.member_id = tbl_members_info.member_id
                WHERE tbl_comaker.member_id != $member_id
                AND tbl_members_info.employment_status = 'Active'";
        $result = mysqli_query($conn, $sql);
        $output .= '<option value="" selected>Select</option>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="'.$row["comaker_id"].'">'.strtoupper($row["lastname"].', '.$row["firstname"]).'</option>';
        }
        echo $output;
    }


    if ($action == 'fetch_loan') { //fetch values on a select in loan_renewal.php
        $output = '';
        $member_id = $_POST['member_id'];

        $sql = "SELECT *, tbl_loan_type.loan_type_id
                FROM tbl_loan_list
                LEFT JOIN tbl_loan_type
                ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                WHERE `status` = 'approved'
                AND `member_id` = $member_id";
        $result = mysqli_query($conn, $sql);
        $output .= '<option selected disabled value="">Application Number || Loan Type || Amount || Balance || Payment Term</option>';
        while ($row = mysqli_fetch_array($result)) {
            $loan_type = $row['loan_type'];
            $loan_type_id = $row['loan_type_id'];
            $loan_interest = $row['loan_interest'];
            $loan_id = $row['loan_id'];
            $application_number = $row['application_number'];
            $loan_amount = $row['loan_amount'];
            $loan_balance = $row['loan_balance'];
            $payment_term = $row['payment_term'];
            $service_fee = $row['service_fee'];
            $share_capital = $row['share_capital'];
            $output .= '<option value="'.$loan_type_id.','.$loan_interest.','.$loan_id.','.$loan_balance.','.$service_fee.','.$share_capital.'">'.$application_number.' || '.$loan_type.' || '.$loan_amount.' || '.round($loan_balance,2).' || '.$payment_term.'</option>';
        }
        echo $output;
    }

    if ($action == 'fetch_comaker') { //fetch comaker on a select in loan_renewal.php
        $output = '';
        $member_id = $_POST['member_id'];

        $sql = "SELECT *, tbl_members_info.member_id
                FROM tbl_comaker
                LEFT JOIN tbl_members_info
                ON tbl_comaker.member_id = tbl_members_info.member_id
                WHERE tbl_comaker.member_id != $member_id
                AND tbl_members_info.employment_status = 'Active'";
        $result = mysqli_query($conn, $sql);
        $output .= '<option value="" selected>Select</option>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="'.$row["comaker_id"].'">'.strtoupper($row["lastname"].', '.$row["firstname"]).'</option>';
        }
        echo $output;
    }
?>