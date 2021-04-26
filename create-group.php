<?php
/** @var mysqli $mysqli */
//include config file - connects to database
require_once "config.php";

$groupname = $description = $imagename = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["groupname"])) {
        $groupname_err = "Please enter a group name.";
    } else {
        $groupname = $_POST["groupname"];
    }

    if (empty($_POST["description"])) {
        $description_err = "Please enter a description.";
    } else {
        $description = $_POST["description"];
    }

    //Check input errors before inserting into database
    if (empty($groupname_err) && empty($description_err)) {

        //sql statement for inserting data into users table with parameters
        $sql = "INSERT INTO groups (name, description) VALUES (?,?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss",$param_groupname, $param_description); // bind parameters to  queries]

            $param_groupname = $groupname;
            $param_description = $description;
            if ($stmt->execute()) {
                $stmt->store_result();

                $sql = "SELECT MAX(groupid) as groupid FROM groups";
                if ($result = $mysqli->query($sql)) {
                    while ($row = $result->fetch_assoc()) {
                        //user echo with html to create stuff
                        $maxgroup = $row["groupid"];
                    }
                } else {
                    echo "Error!" . $mysqli->error;
                }

                header('location:group-page.php?groupid='.$maxgroup);
            } else {
                echo "Oops! Something went wrong. Please try again later." . $mysqli->error;
            }

            $stmt->close(); // close statement - close query
        } else {
            echo "Oop! Something went wrong!. Please try again later." . $mysqli->error;
        }

    } else {
        $all_errors = array($groupname_err,$description_err);
        $errors = getErrors($all_errors);
    }

    //$mysqli->close();
}


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
</section>

<div class="container" style="">
    <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h2>Create Your Own Group!</h2>

        <form id="login" class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <h3>Enter a group name</h3>
                <input type="text" name="groupname" class="input-field" value="<?php echo $groupname; ?>" placeholder="Group Name" required>
            </div>
            <div>
                <h3>Enter a group description</h3>
                <input type="text" name="description" class="input-field" value="<?php echo $description; ?>" placeholder="Description" required>
            </div>
            <input type="submit" class="submit-btn" value="Create Group">
        </form>

    </div>
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