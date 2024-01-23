<?php
	session_start();
	include('../include/db_connect.php');
	include('../include/function.php');
	$action = $_GET['action'];

	if($action == 'fetch_single_login'){ //Login page goes here.
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$username = $conn -> real_escape_string($_POST['username']);
			$password = $conn -> real_escape_string($_POST['password']);
			$employment_status = "Active";

			$sql = "SELECT *, tbl_members_info.member_id, tbl_members_info.employment_status
					FROM tbl_user_accounts 
					LEFT JOIN tbl_members_info
					ON tbl_members_info.member_id  = tbl_user_accounts.member_id
					WHERE `username` = ?
					AND `password` = ?
					AND employment_status = ?
					LIMIT 1";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("sss", $username, $password, $employment_status);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$_SESSION['member_id'] = $row['member_id'];
					$_SESSION['user_type'] = $row['user_type'];
					echo 'Success';
				}
			} else {
				echo 'Incorrect username or password.';
			}
			$stmt->close();
		}
	}
?>