<?php
/**
 * @var mysqli $mysqli
 */

// Initialise the session
session_start();

require_once "config.php";

//Check if the user is logged in, if not then redirect him to login page 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}

//get group information for user hobbys
$group_err = "";


//initial sql
//get hobby ids for user
$sql = "SELECT grouphobbies.groupid, userhobbies.hobbyid from grouphobbies, userhobbies 
        where grouphobbies.hobbyid = userhobbies.hobbyid AND userhobbies.userid = " . $_SESSION["id"] . ";";

//see if query passed successfully
echo ($result = $mysqli->query($sql)) ? "" : "error: " . $mysqli->error;

$groups = array(); // create array to store groupids in
if($result->num_rows > 0)
{
    $result->fetch_assoc(); //fetch first result because it outputs duplicates for some reason
    while($row = $result->fetch_assoc())
    {
        $groups[] = $row["groupid"];
    }
}
else
{
    $group_err = "No groups to recommend.. Try selecting some hobbies";
}



?>
<!-- This is just a template example of html that i pinched off the internet obviously ours will be different -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <div class="container">
        <?php
        foreach($groups as $group) //loop through array of relevant groups for the user to display them on the main window
        {
            $sql = "SELECT groupid, name, description FROM groups WHERE groupid = " . $group . ";";

            echo ($result = $mysqli->query($sql)) ? "" : "error!";

            while($row = $result->fetch_assoc())
            {
                echo "<div class=\"jumbotron\">";
                echo "<h3>" . $row["name"] . "</h3>\n";
                echo "<p>" . $row["description"] . "</p>\n";
                echo "</div>";
            }
        }
        ?>

    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="
    </p>

</body>
</html>