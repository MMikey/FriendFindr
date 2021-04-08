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
$username = $password = "";
$username_err = $password_err = $login_err = "";

//processing form data when submitted by user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //check if username is empty
    //empty returns bool if variable is empty
    //trim removes whitespace from input
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username";
    } else {
        $username = trim($_POST["username"]);
    }

    //check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    //if there are not errors - error strings are empty
    if (empty($username_err) && empty($password_err)) {

        //prepare select statement
        $sql = "SELECT userid, username, password FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            //bind variable to prepared statement ready for execution
            $stmt->bind_param("s", $param_username);

            //set parameters
            $param_username = $username;

            //attempt to execute prepared statement
            if ($stmt->execute()) {
                //Store result into $stmt 
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    //bind result variable
                    //essential stores each result variable from row into stmt, then we can use fetch to get each one by one
                    //in this case we have bound the results to the 3 variables in the arguements list, $id, $username, $hashed_password
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        //password verify checks if the password entered is the same as the hashed one stored in the database
                        if (password_verify($password, $hashed_password)) {
                            //Password is correct so start a new session for that user.
                            //basically a session is local to the user so thats how we can display groups relevant to them
                            session_start();

                            //store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            //redirect user to welcome page
                            header("location: welcome.php");
                        } else {
                            //password is not valid
                            echo "hi";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </form>
    </div>
</body>

</html>