<?php
require("function.php");
require_once 'conn.php';
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: log-in-admin.php");
    exit;
}
$reference = $_GET['reference'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Queen's Plastic Packaging</title>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <div class="admin-container">
        <div class="ad-nav">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fa-solid fa-sparkles"></i></span>
                        <span class="title  b-name"><i class="fa-solid fa-house"></i>Queen's Plastic Packaging</span>
                        <div class="line"></div>

                    </a>
                </li>
                <li>
                    <a href="admin-panel.php">
                        <!-- <span  class="icons"><i class="fa-solid fa-sparkles"></i></span> -->
                        <span class="title"><i class="fa-solid fa-house"></i>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="customers.php">
                        <span class="title"><i class="fa-solid fa-house"></i>Customers</span>
                    </a>
                </li>
                <li>
                    <a href="orders.php">
                        <span class="title"><i class="fa-solid fa-house"></i>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="messages.php">
                        <!-- <span  class="icon"><i class="fa-solid fa-sparkles"></i></span> -->
                        <span class="title"><i class="fa-solid fa-house"></i>Messages</span>
                    </a>
                </li>
                <li>
                    <a href="add-products.php">
                        <!-- <span  class="icon"><i class="fa-solid fa-sparkles"></i></span> -->
                        <span class="title"><i class="fa-solid fa-house"></i>Add Products</span>
                    </a>
                </li>
                <li>
                    <a href="logout-admin.php">
                        <!-- <span  class="icon"><i class="fa-solid fa-sparkles"></i></span> -->
                        <span class="title"><i class="fa-solid fa-house"></i>Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-admin">
            <div class="topbar">
                <div class="toggle">
                    <i class="fa-solid fa-house"> </i>
                </div>

                <div class="user">
                    <img src="images/gold.jpg" alt="">
                </div>
            </div>
            <div class="info-container">
                <?php
                $sql = "SELECT * FROM orders WHERE reference = '$reference'";
                $result = mysqli_query($mysqli, $sql);
                $order = mysqli_fetch_assoc($result);
                $refrence = $order['reference'];
                $name = $order['customer_name'];
                $amount = $order['product_price'];
                $status = $order['order_status'];
                $number = $order['customer_phone'];
                $email = $order['customer_email'];
                ?>
                <h1 class="order-details-title">Order Details</h1>
                <div class="order-details">
                    <p class="order-details-label">Payment Reference:</p>
                    <p class="order-details-value"><?php echo $reference; ?></p>
                    <p class="order-details-label">Customer Name:</p>
                    <p class="order-details-value"><?php echo $name ?></p>
                    <p class="order-details-label">Customer Email:</p>
                    <p class="order-details-value"><?php echo $email; ?></p>
                    <p class="order-details-label">Customer Phone number:</p>
                    <p class="order-details-value"><?php echo $number; ?></p>
                    <p class="order-details-label">Amount Paid:</p>
                    <p class="order-details-value"><?php echo '₦' . number_format($amount, 2); ?></p>
                    <p class="order-details-label">Status of Order:</p>
                    <p class="order-details-value"><?php echo $status; ?></p>
                </div>
            </div>





            <!-- order  details -->
            <div class="info-container">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Products Bought</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Product Name</td>
                                <td>Quantity</td>
                                <td>Price</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php


                            $sql = "SELECT * FROM orders WHERE reference = '$reference'";
                            $result = mysqli_query($mysqli, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($order = mysqli_fetch_assoc($result)) {
                                    $product_name = $order['product_name'];
                                    $price = $order['price'];
                                    $quantity = $order['quantity'];
                            ?>
                                    <tr>
                                        <td><?php echo $product_name; ?></td>
                                        <td><?php echo $quantity; ?></td>
                                        <td><?php echo $price; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "No products found";
                            }
                            // Close the connection
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Menu-toggle
        let toggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.ad-nav');
        let mainAdmin = document.querySelector('.main-admin')

        toggle.onclick = function() {
            navigation.classList.toggle('active')
            mainAdmin.classList.toggle('active')
        }
        // let list=document.querySelectorAll(".ad-nav li")
        // function  activeLink(){
        //     list.forEach((item)=>
        //     item.classList.remove('hovered'))
        //     this.classList.add('hovered')
        // }
        // list.forEach((item)=>
        // item.addEventListener('mouseover',activeLink))
    </script>
</body>
<style>
    .info-container {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
    }

    .order-details {
        display: grid;
        grid-template-columns: auto auto;
        grid-row-gap: 5px;
    }

    .order-details-title {
        margin-top: 0;
    }

    .order-details-label {
        font-weight: bold;
        margin: 0;
    }

    .order-details-value {
        margin: 0;
    }
</style>

</html>