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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <title>All Products|Queen's Plastic Packaging | E-commerce Website</title>

    <link href="index.html">

</head>

<body>
    <div class="container">

        <?php include 'navbar.php'; ?>



        <div class="cart-container ">
            <center>
                <h2 class="cart-title">My Product Cart
                    <!-- <div class="line"></div> -->

                </h2>
            </center>


            <form method="POST" id="myForm" action="actions.php">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>image</th>
                            <th>Product</th>
                            <th>Size(ml)</th>
                            <th>Price</th>
                            <th>Quantity(x12)</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        //initialize total
                        $total = 0;
                        if (!empty($_SESSION['cart'])) {
                            //create array of initial qty which is 1
                            $index = 0;
                            if (!isset($_SESSION['qty_array'])) {
                                $_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);
                            }
                            $sql = "SELECT * FROM products WHERE id IN (" . implode(',', $_SESSION['cart']) . ")";
                            $query = $mysqli->query($sql);
                            while ($row = $query->fetch_assoc()) {

                                $id = $row['id'];
                                $image = $row['product_image'];
                                $image_path = 'images/' . $image;
                        ?>
                                <tr>

                                    <td>
                                        <a href="delete_item.php?id=<?php echo $row['id']; ?>&index=<?php echo $index; ?>"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                    <div class="cart-info">
                                        <td>
                                            <img width="40" src="<?php echo $image_path; ?>" alt="">
                                        </td>
                                        <td><?php echo $row['Name']; ?></td>
                                        <td><?php echo $row['sizes'] . 'ml' ?></td>
                                        <td><?php echo number_format($row['product_Price'], 2); ?></td>
                                        <input type="hidden" name="qty_array[]" value="<?php echo $_SESSION['qty_array'][$index]; ?>">
                                        <input type="hidden" name="indexes[]" value="<?php echo $index; ?>">
                                        <td><input style="background-color: transparent; border:none; text-decoration:underline;" type="number" min="1" max="10" class="form-control" value="<?php echo $_SESSION['qty_array'][$index]; ?>" id="quantity" name="qty_<?php echo $index;  ?>"></td>
                                        <td><?php echo number_format($_SESSION['qty_array'][$index] * $row['product_Price'], 2); ?></td>
                                    </div>
                                    <?php $total += $_SESSION['qty_array'][$index] * $row['product_Price'];
                                    $_SESSION['cart_total'] = $total + 500;
                                    ?>
                                </tr>
                            <?php
                                $index++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" style="text-align: center; justify-content:center;">
                                    No Item in Cart
                                </td>
                            </tr>


                        <?php
                        }
                        $Delivery = 1500;
                        $Subtotal = $Delivery + $total;
                        ?>
                    </tbody>

                </table>
                <div class="total-price">
                    <table>

                        <tr>
                            <td><b>Total</b></td>
                            <td><b><?php echo number_format($total, 2); ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Delivery Fee</b></td>
                            <td><b><?php echo number_format($Delivery, 2);; ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Subtotal</b></td>
                            <td><b><?php echo number_format($Subtotal, 2); ?></b></td>
                        </tr>
                    </table>
                </div>
                <div class="buttons">

                    <a href="product.php" class="btn"> Back</a>
                    <a href="confirm_order.php" class="btn"> Confirm order</a>
                    <!-- <a href="clear_cart.php" class="btn"> </a> -->
                    <button type="submit" class="btn" name="clear cart">Clear cart</button>
                    <button type="submit" class="btn" name="save">Update subtotal</button>
                </div>
            </form>
        </div>



        <?php include 'footer.php'; ?>
    </div>

    <style>
        .cart-info td img {
            width: 80px;
            height: 80px;
            margin-right: 10px;
            /* max-width: 200px; */
        }

        .btn {
            background-color: goldenrod;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 10px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            text-transform: uppercase;
            width: auto;
        }

        .btn:hover {
            background-color: #fff;
            color: #d4af37;
            border: 1px solid #d4af37;
        }

        .buttons {
            align-items: center;
            justify-content: center;
            display: flex;
        }

        .total-price {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .total-price table {
            border-top: 3px solid goldenrod;
            max-width: 400px;
            width: 100%;
        }

        td:last-child,
        th:last-child {
            text-align: right;
        }
    </style>
    <script>
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
        const quantityInput = document.getElementById("quantity");

        quantityInput.addEventListener("input", function(event) {
            if (event.target.value === "0") {
                event.target.setCustomValidity("Please enter a value greater than 0.");
            } else {
                event.target.setCustomValidity("");
            }
        });
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
        document.getElementById("myForm").addEventListener("keydown", function(event) {
            if (event.keyCode === 13) { // 13 is the code for the Enter key
                event.preventDefault(); // prevent the form from submitting
            }
        });
    </script>
</body>

</html>