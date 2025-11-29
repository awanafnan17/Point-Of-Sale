<?php
$password = 'pointofsale';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Generated Hash: " . $hash . "\n";

$mysqli = new mysqli("localhost", "ospos", "ospos", "ospos", 3306);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$stmt = $mysqli->prepare("UPDATE ospos_employees SET password = ? WHERE username = 'admin'");
$stmt->bind_param("s", $hash);
$stmt->execute();

echo "Password updated successfully for user 'admin'.\n";
$stmt->close();
$mysqli->close();
?>
