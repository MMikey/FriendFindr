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

</head>


<body>
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

<?php $mysqli->close();?>