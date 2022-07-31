<?php

require "../db.php";

$items_per_page = 30;
$offset = $_GET["page"] * $items_per_page;
$data = ["drawings" => []];
$sql = "SELECT id, pseudo, file, date FROM drawings WHERE fk_type = ? LIMIT ?, ?;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $_GET["type"], $offset, $items_per_page);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $data["drawings"][] = $row;
}
$stmt->close();

header("Content-Type: application/json");
echo json_encode($data);
