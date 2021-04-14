<?php
/**
 * @var mysqli $mysqli
 */

// Initialise the session
session_start();

require_once "config.php";

//Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

function getUserEvents()
{
    global $mysqli;
    $sql = "SELECT e.eventid, e.name, e.description FROM events e, userevent ue WHERE e.eventid = ue.eventid AND ue.userid =" . $_SESSION["id"] . ";";
    $joinedgroups_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql statement
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div id=\"recommended-groups-box\" class=\"jumbotron\">";
            echo "<h3>" . $row["name"] . "</h3>\n";
            echo "<p>" . $row["description"] . "</p>\n";
            echo '<a href="event-page.php?eventid='.$row["eventid"].'" class="btn btn-info" role="button">Find Out More</a>';
            echo "</div>";
        }
    } else {
        $joinedgroups_err = "You haven't selected any events";
    }
    if (!empty($joinedgroups_err)) {
        echo '<div class="alert alert-danger">' . $joinedgroups_err . '</div>';
    }

}

function getRecommendedEvents()
{
    global $mysqli;
    $sql = "SELECT * FROM events";
    $group_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div id=\"recommended-groups-box\" class=\"jumbotron\">";
            echo "<h3>" . $row["name"] . "</h3>\n";
            echo "<p>" . $row["description"] . "</p>\n";
            echo '<a href="event-page.php?groupid='.$row["groupid"].'" class="btn btn-info" role="button">View Group</a>';
            echo "</div>";
        }

    } else {
        //$group_err = "No groups to recommend.. Try selecting some hobbies";
    }
    if (!empty($group_err)) {
        echo '<div class="alert alert-danger">' . $group_err . '</div>';
    }

}

?>

<!-- This is just a template example of html that i pinched off the internet obviously ours will be different -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/FFStylesheet.css">
</head>
<!--<h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1> -->

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
    </ul>
</nav>

<body>

<div class="container">
    <h2>Your Events</h2>
    <?php getUserEvents(); ?>


    <h2>Suggested Events</h2>
    <?php getRecommendedGroups(); ?>

</div>



</body>
