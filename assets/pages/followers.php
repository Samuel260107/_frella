<?php
require_once 'functions.php'; // Certifique-se de que a função existe e está no lugar certo.

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // Recuperar informações do usuário e seguidores
    $userData = getUserById($user_id); // Função que busca os dados do usuário
    $followers = getFollowers($user_id); // Função que recupera os seguidores
    
    // Exibir os seguidores ou informações adicionais
    echo "Seguidores de: " . $userData['first_name'] . " " . $userData['last_name'];
    
    foreach ($followers as $follower) {
        echo "<p>" . $follower['first_name'] . " " . $follower['last_name'] . "</p>";
    }
} else {
    echo "ID do usuário não fornecido.";
}
?>

<style>
    .seguidores-list {
    display: flex;
    flex-wrap: wrap;
}

.seguidor {
    width: 200px;
    margin: 10px;
    text-align: center;
}

.follower-img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}
</style>