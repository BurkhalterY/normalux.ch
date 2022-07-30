<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "normalux2";

$data = ["drawings" => []];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, pseudo, file, date FROM drawings WHERE fk_type = ? LIMIT 30;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["type"]);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $data["drawings"][] = $row;
}
$stmt->close();

header("Content-Type: application/json");
echo json_encode($data);
exit();
