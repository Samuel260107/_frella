<?php
// Inclua sua conexão com o banco de dados
require_once '../php/config.php';

// Função para obter a lista de usuários
function getUsers($user_id) {
    global $db;

    // Consulta para obter usuários (exceto o usuário logado)
    $query = "SELECT id, username FROM users WHERE id != ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

// Supondo que o usuário logado tenha seu ID armazenado em uma variável de sessão
session_start();
$user_id = $_SESSION['user_id'];  // Certifique-se de que o ID do usuário esteja na sessão

// Obter os usuários e retornar como JSON
$users = getUsers($user_id);
echo json_encode($users);
?>
