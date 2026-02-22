<?php
require_once __DIR__ . "/middleware/cors.php";
require_once __DIR__ . "/utils/response.php";

// ---------------------------------------------------------------------------
// Cookie-based auth gate
//
// Currently allows ALL requests (no cookie check).
// To enforce authentication, uncomment the block below and set
// AUTH_COOKIE_NAME / AUTH_COOKIE_VALUE to match the cookie your login
// system issues (e.g. an ERP session cookie).
//
// When enabled the flow is:
//   1. Frontend sends requests with credentials: "include", so the browser
//      attaches cookies for localhost:8000.
//   2. This script reads the expected cookie and compares its value.
//   3. If the cookie is missing or the value doesn't match, the user is
//      treated as unauthenticated and canModify returns false.
// ---------------------------------------------------------------------------

// define("AUTH_COOKIE_NAME",  "erp_session");
// define("AUTH_COOKIE_VALUE", "expected-token-or-hash");
//
// $cookie = $_COOKIE[AUTH_COOKIE_NAME] ?? null;
//
// if ($cookie === null || $cookie !== AUTH_COOKIE_VALUE) {
//     jsonResponse(["allowed" => false]);
// }

jsonResponse(["allowed" => false]);
