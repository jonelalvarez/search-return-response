<?php

require_once 'dbConfig.php';
require_once 'models.php';


if (isset($_POST['insertUserBtn'])) {
	$insertUser = insertNewUser($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['suffix'], $_POST['bdate'], $_POST['gender'], $_POST['nationality'], $_POST['email']);

	if ($insertUser) {
		$_SESSION['message'] = "Successfully inserted!";
		$_SESSION['status'] = "success";
	} else {
		$_SESSION['message'] = "Failed to insert!";
		$_SESSION['status'] = "error";
	}
	header("Location: ../index.php");
}



if (isset($_POST['editUserBtn'])) {
	$editUser = editUser($pdo, $_POST['gender'], $_POST['nationality'], $_POST['email'], $_GET['astronaut_id']);

	if ($editUser) {
		$_SESSION['message'] = "Successfully edited!";
		$_SESSION['status'] = "success";
	} else {
		$_SESSION['message'] = "Failed to edit!";
		$_SESSION['status'] = "error";
	}
	header("Location: ../index.php");
}


if (isset($_POST['deleteUserBtn'])) {
	$deleteUser = deleteUser($pdo, $_GET['astronaut_id']);

	if ($deleteUser) {
		$_SESSION['message'] = "Successfully deleted!";
		$_SESSION['status'] = "success";
	} else {
		$_SESSION['message'] = "Failed to delete!";
		$_SESSION['status'] = "error";
	}
	header("Location: ../index.php");
}


if (isset($_GET['searchBtn'])) {
	$searchForAUser = searchForAUser($pdo, $_GET['searchInput']);
	foreach ($searchForAUser as $row) {
		echo "<tr> 
				<td>{$row['astronaut_id']}</td>
				<td>{$row['first_name']}</td>
				<td>{$row['last_name']}</td>
				<td>{$row['suffix']}</td>
				<td>{$row['bdate']}</td>
				<td>{$row['gender']}</td>
				<td>{$row['nationality']}</td>
				<td>{$row['email']}</td>
				<td>{$row['status']}</td>
			  </tr>";
	}
}

?>