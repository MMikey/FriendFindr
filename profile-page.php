<?php
/** @var mysqli $mysqli */
//include config file - connects to database
require_once "config.php";
include("PhP classes/Validator.php");
include("PhP classes/User.php");

session_start();

if ($_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (!isset($_GET["userid"])) {
    $userid = $_SESSION["id"];
} else {
    $userid = $_GET["userid"];
}

try {
    $user = new User($userid);
} catch (Exception $e) {
    $user_err = $e->getMessage();
}


function GetVar($var, $userid, $conn)
{
    // make the query
    $query = $conn->query("SELECT " . $var . " FROM users WHERE userid = '" . $userid . "' LIMIT 1");
    $result = $query->fetch_assoc(); // fetch it first
    return $result[$var];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width"/>
    <meta name="description" content="This is a friend finding Application"/>
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/wpCss.css"
    ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="./data/logo.png"/></a>
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
<section id="profile">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 p-2 mx-auto">
                <div class="bo-area p-3 mb-2 rounded shadow"
                     style="background-image: linear-gradient(to right, #7070ec, #7340f1);">
                    <div class="col-sm-12 mb-2 pb-2 border-bottom text-color">
                        <div class="row">
                            <div class="col-sm-6 ">
                                <h2><?php echo GetVar('username', $userid, $mysqli) ?> </h2>
                                <p>
                                    <strong>Location:</strong>&nbsp;&nbsp;<?php echo GetVar('location', $userid, $mysqli) ?>
                                </p>
                                <p><strong>About Me:</strong>&nbsp;&nbsp;<?php echo GetVar('bio', $userid, $mysqli) ?>
                                </p>
                                <p><strong>Hobbies: </strong>
                                    <?php
                                    foreach ($user->getHobbies() as $hobby) {
                                        echo <<<HTML
                                    <span class="mr-1 badge badge-light">$hobby</span>
                                    HTML;
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="mt-2 col-sm-4 text-center float-right">
                                <figure>
                                    <div class="rounded-circle">
                                        <img class="img-responsive rounded-circle w-100" style=""
                                             alt="No profile picture found"
                                             src="<?php echo $user->getProfilePic() ?>"
                                             onerror=this.src="uploads/profile_pictures/default.jpg">
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 divider text-center mx-auto">
                        <h2><strong>Groups</strong></h2>
                        <ul class="list-group pb-2">
                            <?php
                            foreach ($user->getGroups() as $groupid => $group) {
                                echo "<a href='group-page.php?groupid=$groupid' class='list-group-item list-group-item-action'>$group</a>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-----sodicla media ------>
<section id="social-media">
    <div class="container text-center">
        <p>FIND US ON SOCIAL MEDIA</p>

        <div class="social-icons">
            <a href="#"> <img src="./data/fb.png"/> </a>
            <a href="#"> <img src="./data/ig.png"/> </a>
            <a href="#"> <img src="./data/ws.jpg"/> </a>
        </div>
    </div>
</section>

<!----Footer Section---->
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 footer-box">
                <img src="./data/logo.png"/>
                <p>
                    Welcome To FriendFindr:
                    Join your group and become a part of something
                </p>
            </div>
            <div class="col-md-4 footer-box">
                <p><b> Contact us </b></p>
                <p><i class="fa fa-map-marker"></i> MMU, Manchester</p>
                <p><i class="fa fa-phone"></i>01617959454</p>
                <p><i class="fa fa-envelope"></i>friendfindr1@hotmail.com</p>
            </div>
            <div class="col-md-4 footer-box">
                <p><b> Subscribe </b></p>
                <input type="email" class="form-control" placeholder="Your Email"/>
                <button type="button" class="btn btn-primary">Contact us</button>
            </div>
        </div>
    </div>
</section>

</body>
</html>
