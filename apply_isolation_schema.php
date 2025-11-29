<?php
$mysqli = new mysqli("localhost", "ospos", "ospos", "ospos", 3306);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Add company_id to ospos_items
$result = $mysqli->query("SHOW COLUMNS FROM ospos_items LIKE 'company_id'");
if ($result->num_rows == 0) {
    $mysqli->query("ALTER TABLE ospos_items ADD COLUMN company_id INT(11) NOT NULL DEFAULT 1");
    echo "Added company_id to ospos_items.\n";
} else {
    echo "company_id already exists in ospos_items.\n";
}

// Add company_id to ospos_people
$result = $mysqli->query("SHOW COLUMNS FROM ospos_people LIKE 'company_id'");
if ($result->num_rows == 0) {
    $mysqli->query("ALTER TABLE ospos_people ADD COLUMN company_id INT(11) NOT NULL DEFAULT 1");
    echo "Added company_id to ospos_people.\n";
} else {
    echo "company_id already exists in ospos_people.\n";
}

$mysqli->close();
?>
