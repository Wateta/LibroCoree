<?php

include '../config/db.php';
include '../auth/auth_check.php';

$id = $_GET['id'];

$sql = "DELETE FROM books WHERE id=$id";

if(mysqli_query($conn, $sql)){
    header("Location: view_books.php");
    exit();
} else {
    echo "Error deleting book!";
}

?>