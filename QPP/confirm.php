<?php
session_start();
require_once "conn.php";

$total = isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 0;

// Get the current user's cart details
$id = $_SESSION["id"];
// $sql = "SELECT * FROM user WHERE id = '$id'";
// $result = mysqli_query($mysqli, $sql);
// $user = mysqli_fetch_assoc($result);
// if (mysqli_num_rows($result) > 0) {
//   $Fname = $user['First_Name'];
//   $email = $user['Email'];
//   $phone = $user['Phone_number'];
// }
if (isset($_POST['Confirm_order'])) {
  $customer_name = $_POST['name'];
  $customer_email = $_POST['email'];
  $customer_phone = $_POST['phone'];
  $product_price = $total;
  $customer_address = $_POST['address'];

  $sql = "SELECT * FROM cart_items WHERE customer_id = $id";
  $res = mysqli_query($mysqli, $sql);

  // Insert the cart details into the orders table
  $insert_query = '';
  while ($row = mysqli_fetch_assoc($res)) {
    $product_id = $row['product_id'];
    $product_name = $row['product_name'];
    $quantity = $row['quantity'];
    $price = $row['price'];
    $insert_query .= "INSERT INTO orders (user_id, product_id,product_name, quantity, price, customer_name, customer_email, customer_phone, product_price,customer_address) VALUES ('$id', '$product_id','$product_name', '$quantity', '$price','$customer_name', '$customer_email', '$customer_phone', '$product_price','$customer_address');";
  }
  mysqli_multi_query($mysqli, $insert_query);

  // Free all the result sets from the previous query
  while (mysqli_next_result($mysqli)) {
    if ($result = mysqli_store_result($mysqli)) {
      mysqli_free_result($result);
    }
  }

  // Update the cart items table
  $sql = "DELETE FROM cart_items WHERE customer_id = $id";
  mysqli_query($mysqli, $sql);

  if ($res) {
    header("location: confirmOrder.php");
  } else {
    echo "Error placing order.";
  }
}

// // $_SESSION["Email"] = $Email;
// $email = 'emelifonwuw@gmail.com';

// $sql = "SELECT * FROM orders WHERE user_id = '$id'";
// $result = $mysqli->query($sql);

// $order_details = array();
// if ($result->num_rows > 0) {
//   while ($row = $result->fetch_assoc()) {
//     $order_details[] = $row;
//   }
// }

// // Step 2: Generate HTML table
// $html = '<table><tr><th>Product Name</th><th>Quantity</th><th>Price</th></tr>';

// foreach ($order_details as $order_item) {
//   $html .= '<tr><td>' . $order_item['product_name'] . '</td><td>' . $order_item['quantity'] . '</td><td>' . $order_item['price'] . '</td></tr>';
// }

// $html .= '</table>';

// // Step 3: Compose and send email
// $to = $email;
// $subject = 'Your Order Details';

// $headers = "MIME-Version: 1.0" . "\r\n";
// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// $message = '<html><body>';
// $message .= '<p>Dear customer,</p>';
// $message .= '<p>Thank you for your recent purchase. Here are the details of your order:</p>';
// $message .= $html;
// $message .= '<p>Thank you for shopping with us!</p>';
// $message .= '</body></html>';

// mail($to, $subject, $message, $headers);




// require 'vendor/autoload.php';
// use Mailgun\Mailgun;
// # Instantiate the client.
// $mgClient = new Mailgun('4ed1befa158bf5700e5524ec8ecedd05-15b35dee-17371da2');
// $domain = "YOUR_DOMAIN_NAME";
// # Make the call to the client.
// $result = $mgClient->sendMessage($domain, array(
// 	'from'	=> 'Excited User <mailgun@YOUR_DOMAIN_NAME>',
// 	'to'	=> 'Baz <YOU@YOUR_DOMAIN_NAME>',
// 	'subject' => 'Hello',
// 	'text'	=> 'Testing some Mailgun awesomness!'
// ));
