<?php global $user; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';
$posts = getPost1();
?>
<style>
.post-container {
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
}

.post-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.post-img {
    width: 200px; /* Deixa a imagem ocupar toda a largura do post */
    max-width: 600px; /* Define um tamanho máximo para não extrapolar */
    height: auto; /* Mantém a proporção da imagem */
    margin-bottom: 15px;
}

.post-container p {
    font-size: 1.2rem; /* Aumenta o tamanho do texto do post */
    line-height: 1.6;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<a class="navbar-brand" href="?home">
    <img src="#" alt="" height="28">
</a>

<div class="container col-md-9 col-sm-12 rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
        <form method="post" action="/_frella/assets/php/action.php?meuperfil" enctype="multipart/form-data" id="profileForm">
            <div class="d-flex justify-content-center">
                <img src="assets/img/fundo/<?=$user['fundo_pic']?>" class="img-thumbnail my-3" style="height:150px;width:150px" alt="...">
                <div class="mb-3">
                    <label for="formFile" class="form-label">foto do fundo</label>
                    <input class="form-control" type="file" name="fundo_pic" id="formFile">
                </div>
            </div>
            <div class="form-floating mt-1 col-md-6 col-sm-12">
                <img src="assets/img/profile/<?=$user['profile_pic']?>" class="img-thumbnail my-3" style="height:150px;width:150px" alt="Imagem do perfil">
            </div>

            <div class="d-flex">
                <div class="form-floating mt-1 col-6">
                    <input type="text" class="form-control" id="name" name="name" value="<?=$user['first_name']?> <?=$user['last_name']?>">
                    <a href="#" class="ms-2 edit-icon" data-field="name"><i class="fas fa-pencil-alt"></i></a>
                </div>
            </div>
            <div class="form-floating mt-1 col-6">
                <label for="username" value="@<?=$user['username']?>">@<?=$user['username']?></label>
            </div>
            <div class="form-floating mt-1 col-6">
                <label for="age">Idade</label>
                <input type="text" class="form-control" id="age" name="age" value="<?=$user['age']?>">
                <a href="#" class="ms-2 edit-icon" data-field="age"><i class="fas fa-pencil-alt"></i></a>
            </div>
            <div class="form-floating mt-1 col-6">
                <label for="job">Trabalho</label>
                <input type="text" class="form-control" id="job" name="job" value="<?=$user['job']?>">
                <a href="#" class="ms-2 edit-icon" data-field="job"><i class="fas fa-pencil-alt"></i></a>
            </div>
            <div class="form-floating mt-1 col-6">
                <label for="bio">Sobre mim</label>
                <input type="text" class="form-control" id="bio" name="bio" value="<?=$user['bio']?>">
                <a href="#" class="ms-2 edit-icon" data-field="bio"><i class="fas fa-pencil-alt"></i></a>
            </div>
        </form>
        <h1>Portifolio</h1>
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-container" height="100px">
                    <div class="post-header">
                    <?php if (!empty($post['post_img'])): ?>
                        <img class="post-img" src="assets/img/posts/<?= $post['post_img'] ?>" alt="Imagem do post">

                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum post encontrado.</p>
        <?php endif; ?>
    </div>
    <a href="?post"><button>Mostrar</button></a>
</div>
<style>
    .post-img{
        width: 100px;
    }
</style>
<script>
// Função para permitir a edição dos campos
document.querySelectorAll('.edit-icon').forEach(icon => {
    icon.addEventListener('click', function(event) {
        event.preventDefault();
        let field = this.getAttribute('data-field');
        let input = document.getElementById(field);
        input.focus(); // Foco no campo
    });
});

// Submeter o formulário ao pressionar Enter em qualquer campo de input
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        let activeElement = document.activeElement;
        // Verifica se o elemento ativo é um campo de input e não é um botão
        if (activeElement.tagName === 'INPUT' && activeElement.type !== 'submit') {
            event.preventDefault(); // Impede a ação padrão do Enter
            document.getElementById('profileForm').submit(); // Submete o formulário
        }
    }
});
</script>
