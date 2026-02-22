<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
  UPDATE receipts
  SET date=?, sanction_order=?, category=?, amount=?, attachment=?
  WHERE id=?
");

$stmt->execute([
  $data["date"],
  $data["sanctionOrder"],
  $data["category"],
  $data["amount"],
  $data["attachment"] ?? null,
  $data["id"]
]);

jsonResponse(["success" => true]);