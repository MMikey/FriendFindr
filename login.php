<?php
/** @var mysqli $mysqli */

session_start();

//checks if user is already logged in 
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    //redirects user to home page
    header("location: welcome.php");
    exit;
}

//include config file - connect to database
require_once "config.php";

//declare variables and initialise with empty values
$login_username = $login_password = "";
$login_username_err = $login_password_err = $login_err = "";


//processing form data when submitted by user
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit_1']) {
    //check if username is empty
    //empty returns bool if variable is empty
    //trim removes whitespace from input
    if (empty(trim($_POST["username"]))) {
        $login_username_err = "Please enter username";
    } else {
        $login_username = trim($_POST["username"]);
    }

    //check if password is empty
    if (empty(trim($_POST["password"]))) {
        $login_password_err = "Please enter your password.";
    } else {
        $login_password = trim($_POST["password"]);
    }

    //if there are not errors - error strings are empty
    if (empty($login_username_err) && empty($login_password_err)) {

        //prepare select statement
        $sql = "SELECT userid, username, password FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            //bind variable to prepared statement ready for execution
            $stmt->bind_param("s", $param_username);

            //set parameters
            $param_username = $login_username;

            //attempt to execute prepared statement
            if ($stmt->execute()) {
                //Store result into $stmt 
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    //bind result variable
                    //essential stores each result variable from row into stmt, then we can use fetch to get each one by one
                    //in this case we have bound the results to the 3 variables in the arguements list, $id, $username, $hashed_password
                    $stmt->bind_result($id, $login_username, $hashed_password);
                    if ($stmt->fetch()) {
                        //password verify checks if the password entered is the same as the hashed one stored in the database
                        if (password_verify($login_password, $hashed_password)) {
                            //Password is correct so start a new session for that user.
                            //basically a session is local to the user so thats how we can display groups relevant to them
                            session_start();

                            //store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $login_username;

                            //redirect user to welcome page
                            header("location: welcome.php");
                        } else {
                            //password is not valid
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    //username doesn't exist
                    $login_err = "Invalid username or password.";
                }
            } else {
                //execution of prepared statement has failed
                //if you see this message something is wrong with your query not user input
                echo "Oops! Something went wrong. Please try again later";
            }

            $stmt->close();
        }
        else
        {
            echo "Something went wrong! " . $mysqli->error;
        }
    }
         
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/rgCss.css?version=51"">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>
<div class="head">
    <div class="form-box" id="form-box">
        <a class="login-logo" href="index.php"><img src="./data/logo.png" /></a>
        <div class="button-box">
            <div id="btn"> </div>
            <button type="button" class="toggle-btn" onclick="login()">Log In</button>
            <a href="signup.php"><button type="button" class="toggle-btn">Register</button></a>
        </div>
        <div class="social-icons">
            <img src="./data/fb.png">
            <img src="./data/ig.png">
            <img src="./data/ws.jpg">
        </div>
        <!--LOGIN FORM-->
        <div class="error-messages">
        <?php
        if (!empty($login_err)) {
            echo '<div id="error_message"> <p>' . $login_err . '</p></div>';
        }
        ?>
        </div>
        <form id="login" class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input name = "username" type="text" class="input-field" placeholder="User Id" required>
            <span class="invalid-feedback"><?php echo $login_username_err; ?></span>

            <input name="password" type="password" class="input-field" placeholder="Enter Password" required>
            <span class="invalid-feedback"><?php echo $login_password_err;?></span>
            <input name ="submit_1" type="submit" class="submit-btn" value="login">
        </form>

    </div>

</div>

    <script>
        const x = document.getElementById("login");
        const y = document.getElementById("register");
        const z = document.getElementById("btn");

        function register(){

            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }
        function login(){

            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0";
        }
    </script>
</body>
</html>
</body>

</html>
