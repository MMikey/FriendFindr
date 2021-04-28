<?php
/** @var mysqli $mysqli  */
include_once "config.php";

session_start();
if($_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


//check if we're uploading to profile or group page
if(isset($_GET["groupid"]) || isset($_POST["groupid"])) $target_dir = "uploads/group_pictures/";
else $target_dir = "uploads/profile_pictures/";
$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$newfilename =  round(microtime(true)) . '.' . end($temp);
$target_file = $target_dir . $newfilename;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " .   $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if(!isset($_GET["groupid"]) && !isset($_POST["groupid"])) {
    if(!uploadProfilePicToDatabase($newfilename)) $uploadOk=0;
} else if(!uploadGroupPicToDatabase($newfilename)) $uploadOk =0;


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        header("location: welcome.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

function uploadGroupPicToDatabase($name) {
    global $mysqli;
    //check if file already exists
    $groupid = (isset($_GET["groupid"])) ? $_GET["groupid"] : $_POST["groupid"];
    $sql = "SELECT grouppictureid FROM grouppictures WHERE groupid =". $groupid .";";
    if($result = $mysqli->query($sql))
    {
        if($result->num_rows == 0) {
            $sql = "INSERT into grouppictures (name,groupid) VALUES(?,?);";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $param_name, $param_id);
            $param_name = $name;
            $param_id = $groupid;
        }else {
            $sql = "UPDATE grouppictures SET name=? WHERE groupid =?;";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $param_name, $param_id);
            $param_name = $name;
            $param_id = $groupid;
        }
        if($stmt->execute()) {
            return true;
        } else {
            echo $mysqli->error;
            return false;
        }
    } else {
        echo $mysqli->error;
        return false;
    }

}
function uploadProfilePicToDatabase($name) {
    global $mysqli;
    //check if file already exists
    $sql = "SELECT profilepictureid FROM profilepictures WHERE userid =". $_SESSION["id"] .";";
    if($result = $mysqli->query($sql))
    {
        if($result->num_rows == 0) {
            $sql = "INSERT into profilepictures (name,userid) VALUES(?,?);";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $param_name, $param_id);
            $param_name = $name;
            $param_id = $_SESSION["id"];
        }else {
            $sql = "UPDATE profilepictures SET name=? WHERE userid =?;";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $param_name, $param_id);
            $param_name = $name;
            $param_id = $_SESSION["id"];
        }
        if($stmt->execute()) {
            return true;
        } else {
            echo $mysqli->error;
            return false;
        }
    } else {
        echo $mysqli->error;
        return false;
    }

}





