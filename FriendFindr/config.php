<?php

//$host="127.0.0.1";
//$port=3307;
//$socket="";

//connects to local database in phpmyadmin
//these may be different on your machine
//for example default username is usually root and password is usually empty
$host = "localhost"; //if that doesn't work try 127.0.0.1
$user="root";
$password="";
$dbname="friendfindr"; //change to whatever the database is on your machine

//object oriented approach, basically connect to database
$mysqli = new mysqli($host, $user, $password, $dbname);
//$mysqli = new mysqli($host, $user, $password, $dbname, $port, $socket);

if($mysqli->connect_error)
{
    echo "Connect failed " . $mysqli->connect_error;
    exit();
}
	
?>