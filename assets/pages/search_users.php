<?php
// Conectar ao banco de dados
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $users = searchUsers($query); // Função que pesquisa no banco de dados
    echo json_encode($users); // Retorna o resultado como JSON
}

function searchUsers($query) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE username LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}
?>