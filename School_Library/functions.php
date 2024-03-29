<?php
function invalidfirstname($firstname) {
	if (!preg_match("/^[a-zA-Zα-ωΑ-Ω άέώύόίήΆΈΏΎΌΊΉ]*$/u", $firstname)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidlastname($lastname) {
	if (!preg_match("/^[a-zA-Zα-ωΑ-Ω άέώύόίήΆΈΏΎΌΊΉ]*$/u", $lastname)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidname($name) {
	if (!preg_match("/^[a-zA-Zα-ωΑ-Ω άέώύόίήΆΈΏΎΌΊΉ]*$/u", $name)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidphone($phone) {
	if (!preg_match('/^2\d{9}$/', $phone)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}
function pwdMatch($password, $passwordrepeat) {
	if ($password !== $passwordrepeat) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function usernametaken($conn, $username) {
	$sql1 = "SELECT * FROM User WHERE Username = ?";
	$stmt1 = mysqli_stmt_init($conn);
	$sql2 = "SELECT * FROM Administrator WHERE Username = ?";
	$stmt2 = mysqli_stmt_init($conn);
	$sql3 = "SELECT * FROM LibraryOperator WHERE Username = ?";
	$stmt3 = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt1, $sql1) || !mysqli_stmt_prepare($stmt2, $sql2) || !mysqli_stmt_prepare($stmt3, $sql3)) {
		header("location: signup.php?error=stmtfailed");
		exit();
	}
	mysqli_stmt_bind_param($stmt1, "s", $username);
	mysqli_stmt_execute($stmt1);
	$resultData1 = mysqli_stmt_get_result($stmt1);
	mysqli_stmt_close($stmt1);
	
	mysqli_stmt_bind_param($stmt2, "s", $username);
	mysqli_stmt_execute($stmt2);
	$resultData2 = mysqli_stmt_get_result($stmt2);
	mysqli_stmt_close($stmt2);
	
	mysqli_stmt_bind_param($stmt3, "s", $username);
	mysqli_stmt_execute($stmt3);
	$resultData3 = mysqli_stmt_get_result($stmt3);
	mysqli_stmt_close($stmt3);

	if ($row = mysqli_fetch_assoc($resultData1) || $row = mysqli_fetch_assoc($resultData2) || $row = mysqli_fetch_assoc($resultData3)) {
		return $row;
	}
	else {
		$result = false;
		return $result;
	}
}

function libraryoperatorexists($conn, $school) {
	$sql = "SELECT * FROM LibraryOperator WHERE School_ID = ?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: signup.php?error=stmtfailed");
		exit();
	}
	mysqli_stmt_bind_param($stmt, "i", $school);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	mysqli_stmt_close($stmt);

	if (mysqli_fetch_assoc($resultData)) {
		$result = true;
		return $result;
	}
	else {
		$result = false;
		return $result;
	}
}

function schoolexists($conn, $schoolname, $id) {
	$sql = "SELECT school_id FROM school WHERE name = ?";
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "s", $schoolname);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	mysqli_stmt_close($stmt);

	if ($row = mysqli_fetch_row($resultData)) {
		if ($row[0] != $id) {
			$result = true;
			return $result;
		}
		else {
			$result = false;
			return $result;
		}
	}
	else {
		$result = false;
		return $result;
	}
}

function phoneexists($conn, $phone, $id) {
	$sql = "SELECT school_id FROM school WHERE phone_number = ?";
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "i", $phone);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	mysqli_stmt_close($stmt);

	if ($row = mysqli_fetch_row($resultData)) {
		if ($row[0] != $id) {
			$result = true;
			return $result;
		}
		else {
			$result = false;
			return $result;
		}
	}
	else {
		$result = false;
		return $result;
	}
}

function createUser($conn, $firstname, $lastname, $username, $password, $age, $role, $school) {
	$stmt = $conn->prepare("SELECT LibraryOperator_ID FROM LibraryOperator WHERE School_ID = '$school'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];
	$sql = "INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, School_ID, LibraryOperator_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: signup.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ssssisii", $username, $password, $firstname, $lastname,  $age, $role, $school, $libraryOperatorId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: signup.php?error=none");
	exit();
}

function createLibraryOperator($conn, $firstname, $lastname, $username, $password, $age, $school) {
	$stmt = $conn->prepare("SELECT Admin_ID FROM School WHERE School_ID = '$school'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $adminId = $row['Admin_ID'];
	$sql = "INSERT INTO LibraryOperator (Username, Password, First_Name, Last_Name, Age, School_ID, Admin_ID) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: signup.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ssssiii", $username, $password, $firstname, $lastname, $age, $school, $adminId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: signup.php?error=none");
	exit();
}

function loginUser($conn, $username, $password) {
	$sql1 = "SELECT * FROM User WHERE Username = ?";
	$stmt1 = mysqli_stmt_init($conn);
	$sql2 = "SELECT * FROM Administrator WHERE Username = ?";
	$stmt2 = mysqli_stmt_init($conn);
	$sql3 = "SELECT * FROM LibraryOperator WHERE Username = ?";
	$stmt3 = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt1, $sql1) || !mysqli_stmt_prepare($stmt2, $sql2) || !mysqli_stmt_prepare($stmt3, $sql3)) {
		header("location: signin.php?error=stmtfailed");
		exit();
	}
	mysqli_stmt_bind_param($stmt1, "s", $username);
	mysqli_stmt_execute($stmt1);
	$resultData1 = mysqli_stmt_get_result($stmt1);
	mysqli_stmt_close($stmt1);
	
	mysqli_stmt_bind_param($stmt2, "s", $username);
	mysqli_stmt_execute($stmt2);
	$resultData2 = mysqli_stmt_get_result($stmt2);
	mysqli_stmt_close($stmt2);
	
	mysqli_stmt_bind_param($stmt3, "s", $username);
	mysqli_stmt_execute($stmt3);
	$resultData3 = mysqli_stmt_get_result($stmt3);
	mysqli_stmt_close($stmt3);

	if ($row = mysqli_fetch_assoc($resultData1)) {
		if ($password != $row['Password']) {
			header("location: signin.php?error=wrongpassword");
			exit();
		}
		else if ($password == $row['Password']) {
			if ($row['Approved'] == 0) {
				header("location: signin.php?error=notapproved");
				exit();
			}
			else {
				session_start();
				$_SESSION["user_id"] = $row['User_ID'];
				header("location: user.php");
				exit();
			}
		}
	}
	else if ($row = mysqli_fetch_assoc($resultData2)) {
		if ($password != $row['Password']) {
			header("location: signin.php?error=wrongpassword");
			exit();
		}
		else if ($password == $row['Password']) {
			session_start();
			$_SESSION["admin_id"] = $row['Admin_ID'];
			header("location: admin.php");
			exit();
		}
	}
	else if ($row = mysqli_fetch_assoc($resultData3)) {
		if ($password != $row['Password']) {
			header("location: signin.php?error=wrongpassword");
			exit();
		}
		else if ($password == $row['Password']) {
			if ($row['Approved'] == 0) {
				header("location: signin.php?error=notapproved");
				exit();
			}
			else {
				session_start();
				$_SESSION["libraryoperator_id"] = $row['LibraryOperator_ID'];
				header("location: libraryoperator.php");
				exit();
			}
		}
	}
	else {
		header("location: signin.php?error=wrongusername");
		exit();
	}
}

function check_user_login($conn) {
	if(isset($_SESSION['user_id'])) {
		$id = $_SESSION['user_id'];
		$query = "select * from User where User_id = '$id' limit 1";
		$result = mysqli_query($conn,$query);
		if($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}
	header("Location: index.php");
	die;
}

function check_admin_login($conn) {
	if(isset($_SESSION['admin_id'])) {
		$id = $_SESSION['admin_id'];
		$query = "select * from Administrator where Admin_ID = '$id' limit 1";
		$result = mysqli_query($conn,$query);
		if($result && mysqli_num_rows($result) > 0) {
			$admin_data = mysqli_fetch_assoc($result);
			return $admin_data;
		}
	}
	header("Location: index.php");
	die;
}

function check_libraryoperator_login($conn) {
	if(isset($_SESSION['libraryoperator_id'])) {
		$id = $_SESSION['libraryoperator_id'];
		$query = "select * from LibraryOperator where LibraryOperator_ID = '$id' limit 1";
		$result = mysqli_query($conn,$query);
		if($result && mysqli_num_rows($result) > 0) {
			$libraryoperator_data = mysqli_fetch_assoc($result);
			return $libraryoperator_data;
		}
	}
	header("Location: index.php");
	die;
}

function changepassword($conn, $username, $oldpassword, $newpassword) {
	$sql1 = "SELECT * FROM User WHERE Username = ?";
	$stmt1 = mysqli_stmt_init($conn);
	$sql2 = "SELECT * FROM Administrator WHERE Username = ?";
	$stmt2 = mysqli_stmt_init($conn);
	$sql3 = "SELECT * FROM LibraryOperator WHERE Username = ?";
	$stmt3 = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt1, $sql1) || !mysqli_stmt_prepare($stmt2, $sql2) || !mysqli_stmt_prepare($stmt3, $sql3)) {
		header("location: password.php?error=stmtfailed");
		exit();
	}
	mysqli_stmt_bind_param($stmt1, "s", $username);
	mysqli_stmt_execute($stmt1);
	$resultData1 = mysqli_stmt_get_result($stmt1);
	mysqli_stmt_close($stmt1);
	
	mysqli_stmt_bind_param($stmt2, "s", $username);
	mysqli_stmt_execute($stmt2);
	$resultData2 = mysqli_stmt_get_result($stmt2);
	mysqli_stmt_close($stmt2);
	
	mysqli_stmt_bind_param($stmt3, "s", $username);
	mysqli_stmt_execute($stmt3);
	$resultData3 = mysqli_stmt_get_result($stmt3);
	mysqli_stmt_close($stmt3);

	if ($row = mysqli_fetch_assoc($resultData1)) {
		if ($oldpassword != $row['Password']) {
			header("location: password.php?error=wrongpassword");
			exit();
		}
		else if ($oldpassword == $row['Password']) {
			$query = "UPDATE User 
                    SET Password = '$newpassword'
                    WHERE Username = '$username'";
            if (mysqli_query($conn, $query)) {
				header("location: password.php?error=none");
				exit();
            }
			else {
				header("location: password.php?error=stmtfailed");
				exit();
			}
		}
	}
	else if ($row = mysqli_fetch_assoc($resultData2)) {
		if ($oldpassword != $row['Password']) {
			header("location: password.php?error=wrongpassword");
			exit();
		}
		else if ($oldpassword == $row['Password']) {
			$query = "UPDATE Administrator 
			SET Password = '$newpassword'
			WHERE Username = '$username'";
			if (mysqli_query($conn, $query)) {
				header("location: password.php?error=none");
				exit();
			}
			else {
				header("location: password.php?error=stmtfailed");
				exit();
			}
		}
	}
	else if ($row = mysqli_fetch_assoc($resultData3)) {
		if ($oldpassword != $row['Password']) {
			header("location: signin.php?error=wrongpassword");
			exit();
		}
		else if ($oldpassword == $row['Password']) {
			$query = "UPDATE LibraryOperator 
			SET Password = '$newpassword'
			WHERE Username = '$username'";
			if (mysqli_query($conn, $query)) {
				header("location: password.php?error=none");
				exit();
			}
			else {
				header("location: password.php?error=stmtfailed");
				exit();
			}
		}
	}
	else {
		header("location: password.php?error=wrongusername");
		exit();
	}
}

function invalidimageurl($image)
{
    $pattern = '/^(http(s)?:\/\/)?[a-zA-Z0-9_\-]+(\.[a-zA-Z0-9_\-]+)*(\.[a-zA-Z]{2,6})(\/[a-zA-Z0-9_\-\.]+)*(\?[\w\-\.\[\]]*=[\w\-\.\[\]]*(&[\w\-\.\[\]]*=[\w\-\.\[\]]*)*)?$/';

    if (!preg_match($pattern, $image)) {
        return true;
    }

    return false;
}

function invalidisbn($isbn) {
	if (!preg_match('/^97\d{11}$/', $isbn)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function isbnexists($conn, $isbn, $id) {
	$sql = "SELECT book_id FROM book WHERE isbn = ?";
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "i", $isbn);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	mysqli_stmt_close($stmt);

	if ($row = mysqli_fetch_row($resultData)) {
		if ($row[0] != $id) {
			$result = true;
			return $result;
		}
		else {
			$result = false;
			return $result;
		}
	}
	else {
		$result = false;
		return $result;
	}
}

function titleexists($conn, $title, $id) {
	$sql = "SELECT book_id FROM book WHERE title = ?";
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "s", $title);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	mysqli_stmt_close($stmt);

	if ($row = mysqli_fetch_row($resultData)) {
		if ($row[0] != $id) {
			$result = true;
			return $result;
		}
		else {
			$result = false;
			return $result;
		}
	}
	else {
		$result = false;
		return $result;
	}
}