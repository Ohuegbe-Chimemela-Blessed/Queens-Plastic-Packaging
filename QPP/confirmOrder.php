<?php
session_start();
require_once "conn.php";
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: log-in.php");
    exit;
}
$total = isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 0;

$id = $_SESSION["id"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="check.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <title>All Products|Queen's Plastic Packaging | E-commerce Website</title>

    <link href="index.html">

</head>
<?php
$sql = "SELECT customer_email FROM orders WHERE user_id = $id";
$result = mysqli_query($mysqli, $sql);
$user = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
    $Email = $user['customer_email'];
}
?>

<body>

    <h1>Checkout page</h1>

    <form method="post" action="">

        <input type="text" name="name" id="name" placeholder="Insert your full name" required hidden><br>

        <input type="text" name="phone" id="phone" placeholder="insert your phone number" required hidden><br>

        <input type="email" value="<?php echo $Email; ?>" placeholder="insert your email address" name="email" id="email" hidden><br><br>


        <input type="text" id="total_price" name="total_price" value="<?php echo $total; ?>" disabled hidden>


        <a href="confirm_order.php" class="btn"> Back</a>
        <button type="submit" onclick="payWithPaystack()">CLICK TO PROCEED WITH PAYMENT </button>
    </form>




    <?php include 'footer.php'; ?>


</body>

</html>
<style>
    /* Checkout page styles */

    /* Header */
    /* Checkout page styling */

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-top: 30px;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="tel"],
    form button,
    form a.btn {
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
        color: #333;
        background-color: #f2f2f2;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        margin-bottom: 10px;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="tel"],
    form button {
        width: 100%;
    }

    form input[type="text"]:focus,
    form input[type="email"]:focus,
    form input[type="tel"]:focus,
    form button:focus,
    form a.btn:focus {
        outline: none;
    }

    form button {
        cursor: pointer;
        background-color: #0066ff;
        color: #fff;
        font-weight: bold;
    }

    form a.btn {
        cursor: pointer;
        background-color: #ccc;
        color: #333;
        font-weight: bold;
    }

    /* Footer styling */

    .footer {
        background-color: #222;
        color: #fff;
        padding: 50px 0;
    }

    .footer h1,
    .footer h3 {
        font-family: 'Montserrat', sans-serif;
        margin-bottom: 20px;
    }

    .footer p {
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .footer hr {
        margin: 30px 0;
        border: none;
        height: 1px;
        background-color: #555;
    }

    .footer-col-1,
    .footer-col-2,
    .footer-col-4,
    .footer-col-5 {
        width: 25%;
        padding: 0 20px;
    }

    .footer-col-2 h1 {
        font-size: 32px;
        margin-bottom: 30px;
    }

    .footer-col-4 ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .footer-col-4 ul li {
        margin-bottom: 10px;
    }

    .footer-col-5 ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .footer-col-5 ul li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .footer-col-5 ul li i {
        font-size: 24px;
        margin-right: 10px;
    }

    @media (max-width: 992px) {

        .footer-col-1,
        .footer-col-2,
        .footer-col-4,
        .footer-col-5 {
            width: 50%;
            margin-bottom: 30px;
        }
    }

    @media (max-width: 768px) {

        .footer-col-1,
        .footer-col-2,
        .footer-col-4,
        .footer-col-5 {
            width: 100%;
        }
    }
</style>