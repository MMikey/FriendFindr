<?php
/**
 * @var mysqli $mysqli
 */
include("solution/Validator.php");

// Initialise the session
session_start();

require_once "config.php";

//Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$hobby = $bio = $location = "";
$hobby_err = $bio_err = $location_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!empty($_POST["hobby"])) {
        foreach ($_POST["hobby"] as $value) {
            if(Validator::validateHobby($_SESSION["id"],$value) !== true) continue; //if hobby already exists skip
            $sql = "INSERT INTO userhobbies (hobbyid,userid) VALUES (" . $value . "," . $_SESSION["id"] . ");";
            if ($mysqli->query($sql)) {
                //redirect to login page
            } else {
                echo "Error!" . $mysqli->error;
            }
        }
    }

    if(!empty($_POST["bio"])) {
        $sql = "UPDATE users SET bio= ? WHERE userid =" . $_SESSION["id"] . ";";

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_bio);
            $param_bio = $_POST["bio"];
            if($stmt->execute()) {
                $stmt->store_result();
            } else {
                $bio_err = "Oops! Something went wrong! " . $mysqli->error;
            }
        } else {
            $bio_err = "Oops! Something went wrong! " . $mysqli->error;
        }
    }

    if(!empty($_POST["location"])) {
        $sql = "UPDATE users SET location=? WHERE userid =" . $_SESSION["id"] . ";";
        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_location);
            $param_location = $_POST["location"];
            if($stmt->execute()) {
                $stmt->store_result();
            } else {
                $location_err = "Oops! Something went wrong! " . $mysqli->error;
            }
        } else {
            $location_err = "Oops! Something went wrong! " . $mysqli->error;
        }
    }

    header("location: profile-page.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="This is a friend finding Application" />
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/wpCSS.css"">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
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
                    <li class="nav-item">
                        <a class="nav-link" href="groups-page.php">All Groups</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Profile
                        </a>
                        <div class="dropdown-menu" style="color:black">
                            <a class="dropdown-item" href="profile-page.php">My Profile</a>
                            <a class="dropdown-item" href="update-profile.php">Edit Profile</a>
                            <a class="dropdown-item" href="reset-password.php">Reset Password</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>
<div class="container">
    <h2>Update Profile</h2>
    <p>Please fill in fields that you would like to update</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>
                Select a Hobby
                <small class="text-muted">Optional</small>
            </label>
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
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
    </form>

</div>
    <!-----sodicla media ------>
    <section id="social-media">
        <div class="container text-center">
            <p>FIND US ON SOCIAL MEDIA</p>

            <div class="social-icons">
                <a href="#"> <img src="./data/fb.png" /> </a>
                <a href="#"> <img src="./data/ig.png" /> </a>
                <a href="#"> <img src="./data/ws.jpg" /> </a>
            </div>
        </div>
    </section>

    <!----Footer Section---->
    <section id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-box">
                    <img src="./data/logo.png" />
                    <p>
                        Welcome To FriendFindr:
                        Join your group and become a part of something
                    </p>
                </div>
                <div class="col-md-4 footer-box">
                    <p><b> Contact us </b></p>
                    <p><i class="fa fa-map-marker"></i> MMU, Manchester</p>
                    <p><i class="fa fa-phone"></i>01617959454</p>
                    <p><i class="fa fa-envelope"></i>BlaBlaBla@hotmail.co.uk</p>
                </div>
                <div class="col-md-4 footer-box">
                    <p><b> Subscribe </b></p>
                    <input type="email" class="form-control" placeholder="Your Email" />
                    <button type="button" class="btn btn-primary">Contact us</button>
                </div>
            </div>
        </div>
    </section>

</body>
</html>