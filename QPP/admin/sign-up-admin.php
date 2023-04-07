<?php
// Include config file
require_once "conn.php";

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $position_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["Email"]))) {
        $email_err = "Please enter an Email";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM admins WHERE Email = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = trim($_POST["Email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $email_err = "This Email is already taken.";
                } else {
                    $email = trim($_POST["Email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    //position
    if (empty(trim($_POST['position']))) {
        $position_err = "Please enter a position";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM admins WHERE position = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_position = trim($_POST['position']);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $position_err = "This position is already taken.";
                } else {
                    $position = trim($_POST['position']);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["Password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["Password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["Password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        //The ret of the inputed data
        $Name = $_POST['name'];
        $phone = $_POST['phone_number'];

        // Prepare an insert statement
        $sql = "INSERT INTO admins (name,Email, Pass,Phone_number,position) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $Name, $param_email, $param_password, $phone, $param_position);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: log-in-admin.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Queen's Plastic Packaging </title>
</head>

<body>
    <section>
        <div class="sign-up-container">
            <div class="big-box">
                <div class="d-v-section  imagebox1">
                    <img src="images/bottle1.png" alt="">
                </div>
                <div class="d-v-section  text-box">
                    <h1>Sign Up</h1>
                    <p style="color: gray;  font-style: italic;">Join Us to not miss out on amazing offers! </p>
                    <div class="line"></div>
                    <div class="infos">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="names">
                                <input type="text" name="name" placeholder="Full Name">
                                <input type="text" placeholder="Phone Number" name="phone_number" id="">
                                <?php echo $position_err; ?>
                                <input type="text" placeholder="Position at Queen's plastics" name="position" id="">
                            </div>
                            <div class="email">
                                <?php echo $email_err; ?>
                                <input type="email" placeholder="E-Mail Address" name="Email" id="">
                                <?php echo $password_err; ?>
                                <input type="password" placeholder="Enter Password" name="Password" id="">
                                <?php echo $confirm_password_err; ?>
                                <input type="password" placeholder="confirm your password" name="confirm_password" id="">
                            </div>
                            <div class="sign-up-btn search-btn">
                                <input style="background: none; border: none;" name="SignIn" type="submit" value="Sign In">
                            </div>
                        </form>

                        <p>Already have an account? <a href="log-in-admin.php">
                                <b class="bold">Log In</b>
                            </a></p>
                    </div>

                </div>
            </div>


            <div class="footer-divv">
                <div class="footer">Queen's Plastic Packaging &trade;; All Rights Reserved 2023

                </div>
            </div>


        </div>
    </section>


</body>

</html>