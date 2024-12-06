<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';

// Obtém usuários
$users = getUsers1();
echo json_encode($users, JSON_UNESCAPED_UNICODE);