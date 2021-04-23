<?php
//connects to local database in phpmyadmin
//these may be different on your machine
//default user and password is 'root' ''
$host = "localhost"; //if that doesn't work try 127.0.0.1
$user="root";
$password="";
$dbname="friendfindr"; //change to whatever the database is on your machine
//$port=3307;
//$socket="";

//Object oriented approach, basically connect to database
$mysqli = new mysqli($host, $user, $password, $dbname);
//$mysqli = new mysqli($host, $user, $password, $dbname, $port, $socket);

if($mysqli->connect_error)
{
    echo "Connect failed " . $mysqli->connect_error;
    exit();
}
?>