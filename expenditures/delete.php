<?php
require "../middleware/cors.php";
require "../config/database.php";
require "../utils/response.php";

$id = $_GET["id"] ?? null;
if (!$id) jsonResponse(["error" => "Missing id"], 400);

$stmt = $pdo->prepare("DELETE FROM expenditures WHERE id=?");
$stmt->execute([$id]);

jsonResponse(["success" => true]);