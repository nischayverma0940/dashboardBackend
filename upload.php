<?php
require "middleware/cors.php";
require "utils/response.php";

$type = $_POST["type"] ?? "";
if (!in_array($type, ["receipt", "expenditure"], true)) {
  jsonResponse(["error" => "Invalid type. Use 'receipt' or 'expenditure'."], 400);
}

if (!isset($_FILES["file"]) || $_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
  $msg = isset($_FILES["file"]) ? "Upload error code: " . $_FILES["file"]["error"] : "No file uploaded.";
  jsonResponse(["error" => $msg], 400);
}

$file = $_FILES["file"];
$maxSize = 10 * 1024 * 1024; // 10 MB
if ($file["size"] > $maxSize) {
  jsonResponse(["error" => "File too large. Maximum size is 10 MB."], 400);
}

$allowed = [
  "pdf" => "application/pdf",
  "jpg" => "image/jpeg",
  "jpeg" => "image/jpeg",
  "png" => "image/png",
  "gif" => "image/gif",
  "webp" => "image/webp",
];
$ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
if (!isset($allowed[$ext])) {
  jsonResponse(["error" => "File type not allowed. Use PDF or image (jpg, png, gif, webp)."], 400);
}

$baseDir = __DIR__ . "/uploads/" . ($type === "receipt" ? "receipts" : "expenditures");
$year = date("Y");
$dir = $baseDir . "/" . $year;
if (!is_dir($dir)) {
  if (!mkdir($dir, 0755, true)) {
    jsonResponse(["error" => "Failed to create upload directory."], 500);
  }
}

$name = uniqid("", true) . "." . $ext;
$path = $dir . "/" . $name;
if (!move_uploaded_file($file["tmp_name"], $path)) {
  jsonResponse(["error" => "Failed to save file."], 500);
}

$url = "uploads/" . ($type === "receipt" ? "receipts" : "expenditures") . "/" . $year . "/" . $name;
jsonResponse(["url" => $url]);
