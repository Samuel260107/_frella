<?php
// Inclua a conexão com o banco de dados e a verificação de sessão
include $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';
session_start();

// Verifique se o usuário está logado e se o parâmetro 'user' foi passado na URL
if (!isset($_SESSION['user_id']) || !isset($_GET['user'])) {
    header('Location: login.php');
    exit();
}

$logged_in_user_id = $_SESSION['user_id'];
$other_user_id = $_GET['user'];

// Obtenha o nome de usuário do outro usuário
$query = "SELECT username FROM users WHERE id = $other_user_id";
$result = mysqli_query($conn, $query);
$other_user = mysqli_fetch_assoc($result);

if (!$other_user) {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversa com <?php echo $other_user['username']; ?></title>
</head>
<body>
    <h2>Conversando com: <?php echo $other_user['username']; ?></h2>

    <!-- Exibir mensagens -->
    <div id="messages">
        <?php
        // Obtenha as mensagens entre os dois usuários
        $query = "SELECT * FROM messages WHERE (sender_id = $logged_in_user_id AND receiver_id = $other_user_id) OR (sender_id = $other_user_id AND receiver_id = $logged_in_user_id) ORDER BY timestamp ASC";
        $result = mysqli_query($conn, $query);

        while ($message = mysqli_fetch_assoc($result)) {
            echo "<div class='message'>";
            if ($message['sender_id'] == $logged_in_user_id) {
                echo "<strong>Você:</strong> " . htmlspecialchars($message['message']);
            } else {
                echo "<strong>" . htmlspecialchars($other_user['username']) . ":</strong> " . htmlspecialchars($message['message']);
            }
            echo "</div>";
        }
        ?>
    </div>

    <!-- Formulário para enviar mensagens -->
    <form action="send_message.php" method="POST">
        <input type="hidden" name="receiver_id" value="<?php echo $other_user_id; ?>">
        <textarea name="message" placeholder="Escreva sua mensagem..." required></textarea>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>