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
$group_err = $joinedgroups_err = "";


//getting joined groups
$sql = "SELECT groupid from usergroups WHERE userid = " . $_SESSION["id"] . ";";
$joinedgroups_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql statement
$joined_groups = array(); //array to store groupids
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $joined_groups[] = $row["groupid"];
    }
} else {
    $joinedgroups_err = "You're not part of any groups.. ";
}

//get hobby ids from current users hobbies
//!!!better way of doing this!!! \/
//sql = "SELECT g.name, g.description FROM groups g, grouphobbies gh, userhobbies uh where gh.hobbyid = uh.hobbyid AND uh.userid = 23";
$sql = "SELECT grouphobbies.groupid, userhobbies.hobbyid from grouphobbies, userhobbies 
        where grouphobbies.hobbyid = userhobbies.hobbyid AND userhobbies.userid = " . $_SESSION["id"] . ";";
$group_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql
$recommended_groups = array(); // create array to store groupids
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recommended_groups[] = $row["groupid"];
    }
} else {
    $group_err = "No groups to recommend.. Try selecting some hobbies";
}

//removes duplicates from joined groups
$recommended_groups = array_diff($recommended_groups, $joined_groups);

?>
<!-- This is just a template example of html that i pinched off the internet obviously ours will be different -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/FFStylesheet.css">

</head>
<body>
<h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
<div class="container">
    <h2>Your groups</h2>
    <?php
    if (!empty($joinedgroups_err)) {
        echo '<div class="alert alert-danger">' . $joinedgroups_err . '</div>';
    }

    foreach ($joined_groups as $group)
    {
        $sql = "SELECT groupid, name, description FROM groups WHERE groupid = " . $group . ";";

        echo ($result = $mysqli->query($sql)) ? "" : "error!";

        while ($row = $result->fetch_assoc()) {
            echo "<div id=\"recommended-groups-box\" class=\"jumbotron\">";
            echo "<h3>" . $row["name"] . "</h3>\n";
            echo "<p>" . $row["description"] . "</p>\n";
            echo "</div>";
        }
    }
    ?>
    <h2>Recommended groups</h2>
    <?php
    if (!empty($group_err)) {
        echo '<div class="alert alert-danger">' . $group_err . '</div>';
    }

    foreach ($recommended_groups as $group) //loop through array of relevant groups for the user to display them on the main window
    {
        $sql = "SELECT groupid, name, description FROM groups WHERE groupid = " . $group . ";";

        echo ($result = $mysqli->query($sql)) ? "" : "error!";

        while ($row = $result->fetch_assoc()) {
            echo "<div id=\"recommended-groups-box\" class=\"jumbotron\">";
            echo "<h3>" . $row["name"] . "</h3>\n";
            echo "<p>" . $row["description"] . "</p>\n";
            echo "</div>";
        }
    }
    ?>

</div>
<p>
    <a href="update_profile.php" class="btn btn-secondary">Update Profile</a>
    <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</p>

</body>
</html>