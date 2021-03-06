<?php header("location: login.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FriendFindr - Find some friends!</title>
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
    <div class="container">
        <header class="row">
        </header>

        <section>
            <h2>Find your group!</h2>
            <p>Signup and find your group</p>

        </section>

        <footer>
            <p>FriendFinderInc</p>
        </footer>
    </div>

</html>