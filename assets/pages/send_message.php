<?php
session_start(); // Inicie a sessão

require_once '../php/config.php'; // Inclua o arquivo de configuração do banco de dados
require_once '../php/functions.php'; // Inclua as funções

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o usuário está logado
    if (isset($_SESSION['userdata']['id'])) {
        $sender_id = $_SESSION['userdata']['id'];
        $receiver_id = $_POST['receiver_id'];
        $message_text = $_POST['message_text'];

        // Adicione uma linha para depuração
        var_dump($receiver_id); // Verifique o valor de receiver_id

        // Verifica se o receiver_id é válido
        $stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->bind_param("i", $receiver_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // O receiver_id é válido
            if (!empty($message_text)) {
                sendMessage($sender_id, $receiver_id, $message_text);
            }
            header("Location: chat.php?user=$receiver_id");
            exit;
        } else {
            // O receiver_id não é válido
            echo "Erro: O ID do receptor não é válido.";
        }
    } else {
        echo "Erro: Usuário não logado.";
        var_dump($_SESSION); // Para depurar e ver o que está na sessão
    }
}
?>
