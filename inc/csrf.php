<?php

session_start();
if (empty($_SESSION['_token'])) {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
}

function csrfToken() {
    return $_SESSION['_token'];
}

function checkCsrfToken() {
    if (empty($_POST['_token']) || !hash_equals($_SESSION['_token'], $_POST['_token'])) {
        http_response_code(403);
        die('Access denied. CSRF check failed');
    }
}