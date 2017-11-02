<?php
	session_start();

	$cart = array_search('1', array_column($_SESSION['cart'], 'id'));

	if (isset($_POST['quantity'])) {
		echo $_POST['quantity'] . ', ';
		echo $_POST['cart'] . ', ';
		var_dump($_SESSION);
	}
?>