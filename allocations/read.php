<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$allocations = $pdo->query("
  SELECT id, date, allocation_number AS allocationNumber
  FROM allocations
  ORDER BY date DESC, id DESC
")->fetchAll();

foreach ($allocations as &$a) {
  $stmt = $pdo->prepare("
    SELECT category, allocated_amount
    FROM allocation_amounts
    WHERE allocation_id=?
  ");
  $stmt->execute([$a["id"]]);

  $a["categoryAmounts"] = array_map(fn($r) => [
    "category" => $r["category"],
    "allocatedAmount" => (float)$r["allocated_amount"]
  ], $stmt->fetchAll());
}

jsonResponse($allocations);