<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$servername = "103.57.220.210";
$username = "xmyoyqsfhosting_enbeeclick";
$password = "AilBD5s(clM7W0:";
$dbname = "xmyoyqsfhosting_enbeeclick";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$sql = "SELECT * FROM `0F2_defaultactionscheduler_actions`;";

$stmt = $conn->query($sql);

$result = $stmt->fetch_all(PDO::FETCH_ASSOC);
echo "<pre>";
var_dump($result);
echo "</pre>";