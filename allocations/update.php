<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

$pdo->beginTransaction();

$stmt = $pdo->prepare("
  UPDATE allocations
  SET date=?, allocation_number=?
  WHERE id=?
");
$stmt->execute([
  $data["date"],
  $data["allocationNumber"],
  $data["id"]
]);

$pdo->prepare("DELETE FROM allocation_amounts WHERE allocation_id=?")
    ->execute([$data["id"]]);

$stmt2 = $pdo->prepare("
  INSERT INTO allocation_amounts (allocation_id, category, allocated_amount)
  VALUES (?, ?, ?)
");

foreach ($data["categoryAmounts"] as $ca) {
  $stmt2->execute([
    $data["id"],
    $ca["category"],
    $ca["allocatedAmount"]
  ]);
}

$pdo->commit();

jsonResponse(["success" => true]);