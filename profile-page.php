<?php

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
<div class="container">

    <h2>Groups:</h2>

    <?php



    ?>



</div>
</body>
</html>

