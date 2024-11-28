<?php
require_once 'functions.php';
include('functions.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lógica para o login
if (isset($_GET['login']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = validateLoginForm($_POST);

    if ($response['status']) {
        $_SESSION['Auth'] = true;
        $_SESSION['userdata'] = $response['user'];
        header("Location: ../../?home"); // Redireciona para a home após login
        exit();
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("Location: ../../?login"); // Redireciona para o login em caso de erro
        exit();
    }
}

if (isset($_GET['signup']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = validateSignupForm($_POST);
    if ($response['status']) {
        if ($userId = createUser($_POST)) {
            $_SESSION['Auth'] = true;
            $_SESSION['userdata'] = getUser($userId);
            header('Location: ../../?perfill');
            exit();
        } else {
            echo "Erro ao criar usuário.";
        }
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("Location: ../../?signup");
        exit();
    }
}

if (isset($_GET['follow'])) {
    $follower_id = $_SESSION['userdata']['id'];
    $following_id = $_POST['following_id'];

    if (followUser($follower_id, $following_id)) {
        header("Location: ../../?home");
    } else {
        header("Location: /wall.php?msg=Já segue este usuário");
    }
    exit();
}

if (isset($_GET['unfollow'])) {
    $follower_id = $_SESSION['userdata']['id'];
    $following_id = $_POST['following_id'];

    if (unfollowUser($follower_id, $following_id)) {
        header("Location: ../../?home");
    } else {
        header("Location: /wall.php?msg=Erro ao deixar de seguir");
    }
    exit();
}

if (isset($_GET['perfil']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateStatus = updateProfile($_POST, $_FILES['profile_pic']);
    if ($updateStatus) {
        header('Location: ../../?home');
        exit();
    } else {
        echo "Erro ao atualizar o perfil.";
    }
}

if (isset($_GET['meuperfil']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Garante que os dados obrigatórios estão presentes
    $age = $_POST['age'] ?? '';
    $job = $_POST['job'] ?? '';
    $bio = $_POST['bio'] ?? '';

    if (!empty($age) && !empty($job) && !empty($bio)) {
        $updateStatus = updateProfile1($_POST, $_FILES['profile_pic'], $_FILES['fundo_pic']);
        if ($updateStatus) {
            header('Location: ../../?meuperfil');
            exit();
        } else {
            echo "Erro ao atualizar o perfil.";
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios.";
    }
}

if (isset($_POST['post_text']) && isset($_FILES['post_img']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $_FILES['post_img'];

    if ($response['error'] === UPLOAD_ERR_OK) {
        $image_name = time() . basename($response['name']);
        $image_dir = "../img/posts/$image_name"; 

        if (move_uploaded_file($response['tmp_name'], $image_dir)) {
            if (createPost($_POST['post_text'], $image_name, 'default')) {
                header("Location: ../../?new_post_added");
                exit();
            } else {
                echo "Erro ao adicionar o post.";
            }
        } else {
            echo "Erro ao mover o arquivo de imagem.";
        }
    } else {
        $_SESSION['error'] = "Erro no upload da imagem: " . $response['error'];
        header("Location: ../../");
        exit();
    }
}

if (isset($_GET['logout'])) {
    // Destroi a sessão
    $_SESSION = [];
    session_destroy();
    header("Location: ../../?login");
    exit();
}

if (isset($_GET['delete_post']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];

    // Verifica se o post pertence ao usuário logado antes de excluir
    $query = "SELECT user_id FROM posts WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);

    if ($post && $post['user_id'] == $_SESSION['userdata']['id']) {
        if (deletePost($post_id)) {
            header("Location: ../../?home");
            exit();
        } else {
            echo "Erro ao excluir o post.";
        }
    } else {
        echo "Você não tem permissão para excluir este post.";
    }
}
