<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';

if (isset($_GET['userId'])) {
    $currentUserId = $_SESSION['user_id']; // Usuário logado
    $otherUserId = intval($_GET['userId']);

    // Verifica se a conexão foi realizada
    if (!$conn) {
        echo json_encode(['error' => 'Erro de conexão com o banco']);
        exit();
    }

    $stmt = $conn->prepare("
        SELECT 
            sender_id, 
            receiver_id, 
            message, 
            timestamp 
        FROM 
            messages 
        WHERE 
            (sender_id = ? AND receiver_id = ?) 
            OR 
            (sender_id = ? AND receiver_id = ?)
        ORDER BY 
            timestamp ASC
    ");
    $stmt->bind_param("iiii", $currentUserId, $otherUserId, $otherUserId, $currentUserId);

    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Falha ao executar consulta']);
        exit();
    }

    $result = $stmt->get_result();
    $messages = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'sender' => $row['sender_id'] == $currentUserId ? 'me' : 'other',
                'message' => $row['message'],
                'timestamp' => date('d/m/Y H:i:s', strtotime($row['timestamp']))
            ];
        }
        echo json_encode($messages);
    } else {
        echo json_encode([]); // Nenhuma mensagem encontrada
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID do usuário não fornecido']);
}