<?php

//include config file - connects to database
require_once "config.php";

//initialise variables with empty values
$username = $password = $confirm_password = $email = $bio = $location = "";
$username_err = $password_err = $confirm_password_err = $hobby_err = $email_err = "";


//processing form data when submitted

//checks if the page sends a 'post' method 
//essentially checks if the user has clicked the submit button 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Validate username 
    //here we check if the username field is empty or already taken
    //empty = checks if field is empty
    //trim = removes whitespace from beginning and end of string
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        //prepare sql select statement
        //? is variable that will inserted as username
        $sql = "SELECT userid FROM users WHERE username = ?";

        //prepare = prepares a sql statement for execution.
        //Basically, will bind parameters to the question mark
        //then execute that statement
        if ($stmt = $mysqli->prepare($sql)) {
            //bind variable to prepared statement as parameters
            //this method also sanitised inputs, no sql injections...
            $stmt->bind_param("s", $param_username);

            //set the username parameter from the username input
            $param_username = trim($_POST["username"]);

            //attempt to execute statement
            if ($stmt->execute()) {
                $stmt->store_result();

                //check if there are rows from table that returns with same username
                //i.e username already exists in table and user should try another one
                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else // if statement can't be executed for whatever reason
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    // Validate password
    //check password field is empty or less that 6 chars
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    //checks if confirm password field is empty
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password!";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        //check theres no password error and that the passwords match
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    //Validate email
    if (empty(trim($_POST["email"])) || filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email addres";
    } else {
        $email = $_POST["email"];
    }



    //Validate Hobby Selection
    if (empty($_POST["hobby"])) {
        $hobby_err = "Please select at least one hobby!";
    } else {
        $hobby = $_POST["hobby"];
    }


    //Check input errors before inserting into database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($hobby_err)) {

        //sql statement for inserting data into users table with parameters
        $sql = "INSERT INTO users (username, email, bio, password) VALUES (?,?,?,?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $param_username, $param_email, $param_password); // bind parameters to  queries

            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // creates password hash. (secure passwords)

            if ($stmt->execute()) {
                //redirect to login page
                //header("location: login.php");
                //echo "submitted!";
            } else {
                echo "Oops! Something went wrong. Please try again later." . $mysqli->error;
            }

            $stmt->close(); // close statement - close query
        } else {
            echo "Oop! Something went wrong!. Please try again later." . $mysqli->error;
        }

        //sql statement for inserting data into userhobby table
        foreach ($hobby as $value) {
            $sql = "INSERT INTO userhobbies (hobbyid,userid) VALUES (" . $value . ",(SELECT MAX(userid) FROM users));";
            if ($mysqli->query($sql)) {
                //redirect to login page
                header("location: login.php");
            } else {
                echo "Error!" . $mysqli->error;
            }
        }
    }
    //$mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Friend Finder - Sign Up</title>
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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Select a Hobby</label>
                <!-- user can select mulitple hobbys and store them as an array -->
                <select multiple name="hobby[]" class="form-control <?php echo (!empty($hobby_err)) ? 'is-invalid' : ''; ?>">
                    <?php
                    //Populating hobby input field
                    //prepare sql select statement
                    $sql = "SELECT hobbyid, name FROM hobbies";
                    if ($result = $mysqli->query($sql)) {
                        while ($row = $result->fetch_assoc()) {
                            //user echo with html to create stuff
                            echo '<option value ="' . $row["hobbyid"] . '">' . $row["name"] . "</option>/n";
                        }
                    } else {
                        echo "Error!" . $mysqli->error;
                    }
                    ?>
                </select>
                <span class="invalid-feedback"><?php echo $hobby_err; ?></span>
            </div>
            <div class="form-group">
                <label>Enter something about yourself!</label>
                <textarea  name="bio" class="form-control" rows="3" value = "<?php echo $bio;?>"></textarea>
            </div>
            <div class="form-group">
                <label>Whats your city?</label>
                <input type="text" name = "location" class = "form-control" value = "<?php echo $location?>">
            </div>
            <div class="form-group">
                <label>Please confirm your date of birth</label>    
                <input type = "date" name = "date" class = "form-control" id ="date">
                <span class="invalid-feedback"><?php echo $date_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>

</html>

<?php $mysqli->close();?>