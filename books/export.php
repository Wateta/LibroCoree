<?php
include '../auth/auth_check.php';
include '../config/db.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="librocore-books-'.date('Y-m-d').'.csv"');
$out = fopen('php://output','w');
fputcsv($out,['ID','Title','Author','Category','Quantity','Published Year','ISBN']);
$r = mysqli_query($conn,"SELECT id,title,author,category,quantity,published_year,isbn FROM books ORDER BY id");
while($row=mysqli_fetch_assoc($r)) fputcsv($out,$row);
fclose($out); exit;
