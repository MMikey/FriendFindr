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

function getJoinedGroups()
{
    global $mysqli;
    $sql = "SELECT g.groupid, g.name, g.description FROM groups g, usergroups ug WHERE g.groupid = ug.groupid AND ug.userid =" . $_SESSION["id"] . ";";
    $joinedgroups_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql statement
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div id=\"recommended-groups-box\" class=\"jumbotron\">";
            echo "<h3>" . $row["name"] . "</h3>\n";
            echo "<p>" . $row["description"] . "</p>\n";
            echo '<a href="group-page.php?groupid='.$row["groupid"].'" class="btn btn-info" role="button">View Group</a>';
            echo "</div>";
        }
    } else {
        $joinedgroups_err = "You're not part of any groups.. ";
    }
    if (!empty($joinedgroups_err)) {
        echo '<div class="alert alert-danger">' . $joinedgroups_err . '</div>';
    }

}

function getRecommendedGroups()
{
    global $mysqli;
    $sql = "SELECT g.groupid, g.name, g.description FROM groups g, grouphobbies gh, userhobbies uh 
            where gh.hobbyid = uh.hobbyid AND uh.userid = " . $_SESSION["id"] . ";";
    $group_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                echo "<div id=\"recommended-groups-box\" class=\"jumbotron\">";
                echo "<h3>" . $row["name"] . "</h3>\n";
                echo "<p>" . $row["description"] . "</p>\n";
                echo '<a href="group-page.php?groupid='.$row["groupid"].'" class="btn btn-info" role="button">View Group</a>';

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
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/FFStylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

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
<h1 class="my-5" style="text-align: center">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to FriendFindr</h1>

<div class="container">
    <h2>Your groups</h2>
    <?php getJoinedGroups(); ?>


    <h2>Recommended groups</h2>
    <?php getRecommendedGroups(); ?>

</div>
<p>
    <a href="update-profile.php" class="btn btn-secondary">Update Profile</a>
    <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</p>

</body>
</html>
<?php $mysqli->close();?>