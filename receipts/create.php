<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
  INSERT INTO receipts (date, sanction_order, category, amount, attachment)
  VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([
  $data["date"],
  $data["sanctionOrder"],
  $data["category"],
  $data["amount"],
  $data["attachment"] ?? null
]);

jsonResponse(["success" => true]);