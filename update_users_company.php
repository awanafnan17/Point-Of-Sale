<?php
$mysqli = new mysqli("localhost", "ospos", "ospos", "ospos", 3306);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Update Talha
$mysqli->query("UPDATE ospos_people p JOIN ospos_employees e ON p.person_id = e.person_id SET p.company_id = 2 WHERE e.username = 'talha'");
echo "Updated Talha to Company ID 2.\n";

// Update Hashim
$mysqli->query("UPDATE ospos_people p JOIN ospos_employees e ON p.person_id = e.person_id SET p.company_id = 3 WHERE e.username = 'hashim'");
echo "Updated Hashim to Company ID 3.\n";

$mysqli->close();
?>
