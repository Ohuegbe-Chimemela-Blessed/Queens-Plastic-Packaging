<?php

function users()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-commerce";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT COUNT(*) FROM user";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}
function People()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-commerce";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT First_Name FROM user";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}
function Products()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-commerce";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT COUNT(*) FROM products";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}
function Orders()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-commerce";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT COUNT(*) FROM orders";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}
function UnreadMessage()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-commerce";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT COUNT(*) FROM messages";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}
