<?php

$host = "localhost";
$user = "root";
$password = "soniateta123";
$database = "library_system";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?>