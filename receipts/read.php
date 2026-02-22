<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$stmt = $pdo->query("
  SELECT id, date, sanction_order AS sanctionOrder, category, amount, attachment
  FROM receipts
  ORDER BY date DESC, id DESC
");

jsonResponse($stmt->fetchAll());