<?php
// Inicia a sessão
session_start();

// Remove todas as variáveis de sessão
$_SESSION = [];

// Se você quiser destruir a sessão completamente, você pode usar:
session_destroy();

// Redireciona o usuário para a página de login ou homepage
header("Location: ?login"); // Altere para a página desejada
exit;
?>
