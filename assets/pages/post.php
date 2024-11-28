<?php 
global $user; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';

// Mude o parâmetro para 'post' ou deixe 'type' como antes, mas use consistentemente.
$post_type = isset($_GET['post']) && $_GET['post'] !== 'all' ? $_GET['post'] : null;

// Obtém os posts com base no tipo selecionado
$posts = getPost2($post_type);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<a href="?home"><img src="/_frella/assets/img/navbar/logo.png" width="70px" alt=""></a>
<h1>Portfólio</h1>
<div class="filter-container">
    <a href="?post=design">
        <button class="<?= $post_type == 'design' ? 'active' : '' ?>">Design</button>
    </a>

    <a href="?post=site">
        <button class="<?= $post_type == 'site' ? 'active' : '' ?>">Site</button>
    </a>

    <a href="?post=all">
        <button class="<?= !$post_type ? 'active' : '' ?>">Todos</button>
    </a>
</div>

<!-- Lista de posts -->
<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="post-container" height="100px">
            <div class="post-header">
            <?php if (!empty($post['post_img'])): ?>
                <!-- Agora a imagem tem a classe 'open-modal' -->
                <img class="post-img open-modal" 
                     src="assets/img/posts/<?= $post['post_img'] ?>" 
                     alt="Imagem do post" 
                     data-img="assets/img/posts/<?= $post['post_img'] ?>" 
                     data-type="<?= $post['post_type'] ?>">
            <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhum post encontrado.</p>
<?php endif; ?>

<!-- Modal -->
<div id="postModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalPostType"></h2>
        <img id="modalPostImg" src="" alt="Imagem do post em destaque">
    </div>
</div>

<!-- JavaScript para o modal -->
<script>
    // Aguarde o carregamento do DOM para garantir que o código JavaScript funcione corretamente
    document.addEventListener('DOMContentLoaded', function() {
        // Função para abrir o modal
        document.querySelectorAll('.open-modal').forEach(function(element) {
            element.addEventListener('click', function() {
                const modal = document.getElementById('postModal');
                const modalImg = document.getElementById('modalPostImg');
                const modalType = document.getElementById('modalPostType');
                
                modal.style.display = "block";
                modalImg.src = this.getAttribute('data-img');
                modalType.innerText = this.getAttribute('data-type');
            });
        });

        // Função para fechar o modal
        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('postModal').style.display = "none";
        });

        // Fechar o modal se clicar fora dele
        window.onclick = function(event) {
            const modal = document.getElementById('postModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    });
</script>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal img {
        max-width: 100%;
        height: auto;
    }
    .post-img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Isso mantém a proporção da imagem sem distorcer, mas preenche o contêiner */
    object-position: center; /* Centraliza a imagem se ela for cortada */
    transition: transform 0.3s ease;
    cursor: pointer;
}

.post-img:hover {
    transform: scale(1.05); /* Zoom ao passar o mouse */
}
   
.filter-container {
    display: flex;
    justify-content: center; /* Centraliza os botões horizontalmente */
    align-items: center;     /* Alinha verticalmente (caso precise de ajuste vertical) */
    gap: 20px;               /* Espaçamento entre os botões */
    margin-bottom: 30px;     /* Espaçamento abaixo do conjunto de botões */
}

/* Ajuste do estilo dos botões */
button {
    background-color: #e0e0e0;
    border: none;
    padding: 10px 20px;
    margin: 0; /* Remover o margin padrão dos botões */
    cursor: pointer;
    border-radius: 20px;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease, color 0.3s ease;
}

button.active {
    background-color: #4caf50; /* Verde para indicar o botão ativo */
    color: white;
}

button:hover {
    background-color: #2e7d32;
    color: white;
}

/* Ajuste dos títulos */
h1 {
    text-align: center;
    font-size: 32px;
    color: #fff;
    margin-bottom: 30px;
    background-color: #2e7d32;
    padding: 20px;
    border-radius: 10px;
}


/* Container dos posts */
.post-container {
    display: inline-block;
    width: 45%;
    margin: 30px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.post-header {
    position: relative;
    height: 250px;
}

.post-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.post-img:hover {
    transform: scale(1.05); /* Zoom ao passar o mouse */
}

/* Modal */
.modal-content {
    background-color: #fff;
    border-radius: 15px;
    padding: 20px;
    max-width: 600px;
    margin: 5% auto;
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Estilo do modal */
.modal img {
    border-radius: 10px;
    max-width: 100%;
}

.close {
    font-size: 30px;
    color: #333;
}

.close:hover {
    color: #d9534f;
    cursor: pointer;
}

/* Ajuste do layout geral */
body {
    background-color: #388e3c;
    font-family: Arial, sans-serif;
}
    </style>
