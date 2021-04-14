<?php
/** @var mysqli $mysqli */
//include config file - connects to database
require_once "config.php";
include("solution/Validator.php");

//initialise variables with empty values
$username = $password = $confirm_password = $email = $bio = $location = $birthdate = "";
$username_err = $password_err = $confirm_password_err = $hobby_err = $email_err = $date_err = "";

//processing form data when submitted

//checks if the page sends a 'post' method 
//essentially checks if the user has clicked the submit button 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //validate username
    $checkUsername = Validator::validateUsername($_POST["username"]);
    if($checkUsername === true)
    {
        $username = trim($_POST["username"]);
    } else {
        $username_err = $checkUsername;
    }

    //Validate password
    //check password field is empty or less that 6 chars
    $checkPassword = Validator::validatePassword($_POST["password"]);
    if($checkPassword === true)
    {
        $password = trim($_POST["password"]);
    } else {
        $password_err = $checkPassword;
    }

    //Validate confirm password
    //checks if confirm password field is empty
    $checkConfirmPassword = Validator::validateConfirmPassword($password,$confirm_password);
    if($checkConfirmPassword === true) {
        $confirm_password = trim($_POST["confirm_password"]);
    } else {
        $confirm_password_err = $checkConfirmPassword;
    }

    //Validate email
    $checkEmail = Validator::validateEmail($_POST["email"]);
    if($checkEmail === true) {
        $email = $checkEmail;
    } else {
        $email_err = $checkEmail;
    }

    //Validate Hobby Selection
    if (empty($_POST["hobby"])) {
        $hobby_err = "Please select at least one hobby!";
    } else {
        $hobby = $_POST["hobby"];
    }

    //Validate bio
    if(empty(trim($_POST["bio"]))){
        $bio = "";
    } else {
        $bio = $_POST["bio"];
    }

    //Validate location
    if(empty(trim($_POST["location"]))){
        $location = "";
    } else {
        $location = $_POST["location"];
    }

    //Validate birthdate
    $checkBirthdate = Validator::validateBirthday($_POST["date"]);
    if($checkBirthdate === true){
        $birthdate = $checkBirthdate;
    } else {
        $date_err = $checkBirthdate;
    }


    //Check input errors before inserting into database
    if (empty($username_err) && empty($email_err) &&
        empty($password_err) && empty($confirm_password_err)
        && empty($hobby_err) && empty($date_err)) {

        //sql statement for inserting data into users table with parameters
        $sql = "INSERT INTO users (username, email, password, location, bio, DateOfBirth ) VALUES (?,?,?,?,?,?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssssss", $param_username, $param_email, $param_password, $param_location
            ,$param_bio, $param_date); // bind parameters to  queries

            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // creates password hash. (secure passwords)
            $param_location = $location;
            $param_bio = $bio;
            $param_date = $birthdate;
            if ($stmt->execute()) {
                $stmt->store_result();
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
    <link rel="stylesheet" type="text/css" href="css/FFStylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <!-- Links -->
    <a class="navbar-brand" href="index.php">FriendFindr</a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="welcome.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="groups-page.php">All groups</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Profile
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="profile-page.php">My Profile</a>
                <a class="dropdown-item" href="update-profile.php">Edit Profile</a>
                <a class="dropdown-item" href="reset-password.php">Reset Password</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
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
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
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
                <label>
                    Enter something about yourself!
                    <small class="text-muted">Optional</small>
                </label>
                <textarea  name="bio" class="form-control" rows="3" value = "<?php echo $bio;?>"></textarea>
            </div>
            <div class="form-group">
                <label>
                    Whats your city?
                    <small class="text-muted">Optional</small>
                </label>
                <input type="text" name = "location" class = "form-control" value = "<?php echo $location?>">
            </div>
            <div class="form-group">
                <label>Please confirm your date of birth</label>    
                <input type = "date" name = "date" class = "form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birthdate; ?>" id ="date">
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