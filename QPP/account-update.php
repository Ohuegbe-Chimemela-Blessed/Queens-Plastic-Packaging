<?php

// connect to the database
require_once "conn.php";

// check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validate the form input
    // ...

    // check which fields the user has updated
    $sql = "UPDATE user SET ";
    $params = array();
    if (!empty($_POST["First_Name"])) {
        $sql .= "First_Name = ?, ";
        $params[] = $_POST["First_Name"];
    }
    if (!empty($_POST["Last_Name"])) {
        $sql .= "Last_Name = ?, ";
        $params[] = $_POST["First_Name"];
    }
    if (!empty($_POST["Email"])) {
        $sql .= "Email = ?, ";
        $params[] = $_POST["Email"];
    }
    if (!empty($_POST["Address"])) {
        $sql .= "Address = ?, ";
        $params[] = $_POST["Address"];
    }
    if (!empty($_POST["Phone_number"])) {
        $sql .= "Phone_number = ?, ";
        $params[] = $_POST["Phone_number"];
    }
    if (!empty($_POST["DOB"])) {
        $sql .= "DOB = ?, ";
        $params[] = $_POST["DOB"];
    }
    if (!empty($_POST["Gender"])) {
        $sql .= "Gender = ?, ";
        $params[] = $_POST["Gender"];
    }
    if (!empty($_POST["image"])) {
        $sql .= "image = ?, ";
        $params[] = $_POST["image"];
    }
    if (!empty($_POST["Pass"])) {
        $sql .= "Pass = ?, ";
        $params[] = password_hash($_POST["Pass"], PASSWORD_DEFAULT);
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE id = ?";

    $params[] = $_SESSION["id"];

    // execute the SQL statement
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    if ($stmt->execute()) {
        header("location: account.php");
        exit;
    } else {
        echo "Something went wrong. Please try again later.";
    }
}

// // get the user details
// $sql = "SELECT * FROM user WHERE id = ?";
// $stmt = $mysqli->prepare($sql);
// $stmt->bind_param("i", $_SESSION["id"]);
// $stmt->execute();
// $result = $stmt->get_result();
// $user = $result->fetch_assoc();
// 
?>
<!-- create the form -->