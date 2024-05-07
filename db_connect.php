<?php

$host = 'localhost'; 
$dbname = 'tech_exam_history';    
$username = 'root';  
$password = '';       

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}