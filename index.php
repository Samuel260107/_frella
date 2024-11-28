<?php
require_once 'assets/php/functions.php'; // Inclui functions.php corretamente

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica autenticação do usuário
if (isset($_SESSION['Auth'])) {
    $user = getUser($_SESSION['userdata']['id']);
} else {
    showPage('login'); // Redireciona para a página de login
    exit();
}

// Verifica as páginas baseadas nos parâmetros na URL
$pagecount = count($_GET);

if (!$pagecount || isset($_GET['signup'])) {
    showPage('signup');
    exit();
}

if (!$pagecount || isset($_GET['login'])) {
    showPage('login');
    exit();
}

if (isset($_SESSION['Auth'])) {
    if (!$pagecount || isset($_GET['perfill'])) {
        showPage('perfil');
        exit();
    }
    if (!$pagecount || isset($_GET['home'])) {
        showPage('navbar');
        showPage('fundohome');
        showPage('wall');
        exit();
    }
    if (!$pagecount || isset($_GET['meuperfill'])) {
        showPage('navbar');
        showPage('meuperfil');
        exit();
    }
    if (!$pagecount || isset($_GET['profile'])) {
        showPage('navbar');
        showPage('profile');
        exit();
    }
    if (!$pagecount || isset($_GET['post'])) {
        showPage('post');
        exit();
    }
    if (!$pagecount || isset($_GET['logout'])) {
        showPage('logout');
        exit();
    }
}
?>
