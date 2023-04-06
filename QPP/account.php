<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once "conn.php";
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: log-in.php");
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

?>




<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <title>My Account |Queen's Plastic Packaging | E-commerce Website</title>
</head>

<body>
    <div class="container">

        <?php include 'navbar.php'; ?>
        <?php
        $id = $_SESSION["id"];
        // $Email = $_SESSION["Email"];
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $result = mysqli_query($mysqli, $sql);
        $user = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $Fname = $user['First_Name'];
            $email = $user['Email'];
            $Lname = $user['Last_Name'];
            $DOB = $user['DOB'];
            $Gender = $user['Gender'];
            $phone = $user['Phone_number'];
            $image = $user['image'];
            $image_path = 'images/' . $image;
        ?>

            <h2 class="user-information">User Information
                <div class="line"></div>

            </h2>
            <div class="row">
                <div class="col-2   the-user">
                    <div style="margin-bottom: 100px;">
                        <img class="user" src=" <?php echo $image_path; ?> " alt="" srcset="">
                    </div>

                </div>
                <div class="col-2   the-user2">
                    <!-- <img src="images/bottle1.png" alt=""> -->
                    <div class="user-info">
                        <h2 class="name">
                            <?php echo $Fname; ?><?php echo " " ?><?php echo $Lname; ?>
                        </h2>
                        <div class="infos">
                            <div class="info">
                                Email: <?php echo $email; ?>
                            </div>
                            <div class="info">
                                Phone Number: <?php echo $phone ?>
                            </div>
                            <div class="info">
                                Gender: <?php echo $Gender; ?>
                            </div>
                            <div class="info">
                                Date Of Birth: <?php echo $DOB; ?>
                            </div>
                        </div>


                        <!-- <input name="update details" class="btn cart-btn add1" type="submit" value="Update details"> -->
                        <!-- <input name="add-products" class="btn cart-btn add2" type="submit" value="submit"> -->
                        <!-- <a href="" class="btn cart-btn add1">Update Details</a> -->
                        <span href="" class="btn cart-btn add1">Update Details</span>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo "No user found with email $Email";
        }
        ?>
        <div class="categories">
            <h2 class="title">Poduct you might like
            </h2>
            <div class="small-container">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
                    $result = mysqli_query($mysqli, $sql);
                    // Loop through the products and display each one
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
                            <div class="col-4">
                                <img src="<?php echo $image_path; ?>" alt="">
                                <h4><?php echo $name; ?> </h4>
                                <div class="rating">
                                    <?php
                                    for ($i = 1; $i <= $star; $i++) {
                                        echo '<i class="fa-solid fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <p>Price:£<?php echo number_format($price, 2) ?></p>
                                <a href="product-details.php?id=<?php echo $id; ?>" class="btn btn-2">View</a>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No products found";
                    }

                    ?>
                </div>

            </div>
        </div>
        <div class="popup">
            <div class="main-pop-up">
                <form action="account-update.php" method="post">
                    <h2 class="cart-title">Update user details
                        <div class="line"></div>
                    </h2>
                    <div class="input-bars">
                        <label for="image">Display Image</label>
                        <input type="file" name="image" id="image" directory="images/">
                        <input type="name" name="Last_Name" id="name" placeholder="First  Name" autocomplete="on">
                        <input type="name" name="First_Name" id="name" placeholder="Last name" autocomplete="on">
                        <input type="date" name="DOB" id="DOB" placeholder="Enter your new email" autocomplete="on">
                        <input type="text" name="Address" id="Address" placeholder="Input your Address" autocomplete="on">
                        <input type="text" name="Phone_number" placeholder="Enter your new Phone Number">
                        <input type="text" name="Pass" placeholder="New password">
                    </div>
                    <input class="btn cart-btn add2" type="submit" value="submit">

                </form>
            </div>
        </div>



        <?php include 'footer.php'; ?>
    </div>
    <style>
        .product {
            width: 24%;
            display: inline-block;
        }

        .product:nth-child(4n) {
            clear: left;
        }
    </style>

    <script>
        let popup = document.querySelector('.popup');
        let add2 = document.querySelector('.add2');
        let add1 = document.querySelector('.add1')
        let mainPop = document.querySelector('.main-pop-up')

        var MenuItems = document.getElementById("MenuItems")
        MenuItems.style.maxHeight = "0px"

        function menutoggle() {
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "200px"
            } else {
                MenuItems.style.maxHeight = "0px"
            }
        }
    </script>

    <script>
        let toggle = document.querySelector('.toggle')
        let background = document.querySelector('.container')
        let myLilText = document.querySelector('.user')
        let myContact = document.querySelector(' .my-contact')
        let header = document.querySelector('.header')
        let meet = document.querySelector('.meet')
        let phone = document.querySelector('.phone')

        toggle.onclick = function() {
            toggle.classList.toggle('active')
            background.classList.toggle('active')
            myLilText.classList.toggle('active')

        }
    </script>
</body>

</html>