<?php
global $user;
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';
// $posts = getPost();
$users = getUsers();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';


// Verifica se o ID do perfil foi passado via GET
if (isset($_GET['profile'])) {
    $userId = $_GET['profile'];
    $userData = getUserById($userId); // Função para buscar dados do usuário pelo ID
    $userPosts = getPostsByUserId($userId); // Função para buscar os posts do usuário pelo ID
    $followers = getFollowers($userId); // Função para buscar seguidores do usuário
    $isFollowing = isFollowing($user['id'], $userId); // Verifica se o usuário atual está seguindo este perfil
}
?>
    <!-- Exibe os dados do perfil -->
    <img class="fundo" src="assets/img/profile/fundo.png">
    <div class="foto">
        <img class="ftperfil" src="assets/img/profile/<?= $userData['profile_pic'] ?>" alt="Foto de perfil">
    </div>
    <div class="perfil">
        <div class="perfil1">
            <div class="username">
            <h1><?= $userData['first_name'] . ' ' . $userData['last_name'] ?></h1>
            <p>@<?= $userData['username'] ?></p>
            </div>
            <div class="seguidos">
                <!-- Botão para seguir ou deixar de seguir -->
                <?php if ($user['id'] !== $userId): // Exibe o botão apenas se o perfil não for o do próprio usuário ?>
                <?php if ($isFollowing): ?>
                    <form action="assets/php/action.php?unfollow1" method="POST">
                        <img class="imgdeixar" src="assets/img/profile/deixardeseguir1.png">
                        <button class="botdeixar" type="submit">
                        <img class="imgdeixar" src="assets/img/profile/deixardeseguir1.png">
                        </button>
                    </form>
                <?php else: ?>
                    <form action="assets/php/action.php?follow1" method="POST">
                        <input type="hidden" name="following_id" value="<?= $userId ?>">
                        <button class="botseguir" type="submit">
                            <img class="imgseguir" src="assets/img/profile/seguir1.png">
                        </button>
                    </form>
                <?php endif; ?>
                <?php endif; ?>
                <!-- Link para visualizar seguidores -->
                <p><a class="seguidores" href="followers.php?user_id=<?= $userId ?>"><?= count($followers) ?> Seguidores</a></p>
            </div>
        </div>
        <div class="perfil2">
            <div class="inf">
                <p class="trabalho">Trabalho: <?= $userData['job'] ?></p>
                <p class="idade">Idade: <?= $userData['age'] ?></p>
            </div>
            <div class="sobremim">
                <p>Sobre mim: </p>
                <div class="bio">
                    <?= $userData['bio'] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="portifolio">
        <h2 class="tituloport">Portfólio</h2>
        <!-- Exibe os posts do usuário -->
        <div class="publicacao">
            <?php if (!empty($userPosts)): ?>
                <?php foreach ($userPosts as $post): ?>
                    <div class="post-container">
                        <div class="post-header">
                            <div class="imgport">
                                <!-- Verifica se o post tem imagem -->
                                <?php if (!empty($post['post_img'])): ?>
                                    <img class="post-img" src="assets/img/posts/<?= $post['post_img'] ?>" alt="Imagem do post" width="100">
                                <?php endif; ?>
                                <!-- Exibe o texto do post -->
                            </div>
                            <div class="textport">
                                <p><?= $post['post_text'] ?></p>
                            </div>
                            <div class="textport2">
                                <p><small><?= $post['created_at'] ?></small></p>
                            </div>                            
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum post encontrado.</p>
            <?php endif; ?>
        </div>
        <!-- Editar para que apareça o botão de mais apenas se tiver mais portifolios -->
        <div class="maisport">
            <p>Ver mais</p>
        </div>
    </div>
    <div class="redes">
        <img class="redes1" src="assets/img/profile/linkedin.png" alt="linkedin">
        <img class="redes1" src="assets/img/profile/whatsapp.png" alt="whatsapp">
        <img class="redes1" src="assets/img/profile/instagram.png" alt="instagram">
    </div>
<style>
    body{
        background-color:#FFFCEA;
        margin: 0;
        padding: 0;
    }
    .fundo{
        position: absolute;
        top: 0;
        width: 100%;
        height: 190px;
        z-index: -15;
    }
    .foto{   
        position: relative;
        display: flex;
        width: 100%;
        height: auto;
        z-index: 10;
        bottom: 55px;
        justify-content: center;
    }
    .ftperfil{
        width: 240px;
        height: 240px;
        border-radius: 100%;
        
    }
    .perfil{
        position: relative;
        width: auto;
        height: auto ;
        border: none;
        margin-left: 11%;
        margin-right: 11%;
        bottom: 150px;
       
    }
    .perfil1{
        background-color: #E03C31;
        height: 100px;
        width: auto;
        border: none;
        display: flex;
        align-items: flex-end;
        padding: 5px 15px 0;
        color: white;
        justify-content: space-between;
        align-content: flex-end;
        flex-direction: row;
        flex-wrap: nowrap;
    }
    .seguidos{
        z-index: 11;
    }
    .botdeixar{
        background-color: transparent; /* Remove a cor de fundo */
        border: none;                  /* Remove a borda padrão */
        padding: -1;                    /* Remove o espaçamento interno */
        cursor: pointer;  
    }
    .imgdeixar{
        width: 55px;
        height: 55px;
        border: none;
        border: none;
        color: transparent;
        background-color: #E03C31;
        text-decoration: none;
        height: auto;   
        display: block;
    }
    .botseguir{
        background-color: transparent; /* Remove a cor de fundo */
        border: none;                  /* Remove a borda padrão */
        padding: 0;                    /* Remove o espaçamento interno */
        cursor: pointer;  
       
    }
    .imgseguir{
        width: 45px;
        height: 45px;
        border: none;
        border-style: none;
        background-color: #E03C31;
        height: auto;   
        display: block;
    }
    .seguidores{
        color: white;
        text-decoration: none;
    }
    .perfil2{
        position: relative;
        height: 170px;
        background-color: #d2d2d2;
        display: flex;
        /* flex-wrap: nowrap; */
        align-content: center;
        justify-content: space-between;
        align-items: center;
        /* flex-direction: row; */
    
    }
    .inf{
        position: relative;
        bottom: 15%;
        padding: 5% 5%;
    }
    .idade{
        position: relative;
        top: 50px;
    }
    .bio{
        width: 300px;
        height: 100px;
        background-color:#F3F3F3;
        margin-right: 35px;

    }
    .portifolio{
        position: relative;
        width: auto;
        height: 350px ;
        border: none;
        bottom: 160px;
        background-color: #d2d2d2;
        margin-left: 11%;
        margin-right: 11%;
    }
    .tituloport{
        background-color: #E03C31;
        text-align: center;
        color: white;
    }
    .publicacao{
        display: flex;
    }
    .post-container{
        padding: 0 15px 0 15px; 
    }
    .textport{
        position: absolute;
        max-height: 80px;
        max-width: 105px;
        font-size: 10px;
        bottom: 0;
        word-wrap: break-word; 
        height: 40%;
    }
    .textport2{
        position: absolute;
        bottom: 0;
        font-size: 10px;
    }
    .maisport{
        position: relative;
        top: 60px;
        background-color: #E03C31;
        text-align: center;
        color: white;
    }
    .redes{
        text-align: center;
        justify-content: center;
        
    }
    .redes1{
        padding: 0 5px 0;
        width: 33pxx;
        height: 33px;
        position: relative;
        bottom: 7px;
    }
</style>