<?php
/** @var mysqli $mysqli */
//include config file - connects to database
require_once "config.php";
include("solution/Validator.php");

session_start();

if($_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en ">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
<h1><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>

<nav>
    <ul id="navlist">
        <li><a href="welcome.php" title="Home">Home</a></li>
        <li><a href="groups-page.php" title="Groups">Groups</a></li>
    </ul>
</nav>


<div class="container">

    <h2>Your Hobbies:</h2>

    <div class="form-group">
        <label>Select a Hobby</label>
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



</div>
</body>
</html>
