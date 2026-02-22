<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

$pdo->beginTransaction();

$stmt = $pdo->prepare("
  INSERT INTO allocations (date, allocation_number)
  VALUES (?, ?)
");
$stmt->execute([$data["date"], $data["allocationNumber"]]);

$allocationId = $pdo->lastInsertId();

$stmt2 = $pdo->prepare("
  INSERT INTO allocation_amounts (allocation_id, category, allocated_amount)
  VALUES (?, ?, ?)
");

foreach ($data["categoryAmounts"] as $ca) {
  $stmt2->execute([
    $allocationId,
    $ca["category"],
    $ca["allocatedAmount"]
  ]);
}

$pdo->commit();

jsonResponse(["success" => true]);