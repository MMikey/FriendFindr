<?php
/** @var mysqli $mysqli */
include_once "config.php";
include("solution/Group.php");

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}

//checks if the page sends a 'post' method
//essentially checks if the user has clicked the submit button
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Check input errors before inserting into database
    if (empty($username_err) && empty($email_err) &&
        empty($password_err) && empty($confirm_password_err)
        && empty($hobby_err) && empty($date_err)) {

        //sql statement for inserting data into users events
        $sql = "INSERT INTO userevents (userid, eventid) VALUES (?,?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssssss", $param_userid, $param_eventid); // bind parameters to  queries

            $param_userid = $_SESSION["username"];
            $param_eventid = 2;

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

<div class = "container">

    <h1>Event Name</h1>
    <p>Details about the event</p>
    <p>Location, Time</p>
    <input type="submit" class="btn btn-primary" value="Interested">
    <input type="reset" class="btn btn-secondary ml-2" value="Not Interested">



</div>


</body>

</html>
