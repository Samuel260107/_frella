<?php
global $user; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';

// Usuário logado (use o ID do usuário logado da sessão)
if (isset($_SESSION['Auth'])) {
    $user = getUser($_SESSION['userdata']['id']);
} 

// Função para obter todos os usuários, exceto o logado
function getOtherUsers($currentUserId) {
    global $conn; // Certifique-se de ter uma conexão com o banco
    $query = "SELECT id, username FROM users WHERE id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Função para obter as mensagens entre dois usuários
function getMessages($senderId, $receiverId) {
    global $conn;
    $query = "SELECT * FROM messages 
              WHERE (sender_id = ? AND receiver_id = ?)
                 OR (sender_id = ? AND receiver_id = ?)
              ORDER BY created_at ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $senderId, $receiverId, $receiverId, $senderId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Manipular seleção de usuário
$selectedUserId = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;
$messages = $selectedUserId ? getMessages($currentUserId, $selectedUserId) : [];
$users = getOtherUsers($currentUserId);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Mensagens</title>
</head>
<body>
    <h1>Mensagens</h1>
    <div style="display: flex; gap: 20px;">
        <!-- Lista de usuários -->
        <div style="width: 30%;">
            <h3>Usuários</h3>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li>
                        <a href="?user_id=<?= $user['id']; ?>">
                            <?= htmlspecialchars($user['username']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Chat -->
        <div style="width: 70%;">
            <?php if ($selectedUserId): ?>
                <h3>Conversa com <?= htmlspecialchars($users[array_search($selectedUserId, array_column($users, 'id'))]['username'] ?? 'Usuário'); ?></h3>
                <div style="border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: scroll;">
                    <?php if ($messages): ?>
                        <?php foreach ($messages as $message): ?>
                            <div>
                                <strong><?= $message['sender_id'] == $currentUserId ? 'Você' : 'Outro'; ?>:</strong>
                                <?= htmlspecialchars($message['content']); ?>
                                <small style="color: #999;"><?= $message['created_at']; ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhuma mensagem.</p>
                    <?php endif; ?>
                </div>
                <!-- Formulário para enviar mensagens -->
                <form method="POST" action="../pages/send_message.php">
    <textarea name="content" rows="3" placeholder="Escreva sua mensagem..." required></textarea>
    <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($selectedUserId); ?>">
    <button type="submit">Enviar</button>
</form>
            <?php else: ?>
                <p>Selecione um usuário para começar a conversar.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>