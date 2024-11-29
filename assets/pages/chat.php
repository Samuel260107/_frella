<?php
session_start();
require_once '../php/config.php'; // Inclua o arquivo de configuração do banco de dados
require_once '../php/functions.php'; // Inclua as funções

// Verifica se o usuário está logado
if (!isset($_SESSION['userdata']['id'])) {
    echo "Erro: Usuário não logado.";
    exit;
}

// Pega o ID do usuário logado
$logged_user_id = $_SESSION['userdata']['id'];

// Pega o ID do usuário destinatário da URL (ex: chat.php?user=2)
$receiver_id = isset($_GET['user']) ? $_GET['user'] : null;

if ($receiver_id) {
    // Busca as mensagens trocadas entre o usuário logado e o destinatário
    $stmt = $db->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC");
    $stmt->bind_param("iiii", $logged_user_id, $receiver_id, $receiver_id, $logged_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Erro: ID do destinatário não especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css"> <!-- Ajuste o caminho do seu arquivo CSS -->
</head>
<body>
    <header>
        <h2>Chat com Usuário <?php echo $receiver_id; ?></h2>
    </header>

    <main>
        <!-- Exibição das mensagens -->
        <div class="chat-box">
            <?php while ($message = $result->fetch_assoc()): ?>
                <div class="message <?php echo ($message['sender_id'] == $logged_user_id) ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($message['message']); ?></p>
                    <span class="timestamp"><?php echo $message['created_at']; ?></span>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Formulário de envio de mensagem -->
        <form action="chat.php?user=<?php echo $receiver_id; ?>" method="POST">
            <textarea name="message_text" rows="3" placeholder="Digite sua mensagem..."></textarea>
            <button type="submit">Enviar</button>
        </form>
    </main>

    <script>
        // Opcional: Automático para rolar até a última mensagem
        const chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</body>
</html>

<?php
// Processa o envio de mensagens
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_text = $_POST['message_text'];

    // Verifica se a mensagem não está vazia
    if (!empty($message_text)) {
        // Envia a mensagem
        sendMessage($logged_user_id, $receiver_id, $message_text);
        // Redireciona para a mesma página para mostrar a nova mensagem
        header("Location: chat.php?user=$receiver_id");
        exit;
    } else {
        echo "Erro: A mensagem não pode estar vazia.";
    }
}
?>