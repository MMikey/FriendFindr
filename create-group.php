<?php
/** @var mysqli $mysqli */
//include config file - connects to database
require_once "config.php";
include("solution/Validator.php");

//initialise variables with empty values
$username = $password = $confirm_password = $email = $bio = $location = $birthdate = "";
$username_err = $password_err = $confirm_password_err = $hobby_err = $email_err = $date_err = "";
$errors = array();

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
    $checkConfirmPassword = Validator::validateConfirmPassword($password,$_POST["confirm_password"]);
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
    } else {
        $all_errors = array($username_err,$email_err, $password_err, $confirm_password_err,$hobby_err, $date_err);
        $errors = getErrors($all_errors);
    }

    //$mysqli->close();
}
function getErrors($all_errors) : array{
    $errors = array();
    foreach($all_errors as $error) {
        if(!empty($error)) {
            $errors[] = $error;
        }
    }
    return $errors;
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Sign-Up</title>
        <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
        <link rel="stylesheet" type="text/css" href="css/rgCss.css?version=51"">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </head>

    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="./data/logo.png" /></a>
                <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav"
                        aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                >
                    <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="welcome.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                Groups
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="groups-page.php">All Groups</a>
                                <a class="dropdown-item" href="create-group.php">Create Group</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="events-page.php">Events</a>
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
                        <li class="nav-item">
                            <a class="nav-link" href="about-us.php">About us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <body>
    <div class="head">
        <div class="form-box" id="form-box">
            <a class="login-logo" href="index.php"><img src="./data/logo.png" /></a>
            <div class="button-box">
                <div id="btnR"> </div>
                <a href="login.php"><button type="button" class="toggle-btn">Log In</button></a>
                <button type="button" class="toggle-btn">Register</button>
            </div>
            <div class="social-icons">
                <img src="./data/fb.png">
                <img src="./data/ig.png">
                <img src="./data/ws.jpg">
            </div>
            <div class='error-messages'>
                <ul>
                    <?php
                    if(!empty($errors)) {
                        foreach ($errors as $error) {
                            echo "<li id='error_message'>$error</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <form id="login" class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <input type="text" name="username" class="input-field" value="<?php echo $username; ?>" placeholder="Username" required>


                <input type="email" name="email" class="input-field" value="<?php echo $email; ?>" placeholder="Email Id" required>

                <select multiple name="hobby[]" class="input-field">
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


                <textarea  name="bio" class="input-field" rows="3" value = "<?php echo $bio;?>" placeholder="Tell us something about yourself"></textarea>

                <input type="text" name = "location" class = "input-field" value = "<?php echo $location?>" placeholder="Whats your current city?">


                <input type = "date" name = "date" class = "input-field" value="<?php echo $birthdate; ?>" id ="date">

                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>


                <input type="password" name="confirm_password" class="input-field" value="<?php echo $confirm_password; ?>"placeholder="Confirm Password">


                <input type="checkbox" class="check-box"> <span> I agree </span>
                <input type="submit" class="submit-btn" value="Register">
            </form>
        </div>
    </div>
    </body>

    </html>

<?php $mysqli->close();?>