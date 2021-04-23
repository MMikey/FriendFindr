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
$post = "";
$group_err = $post_err = "";

try {
    $group = new Group($group_ID);
} catch(Exception $e) {
    $group_err = $e->getMessage();
}


if(isset($_POST["join_group"])) {
    try {
        $group->add_user($_SESSION["id"]);
        header('location: group-page.php?groupid='.$group_ID);
    } catch(Exception $e) {
        $group_err = $e;
    }
}

if(isset($_POST["leave_group"])) {
     try {
         $group->remove_user($_SESSION["id"]);
     } catch(Exception $e) {
         $group_err = $e->getMessage();
     }
}

if(isset($_POST["remove_post"])) {
    delete_post($_POST["post_id"]);
}

if(isset($_POST["post_message"])){
    $sql = "INSERT into posts (userid, groupid, content) VALUES (?,?,?);";

    if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sss",$param_userid, $param_groupid, $param_content );
        $param_userid = $_SESSION["id"];
        $param_groupid = $group->get_id();
        $param_content = $_POST["message"];

        if($stmt->execute()) {
            $stmt->store_result();
            header('location: group-page.php?groupid='.$group_ID);
        } else {
            $post_err = "Oops! Something went wrong! " . $stmt->error;
        }
    } else {
        $post_err = "Oops! Something went wrong! " . $stmt->error;
    }
}

function delete_post($post_id) {
    global $mysqli;


    $sql = "DELETE FROM posts WHERE postid = $post_id";
    if($mysqli->query($sql)) {

    } else {
        echo "error!";
    }

}

function getPosts($group_id){
    global $mysqli;

    $sql = "SELECT postid, content,userid,posted_at FROM posts WHERE groupid = $group_id ORDER BY posted_at DESC ";

    if($result = $mysqli->query($sql)) {
        if($result->num_rows == 0) {
            echo <<<HTML
                <div class="row">
                <h5 class="col-12"> There are currently no posts: Be the first!</h5>
                </div>
                HTML;

        }
        while($row = $result->fetch_assoc()){
            $sql = "SELECT username FROM users WHERE userid =".$row["userid"].";";
            $_result = $mysqli->query($sql);
            $_row = $_result->fetch_assoc();
            $delete_btn = "";
            if($row['userid'] == $_SESSION['id']) {
                $delete_btn=<<<HTML
                    <form method="post" action="">
                        <input type="hidden" name="post_id" value="{$row["postid"]}">
                        <input type="submit" name="remove_post" class="btn btn-danger" value="Delete Post">
                    </form>
                    HTML;
            }

            echo <<<HTML
                <tr>
                    <th style="width:20%" scope="row" class="table-secondary">{$_row["username"]}</th>
                    <td style="width:50%">{$row["content"]}</td>
                    <td style="width:20%">{$row["posted_at"]}</td>
                    <td style="width:%" class="float-right">{$delete_btn}</td>
                </tr>
                HTML;
        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>

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

<h1 class="my-5"></h1>
<div class="container ">
    <section class="jumbotron text-center">
        <div class="container">
            <?php
            if (!empty($group_err)) {
                echo '<div class="alert alert-danger">' . $group_err . '</div>';
            }
            ?>
            <h2 class="jumbotron-heading"><?php echo $group->get_name() ?></h2>
            <p class="lead text-muted"><?php echo $group->get_description()?></p>
            <form method="post">
                <?php echo (!$group->is_member($_SESSION["id"])) ? '<input type="submit" name="join_group" class="btn btn-primary" value="Join group">'  :
                    '<input type="submit" name="leave_group" class="btn btn-secondary" value="Leave group">';?>
            </form>
        </div>
    </section>

    </p>
    <div class="container p-3 bg-light">
        <h3>Group Posts</h3>
       <div class="container overflow-auto p-2 bg-white">
           <table class="table table-striped">
               <tbody>
                   <?php getposts($group_ID) ?>
               </tbody>
           </table>
       </div>
        <form  method="post">
            <div class="form-group">
                <label>Enter a message</label>
                <textarea style="width: 50%" name="message" class="form-control text-center" rows="3" value = "<?php echo $post;?>"
                    <?php echo ($group->is_member($_SESSION["id"])) ? "" : "placeholder='You must be a member to make a post' disabled"?>></textarea>
                <span class="invalid-feedback"><?php echo $post_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="post_message" class="btn btn-primary" value="Post">
            </div>
        </form>
    </div>

    <div class="container mt-2 mb-2 p-3 bg-light">
        <h3>Members</h3>
        <?php
        $members = $group->get_members();
        foreach($members as $member=>$member_value){
        echo <<<HTML
            <div class="row">
            <p class = "col-2">{$member_value}</p>
            <a href="profile-page.php?userid=$member" class="btn-default col-10" role="button">View Profile</a>
            </div>
            HTML;
        }
        ?>
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
