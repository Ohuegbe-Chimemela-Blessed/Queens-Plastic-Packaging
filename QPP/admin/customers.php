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
                    <i class="fa-solid fa-house"> </i>
                </div>

                <div class="user">
                    <img src="images/gold.jpg" alt="">
                </div>
            </div>



            <!-- order  details -->
            <div class=".info-container">
                <div class="recentOrders ">
                    <div class="cardHeader">
                        <h2>Customers</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>id</td>
                                <td>Image</td>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Email</td>
                                <td>Gender</td>
                                <td>D.O.B</td>
                                <td>phone</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through the products and display each one

                            $sql = "SELECT * FROM user";
                            $result = mysqli_query($mysqli, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($customer = mysqli_fetch_assoc($result)) {
                                    $id = $customer['Id'];
                                    $Fname = $customer['First_Name'];
                                    $Lname = $customer['Last_Name'];
                                    $Email = $customer['Email'];
                                    $Gender = $customer['Gender'];
                                    $DOB = $customer['DOB'];
                                    $image = $customer['image'];
                                    $image_path = 'images/' . $image;
                                    $phone = $customer['Phone_number'];
                            ?>
                                    <tr>
                                        <td><?php echo $id; ?></td>
                                        <td>
                                            <div class="imgBx">
                                                <img src="<?php echo $image_path; ?> " alt="Customer img">
                                            </div>
                                        </td>
                                        <td><?php echo $Fname ?></td>
                                        <td><?php echo $Lname ?></td>
                                        <td><?php echo $Email ?></td>
                                        <td><?php echo $Gender ?></td>
                                        <td><?php echo $DOB ?></td>
                                        <td><?php echo $phone ?></td>
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

    .imgBx img {
        max-width: 100px;
        /* set the maximum width to 100 pixels */
    }
</style>

</html>