<?php 
global $user; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';
$posts = getPost();
$users = getUsers();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
<div class="content-wrapper">
    <div class="posts">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-container">
                <div class="post-image-wrapper">
    <div class="post-overlay">
        <div class="post-details">
        <p><?= $post['post_text'] ?></p>
            </div>
        <div class="post11">
            <div class="k">
            <strong><?= $post['first_name'] . ' ' . $post['last_name'] ?></strong>
            <p><?= $post['post_type'] ?></p>
            </div>
            <div class="kk">
            <img width="50px" height="50px" src="assets/img/profile/<?= $post['profile_pic'] ?>"></p>
            </div>
        </div>
    </div>
    <?php if (!empty($post['post_img'])): ?>
        <img class="post-img open-modal" src="assets/img/posts/<?= $post['post_img'] ?>" width="500px" alt="Imagem do post" 
             data-img="assets/img/posts/<?= $post['post_img'] ?>" 
             data-type="Post de <?= $post['first_name'] ?>" 
             data-project="<?= $post['post_text'] ?>" 
             data-profile-pic="assets/img/profile/<?= $post['profile_pic'] ?>"
             data-profile-link="?profile=<?= $post['user_id'] ?>">
    <?php endif; ?>
</div>

                    <!-- Bloco para interações: curtir e contagem de curtidas -->
                    <!-- <div class="interactions">
                        <form action="assets/php/action.php?<?= isPostLiked($post['id']) ? 'unlike' : 'like' ?>" method="POST">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <button type="submit" class="like-button"><?= isPostLiked($post['id']) ? 'Descurtir' : 'Curtir' ?></button>
                        </form>
                        <span><?= getLikesCount($post['id']) ?> curtidas</span>
                    </div>

                    <?php if ($post['user_id'] == $_SESSION['userdata']['id']): ?>
                        <form action="assets/php/action.php?delete_post" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este post?');">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <button type="submit" class="delete-button">Excluir Post</button>
                        </form>
                    <?php endif; ?>
                </div> -->
                <br>
                <br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum post encontrado.</p>
        <?php endif; ?>
    </div>
    <div id="postModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalPostImg" src="" alt="Imagem do post">
            <h2 id="modalPostType"></h2>
            <p id="projectName"></p>
            <img id="modalProfilePic" width="50px" alt="Foto de perfil">
            <a id="modalProfileLink" href="#">Ver perfil</a>

        </div>
    </div>

    <div class="profiles">
        <a href="?meuperfill">
            <div class="nj">
                <img src="assets/img/profile/<?= $user['profile_pic'] ?>" alt="Foto de perfil" width="70" height="70" class="suafoto">
                <div class="nj1">
                <div class="nj2">
                <?= $user['first_name'] ?> <?= $user['last_name'] ?>
                </div>
                <br>
                <div class="nj3">
                @<?= $user['username'] ?>
                </div>
                </div>
            </div>
        </a>

        <?php if (!empty($users)): ?>
            <?php foreach ($users as $profile_user): ?>
                <?php if ($profile_user['id'] !== $user['id']): ?>
                    <a href="?profile=<?= $profile_user['id'] ?>">
                        <div class="profile-container">
                            <img src="assets/img/profile/<?= $profile_user['profile_pic'] ?>" alt="Foto de perfil" width="50" height="50">
                            <div class="bp">
                                <div class="bp1">
                                    <div class="bp1n">
                                <strong><?= $profile_user['first_name'] . ' ' . $profile_user['last_name'] ?></strong>
                                    </div>
                                <div class="bp1e">
                                <p>@<?= $profile_user['username'] ?></p>
                                </div>
                </div>

                                <?php if (isFollowing($user['id'], $profile_user['id'])): ?>
                                    <form action="assets/php/action.php?unfollow" method="POST">
                                        <input type="hidden" name="following_id" value="<?= $profile_user['id'] ?>">
                                        <button class="btns" type="submit"><img class="imgseguir" src="assets/img/profile/seguir2.png"></button>
                                    </form>
                                <?php else: ?>
                                    <form action="assets/php/action.php?follow" method="POST">
                                        <input type="hidden" name="following_id" value="<?= $profile_user['id'] ?>">
                                        <button class="btnd" type="submit"><img class="imgseguir" src="assets/img/profile/deixardeseguir2.png"></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum perfil encontrado.</p>
        <?php endif; ?>
    </div>
</div>
<!-- JavaScript para o modal -->
<script>
    // Função para abrir o modal
    document.querySelectorAll('.open-modal').forEach(function(element) {
        element.addEventListener('click', function() {
            const modal = document.getElementById('postModal');
            const modalImg = document.getElementById('modalPostImg');
            const modalType = document.getElementById('modalPostType');
            const projectName = document.getElementById('projectName');
            const modalProfilePic = document.getElementById('modalProfilePic');
            const modalProfileLink = document.getElementById('modalProfileLink');
            
            modal.style.display = "block";
            modalImg.src = this.getAttribute('data-img');
            modalType.innerText = this.getAttribute('data-type');
            projectName.innerText = this.getAttribute('data-project') || 'Projeto sem nome'; // Caso o nome do projeto não esteja definido
            modalProfilePic.src = this.getAttribute('data-profile-pic');
            modalProfileLink.href = this.getAttribute('data-profile-link'); // Definindo o link do perfil
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
</script>

<style>
    *{
font-family: "Inter", sans-serif;
font-optical-sizing: auto;
font-weight: <weight>;
font-style: normal;
}
.post-image-wrapper {
    position: relative; /* Define a posição para que os elementos internos possam ser posicionados em relação a ela */
    width: 800px;
    height: 351px;
    margin-left: 40PX;
    border-radius: 35px 0px 35px 0px ;
    overflow: hidden; /* Oculta qualquer conteúdo que ultrapasse os limites */
}

.post-overlay {
    border-radius: 30px 0 30px 0; 
    position: absolute;
    border: 5px solid #fff;
    top: 0;
    left: 0;
    width: 99%;
    height: 97%;
    background: linear-gradient(
        to bottom, 
        rgba(217, 217, 217, 0.3), /* Parte superior mais clara */
        rgba(0, 0, 0, 0.4)  /* Parte inferior mais escura */
    ); /* Fundo semi-transparente */
    display: flex;
    justify-content: center;
    align-items: center;
    color: white; /* Texto branco para contraste */
    opacity: 1; /* Exibe a camada o tempo todo */
}

.post-image-wrapper:hover .post-overlay {
    opacity: 1; /* Exibe a camada ao passar o mouse */
}
.post11{
    display: flex;
    position: absolute;
    bottom: 20px; /* Alinha o elemento à parte inferior */
    right: 30px; /* Alinha o elemento à parte direita */
    text-align: left; /* Mantém o alinhamento do texto */
    text-underline-position: from-font;
    text-decoration-skip-ink: none;
}
.post-img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* A imagem será cortada, mas preencherá todo o espaço do container */
}
.post11 img{
    border-radius: 50%;
}
.k strong{
    font-size: 20px;
    margin-right: 10px;
    
}
.k p{
    margin-right: 10px;
    margin-top: -5px;
    font-family: Inter;
font-size: 10px;
font-weight: 400;
line-height: 20.57px;
text-align: left;
text-underline-position: from-font;
text-decoration-skip-ink: none;

}
.post-details {
    position: absolute; /* Torna o elemento posicionado em relação ao pai */
    bottom: 10px; /* Define a posição a 10px da parte inferior */
    left: 30px; /* Define a posição a 10px da borda esquerda */
    background-color: rgba(0, 0, 0, 0.0); /* Fundo escuro semi-transparente para contraste */
    padding: 5px 10px; /* Adiciona um pequeno preenchimento ao redor do texto */
    border-radius: 5px; /* Bordas arredondadas */
    color: white; /* Garante que o texto fique visível */
    font-size: 30px; /* Ajuste o tamanho do texto conforme necessário */
    font-family: Inter;
    font-size: 33px;
    font-weight: 400;
    line-height: 47.2px;
    text-align: left;
    text-underline-position: from-font;
    text-decoration-skip-ink: none;

}
    .bp{
        display: flex;
    }
    .bp1n{
        margin-top: 20px;
        color: white;
    }
    .bp1e{
        color: rgba(255, 255, 255, 1);
        font-family: Inter;
        margin-top: -10px;
font-weight: 200;

    }
    .nj3{
        color: rgba(255, 255, 255, 1);
        font-family: Inter;
font-weight: 200;
    }
    .btns{
        border: none;
        width: 50px;
        background-color: rgba(217, 217, 217, 0);
    }
    .btnd{
        border: none;
        width: 50px;
        background-color: rgba(217, 217, 217, 0);
    }
    .btnd img{
        width: 50px;
    }
    .btns img{
      width: 50px;
    }
    .nj{
        display: flex;
        align-items: center;
        padding: 10px;
        
    }
    .nj1{
        margin-left: 40px
    }
    .nj2{
        color: white;
        font-family: Inter;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: -13px;
    }
    .bp1{
        margin-right: 20px;
    }
    html{
        background-color: #FFA609;
    }
    .suafoto{
        border-radius: 50%;
    }
    .content-wrapper {
        display: flex;
        justify-content: space-between;
    }
    .posts {
    flex: 3;
    margin-right: 20px;
    width: 70%;  /* Ajuste a largura aqui */
}
    .profiles {
    position: fixed; /* Fixa a seção no canto direito */
    top: 100px; /* Define um espaço de 20px do topo */
    right: 20px; /* Muda para a direita da tela */
    width: 300px; /* Define a largura da seção */
    padding: 30px;
    background-color: rgba(217, 217, 217, 0.5); /* Ajuste da opacidade para 50% */
    height: 73%; /* A altura é ajustada para preencher quase toda a tela */
    border: #fff solid 4px;
    border-radius: 30px 0px 30px 0px;
    z-index: 100; /* Garante que a seção fique acima de outros conteúdos */
}

.content-wrapper {
    margin-top: 100px;
    display: flex;
    justify-content: flex-start; /* Ajusta o layout para começar à esquerda */
}
    .post-container, .profile-container {
        margin-bottom: 20px;
    }
    .profile-container {
        display: flex;
        align-items: center;
        color: white;
        margin-top: 30px;
    }
    .profile-container img {
        border-radius: 50%;
        margin-right: 30px;
        margin-top: 15px;
    }
    /* CSS para o modal */
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
    /* Estilo para a seção de interações */
    .interactions {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }
    .like-button {
        cursor: pointer;
        margin-right: 20px;
        color: red;
    }
    .project-name {
        font-weight: bold;
        margin-left: auto;
    }
</style>