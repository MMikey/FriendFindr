<?php
/** @var mysqli $mysqli */
//include config file - connects to database
require_once "config.php";
include("solution/Validator.php");
include("solution/User.php");

session_start();

if($_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if(!isset($_GET["userid"]))
{
    $userid = $_SESSION["id"];
} else {
    $userid = $_GET["userid"];
}

try{
    $user = new User($userid);
} catch (Exception $e) {
    $user_err = $e->getMessage();
}

function getProfilePic()
{
    global $mysqli;
    $sql = "SELECT name FROM profilepictures WHERE userid =" . $_SESSION["id"] . ";";

    if ($result = $mysqli->query($sql)) {
        $row = $result->fetch_assoc();
        return "uploads/profile_pictures/" . $row["name"] . ".jpg";
    } else {
        return $mysqli->error;
    }

}

function GetVar( $var,$userid,$conn) {
    // make the query
    $query = $conn->query("SELECT ".$var." FROM users WHERE userid = '".$userid."' LIMIT 1");
    $result = $query->fetch_assoc(); // fetch it first
    return $result[$var];
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

    <?php
    if (!empty($group_err)) {
        echo '<div class="alert alert-danger">' . $group_err . '</div>';
    }
    ?>
    <img src="<?php getProfilePic()?>"> <p><?php getProfilePic()?></p>
    <h1><b><?php echo GetVar('username', $userid ,$mysqli)?> </b></h1>
    <p><b><u>Location:</u></b>&nbsp;&nbsp;<?php echo GetVar('location', $userid ,$mysqli)?></p>
    <p><b><u>About Me:</u></b>&nbsp;&nbsp;<?php echo  GetVar('bio', $userid ,$mysqli)?></p>
    <h3 class="font-weight-bold">Joined Groups: </h3>
    <ul class="list-group mb-4" style="width: 20%">
    <?php foreach($user->getGroups() as $group_id => $group) {
        echo <<<HTML
            <li class="list-group-item">$group</li>
            HTML;
    }
    ?>
    </ul>

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
