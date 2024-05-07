<?php

include_once 'db_connect.php';


// Prepare statement for insertion to avoid SQL injection issues
$stmt = $conn->prepare("INSERT INTO Histories (username, amount, country, active, datetime) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sdsis", $username, $amount, $country, $active, $datetime);

// Data generation
$countries = ['USA', 'Canada', 'Malaysia', 'India', 'China', 'Germany', 'France', 'Australia', 'Russia', 'Philippines'];
$records = 100000;

for ($i = 0; $i < $records; $i++) {
    $username = "user_" . rand(1, 1000000);
    $amount = rand(100, 10000);
    $country = $countries[array_rand($countries)];
    $active = (rand(1, 100) <= 95) ? 1 : 0;  
    $datetime = date("Y-m-d H:i:s", rand(strtotime('May 1 2023'), strtotime('May 31 2024')));

    $stmt->execute();
}

echo "Inserted $records records successfully.";

$stmt->close();
$conn->close();