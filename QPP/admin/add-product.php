<?php
require("function.php");
require_once 'conn.php';
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: log-in-admin.php");
    exit;
}
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
                    <a href="add-product.php">
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
                    <i class="fa-solid fa-house"></i>
                </div>
                <div class="search">
                    <label for="">
                        <input type="text" placeholder="Search Here">
                    </label>
                </div>
                <div class="user">
                    <img src="images/gold.jpg" alt="">
                </div>
            </div>

            <div class="details rO2">
                <div class="recentOrders    rO2">
                    <div class="cardHeader">

                        <h2 class="cart-title">Products In Stock
                            <div class="line"></div>
                        </h2>

                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Product Image</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Size</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <?php

                        $sql = "SELECT * FROM products";
                        $result = mysqli_query($mysqli, $sql);
                        // Display the product details
                        if (mysqli_num_rows($result) > 0) {
                            while ($product = mysqli_fetch_assoc($result)) {
                                $id = $product['id'];
                                $name = $product['Name'];
                                $star = $product['Stars'];
                                $price = $product['product_Price'];
                                $size = $product['sizes'];
                                $image = $product['product_image'];
                                $image_path = 'images/' . $image;
                        ?>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="cart-info">
                                                <img src="<?php echo $image_path ?>" alt="">
                                            </div>
                                        </td>
                                        <td><?php echo $name ?></td>
                                        <td><?php echo $price ?></td>
                                        <td><?php echo $size ?></td>
                                        <td>
                                            <span class="status pending">Almost Gone</span>
                                        </td>
                                    </tr>
                            <?php
                            }
                        } else {
                            echo "No products found";
                        }

                        // Close the connection
                        mysqli_close($mysqli);
                            ?>
                                </tbody>
                    </table>
                    <span href="" class="btn cart-btn add1">Add New Product</span>
                </div>


            </div>


            <!-- add to products -->



            <div class="popup">
                <div class="main-pop-up">
                    <form action="add_products.php" method="post">
                        <h2 class="cart-title">Add New Products
                            <div class="line"></div>
                        </h2>
                        <div class="input-bars">
                            <label for="image">Product Image</label>
                            <input type="file" name="image" id="image" directory="images/">
                            <input type="name" name="name" id="name" placeholder="Product   Name" autocomplete="on" required>
                            <input type="text" name="price" id="subject" placeholder="Price   in  Naira" autocomplete="on" autocomplete="on" required> <input type="text" name="subject" id="subject" placeholder="Quantity  in  Stock" autocomplete="on" autocomplete="on" required>
                            <input type="text" name="size" placeholder="Size">
                            <input type="text" name="details" placeholder="Product details">
                        </div>
                        <input name="add-products" class="btn cart-btn add2" type="submit" value="submit">

                    </form>
                </div>
            </div>

            <!-- update products -->
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
        let popup = document.querySelector('.popup');
        let add2 = document.querySelector('.add2');
        let add1 = document.querySelector('.add1')
        let mainPop = document.querySelector('.main-pop-up')

        add1.onclick = function() {
            popup.classList.toggle('active')
            mainPop.classList.toggle('active')
            // mainAdmin.classList.toggle('active')
        }
    </script>
</body>
<style>
    .popup {
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        display: none;
    }

    .main-pop-up {
        width: 60%;
        height: 50%;
        flex-wrap: wrap;
        padding: 20px;
        background-color: rgb(255, 253, 253);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        /* border-radius: 20px; */
        display: flex;
        align-items: center;
        justify-content: center;
        display: none;
    }

    .input-bars {
        display: flex;
        align-items: center;
        justify-content: center;
        /* flex-direction: column; */
        gap: 1rem;
        flex-wrap: wrap;
    }

    form {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        flex-wrap: wrap;
    }

    .input-bars input {
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.233);
        border-radius: 10px;
        height: 30px;
        background: #dde1e727;
        border: 1px solid #eee;
        outline: none;
        font-size: 15px;
        font-weight: 300;
        color: rgb(97, 71, 6);
        padding: 0px 30px;
        width: 85%;
    }

    .popup.active,
    .main-pop-up.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

</html>