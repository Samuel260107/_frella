<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';  // Certifique-se de incluir a função de conexão com o banco

// Verifique se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegue os dados do POST
    $sender_id = $_SESSION['user_id'];  // ID do usuário logado
    $receiver_id = $_POST['receiver_id'];  // ID do destinatário
    $message = $_POST['message'];  // Mensagem

    // Conectar ao banco de dados
    require_once 'config.php';
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Banco de dados não conectado"); 

    // Escapar os dados para prevenir SQL Injection
    $message = mysqli_real_escape_string($db, $message);  // Use a variável $db aqui

    // Inserir a mensagem na tabela de mensagens
    $query = "INSERT INTO messages (sender_id, receiver_id, message, created_at) 
              VALUES ('$sender_id', '$receiver_id', '$message', NOW())";
    
    if (mysqli_query($db, $query)) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Erro ao enviar mensagem: " . mysqli_error($db);  // Use a variável $db aqui
    }

    // Fechar a conexão
    mysqli_close($db);  // Fechar a conexão corretamente
}
?>
