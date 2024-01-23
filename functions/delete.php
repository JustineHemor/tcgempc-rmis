<?php
    session_start();
    include('../include/db_connect.php');
    include('../include/function.php');
    $action = $_GET['action'];
    
    if($action == 'delete_department'){ //Delete record on tbl_department
        $department_id = $_POST['department_id'];
        $sql = "UPDATE `tbl_department` SET `dept_status`='deactivated' WHERE `department_id` = $department_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "<strong>Notice! </strong>You archive a department.";
            $_SESSION['msg_type'] = "warning";
            header("Location: ../department_list.php");
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
    
    if($action == 'delete_position'){ //Delete record on tbl_position
        $position_id = $_POST['position_id'];
        $sql = "UPDATE `tbl_position` SET `position_status`='deactivated' WHERE `position_id` = $position_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "<strong>Notice! </strong>You archive a position.";
            $_SESSION['msg_type'] = "warning";
            header("Location: ../position_list.php");
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }

    if($action == 'delete_loan_type'){ //Delete record on tbl_loan_type
        $loan_type_id = $_POST['loan_type_id'];
        $sql = "UPDATE `tbl_loan_type` SET `loan_type_status`='deactivated' WHERE `loan_type_id` = $loan_type_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "<strong>Notice! </strong>You archive a loan type.";
            $_SESSION['msg_type'] = "warning";
            header("Location: ../loan_types.php");
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }

    if ($action == 'edit_employment_status') { //add employment status on tbl_members_info
        $employment_status = $_POST['employment_status'];
        $member_id = $_POST['member_id'];

        $sql1 = "UPDATE `tbl_members_info` SET `employment_status`='$employment_status' WHERE member_id = $member_id";

        if ($conn->query($sql1) === TRUE) {       
            header("Location: ../members_list.php");
            $_SESSION['message'] = "<strong>Notice! </strong>You archive a member.";
            $_SESSION['msg_type'] = "warning";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

?>