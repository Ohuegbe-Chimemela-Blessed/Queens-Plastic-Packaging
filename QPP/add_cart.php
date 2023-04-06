<?php
session_start();

$customer_id = $_SESSION["id"];
require_once "conn.php";

// Check if product is already in the cart
if (!in_array($_GET['id'], $_SESSION['cart'])) {
	// Add product to the cart
	array_push($_SESSION['cart'], $_GET['id']);
	$_SESSION['message'] = 'Product added to cart';

	// Get product details from the database
	$id = $_GET['id'];
	$sql = "SELECT * FROM products WHERE id = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$product = mysqli_fetch_assoc($result);

	// Insert product into the cart_items table
	if (mysqli_num_rows($result) > 0) {
		// $customer_id = $_SESSION["id"]; // Get the customer ID from the session
		$name = $product['Name'];
		$price = $product['product_Price'];
		$sql2 = "INSERT INTO cart_items (product_id, product_name, price, customer_id) VALUES (?, ?, ?, ?)";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "isdi", $id, $name, $price, $customer_id);
		mysqli_stmt_execute($stmt2);
		if (mysqli_stmt_affected_rows($stmt2) > 0) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
		}
	}
} else {
	$_SESSION['message'] = 'Product already in cart';
}

header('location: product.php');
