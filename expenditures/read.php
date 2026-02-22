<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$stmt = $pdo->query("
  SELECT
    id,
    date,
    bill_no AS billNo,
    voucher_no AS voucherNo,
    category,
    sub_category AS subCategory,
    department,
    amount,
    attachment
  FROM expenditures
  ORDER BY date DESC, id DESC
");

jsonResponse($stmt->fetchAll());