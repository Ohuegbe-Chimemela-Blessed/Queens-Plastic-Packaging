<?php
session_start();
require_once "conn.php";

if (isset($_POST['save'])) {
	foreach ($_POST['indexes'] as $key) {
		$_SESSION['qty_array'][$key] = $_POST['qty_' . $key];
		$qty = intval($_SESSION['qty_array'][$key]);
		$product_id = $_SESSION['cart'][$key];
		$sql = "UPDATE cart_items SET quantity='$qty' WHERE product_id='$product_id' ";
		if (mysqli_query($mysqli, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($mysqli);
		}
	}
}

if (isset($_POST['clear'])) {
	unset($_SESSION['cart']);
	$_SESSION['message'] = 'Cart cleared successfully';
	$sql = "DELETE FROM cart_items";
	if (mysqli_query($mysqli, $sql)) {
		echo "All records deleted successfully";
	} else {
		echo "Error deleting records: " . mysqli_error($mysqli);
	}
}

mysqli_close($mysqli);

$_SESSION['message'] = 'Cart updated successfully';
header('location: cart.php');
