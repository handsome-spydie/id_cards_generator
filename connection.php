<?php
$servername = "localhost";
$username = "akanksha_aafCards";
$password = "Amosta@$123";
$database = "akanksha_aafCards";

// Create connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
  echo "Connection failed";
}

?>