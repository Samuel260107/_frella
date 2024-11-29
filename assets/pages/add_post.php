<?php
session_start();
require_once '../php/functions.php'; // Caminho para o arquivo functions.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_text']) && isset($_POST['post_type']) && isset($_FILES['post_img'])) {
        $post_text = $_POST['post_text'];
        $post_type = $_POST['post_type'];
        $image = $_FILES['post_img'];

        // Verifica se o upload foi bem-sucedido
        if ($image['error'] === UPLOAD_ERR_OK) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            // Verifica o tipo de arquivo
            if (in_array(strtolower($file_extension), $allowed_extensions)) {
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/img/posts/';
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;

                // Move o arquivo para o diretório de uploads
                if (move_uploaded_file($image['tmp_name'], $upload_path)) {
                    // Função para criar o post
                    if (createPost($post_text, $new_filename, $post_type)) {
                        header("Location: http://localhost/_frella/?home"); // Redireciona para a home após o sucesso
                        exit();
                    } else {
                        echo "Algo deu errado ao adicionar o post.";
                    }
                } else {
                    echo "Falha ao mover o arquivo de imagem.";
                }
            } else {
                echo "Formato de arquivo não permitido. Use JPG, JPEG, PNG ou GIF.";
            }
        } else {
            echo "Erro no upload da imagem: " . $image['error'];
        }
    } else {
        echo "Dados do formulário não foram enviados.";
    }
} else {
    echo "Método de requisição não suportado.";
}
?>
