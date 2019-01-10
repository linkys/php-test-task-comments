<?php
require_once 'csrf.php';
require_once 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    checkCsrfToken();

    $data = handleData($_POST);

    switch ($data['_action']) {
        case 'add_comment':
            createComment($data); break;
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = handleData($_GET);

    switch ($data['_action']) {
        case 'search_comments':
            searchComments($data); break;
    }
}

function getAllComments() {
    global $pdo;

    return $pdo->query('SELECT * FROM comments ORDER BY `created_at` DESC')->fetchAll();
}

function createComment($data) {
    global $pdo;

    $errors = validate($data);

    if(!empty($errors)) {
        header('Content-type: application/json');
        echo json_encode([
            'status' => false,
            'errors' => $errors
        ]);
        exit;
    }

    $data['created_at'] = date("Y-m-d H:i:s");

    $allowed = ['name', 'email', 'message', 'created_at'];

    $sql = "INSERT INTO comments SET " . pdoSet($allowed, $data);
    $stmt = $pdo->prepare($sql);

    $stmt->execute($data);

    $data['id'] = $pdo->lastInsertId();
    $data['created_at'] = date("d.m.Y H:i:s", strtotime($data['created_at']));

    header('Content-type: application/json');
    echo json_encode([
        'status' => true,
        'data' => $data
    ]);
    exit;
}

function searchComments($data) {
    global $pdo;

    $stmt = $pdo->prepare('SELECT id FROM comments WHERE email = ?');
    $stmt->execute([$data['s']]);

    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    header('Content-type: application/json');
    echo json_encode([
        'ids' => $ids
    ]);
    exit;
}

function validate($data) {

    $errors = [];

    if (empty($data['name'])) {
        $errors['name'] = "Name is required";
    } else if(strlen($data['email']) > 255) {
        $errors['name'] = "Name has more than 255 characters";
    }

    if (empty($data['email'])) {
        $errors['email'] = "Email is required";
    } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } else if(strlen($data['email']) > 255) {
        $errors['email'] = "Email has more than 255 characters";
    }

    if (empty($data['message'])) {
        $errors['message'] = "Message is required";
    } else if(strlen($data['email']) > 5000) {
        $errors['message'] = "Message has more than 5000 characters";
    }

    return $errors;

}

function handleData($data) {
    foreach ($data as &$item) {
        $item = trim(filter_var($item, FILTER_SANITIZE_STRING));
    }

    return $data;
}
