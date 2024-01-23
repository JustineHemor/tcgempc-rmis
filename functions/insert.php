<?php
    session_start();
    include('../include/db_connect.php');
    include('../include/function.php');

    $action = $_GET['action'];
    
    if($action == 'insert_department'){ //add or edit record on tbl_department
        $department = $conn -> real_escape_string($_POST['department']);
        $dept_acronym = $conn -> real_escape_string($_POST['dept_acronym']);

        $sql = "INSERT INTO `tbl_department`(`department`,`dept_acronym`) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $department, $dept_acronym);
        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['message'] = "<strong>Great! </strong>You added a department successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../department_list.php");
        } else {
            echo "Error inserting record: " . $conn->error;
            $stmt->close();  
        }
    }

    if($action == 'insert_position'){ //add record on tbl_position
        $position =  $_POST['position'];
        $department_id =  $_POST['department_id'];
        $monthly_salary =  $_POST['monthly_salary'];

        $sql = "INSERT INTO `tbl_position`(`position`,`department_id`,`monthly_salary`) VALUES ('$position',$department_id, '$monthly_salary')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "<strong>Great! </strong>You added a position successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../position_list.php");
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }

    if($action == 'insert_loan_type'){ //add record on tbl_loan_type
        $loan_type = $_POST['loan_type'];
        $loan_interest = $_POST['loan_interest'];
        $service_fee = $_POST['service_fee'];
        $share_capital = $_POST['share_capital'];

        $sql = "INSERT INTO `tbl_loan_type`(`loan_type`,`loan_interest`,`service_fee`,`share_capital`) VALUES ('$loan_type',$loan_interest,$service_fee,$share_capital)";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "<strong>Great! </strong>You added a loan type successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../loan_types.php");
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }

    if($action == 'insert_member'){ //add record on tbl_members_info
        
        $lastname = $conn -> real_escape_string($_POST['lastname']);
        $firstname = $conn -> real_escape_string($_POST['firstname']);
        $username = $conn -> real_escape_string($_POST['username']);
        $password = $conn -> real_escape_string($_POST['password']);
        $middlename = $conn -> real_escape_string($_POST['middlename']);
        $civilstatus = $conn -> real_escape_string($_POST['civilstatus']);
        $gender = $conn -> real_escape_string($_POST['gender']);
        $birth_date = $conn -> real_escape_string($_POST['birth_date']);
        $address = $conn -> real_escape_string($_POST['address']);
        $birthplace = $conn -> real_escape_string($_POST['birthplace']);
        $phonenum = $conn -> real_escape_string($_POST['phonenum']);
        $position = $conn -> real_escape_string($_POST['position']);
        $department = $conn -> real_escape_string($_POST['department']);
        $salary = $conn -> real_escape_string($_POST['salary']);
        $othersourceofincome = $conn -> real_escape_string($_POST['othersourceofincome']);
        $annualincome = $conn -> real_escape_string($_POST['annualincome']);
        $religion = $conn -> real_escape_string($_POST['religion']);
        $tin = $conn -> real_escape_string($_POST['tin']);
        $spousename = $conn -> real_escape_string($_POST['spousename']);
        $occupation = $conn -> real_escape_string($_POST['occupation']);
        $beneficiary = $conn -> real_escape_string($_POST['beneficiary']);
        $relation = $conn -> real_escape_string($_POST['relation']);;
        $dependentsnum = $conn -> real_escape_string($_POST['dependentsnum']);
        $member_number = $conn -> real_escape_string($_POST['member_number']);
        $employment_status = "Active";
        $dateToday = date("Y-m-d");
        $membership_date = $conn -> real_escape_string($_POST['membership_date']);
        $user_type = $conn -> real_escape_string($_POST['user_type']);
        $share_capital = $conn -> real_escape_string($_POST['share_capital']);
        $remittance = $conn -> real_escape_string($_POST['remittance']);

        $member_numberError = 0;
        $identityError = 0;

        $sql5 = "SELECT * FROM `tbl_members_info`";
        $sql5result = $conn->query($sql5);
        if ($sql5result->num_rows > 0) {
            while($row = $sql5result->fetch_assoc()) {
                $lname = $row['lastname'];
                $fname = $row['firstname'];
                $mname = $row['middlename'];
                $bday = $row['birth_date'];
                $mem_num = $row['member_number'];
                if ((strtoupper($lastname)) == (strtoupper($lname)) && (strtoupper($firstname)) == (strtoupper($fname)) && (strtoupper($middlename)) == (strtoupper($mname)) && (($birth_date)) == (($bday))) {
                    $identityError = 1;
                } elseif ($mem_num == $member_number) {
                    $member_numberError = 1;
                }
            }
        }

        if ($identityError == 1) {
            $_SESSION['message'] = "<strong>Oops! </strong>Member already exists!";
            $_SESSION['msg_type'] = "danger";
            header("Location: ../add_member.php");
        } elseif ($member_numberError == 1) {
            $_SESSION['message'] = "<strong>Oops! </strong>Member number already used!";
            $_SESSION['msg_type'] = "danger";
            header("Location: ../add_member.php");
        } else {
            $sql = "INSERT INTO `tbl_members_info`(`member_number`, `firstname`, `lastname`, `middlename`, `gender`, `civil_status`, `birth_date`, `address`, `birth_place`, `phone_num`, `position_id`, `department_id`, `salary`, `other_income_source`, `annual_income`, `religion`, `tin`, `spouse_name`, `occupation`, `beneficiary`, `relation`, `dependents_num`, `employment_status`, `membership_date`, `share_capital`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssssssssiissssssssssssd", $member_number, $firstname, $lastname, $middlename, $gender, $civilstatus, $birth_date, $address, $birthplace, $phonenum, $position, $department, $salary, $othersourceofincome, $annualincome, $religion, $tin, $spousename, $occupation, $beneficiary, $relation, $dependentsnum, $employment_status, $membership_date, $share_capital);
            $stmt->execute();
            $stmt->close();

            $last_id = $conn->insert_id;

            $sql = "INSERT INTO `tbl_user_accounts`(`member_id`, `username`, `password`, `user_type`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $last_id, $username, $password, $user_type);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO `tbl_shares`(`member_id`, `remittance`, `date`) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ids", $last_id, $remittance, $dateToday);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO `tbl_comaker`(`member_id`) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $last_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "<strong>Great! </strong>inserting user is successful!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../members_list.php");
        }
    }

    if($action == 'insert_existing_member'){ //add old member on tbl_members_info
        
        $lastname = $conn -> real_escape_string($_POST['lastname']);
        $firstname = $conn -> real_escape_string($_POST['firstname']);
        $username = $conn -> real_escape_string($_POST['username']);
        $password = $conn -> real_escape_string($_POST['password']);
        $middlename = $conn -> real_escape_string($_POST['middlename']);
        $civilstatus = $conn -> real_escape_string($_POST['civilstatus']);
        $gender = $conn -> real_escape_string($_POST['gender']);
        $birth_date = $conn -> real_escape_string($_POST['birth_date']);
        $address = $conn -> real_escape_string($_POST['address']);
        $birthplace = $conn -> real_escape_string($_POST['birthplace']);
        $phonenum = $conn -> real_escape_string($_POST['phonenum']);
        $position = $conn -> real_escape_string($_POST['position']);
        $department = $conn -> real_escape_string($_POST['department']);
        $salary = $conn -> real_escape_string($_POST['salary']);
        $othersourceofincome = $conn -> real_escape_string($_POST['othersourceofincome']);
        $annualincome = $conn -> real_escape_string($_POST['annualincome']);
        $religion = $conn -> real_escape_string($_POST['religion']);
        $tin = $conn -> real_escape_string($_POST['tin']);
        $spousename = $conn -> real_escape_string($_POST['spousename']);
        $occupation = $conn -> real_escape_string($_POST['occupation']);
        $beneficiary = $conn -> real_escape_string($_POST['beneficiary']);
        $relation = $conn -> real_escape_string($_POST['relation']);;
        $dependentsnum = $conn -> real_escape_string($_POST['dependentsnum']);
        $member_number = $conn -> real_escape_string($_POST['member_number']);
        $employment_status = "Active";
        $dateToday = date("Y-m-d");
        $membership_date = $conn -> real_escape_string($_POST['membership_date']);
        $user_type = $conn -> real_escape_string($_POST['user_type']);
        $share_capital = $conn -> real_escape_string($_POST['share_capital']);

        $member_numberError = 0;
        $identityError = 0;

        $sql5 = "SELECT * FROM `tbl_members_info`";
        $sql5result = $conn->query($sql5);
        if ($sql5result->num_rows > 0) {
            while($row = $sql5result->fetch_assoc()) {
                $lname = $row['lastname'];
                $fname = $row['firstname'];
                $mname = $row['middlename'];
                $bday = $row['birth_date'];
                $mem_num = $row['member_number'];
                if ((strtoupper($lastname)) == (strtoupper($lname)) && (strtoupper($firstname)) == (strtoupper($fname)) && (strtoupper($middlename)) == (strtoupper($mname)) && (($birth_date)) == (($bday))) {
                    $identityError = 1;
                } elseif ($mem_num == $member_number) {
                    $member_numberError = 1;
                }
            }
        }

        if ($identityError == 1) {
            $_SESSION['message'] = "<strong>Oops! </strong>Member already exists!";
            $_SESSION['msg_type'] = "danger";
            header("Location: ../add_member.php");
        } elseif ($member_numberError == 1) {
            $_SESSION['message'] = "<strong>Oops! </strong>Member number already used!";
            $_SESSION['msg_type'] = "danger";
            header("Location: ../add_member.php");
        } else {
            $sql = "INSERT INTO `tbl_members_info`(`member_number`, `firstname`, `lastname`, `middlename`, `gender`, `civil_status`, `birth_date`, `address`, `birth_place`, `phone_num`, `position_id`, `department_id`, `salary`, `other_income_source`, `annual_income`, `religion`, `tin`, `spouse_name`, `occupation`, `beneficiary`, `relation`, `dependents_num`, `employment_status`, `membership_date`, `share_capital`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssssssssiissssssssssssd", $member_number, $firstname, $lastname, $middlename, $gender, $civilstatus, $birth_date, $address, $birthplace, $phonenum, $position, $department, $salary, $othersourceofincome, $annualincome, $religion, $tin, $spousename, $occupation, $beneficiary, $relation, $dependentsnum, $employment_status, $membership_date, $share_capital);
            $stmt->execute();
            $stmt->close();

            $last_id = $conn->insert_id;

            $sql = "INSERT INTO `tbl_user_accounts`(`member_id`, `username`, `password`, `user_type`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $last_id, $username, $password, $user_type);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO `tbl_comaker`(`member_id`) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $last_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "<strong>Great! </strong>inserting user is successful!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../members_list.php");
        }
    }

    if($action == 'request_loan'){ //add personal record on tbl_loan_list

        $member_id = $conn -> real_escape_string($_POST['member_id']);

        #CHECK IF THE MEMBER IS ALREADY MEMBER FOR 6 MONTHS
        $membership_date = new DateTime ($conn -> real_escape_string($_POST['membership_date']));
        $dateToday = new DateTime ($conn -> real_escape_string($_POST['date_today'])); 
        $dateDiff = $membership_date->diff($dateToday);

        #CHECK THE MEMBER'S SHARE AMOUNT
        $sql2= "SELECT `remittance` FROM `tbl_shares` WHERE member_id = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $shareValue = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $shareValue = $row['remittance'] + $shareValue;
            }
        }
        
        if ($dateDiff->m < 6 && $dateDiff->y == 0) { #CHECK IF THE MEMBER IS ALREADY MEMBER FOR 6 MONTHS
            $_SESSION['message'] = '<strong>Oops! </strong>Your membership must be longer than 5 months to request a loan.';
            $_SESSION['msg_type'] = "danger";
            header("Location: ../loan_request.php");
        }elseif ($shareValue < 1500) { #CHECK THE MEMBER'S SHARE AMOUNT
            $_SESSION['message'] = '<strong>Oops! </strong>Your share must be 1500 or higher to request a loan.';
            $_SESSION['msg_type'] = "danger";
            header("Location: ../loan_request.php");
        }else {
            $sql = "SELECT * FROM tbl_loan_list ORDER BY loan_id DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $last_application_number = $row['application_number'];
            if (substr($last_application_number,0,4) == date("Y")) { // Check if last application number's year is equal to current year
                $application_number = $last_application_number + 1;
            } else {
                $application_number = date("Y")."001";
            }
            
            $member_id = $conn -> real_escape_string($_POST['member_id']);
            $loan_type_id = $conn -> real_escape_string($_POST['loan_type_id']);
            $explodedValue = explode(',',$loan_type_id);
            $loantypeid = $explodedValue[0];
            $total_service_fee = $conn -> real_escape_string($_POST['total_service_fee']);
            $total_share_capital = $conn -> real_escape_string($_POST['total_share_capital']);
            $loan_amount = $conn -> real_escape_string($_POST['loan_amount']);
            $total_interest = $conn -> real_escape_string($_POST['total_interest']);
            $total_payable_amount = $conn -> real_escape_string($_POST['total_payable_amount']);
            $monthly_payable_amount = $conn -> real_escape_string($_POST['monthly_payable_amount']);
            $payment_term = $conn -> real_escape_string($_POST['payment_term']) . " months";
            $comaker_id = $conn -> real_escape_string($_POST['comaker_id']);
            $application_date = $conn -> real_escape_string($_POST['date_today']);
            $status = "for approval";
            $comaker_confirmation = "pending";
            $approval_date = "0000-00-00";

            $sql1 = "INSERT INTO `tbl_loan_list`(`application_number`, `member_id`, `loan_type_id`, `loan_amount`, `total_interest`, `total_payable_amount`, `monthly_payable_amount`, `total_service_fee`, `total_share_capital`, `loan_balance`, `status`, `payment_term`, `comaker_id`, `comaker_confirmation`, `approval_date`, `application_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql1);
            $stmt->bind_param("iiidddddddssisss", $application_number, $member_id, $loantypeid, $loan_amount, $total_interest ,$total_payable_amount, $monthly_payable_amount, $total_service_fee, $total_share_capital, $loan_amount, $status, $payment_term, $comaker_id, $comaker_confirmation, $approval_date, $application_date);
            if ($stmt->execute()) {
                $stmt->close();
                $_SESSION['message'] = '<strong>Great! </strong>Your loan application is successful! Please wait for approval.';
                $_SESSION['msg_type'] = "success";
                header("Location: ../loan_history.php");
            }        
        }
    }

    if ($action == 'renew_loan') { //renew personal record on tbl_loan_list
        $loan_type_id = $conn -> real_escape_string($_POST['loan_type_id']);
        $explodedValue = explode(',',$loan_type_id);
        $loan_id = $explodedValue[2];
        
        $sql = "SELECT * FROM tbl_loan_list ORDER BY loan_id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $last_application_number = $row['application_number'];
        if (substr($last_application_number,0,4) == date("Y")) { // Check if last application number's year is equal to current year
            $application_number = $last_application_number + 1;
        } else {
            $application_number = date("Y")."001";
        }
        $member_id = $conn -> real_escape_string($_POST['member_id']);
        $loantypeid = $explodedValue[0];
        $total_service_fee = $conn -> real_escape_string($_POST['total_service_fee']);
        $total_share_capital = $conn -> real_escape_string($_POST['total_share_capital']);
        $loan_amount = ($conn -> real_escape_string($_POST['loan_amount']));
        $total_interest = $conn -> real_escape_string($_POST['total_interest']);
        $total_payable_amount = $conn -> real_escape_string($_POST['total_payable_amount']);
        $monthly_payable_amount = $conn -> real_escape_string($_POST['monthly_payable_amount']);
        $payment_term = $conn -> real_escape_string($_POST['payment_term']) . " months";
        $comaker_id = $conn -> real_escape_string($_POST['comaker_id']);
        $application_date = $conn -> real_escape_string($_POST['date_today']);
        $status = "for approval";
        $comaker_confirmation = "pending";
        $approval_date = "0000-00-00";

        $sql1 = "INSERT INTO `tbl_loan_list`(`application_number`, `member_id`, `loan_type_id`, `loan_amount`, `total_interest`, `total_payable_amount`, `monthly_payable_amount`, `total_service_fee`, `total_share_capital`, `loan_balance`, `status`, `payment_term`, `comaker_id`, `comaker_confirmation`, `approval_date`, `application_date`,`renewed`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("iiidddddddssissss", $application_number, $member_id, $loantypeid, $loan_amount, $total_interest ,$total_payable_amount, $monthly_payable_amount, $total_service_fee, $total_share_capital, $loan_amount, $status, $payment_term, $comaker_id, $comaker_confirmation, $approval_date, $application_date, $loan_id);
        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['message'] = '<strong>Great! </strong>Your loan renewal is successful! Please wait for approval.';
            $_SESSION['msg_type'] = "success";
            header("Location: ../loan_history.php");
        }
    }

    if ($action == 'member_renew_loan') { //renew members record on tbl_loan_list
        $loan_type_id = $conn -> real_escape_string($_POST['loan_type_id']);
        $explodedValue = explode(',',$loan_type_id);
        $loan_id = $explodedValue[2];

        $sql = "SELECT * FROM tbl_loan_list ORDER BY loan_id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $last_application_number = $row['application_number'];
        if (substr($last_application_number,0,4) == date("Y")) { // Check if last application number's year is equal to current year
            $application_number = $last_application_number + 1;
        } else {
            $application_number = date("Y")."001";
        }
        $member_id = $conn -> real_escape_string($_POST['member_id']);
        $loantypeid = $explodedValue[0];
        $total_service_fee = $conn -> real_escape_string($_POST['total_service_fee']);
        $total_share_capital = $conn -> real_escape_string($_POST['total_share_capital']);
        $loan_amount = ($conn -> real_escape_string($_POST['loan_amount']));
        $total_interest = $conn -> real_escape_string($_POST['total_interest']);
        $total_payable_amount = $conn -> real_escape_string($_POST['total_payable_amount']);
        $monthly_payable_amount = $conn -> real_escape_string($_POST['monthly_payable_amount']);
        $payment_term = $conn -> real_escape_string($_POST['payment_term']) . " months";
        $comaker_id = $conn -> real_escape_string($_POST['comaker_id']);
        $application_date = $conn -> real_escape_string($_POST['date_today']);
        $status = "for approval";
        $comaker_confirmation = "pending";
        $approval_date = "0000-00-00";

        $sql1 = "INSERT INTO `tbl_loan_list`(`application_number`, `member_id`, `loan_type_id`, `loan_amount`, `total_interest`, `total_payable_amount`, `monthly_payable_amount`, `total_service_fee`, `total_share_capital`, `loan_balance`, `status`, `payment_term`, `comaker_id`, `comaker_confirmation`, `approval_date`, `application_date`,`renewed`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("iiidddddddssissss", $application_number, $member_id, $loantypeid, $loan_amount, $total_interest ,$total_payable_amount, $monthly_payable_amount, $total_service_fee, $total_share_capital, $loan_amount, $status, $payment_term, $comaker_id, $comaker_confirmation, $approval_date, $application_date, $loan_id);
        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['message'] = '<strong>Great! </strong>Loan renewal is successful and waiting for approval.';
            $_SESSION['msg_type'] = "success";
            header("Location: ../loan_renewal.php");
        }
    }

    if ($action == 'member_request_loan') { //add record on tbl_loan_list

        $member_id = $_POST['member_id'];

        #CHECK IF THE MEMBER IS ALREADY MEMBER FOR 6 MONTHS
        $sql1 = "SELECT * FROM `tbl_members_info` WHERE `member_id` = $member_id";
        $sql1Result = mysqli_query($conn, $sql1);
        $sql1Row = mysqli_fetch_assoc($sql1Result);
        $membership_date = new DateTime($sql1Row['membership_date']);
        $dateToday = new DateTime($_POST['date_today']);
        $dateDiff = $membership_date->diff($dateToday);

        #CHECK THE MEMBER'S SHARE AMOUNT
        $sql2= "SELECT `remittance` FROM `tbl_shares` WHERE member_id = $member_id";
        $sql2Result = mysqli_query($conn, $sql2);
        $shareValue = 0;
        while($sql2Row = mysqli_fetch_assoc($sql2Result)){
            $shareValue = $sql2Row['remittance'] + $shareValue;
        }
        
        if ($dateDiff->m < 6 && $dateDiff->y == 0) { #CHECK IF THE MEMBER IS ALREADY MEMBER FOR 6 MONTHS
            $_SESSION['message'] = '<strong>Oops! </strong>membership must be 6 months to request a loan.';
            $_SESSION['msg_type'] = "danger";
            header("Location: ../loan_list.php");
        }elseif ($shareValue < 1500) { #CHECK THE MEMBER'S SHARE AMOUNT
            $_SESSION['message'] = '<strong>Oops! </strong>share must be 1500 or higher to request a loan.';
            $_SESSION['msg_type'] = "danger";
            header("Location: ../loan_list.php");
        }else {

            $sql = "SELECT * FROM tbl_loan_list ORDER BY loan_id DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $last_application_number = $row['application_number'];
            if (substr($last_application_number,0,4) == date("Y")) { // Check if last application number's year is equal to current year
                $application_number = $last_application_number + 1;
            } else {
                $application_number = date("Y")."001";
            }

            $loan_type_id = $_POST['loan_type_id'];
            $explodedValue = explode(',',$loan_type_id);
            $loantypeid = $explodedValue[0];
            $loan_amount = $_POST['loan_amount'];
            $total_service_fee = $_POST['total_service_fee'];
            $total_share_capital = $_POST['total_share_capital'];
            $total_interest = $_POST['total_interest'];
            $total_payable_amount = $_POST['total_payable_amount'];
            $monthly_payable_amount = $_POST['monthly_payable_amount'];
            $payment_term = $_POST['payment_term'] . " months";
            $comaker_id = $_POST['comaker_id'];
            $application_date = $_POST['date_today'];
            $status = "for approval";
            $comaker_confirmation = "pending";
            $approval_date = "0000-00-00";

            $sql3 = "INSERT INTO `tbl_loan_list`(`application_number`, `member_id`, `loan_type_id`, `loan_amount`, `total_interest`, `total_payable_amount`, `monthly_payable_amount`, `total_service_fee`, `total_share_capital`, `loan_balance`, `status`, `payment_term`, `comaker_id`, `comaker_confirmation`, `approval_date`, `application_date`) VALUES ('$application_number','$member_id','$loantypeid','$loan_amount',$total_interest,$total_payable_amount,$monthly_payable_amount,$total_service_fee,$total_share_capital,'$loan_amount','$status','$payment_term','$comaker_id','$comaker_confirmation','$approval_date','$application_date')";
            if ($conn->query($sql3) === TRUE) {       
                $_SESSION['message'] = '<strong>Great! </strong>loan application is now for approval!';
                $_SESSION['msg_type'] = "success";
                header("Location: ../loan_list.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }           
        }
    }

    if($action == 'add_member_share'){ //Add share to a member
        $member_id = $_POST['member_id'];
        $remittance = $_POST['remittance'];
        $retention = $_POST['retention'];
        $or = $_POST['or'];
        $withdrawal = $_POST['withdrawal'];
        $dividend = $_POST['dividend'];
        $dateToday = date("Y-m-d");

        $sql = "INSERT INTO `tbl_shares`(`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`dividend`,`date`) VALUES($member_id, $remittance, $retention, $or, $withdrawal, $dividend, '$dateToday')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "<strong>Great! </strong>You add share to a member successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../shares.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if($action == 'cancel_loan'){ //cancel loan request
        $loan_id = $_POST['loan_id'];
        $encrypted_loan_id = $_POST['encrypted_loan_id'];
        $hashed = $_POST['hashed'];
        $renewed = $_POST['renewed'];
        if ($renewed != '') {
            $sql = "UPDATE tbl_loan_list SET `status` = 'cancelled' WHERE `loan_id` = $loan_id";
            if (mysqli_query($conn, $sql)) {
                $sql1 = "UPDATE tbl_loan_list SET `status` = 'approved' WHERE `loan_id` = $renewed";
                if (mysqli_query($conn, $sql1)) {
                    $_SESSION['message'] = "<strong>Notice! </strong>Your loan renewal has been cancelled!";
                    $_SESSION['msg_type'] = "warning";
                    header("Location: ../loan_history.php");
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            $sql = "UPDATE tbl_loan_list SET `status` = 'cancelled' WHERE `loan_id` = $loan_id";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['message'] = "<strong>Notice! </strong>Your loan application has been cancelled!";
                $_SESSION['msg_type'] = "warning";
                header("Location: ../view_loan_history.php?loan_id=".$loan_id);
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    }

    if ($action == 'direct_payment') { // add direct payment
        $int_rate = $_POST['interest_rate'];
        $loan_id = $_POST['loan_id'];
        $payment_amount = $_POST['payment_amount'];
        $date = date("Y-m-d");

        $query = "SELECT *, tbl_loan_type.loan_type_id
                  FROM `tbl_loan_list`
                  LEFT JOIN `tbl_loan_type` 
                  ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                  WHERE loan_id = $loan_id";
        $result = $conn->query($query);
        while($row = $result->fetch_assoc()){
            $loan_balance = $row['loan_balance'];
            $interest_rate = $row['loan_interest'];
        }

        if (!empty($int_rate)) {
            $interest_rate = $int_rate;
        }

        $interest = $loan_balance * $interest_rate;
        $principal = $payment_amount - $interest;
        $balance = $loan_balance - $principal;

        $sql = "INSERT INTO `tbl_payment` (`loan_id`, `principal`, `interest`, `payment_amount`, `balance`, `payment_date`) VALUES ($loan_id, $principal, $interest, $payment_amount, $balance,'$date')";
        if ($conn->query($sql) === TRUE) {
            $sql1 = "UPDATE `tbl_loan_list` SET `loan_balance` = $balance WHERE `loan_id` = $loan_id";
            if ($conn->query($sql1) === TRUE) {
                #CHECK IF LOAN IS ALREADY COMPLETE
                $sql2 = "SELECT * FROM `tbl_loan_list` WHERE `loan_balance` < 1 AND `loan_id` = $loan_id";
                $result = $conn->query($sql2);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $loan_id = $row['loan_id'];
                        $sql3 = "UPDATE `tbl_loan_list` SET `status` = 'complete', `notification_1` = '1' WHERE `loan_id` = $loan_id";
                        if ($conn->query($sql3) === TRUE) {
                        
                        } else {
                            echo "Error: " . $conn->error;
                        }                 
                    }
                }
                $_SESSION['message'] = "<strong>Great! </strong>Payment successful.";
                $_SESSION['msg_type'] = "success";
                header("Location: ../payments.php");
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: " . $conn->error;
        }
    }

    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if ($action == 'upload_excel_file') {
        $date = $_POST['date'];
        $fileName = $_FILES['excel_shares']['name'];
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

        $allowed_ext = ['xls','csv','xlsx'];

        if(in_array($file_ext, $allowed_ext)){
            
            $inputFileNamePath = $_FILES['excel_shares']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $count = "0";
            foreach($data as $row)
            {
                if($count > 0)
                {
                    $member_id = 0;
                    $member_number = $row['0'];
                    $remittance = $row['1'];
                    $retention = $row['2'];
                    $floatOR = $row['3'];
                    $withdrawal = $row['4'];
                    $dividend = $row['5'];

                    echo $member_number . "<br>";

                    $query = "SELECT * FROM `tbl_members_info` WHERE `member_number` = $member_number";
                    $res = mysqli_query($conn, $query);
                    while ($roww = mysqli_fetch_array($res)) {
                        $member_id = $roww['member_id'];
                    }

                    $sql = "INSERT INTO `tbl_shares` (`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`dividend`,`date`) VALUES ('$member_id','$remittance','$retention','$floatOR','$withdrawal','$dividend','$date')";
                    $result = mysqli_query($conn, $sql);
                    $msg = true;
                }
                else
                {
                    $count = "1";
                }
            }

            if(isset($msg))
            {
                $_SESSION['message'] = "<strong>Great! </strong>Shares imported successfully!";
                $_SESSION['msg_type'] = "success";
                header("Location: ../shares.php");
                exit(0);
            }
            else
            {
                $_SESSION['message'] = "<strong>Oops! </strong>Shares not imported.";
                $_SESSION['msg_type'] = "danger";
                header("Location: ../shares.php");
                exit(0);
            }

        } else {
            $_SESSION['message'] = "<strong>Oops! </strong>Invalid file!";
            $_SESSION['msg_type'] = "danger";
            header("Location: ../shares.php");
        }
    }

    if ($action == 'upload_excel_payment') {
        $date = $_POST['date'];
        $fileName = $_FILES['excel_payments']['name'];
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

        $allowed_ext = ['xls','csv','xlsx'];

        if(in_array($file_ext, $allowed_ext)){
            
            $inputFileNamePath = $_FILES['excel_payments']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $count = "0";
            foreach($data as $row)
            {
                if($count > 0)
                {

                    $member_id = 0;
                    $member_number = $row['0'];
                    $member_name = $row['1'];
                    $total = $row['2'];
                    $share = $row['3'];

                    if ($member_number != "") {

                        $payment_amount = $total - $share;

                        $query = "SELECT *
                        FROM `tbl_members_info` 
                        WHERE `member_number` = $member_number";
                        $res = mysqli_query($conn, $query);
                        while ($roww = mysqli_fetch_array($res)) {
                            $member_id = $roww['member_id'];
                        }

                        

                        if ($payment_amount <= 0) {
                            $sql = "INSERT INTO `tbl_shares` (`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`date`) VALUES ('$member_id', '$share', '0.00', '0.00', '0.00','$date')";
                            $result = mysqli_query($conn, $sql);
                        } else {
                            $sql = "INSERT INTO `tbl_shares` (`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`date`) VALUES ($member_id, $share, '0.00', '0.00', '0.00','$date')";
                            $result = mysqli_query($conn, $sql);

                            $query = "SELECT *, tbl_loan_type.loan_type_id
                                      FROM `tbl_loan_list` 
                                      LEFT JOIN `tbl_loan_type` 
                                      ON tbl_loan_list.loan_type_id = tbl_loan_type.loan_type_id
                                      WHERE `member_id` = $member_id
                                      ORDER BY `loan_id` 
                                      LIMIT 1";
                            $res = mysqli_query($conn, $query);
                            $loan_balance = 0;
                            $interest_rate = 0;
                            while ($row = mysqli_fetch_array($res)) {
                                $loan_id = $row['loan_id'];
                                $loan_balance = $row['loan_balance'];
                                $interest_rate = $row['loan_interest'];
                            }

                            $interest = $loan_balance * $interest_rate;
                            $principal = $payment_amount - $interest;
                            $balance = $loan_balance - $principal;

                            $sql = "INSERT INTO `tbl_payment` (`loan_id`, `principal`, `interest`, `payment_amount`, `balance`, `payment_date`) VALUES ($loan_id, $principal, $interest, $payment_amount, $balance,'$date')";
                            if ($conn->query($sql) === TRUE) {
                                $sql1 = "UPDATE `tbl_loan_list` SET `loan_balance` = $balance WHERE `loan_id` = $loan_id";
                                if ($conn->query($sql1) === TRUE) {
                                    #CHECK IF LOAN IS ALREADY COMPLETE
                                    $sql2 = "SELECT * FROM `tbl_loan_list` WHERE `loan_balance` < 1 AND `loan_id` = $loan_id";
                                    $result = $conn->query($sql2);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $loan_id = $row['loan_id'];
                                            $sql3 = "UPDATE `tbl_loan_list` SET `status` = 'complete', `notification_1` = '1' WHERE `loan_id` = $loan_id";
                                            if ($conn->query($sql3) === TRUE) {
                                            
                                            } else {
                                                echo "Error: " . $conn->error;
                                            }                 
                                        }
                                    }
                                } else {
                                    echo "Error: " . $conn->error;
                                }
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        }
                        $msg = true;
                    }

                }
                else
                {
                    $count = "1";
                }
            }

            if(isset($msg))
            {
                $_SESSION['message'] = "<strong>Great! </strong>Payments successful!";
                $_SESSION['msg_type'] = "success";
                header("Location: ../payments.php");
                exit(0);
            }
            else
            {
                $_SESSION['message'] = "<strong>Oops! </strong>Payments not imported.";
                $_SESSION['msg_type'] = "danger";
                header("Location: ../payments.php");
                exit(0);
            }

        } else {
            $_SESSION['message'] = "<strong>Oops! </strong>Invalid file!";
            $_SESSION['msg_type'] = "danger";
            header("Location: ../shares.php");
        }
    }