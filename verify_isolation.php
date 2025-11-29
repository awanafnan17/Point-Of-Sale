<?php
$mysqli = new mysqli("localhost", "ospos", "ospos", "ospos", 3306);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

$users = ['talha', 'hashim'];
foreach ($users as $username) {
    $result = $mysqli->query("SELECT p.first_name, p.company_id FROM ospos_employees e JOIN ospos_people p ON e.person_id = p.person_id WHERE e.username = '$username'");
    if ($row = $result->fetch_assoc()) {
        echo "User: $username, Company ID: " . $row['company_id'] . "\n";
    } else {
        echo "User: $username not found.\n";
    }
}

$mysqli->close();
?>
