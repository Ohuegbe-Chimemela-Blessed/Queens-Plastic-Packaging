<?php
require_once('paystack.php');

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$shipping_address = $_POST['shipping_address'];
$billing_address = $_POST['billing_address'];
$total_price = $_POST['total_price'];

// Validate form data here

$transaction_reference = generate_transaction_reference();

// Send a POST request to Paystack API
$response = paystack_payment($transaction_reference, $total_price, $email);

// Redirect the customer to Paystack payment gateway
header('Location: ' . $response['data']['authorization_url']);

// Handle Paystack webhook notification here
