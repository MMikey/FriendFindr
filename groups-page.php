<?php
/** @var mysqli $mysqli */
include_once  "config.php";
include("solution/Group.php");
// Initialise the session
session_start();

//Check if the user is logged in, if not then redirect him to login page 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}

        //SQL Queries


function getJoinedGroups()
{
    global $mysqli;
    $sql = "SELECT g.groupid, g.name, g.description FROM groups g, usergroups ug WHERE g.groupid = ug.groupid AND ug.userid =" . $_SESSION["id"] . ";";
    $joinedgroups_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql statement
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            try {
                $group = new Group($row["groupid"]);
            } catch(Exception $e) {
                $group_err = $e->getMessage();
                continue;
            }
            echo $group->groupDisplay();
        }
    } else {
        $joinedgroups_err = "You're not part of any groups.. ";
    }
    if (!empty($joinedgroups_err)) {
        echo '<div class="alert alert-danger">' . $joinedgroups_err . '</div>';
    }

}

function getAllGroups() {
    global $mysqli;

    $sql = "SELECT groupid, name, description FROM groups;";

    $group_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            try {
                $group = new Group($row["groupid"]);
            } catch(Exception $e) {
                $group_err = $e->getMessage();
                continue;
            }
            echo $group->groupDisplay();
        }

    } else {
        $group_err = "No groups to recommend.. Try selecting some hobbies";
    }
    if (!empty($group_err)) {
        echo '<div class="alert alert-danger">' . $group_err . '</div>';
    }

}

$usergroups = "SELECT name, description FROM groups grp join usergroups ugr on grp.group_id = ugr.group_id WHERE username = ?";
$othergroups = "SELECT name, description FROM groups grp join usergroups ugr on grp.group_id = ugr.group_id WHERE username = ?";

?>
<!-- This is just a template example of html that i pinched off the internet obviously ours will be different -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="This is a friend finding Application" />
    <title>All groupss</title>
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
<div class="container" style="">
    <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h2>Joined Groups</h2>
    </div>
    <div class="row justify-content-md-center"><?php getJoinedGroups()?></div>

    <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h2>All Groups</h2>
    </div>
    <div class="row justify-content-md-center"><?php getAllGroups()?></div>
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