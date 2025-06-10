<?php
// router.php
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}
require_once __DIR__ . '/public/index.php';
