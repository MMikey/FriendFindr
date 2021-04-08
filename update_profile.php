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

$username = $email = $hobby = $bio = $location = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/FFStylesheet.css">

</head>

<body>
<div class="wrapper">
    <h2>Update Profile</h2>
    <p>Please fill in fields that you would like to update</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="form-group">
            <label>
                Username
                <small class="text-muted">Optional</small>
            </label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <label>
                Email
                <small class="text-muted">Optional</small>
            </label>
            <input type="text" name="email" class="form-control <?php (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label>
                Select a Hobby
                <small class="text-muted">Optional</small>
            </label>
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
        <div class="form-group">
            <label>
                Enter something about yourself!
                <small class="text-muted">Optional</small>
            </label>
            <textarea  name="bio" class="form-control" rows="3" value = "<?php echo $bio;?>"></textarea>
        </div>
        <div class="form-group">
            <label>
                Whats your city?
                <small class="text-muted">Optional</small>
            </label>
            <input type="text" name = "location" class = "form-control" value = "<?php echo $location?>">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
    </form>

</div>
<p>
    <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</p>
</body>

</html>
