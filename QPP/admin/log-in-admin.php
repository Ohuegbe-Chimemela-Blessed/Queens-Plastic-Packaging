<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page


// Include connection file
require_once "conn.php";

// Define variables and initialize with empty values
$Email = $password = "";
$Email_err = $pass_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["Email"]))) {
        $Email_err = "Please enter your Email.";
    } else {
        $Email = trim($_POST["Email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["Password"]))) {
        $pass_err = "Please enter your password.";
    } else {
        $password = trim($_POST["Password"]);
    }

    // Validate credentials
    if (empty($Email_err) && empty($pass_err)) {
        // Prepare a select statement
        $sql = "SELECT id, Email, Pass FROM admins WHERE Email = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = $Email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if Email exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $Email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["Email"] = $Email;

                            // Redirect user to welcome page
                            header("location: admin-panel.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Email doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
    <title>Document</title>
</head>

<body>
    <section>
        <div class="sign-up-container">
            <div class="big-box">
                <div class="d-v-section  imagebox1">
                    <img src="images/bottle1.png" alt="">
                </div>
                <div class="d-v-section  text-box">
                    <!-- <h2  class="biz">
                       Queen's  Plastic Packaging
                   </h2> -->
                    <div class=" log-in-acct">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h1>Log In</h1>
                    <p>Join Us to not miss out on amazing offers! </p>
                    <div class="line"></div>
                    <?php
                    if (!empty($login_err)) {
                        echo '<div  style="color: red;">' . $login_err . '</div>';
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="infos">
                            <div class="email   log-in-email">
                                <input type="email" placeholder="E-Mail Address" name="Email" class="form-control <?php echo (!empty($Email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Email; ?>">
                                <span class="invalid-feedback"><?php echo '<div  style="color: red;">' .  $Email_err . '</div>'; ?></span>

                                <input type="password" placeholder="Password" name="Password" class="form-control <?php echo (!empty($pass_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo '<div  style="color: red;">' . $pass_err . '</div>'; ?></span>
                            </div>
                            <div class="sign-up-btn search-btn">
                                <input style="background: none; border: none;" name="SignIn" type="submit" value="Sign In">
                            </div>
                    </form>
                    <p>Don't have an account? <a href="sign-up-admin.php">
                            <b class="bold">Sign Up</b>
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