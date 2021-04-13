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

if(empty($_GET["groupid"])){
    header('location: groups-page.php');
}
$group_ID = $_GET["groupid"]; //gets id from url

$group_err = "";

try {
    $group = new Group($group_ID);
} catch(Exception $e) {
    $group_err = $e->getMessage();
}


if($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $group->add_user($_SESSION["id"]);
        header('location: group-page.php?groupid='.$group_ID);
    } catch(Exception $e) {
        $group_err = $e;
    }
}

?>

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
<h1 class="my-5"></h1>
<div class="container ">
    <div class="wrapper">
    <?php
    if (!empty($group_err)) {
        echo '<div class="alert alert-danger">' . $group_err . '</div>';
    }
    ?>
    <h2><?php echo $group->get_name() ?></h2>
    <p><?php echo $group->get_description()?></p>
    </div>
    <form method="post">
        <?php echo (!$group->is_member($_SESSION["id"])) ? '<input type="submit" name="join_group" class="button" value="Join group">'  : '';?>
    </form>
    <p><?php echo ($group->is_member($_SESSION["id"])) ? "Joined!" : "";?>
    </p>
</div>


</body>
</html>
