<?php

$credentials = [
    'host' => 'localhost',
    'database' => 'test-task-db',
    'user' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

$dsn = "mysql:host=" . $credentials['host'] . ";dbname=" . $credentials['database'] . ";charset=". $credentials['charset'] ."";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $credentials['user'], $credentials['password'], $opt);

function pdoSet($allowed, &$source = array()) {
    $set = '';

    foreach ($source as $key => $field) {
        if (in_array($key, $allowed)) {
            $set.="`".str_replace("`", "``", $key) . "`" . "=:$key,";
        } else {
            unset($source[$key]);
        }
    }

    return trim($set, ',');
}