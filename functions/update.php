<?php
    session_start();
    include('../include/db_connect.php');
    include('../include/function.php');

    $action = $_GET['action'];

    if($action == 'edit_department'){ //edit record on tbl_department
        $department_id =$_POST['department_id'];
        $department = $_POST['department'];
        $dept_acronym = $_POST['dept_acronym'];

        $sql = "UPDATE `tbl_department` SET `department`='$department', `dept_acronym`='$dept_acronym' WHERE `department_id` = $department_id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "<strong>Great! </strong>You updated a department successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../department_list.php");
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }

    if($action == 'edit_position'){ //edit record on tbl_position
        $position_id =  $_POST['position_id'];
        $position =  $_POST['position'];
        $department_id =  $_POST['department_id'];
        $monthly_salary =  $_POST['monthly_salary'];

        $sql = "UPDATE `tbl_position` SET `position`='$position',`department_id`=$department_id,`monthly_salary`='$monthly_salary' WHERE `position_id` = $position_id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "<strong>Great! </strong>You updated a position successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../position_list.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if($action == 'edit_loan_type'){ //edit record on tbl_loan_type
        $loan_type = $_POST['loan_type'];
        $loan_interest = $_POST['loan_interest'];
        $service_fee = $_POST['service_fee'];
        $loan_type_id = $_POST['loan_type_id'];

        $sql = "UPDATE `tbl_loan_type` SET `loan_type`='$loan_type',`loan_interest`=$loan_interest,`service_fee`='$service_fee' WHERE `loan_type_id` = $loan_type_id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "<strong>Great! </strong>You updated a loan type successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../loan_types.php");
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }

    if($action == 'update_member'){ //update record on tbl_members_info
        $member_id = $_POST['member_id'];
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $gender = $_POST['gender'];
        $civilstatus = $_POST['civilstatus'];
        $birth_date = $_POST['birth_date'];
        $address = $_POST['address'];
        $birthplace = $_POST['birthplace'];
        $phonenum = $_POST['phonenum'];
        $position = $_POST['position'];
        $department = $_POST['department'];
        $salary = $_POST['salary'];
        $othersourceofincome = $_POST['othersourceofincome'];
        $annualincome = $_POST['annualincome'];
        $religion = $_POST['religion'];
        $tin = $_POST['tin'];
        $spousename = $_POST['spousename'];
        $occupation = $_POST['occupation'];
        $beneficiary = $_POST['beneficiary'];
        $relation = $_POST['relation'];
        $dependentsnum = $_POST['dependentsnum'];
        $member_number = $_POST['member_number'];
        $user_type = $_POST['user_type'];
        $employment_status = 'Active';
        $password = $_POST['password'];
        $passwordformat = $_POST['passwordformat'];

        $sql = "UPDATE `tbl_members_info` SET `member_number`=$member_number,`firstname`='$firstname',`lastname`='$lastname',`middlename`='$middlename',`gender`='$gender',`civil_status`='$civilstatus',`birth_date`='$birth_date',`address`='$address',`birth_place`='$birthplace',`phone_num`='$phonenum',`position_id`=$position,`department_id`=$department,`salary`='$salary',`other_income_source`='$othersourceofincome',`annual_income`='$annualincome',`religion`='$religion',`tin`='$tin',`spouse_name`='$spousename',`occupation`='$occupation',`beneficiary`='$beneficiary',`relation`='$relation',`dependents_num`='$dependentsnum', `employment_status`='$employment_status' WHERE member_id = $member_id";
        if ($conn->query($sql) === TRUE) {
            if ($passwordformat == "hashed") {
                $sql1 = "UPDATE `tbl_user_accounts` SET `user_type`='$user_type' WHERE member_id = $member_id";
                if ($conn->query($sql1) === TRUE) {
                    $_SESSION['message'] = "<strong>Great! </strong>updating user is successful!";
                    $_SESSION['msg_type'] = "success";
                    header("Location: ../members_list.php");
                }
            } elseif ($passwordformat == "unhashed") {
                $sql1 = "UPDATE `tbl_user_accounts` SET `user_type`='$user_type', `password`='$password' WHERE member_id = $member_id";
                if ($conn->query($sql1) === TRUE) {
                    $_SESSION['message'] = "<strong>Great! </strong>updating user is successful!";
                    $_SESSION['msg_type'] = "success";
                    header("Location: ../members_list.php");
                }
            }
        }
    }

    if ($action == 'activate_member') { //active member again
        $member_id = $_POST['member_id'];

        $sql1 = "UPDATE `tbl_members_info` SET `employment_status`='Active' WHERE member_id = $member_id";

        if ($conn->query($sql1) === TRUE) {       
            $_SESSION['message'] = "<strong>Great! </strong>You activate a member successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../members_list.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if ($action == 'activate_department') { //active department again
        $department_id = $_POST['department_id'];

        $sql1 = "UPDATE `tbl_department` SET `dept_status`='activated' WHERE department_id = $department_id";

        if ($conn->query($sql1) === TRUE) {       
            $_SESSION['message'] = "<strong>Great! </strong>You activate a department successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../department_list.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if ($action == 'activate_position') { //active position again
        $position_id = $_POST['position_id'];

        $sql1 = "UPDATE `tbl_position` SET `position_status`='activated' WHERE position_id = $position_id";

        if ($conn->query($sql1) === TRUE) {       
            $_SESSION['message'] = "<strong>Great! </strong>You activate a position successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../position_list.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if ($action == 'activate_loan_type') { //active loan type again
        $loan_type_id = $_POST['loan_type_id'];

        $sql1 = "UPDATE `tbl_loan_type` SET `loan_type_status`='activated' WHERE loan_type_id = $loan_type_id";

        if ($conn->query($sql1) === TRUE) {       
            $_SESSION['message'] = "<strong>Great! </strong>You activate a type again successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../loan_types.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if($action == 'status_value'){ //managers decision whether the member is approve or decline

        $loan_amount = $_POST['input_loan_amount'];
        $payment_term = $_POST['input_payment_term']." months";
        $total_interest = $_POST['total_interest'];
        $total_payable_amount = $_POST['total_payable_amount'];
        $monthly_payable_amount = $_POST['monthly_payable_amount'];
        $approval_date = "0000-00-00";
        $managerID = $_POST['managerID'];
        $loan_id = $_POST['loan_id'];
        $member_id = $_POST['member_id'];
        $total_share_capital = $_POST['total_share_capital'];
        $total_service_fee = $_POST['total_service_fee'];
        $renewed = $_POST['renewed'];
        $user_type = $_POST['user_type'];
        $dateToday = date("Y-m-d");

        if ($user_type == "credit committee" || $user_type == "system administrator") {
            if (isset($_POST["requestApprove"])) { //Credit committee clicked approve button
                #CHECK IF THE CREDIT COMMITTEE ALREADY APPROVED PARTICULAR LOAN REQUEST
                $sql4 = "SELECT * FROM `tbl_loan_approval` WHERE manager_id = $managerID AND loan_id = $loan_id";
                $sql4Result  = mysqli_query($conn, $sql4);
                $sql4Row = mysqli_fetch_assoc($sql4Result);
                if ($sql4Row == TRUE) { #CHECK IF THE CREDIT COMMITTEE ALREADY APPROVED PARTICULAR LOAN REQUEST
                    $_SESSION['message'] = '<strong>Oops! </strong>You already approved the request.';
                    $_SESSION['msg_type'] = "danger";
                    header("Location: ../loan_list.php");
                } else {
                    #EDIT MEMBER'S LOAN APPLICATION
                    $sql6 = "UPDATE `tbl_loan_list` SET `loan_amount`=$loan_amount, `total_interest`=$total_interest, `total_payable_amount`=$total_payable_amount, `monthly_payable_amount`=$monthly_payable_amount, `loan_balance`=$loan_amount, `payment_term`='$payment_term', `approval_date`=$approval_date WHERE `loan_id` = $loan_id";
                    if ($conn->query($sql6) === TRUE) {       
                        $_SESSION['message'] = '<strong>Great! </strong>You approve the application.';
                        $_SESSION['msg_type'] = "success";
                        header("Location: ../loan_list.php");
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    #CHECK THE NUMBER OF CREDIT COMMITTEE AND MANAGER
                    $sql = 'SELECT * FROM `tbl_user_accounts` WHERE user_type = "manager" OR user_type = "credit committee"';
                    $sqlResult = mysqli_query($conn, $sql);
                    $sqlRowArray = array();
                    while($sqlRow = mysqli_fetch_assoc($sqlResult)){
                        $sqlRowArray[] = array($sqlRow);
                    }
                    $numOfManager = count($sqlRowArray);
    
                    #INSERT DATA ON tbl_loan_approval
                    $sql1 = "INSERT INTO `tbl_loan_approval`(`loan_id`,`manager_id`,`approval_date`) 
                             VALUES ($loan_id,$managerID,'$dateToday')";
                    if ($conn->query($sql1) === TRUE) {
                        #CHECK THE NUMBER OF APPROVAL
                        $sql2 = "SELECT * FROM tbl_loan_approval WHERE loan_id = $loan_id";
                        $sql2Result = mysqli_query($conn, $sql2);
                        while($sql2Row = mysqli_fetch_assoc($sql2Result)){
                            $sql2RowArray[] = array($sql2Row);
                        }
                        $approvalCount = count($sql2RowArray);
                        if ($approvalCount >= $numOfManager) { #CHECK IF ALL CREDIT COMMITTEE AND MANAGER APPROVED
                            $approval_date = date("Y-m-d");
                            if(empty($renewed)) { #CHECK IF THE LOAN IS RENEWAL
                                $sql3 = "UPDATE `tbl_loan_list` SET `status` = 'approved', `approval_date` = '$approval_date', `notification_1` = '1' WHERE loan_id = $loan_id";
                                if ($conn->query($sql3) === TRUE) {
                                    if ($total_share_capital > 0) {
                                        $sql4 = "INSERT INTO `tbl_shares`(`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`date`) VALUES ('$member_id','0','$total_share_capital','0','0','$dateToday')";
                                        if ($conn->query($sql4) === TRUE) {
                                            $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                            $_SESSION['msg_type'] = "success";
                                            header("Location: ../loan_list.php");
                                        } else {
                                            echo "Error inserting record: " . $conn->error;
                                        }
                                    }
                                    if ($total_service_fee > 0) {
                                        $sql5 = "INSERT INTO `tbl_service_fees` (`loan_id`, `service_fee_amount`, `date`) VALUES ($loan_id, $total_service_fee, '$dateToday')";
                                        if ($conn->query($sql5) === TRUE) {
                                            $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                            $_SESSION['msg_type'] = "success";
                                            header("Location: ../loan_list.php");
                                        } else {
                                            echo "Error inserting record: " . $conn->error;
                                        }
                                    }
                                    if ($total_service_fee <= 0 && $total_share_capital <= 0) {
                                        $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                        $_SESSION['msg_type'] = "success";
                                        header("Location: ../loan_list.php");
                                    }
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                            } else {
                                $sql6 = "UPDATE `tbl_loan_list` SET `loan_balance` = 0, `status`= 'renewed' WHERE `loan_id`= $renewed";
                                if ($conn->query($sql6) === TRUE) {
                                    $sql3 = "UPDATE `tbl_loan_list` SET `status` = 'approved', `approval_date` = '$approval_date', `notification_1` = '1' WHERE loan_id = $loan_id";
                                    if ($conn->query($sql3) === TRUE) {
                                        if ($total_share_capital > 0) {
                                            $sql4 = "INSERT INTO `tbl_shares`(`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`date`) VALUES ('$member_id','0','$total_share_capital','0','0','$dateToday')";
                                            if ($conn->query($sql4) === TRUE) {
                                                $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                                $_SESSION['msg_type'] = "success";
                                                header("Location: ../loan_list.php");
                                            } else {
                                                echo "Error inserting record: " . $conn->error;
                                            }
                                        }
                                        if ($total_service_fee > 0) {
                                            $sql5 = "INSERT INTO `tbl_service_fees` (`loan_id`, `service_fee_amount`, `date`) VALUES ($loan_id, $total_service_fee, '$dateToday')";
                                            if ($conn->query($sql5) === TRUE) {
                                                $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                                $_SESSION['msg_type'] = "success";
                                                header("Location: ../loan_list.php");
                                            } else {
                                                echo "Error inserting record: " . $conn->error;
                                            }
                                        }
                                        if ($total_service_fee <= 0 && $total_share_capital <= 0) {
                                            $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                            $_SESSION['msg_type'] = "success";
                                            header("Location: ../loan_list.php");
                                        }
                                    } else {
                                        echo "Error updating record: " . $conn->error;
                                    }
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                            }
                        }
                        $_SESSION['message'] = '<strong>Great! </strong>You approve the application.';
                        $_SESSION['msg_type'] = "success";
                        header("Location: ../loan_list.php");
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                }
            }
            if (isset($_POST["requestDecline"])) { //Credit committee clicked decline button
                #CHECK IF THE CREDIT COMMITTEE ALREADY APPROVED PARTICULAR LOAN REQUEST
                $sql4 = "SELECT * FROM `tbl_loan_approval` WHERE manager_id = $managerID AND loan_id = $loan_id";
                $sql4Result = mysqli_query($conn, $sql4);
                $sql4Row = mysqli_fetch_assoc($sql4Result);
                if ($sql4Row == TRUE) { #CHECK IF THE MANAGER ALREADY APPROVED PARTICULAR LOAN REQUEST
                    $_SESSION['message'] = '<strong>Oops! </strong>You already approved the request.';
                    $_SESSION['msg_type'] = "danger";
                    header("Location: ../loan_list.php");
                } else {
                    $sql = "UPDATE `tbl_loan_list` SET `status` = 'declined', `notification_1` = '1' WHERE loan_id = $loan_id";
                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = '<strong>Notice! </strong>The application is declined!';
                        $_SESSION['msg_type'] = "warning";
                        header("Location: ../loan_list.php");
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                } 
            }
        } else if ($user_type == 'manager') {
            if (isset($_POST["requestApprove"])) { //Manager clicked approve button

                #CHECK IF THE MANAGER ALREADY APPROVED PARTICULAR LOAN REQUEST
                $sql4 = "SELECT * FROM `tbl_loan_approval` WHERE manager_id = $managerID AND loan_id = $loan_id";
                $sql4Result  = mysqli_query($conn, $sql4);
                $sql4Row = mysqli_fetch_assoc($sql4Result);
                if ($sql4Row == TRUE) { #CHECK IF THE MANAGER ALREADY APPROVED PARTICULAR LOAN REQUEST
                    $_SESSION['message'] = '<strong>Oops! </strong>You already approved the request.';
                    $_SESSION['msg_type'] = "danger";
                    header("Location: ../loan_list.php");
                } else {
                    #CHECK THE NUMBER OF CREDIT COMMITTEE AND MANAGER
                    $sql = 'SELECT * FROM `tbl_user_accounts` WHERE user_type = "manager" OR user_type = "credit committee"';
                    $sqlResult = mysqli_query($conn, $sql);
                    $sqlRowArray = array();
                    while($sqlRow = mysqli_fetch_assoc($sqlResult)){
                        $sqlRowArray[] = array($sqlRow);
                    }
                    $numOfManager = count($sqlRowArray);
                    #INSERT DATA ON tbl_loan_approval
                    $sql1 = "INSERT INTO `tbl_loan_approval`(`loan_id`,`manager_id`,`approval_date`) 
                             VALUES ($loan_id,$managerID,'$dateToday')";
                    if ($conn->query($sql1) === TRUE) {
                        #CHECK THE NUMBER OF APPROVAL
                        $sql2 = "SELECT * FROM tbl_loan_approval WHERE loan_id = $loan_id";
                        $sql2Result = mysqli_query($conn, $sql2);
                        while($sql2Row = mysqli_fetch_assoc($sql2Result)){
                            $sql2RowArray[] = array($sql2Row);
                        }
                        $approvalCount = count($sql2RowArray);
                        if ($approvalCount >= $numOfManager) { #CHECK IF ALL CREDIT COMMITTEE AND MANAGER APPROVED
                            $approval_date = date("Y-m-d");
                            if(empty($renewed)) { #CHECK IF THE LOAN IS RENEWAL
                                $sql3 = "UPDATE `tbl_loan_list` SET `status` = 'approved', `approval_date` = '$approval_date', `notification_1` = '1' WHERE loan_id = $loan_id";
                                if ($conn->query($sql3) === TRUE) {
                                    if ($total_share_capital > 0) {
                                        $sql4 = "INSERT INTO `tbl_shares`(`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`date`) VALUES ('$member_id','0','$total_share_capital','0','0','$dateToday')";
                                        if ($conn->query($sql4) === TRUE) {
                                            $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                            $_SESSION['msg_type'] = "success";
                                            header("Location: ../loan_list.php");
                                        } else {
                                            echo "Error inserting record: " . $conn->error;
                                        }
                                    }
                                    if ($total_service_fee > 0) {
                                        $sql5 = "INSERT INTO `tbl_service_fees` (`loan_id`, `service_fee_amount`, `date`) VALUES ($loan_id, $total_service_fee, '$dateToday')";
                                        if ($conn->query($sql5) === TRUE) {
                                            $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                            $_SESSION['msg_type'] = "success";
                                            header("Location: ../loan_list.php");
                                        } else {
                                            echo "Error inserting record: " . $conn->error;
                                        }
                                    }
                                    if ($total_service_fee <= 0 && $total_share_capital <= 0) {
                                        $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                        $_SESSION['msg_type'] = "success";
                                        header("Location: ../loan_list.php");
                                    }
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                            } else {
                                $sql6 = "UPDATE `tbl_loan_list` SET `loan_balance` = 0, `status`= 'renewed' WHERE `loan_id`= $renewed";
                                if ($conn->query($sql6) === TRUE) {
                                    $sql3 = "UPDATE `tbl_loan_list` SET `status` = 'approved', `approval_date` = '$approval_date', `notification_1` = '1' WHERE loan_id = $loan_id";
                                    if ($conn->query($sql3) === TRUE) {
                                        if ($total_share_capital > 0) {
                                            $sql4 = "INSERT INTO `tbl_shares`(`member_id`,`remittance`,`retention`,`floatOR`,`withdrawal`,`date`) VALUES ('$member_id','0','$total_share_capital','0','0','$dateToday')";
                                            if ($conn->query($sql4) === TRUE) {
                                                $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                                $_SESSION['msg_type'] = "success";
                                                header("Location: ../loan_list.php");
                                            } else {
                                                echo "Error inserting record: " . $conn->error;
                                            }
                                        }
                                        if ($total_service_fee > 0) {
                                            $sql5 = "INSERT INTO `tbl_service_fees` (`loan_id`, `service_fee_amount`, `date`) VALUES ($loan_id, $total_service_fee, '$dateToday')";
                                            if ($conn->query($sql5) === TRUE) {
                                                $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                                $_SESSION['msg_type'] = "success";
                                                header("Location: ../loan_list.php");
                                            } else {
                                                echo "Error inserting record: " . $conn->error;
                                            }
                                        }
                                        if ($total_service_fee <= 0 && $total_share_capital <= 0) {
                                            $_SESSION['message'] = '<strong>Great! </strong>The application is now active!';
                                            $_SESSION['msg_type'] = "success";
                                            header("Location: ../loan_list.php");
                                        }
                                    } else {
                                        echo "Error updating record: " . $conn->error;
                                    }
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                            }
                        }
                        $_SESSION['message'] = '<strong>Great! </strong>You approve the application.';
                        $_SESSION['msg_type'] = "success";
                        header("Location: ../loan_list.php");
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                }
    
            }
            if (isset($_POST["requestDecline"])) { //Manager clicked decline button
    
                #CHECK IF THE MANAGER ALREADY APPROVED PARTICULAR LOAN REQUEST
                $sql4 = "SELECT * FROM `tbl_loan_approval` WHERE manager_id = $managerID AND loan_id = $loan_id";
                $sql4Result = mysqli_query($conn, $sql4);
                $sql4Row = mysqli_fetch_assoc($sql4Result);
                if ($sql4Row == TRUE) { #CHECK IF THE MANAGER ALREADY APPROVED PARTICULAR LOAN REQUEST
                    $_SESSION['message'] = '<strong>Oops! </strong>You already approved the request.';
                    $_SESSION['msg_type'] = "danger";
                    header("Location: ../loan_list.php");
                } else {
                    $sql = "UPDATE `tbl_loan_list` SET `status` = 'declined', `notification_1` = '1' WHERE loan_id = $loan_id";
                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = '<strong>Notice! </strong>The application is declined!';
                        $_SESSION['msg_type'] = "warning";
                        header("Location: ../loan_list.php");
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                } 
            }
        } else {
            $_SESSION['message'] = '<strong>Oops! </strong>An error occured.';
            $_SESSION['msg_type'] = "danger";
            header("Location: ../loan_list.php");
        }
    }

    if($action == 'comaker_confirmation'){//comakers decision whether he/she will approve or decline members comaker req.
        $firstname = $_POST['firstname'];
        $loan_id = $_POST['loan_id'];

        if (isset($_POST["requestApprove"])) { //comaker clicked approve button
            $sql = "UPDATE `tbl_loan_list` SET `comaker_confirmation` = 'accepted' WHERE loan_id = $loan_id";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "<strong>Great! </strong>You are now ".$firstname."'s comaker!";
                $_SESSION['msg_type'] = "success";
                header("Location: ../update_comaker_confirmation.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        if (isset($_POST["requestDecline"])) { //comaker clicked decline button
            $sql = "UPDATE `tbl_loan_list` SET `comaker_confirmation` = 'rejected' WHERE loan_id = $loan_id";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "<strong>Notice! </strong>You refused to become ".$firstname."'s comaker!";
                $_SESSION['msg_type'] = "warning";
                header("Location: ../update_comaker_confirmation.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }

    if($action == 'edit_share'){ //edit share
        $share_id = $_POST['share_id'];
        $member_id = $_POST['member_id'];
        $remittance = $_POST['remittance'];
        $retention = $_POST['retention'];
        $or = $_POST['or'];
        $withdrawal = $_POST['withdrawal'];
        echo $date = $_POST['date'];

        $sql = "UPDATE tbl_shares SET `member_id` = $member_id, `remittance` = $remittance, `retention` = $retention, `floatOR` = $or, `withdrawal` = $withdrawal, `date` = '$date' WHERE `shares_id` = $share_id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "<strong>Great! </strong>You edit a record successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../shares2.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if($action == 'change_comaker'){ //change comaker
        $comaker_id = $_POST['comaker_id'];
        $loan_id = $_POST['loan_id'];
        $encrypted_loan_id = $_POST['encrypted_loan_id'];
        $hashed = $_POST['hashed'];
        $sql = "UPDATE tbl_loan_list SET `comaker_id` = $comaker_id, `comaker_confirmation` = 'pending' WHERE `loan_id` = $loan_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "<strong>Great! </strong>Your comaker has been changed successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../view_loan_history.php?loan_id=".$encrypted_loan_id."&hashed=".$hashed);
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    if($action == 'update_check_number'){ //edit check number when loan activated
        $loan_id = $_POST['loan_id'];
        $encrypted_loan_id = $_POST['encrypted_loan_id'];
        $hashed = $_POST['hashed'];
        $check_number = $_POST['check_number'];
        $sql = "UPDATE `tbl_loan_list` SET `check_number` = '$check_number' WHERE `loan_id` = $loan_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "<strong>Great! </strong>Check number has been changed successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../view_loan_info.php?loan_id=".$encrypted_loan_id."&hashed=".$hashed);
        } else {
            echo "Error updating record: " . mysqli_error($conn);
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

    if ($action == 'change_password') { //User change password
        $member_id = $conn -> real_escape_string($_POST['member_id']);
        $old_pass = $conn -> real_escape_string($_POST['old_pass']);
        $new_pass = $conn -> real_escape_string($_POST['new_pass']);
        $confirm_pass = $conn -> real_escape_string($_POST['confirm_pass']);

        if ($new_pass != $confirm_pass) { //Check if new password and confirm password match
            $_SESSION['message'] = "<strong>Oops! </strong>New and confirm password does not match.";
            $_SESSION['msg_type'] = "danger";
            header("Location: ../change_pass.php");
        } else {
            $sql = "SELECT * FROM `tbl_user_accounts` WHERE member_id = ?";
            $stmt = $conn->prepare($sql);
			$stmt->bind_param("i", $member_id);
			$stmt->execute();
			$result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $member_password = $row['password'];
            $change_pass_date = date($row['change_pass_date']);
            $dateToday = date("Y-m-d");
            $stmt->close();
            if ($member_password == $old_pass) { //Check if old password match the new password

                if ($change_pass_date == "") { //First time reseting password
                    $sql1 = "UPDATE `tbl_user_accounts` SET `password` = ?, `change_pass_date` = ?  WHERE member_id = ?";
                    $stmt = $conn->prepare($sql1);
                    $stmt->bind_param("ssi", $new_pass, $dateToday, $member_id);
                    if ($stmt->execute()){
                        $_SESSION['message'] = "<strong>Great! </strong>Your password has been changed successfully! Reminder, you can only reset your password once a day.";
                        $_SESSION['msg_type'] = "success";
                        header("Location: ../change_pass.php");
                        $stmt->close();
                    }
                } else {
                    if ($change_pass_date == $dateToday) {
                        $_SESSION['message'] = "<strong>Oops! </strong>You can reset your password once a day only.";
                        $_SESSION['msg_type'] = "danger";
                        header("Location: ../change_pass.php");
                    } else {
                        $sql1 = "UPDATE `tbl_user_accounts` SET `password` = ?, `change_pass_date` = ?  WHERE member_id = ?";
                        $stmt = $conn->prepare($sql1);
                        $stmt->bind_param("ssi", $new_pass, $dateToday, $member_id);
                        if ($stmt->execute()){
                            $_SESSION['message'] = "<strong>Great! </strong>Your password has been changed successfully! Reminder, you can only reset your password once a day.";
                            $_SESSION['msg_type'] = "success";
                            header("Location: ../change_pass.php");
                            $stmt->close();
                        }
                    }
                }
            } else {
                $_SESSION['message'] = "<strong>Oops! </strong>Old password is incorrect.";
                $_SESSION['msg_type'] = "danger";
                header("Location: ../change_pass.php");
            }
        }
    }