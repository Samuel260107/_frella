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
.user-name {
    font-size: 1.5rem; /* Aumenta o tamanho do nome */
    font-weight: bold; /* Deixa o texto em negrito */
}

.user-username {
    font-size: 1.2rem; /* Define o tamanho do username */
    color: #ffffff; /* Cor do texto */
    margin-top: 5px; /* Espaço entre o nome e o username */
    text-align: center; /* Centraliza o username */
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
                <img src="assets/img/fundo/<?=$user['fundo_pic']?>" class="fundo" alt="...">
                <div class="mb-3">
                    <label for="formFile" class="form-label">foto do fundo</label>
                    <input class="form-control" type="file" name="fundo_pic" id="formFile">
                </div>
            </div>
            <div class="foto">
    <img src="assets/img/profile/<?=$user['profile_pic']?>" class="profile-pic" style="height:150px;width:150px" alt="Imagem do perfil">
    <a href="#" class="ms-2 edit-icon" data-field="profile_pic"><i class="fas fa-pencil-alt"></i></a>
</div>
<div class="perfil">
    <!-- Seção Vermelha -->
    <div class="perfil1">
        <!-- Nome completo -->
        <div class="user-username">
            <label for="username">@<?=$user['username']?></label>
            <a href="#" class="ms-2 edit-icon" data-field="name"><i class="fas fa-pencil-alt"></i></a>
        </div>
        <!-- Nome de usuário -->
        <div class="user-name">
            <input type="text" class="form-control" id="name" name="name" 
            value="<?=$user['first_name']?> <?=$user['last_name']?>">
        </div>
    </div>
    <!-- Seção Cinza -->
    <div class="perfil2">
    <!-- Contêiner para Trabalho e Idade -->
    <div class="job-age-container">
        <!-- Trabalho -->
        <div class="info-container">
            <label for="job" class="info-label">Trabalho</label>
            <input type="text" class="form-control info-input" id="job" name="job" value="<?=$user['job']?>">
            <a href="#" class="ms-2 edit-icon" data-field="job"><i class="fas fa-pencil-alt"></i></a>
        </div>

        <!-- Idade (agora abaixo do trabalho) -->
        <div class="info-container">
            <label for="age" class="info-label">Idade</label>
            <input type="text" class="form-control info-input" id="age" name="age" value="<?=$user['age']?>">
            <a href="#" class="ms-2 edit-icon" data-field="age"><i class="fas fa-pencil-alt"></i></a>
        </div>
    </div>

    <!-- Sobre mim -->
    <div class="info-container larger-info">
        <label for="bio" class="info-label">Sobre mim</label>
        <textarea class="form-control info-textarea" id="bio" name="bio"><?=$user['bio']?></textarea>
        <a href="#" class="ms-2 edit-icon" data-field="bio"><i class="fas fa-pencil-alt"></i></a>
    </div>
</div>

</div>
    </div>
    <h1 class="portfolio-title">Portifolio</h1>
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
     .fundo {
    position: absolute;
    top: 0;
    width: 100%;
    height: 190px;
    z-index: -1; /* Ajuste o z-index para garantir que não cubra os outros elementos */
}

#formFile {
    position: relative;
    z-index: 100; /* Garante que o campo de arquivo tenha prioridade sobre outros elementos */
}
    .post-img{
        width: 100px;
    }

    
    .profile-pic{
        width: 400px;
        height: 200px;
        border-radius: 50%;
        border: 3px solid #D9D9D9;
        object-fit: cover;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .perfil2 {
    position: relative;
    height: auto;
    background-color: #d2d2d2;
    display: flex;
    flex-wrap: wrap; /* Permite que os campos se ajustem em várias linhas, se necessário */
    gap: 20px; /* Espaço entre os campos */
    padding: 10px 20px;
    border-radius: 5px;
}

/* Contêiner para cada campo */
.info-container {
    display: flex;
    flex-direction: column; /* Empilha label e input */
    align-items: center; /* Centraliza os campos horizontalmente */
    margin: 0 10px;
    flex: 1;
    min-width: 150px; /* Largura mínima */
}

/* Ajuste no contêiner "trabalho e idade" */
.job-age-container {
    display: flex;
    flex-direction: column; /* Coloca os campos Trabalho e Idade em coluna */
    flex: 1; /* Garante que o contêiner ocupe 50% do espaço */
}

/* Contêiner maior para o campo "Sobre mim" */
.larger-info {
    flex: 2; /* Deixa o "Sobre mim" ocupar mais espaço */
    min-width: 300px; /* Largura mínima maior para o campo "Sobre mim" */
}

/* Estilo dos rótulos (labels) */
.info-label {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
    text-align: center;
}

/* Estilo dos inputs */
.info-input {
    text-align: center;
    font-size: 1rem;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    max-width: 150px;
}

/* Estilo do textarea para "Sobre mim" */
.info-textarea {
    text-align: left;
    font-size: 1rem;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    height: 100px; /* Altura maior para textos longos */
    resize: none;
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
    .perfil{
        position: relative;
        width: auto;
        height: auto ;
        border: none;
        margin-left: 11%;
        margin-right: 11%;
        margin-top: 100px;
        bottom: 150px;
       
    }
    .perfil1 {
    background-color: #E03C31;
    height: auto; /* Permite que o container ajuste a altura conforme o conteúdo */
    width: auto;
    border: none;
    display: flex;
    flex-direction: column; /* Organiza o conteúdo em colunas */
    align-items: center; /* Centraliza os elementos no eixo principal */
    justify-content: center; /* Centraliza no eixo cruzado */
    padding: 10px; /* Adiciona um espaçamento interno */
    color: white;
}
.perfil2 {
    position: relative;
    height: auto; /* Ajusta automaticamente para o conteúdo */
    background-color: #d2d2d2;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px; /* Espaçamento interno */
    flex-wrap: wrap; /* Permite que os campos sejam exibidos em múltiplas linhas, se necessário */
    border-radius: 5px;
}

/* Contêiner para cada campo */
.info-container {
    display: flex;
    flex-direction: column; /* Empilha label e input */
    align-items: center; /* Centraliza o conteúdo horizontalmente */
    margin: 0 10px; /* Espaçamento horizontal entre os campos */
}

/* Estilo dos rótulos (labels) */
.info-label {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px; /* Espaço entre o label e o input */
    text-align: center;
}

/* Estilo dos inputs */
.info-input {
    text-align: center;
    font-size: 1rem;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    max-width: 150px; /* Define um tamanho máximo para os campos */
}
.portfolio-title {
    position: relative;
    background-color: #E03C31; /* Cor de fundo vermelha */
    color: white; /* Cor da fonte branca */
    padding: 5px; /* Espaçamento interno */
    text-align: center; /* Centraliza o texto */
    margin-top: -100PX;
    border-radius: 5px; /* Bordas arredondadas */
    width: calc(79.75% - 40px); /* Largura do título igual à largura do conteúdo */
    margin-left: 11.25%; /* Margem à esquerda para alinhar com o conteúdo */
    margin-right: 20px; /* Margem à direita para alinhar com o conteúdo */
}

.container.col-md-9 {
    margin-top: 100px; /* Ajusta o espaçamento para que o título fique abaixo do quadrado cinza */
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
