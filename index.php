<?php
require_once 'assets/php/functions.php'; // Inclui functions.php corretamente

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['Auth'])) {
    $user = getUser($_SESSION['userdata']['id']);
} 

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
    if (!$pagecount || isset($_GET['get_users'])) {
        showPage('get_users');
        exit();
    }
    if (!$pagecount || isset($_GET['search_users'])) {
        showPage('search_users');
        exit();
    }
    if (!$pagecount || isset($_GET['send_message'])) {
        showPage('send_message');
        exit();
    }


}
?>
