<?php
$pdo = new PDO(
    'mysql:host=sql206.infinityfree.com;dbname=if0_42256022_posyandu_web;charset=utf8mb4',
    'if0_42256022',
    'Isal730037i',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
session_start();
?>