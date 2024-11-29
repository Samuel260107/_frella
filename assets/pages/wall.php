<?php 
global $user; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';
$posts = getPost();
$users = getUsers();
?>

<div class="content-wrapper">
    <div class="posts">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-container">
                    <div class="post-header">
                        <img src="assets/img/profile/<?= $post['profile_pic'] ?>" alt="Foto de perfil" width="50">
                        <div>
                            <strong><?= $post['first_name'] . ' ' . $post['last_name'] ?></strong>
                            <p>@<?= $post['username'] ?></p>
                        </div>
                    </div>
                    <?php if (!empty($post['post_img'])): ?>
                        <img class="post-img open-modal" src="assets/img/posts/<?= $post['post_img'] ?>" width="500px" alt="Imagem do post" 
                             data-img="assets/img/posts/<?= $post['post_img'] ?>" 
                             data-type="Post de <?= $post['first_name'] ?>" 
                             data-project="<?= $post['post_text'] ?>" 
                             data-profile-pic="assets/img/profile/<?= $post['profile_pic'] ?>"
                             data-profile-link="?profile=<?= $post['user_id'] ?>"> <!-- Adicionando link do perfil -->
                        <p><?= $post['post_text'] ?></p>
                    <?php endif; ?>
                    <p><small>Postado em: <?= $post['created_at'] ?></small></p>

                    <!-- Bloco para interações: curtir e contagem de curtidas -->
                    <div class="interactions">
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
                </div>
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
                <img src="assets/img/profile/<?= $user['profile_pic'] ?>" alt="Foto de perfil" width="70" class="suafoto">
                <p class="nj1">
                <p class="nj2">
                <?= $user['first_name'] ?> <?= $user['last_name'] ?>
                </p>
                <p class="nj3">
                @<?= $user['username'] ?>
                </p>
        </p>
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
                                <strong><?= $profile_user['first_name'] . ' ' . $profile_user['last_name'] ?></strong>
                                <p>@<?= $profile_user['username'] ?></p>
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
    .bp{
        display: flex;
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
        margin-left: 10px
    }
    .nj2{
        color: white;
        font-family: Inter;
    font-size: 20px;
    font-weight: 600;
    line-height: 36.31px;
    text-align: left;
    text-underline-position: from-font;
    text-decoration-skip-ink: none;

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
    }
    .profiles {
        flex: 1.3;
        padding: 30px;
        background-color: rgba(217, 217, 217, 0.5); /* Ajuste da opacidade para 50% */
        height: 50%;
        border: #fff solid 4px;
        border-radius: 30px 0px 30px 0px;
    }
    .post-container, .profile-container {
        margin-bottom: 20px;
    }
    .profile-container {
        display: flex;
        align-items: center;
    }
    .profile-container img {
        border-radius: 50%;
        margin-right: 10px;
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