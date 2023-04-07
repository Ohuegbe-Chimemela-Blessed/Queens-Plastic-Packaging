<?php
require_once "conn.php";

if (isset($_POST['add-products'])) {

    $name = $_REQUEST['name'];
    $price = $_REQUEST['price'];
    $size = $_REQUEST['size'];
    $details = $_REQUEST['details'];
    $image = $_REQUEST['image'];
    $sql2 = "INSERT INTO products (Name, product_Price, sizes, product_Details, product_image) VALUES ( ?,?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_bind_param($stmt2, "siiss", $name, $price, $size, $details, $image);
    mysqli_stmt_execute($stmt2);
    if (mysqli_stmt_affected_rows($stmt2) > 0) {

        header("location: add-product.php");
    } else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }
}
