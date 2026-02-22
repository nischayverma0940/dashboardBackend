<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
  INSERT INTO expenditures
  (date, bill_no, voucher_no, category, sub_category, department, amount, attachment)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
  $data["date"],
  $data["billNo"],
  $data["voucherNo"],
  $data["category"],
  $data["subCategory"],
  $data["department"],
  $data["amount"],
  $data["attachment"] ?? null
]);

jsonResponse(["success" => true]);