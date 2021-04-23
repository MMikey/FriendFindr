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

/*function getJoinedGroups()
{
    global $mysqli;
    $sql = "SELECT g.groupid, g.name, g.description FROM groups g, usergroups ug WHERE g.groupid = ug.groupid AND ug.userid =" . $_SESSION["id"] . ";";
    $joinedgroups_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql statement
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo <<<HTML
                    <div id="recommended-groups-box" class="jumbotron text-center">
                        <h3 class="jumbotron-heading">{$row["name"]}</h3>
                        <p class="lead text-muted">{$row["description"]}</p>
                        <a href="group-page.php?groupid={$row["groupid"]}" class="btn btn-info" role="button">View Group</a>
                    </div>
                    HTML;
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
    $sql = "SELECT DISTINCT g.groupid, g.name, g.description FROM groups g, grouphobbies gh, userhobbies uh where gh.hobbyid = uh.hobbyid AND uh.userid = " . $_SESSION["id"] . ";";
    $group_err = ($result = $mysqli->query($sql)) ? "" : "Error: " . $mysqli->error;//error check sql
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo <<<HTML
                    <div id="recommended-groups-box" class="jumbotron text-center">
                        <h3 class="jumbotron-heading">{$row["name"]}</h3>
                        <p class="lead text-muted">{$row["description"]}</p>
                        <a href="group-page.php?groupid={$row["groupid"]}" class="btn btn-info" role="button">View Group</a>
                    </div>
                    HTML;

        }

    } else {
        $group_err = "No groups to recommend.. Try selecting some hobbies";
    }
    if (!empty($group_err)) {
        echo '<div class="alert alert-danger">' . $group_err . '</div>';
    }

}
*/
?>
    <!-- This is just a template example of html that i pinched off the internet obviously ours will be different -->
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="css/wpCss.css"/>
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
    </section></section>
    <section id="ban">
	<div class ="container">
	<div class ="row">
	<div class = "col-md-6">
    <!-- <h1 class="my-5" style="text-align: center">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1> -->
	<p class="promo-title"> About us </p>
	<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
	Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
	when an unknown printer took a galley of type and scrambled it to make a type specimen book.
	It has survived not only five centuries </p>
	<a href="#">  </a>
	</div>
	<div class="col-md-6 text-center">
	<img src="./data/aboutus.jpg" class="img-fluid">
	
	</div>
	</div>
	</div>
	
	
	 <!--<img src="./img/bck1.jpg" class="bottom-img"> -->
	</section>
	
	<!--service section -->
	
	<section id="services">
	<div class="container text-center">
	<h1 class="title"> WHAT WE DO? </h1>
	<div class="row">
	<div class="col-md-4 services">
	<img src="./data/home.jpg" class="service-img">
	<h4> Home </h4>
	<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
	Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>
	</div>
	<div class="col-md-4 services">
	<img src="./data/event.jpg" class="service-img">
	<h4> Events </h4>
	<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
	Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>
	</div>
	<div class="col-md-4 services">
	<img src="./data/profile.jpg" class="service-img">
	<h4> Profile </h4>
	<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
	Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>
	</div>
	</div>
	<button type="button" class="btn btn-primary"> All services </button>
	</div>
	</section>
      <!--  <?php getJoinedGroups(); ?>


        <h2>Recommended groups</h2>
        <?php getRecommendedGroups(); ?>

        -->

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
<?php $mysqli->close();?>