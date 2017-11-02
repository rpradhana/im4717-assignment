<?php
	session_start();

	if (isset($_POST['quantity'])) {
		$_SESSION['quantity'] = $_POST['quantity'];
		echo $_POST['quantity'];
	}
?>