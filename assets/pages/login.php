
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login _frella</title>
    <body>
    
    
    <!-- Contêiner principal -->
    <div class="main-container">
        <!-- Div Branca -->
        <div class="form-box">
            <div class="t1">
                <h1>Entrar</h1>
            </div>
            <form method="POST" action="assets/php/action.php?login">
                <div class="login">
                    <input type="text" class="input" name="username_email" placeholder="username_email" required>
                    <input type="password" class="input" name="password" placeholder="Senha" required>
                </div>
                <div class="botao">
                    <button type="submit">Entrar</button>
                </div>
            </form>
        </div>

        <!-- Div Marrom -->
        <div class="brown-box">
        <div class="logo">
        <img src="/_frella/assets/img/login/logo.png" alt="">
    </div>
            <H2>Bem-vindo ao FREELA!</H2>
            <p>Não tem uma conta ainda?,<br> Faça seu cadastro!</p>
            <div class="botao1">
                    <a href="?signup">Cadastrar-se</button>
                </div>
        </div>
    </div>
</body>
<style>
body {
    background-image: url("/_frella/assets/img/login/fundologin.png");
    background-size: cover; /* Ajusta a imagem para cobrir a tela */
    background-position: center; /* Centraliza a imagem */
    margin: 0; /* Remove margens padrão */
    height: 100vh; /* Define a altura como a altura total da janela */
    display: flex; /* Ativa o Flexbox no body */
    justify-content: center; /* Centraliza o conteúdo horizontalmente */
    align-items: center; /* Centraliza o conteúdo verticalmente */
}

.main-container {
    display: flex; /* Faz as divs ficarem lado a lado */
    justify-content: center; /* Alinha horizontalmente as divs internas */
    align-items: center; /* Alinha verticalmente as divs internas */
    gap: 0; /* Espaçamento entre as divs */
}

.form-box {
    position: relative;
    max-width: 405px;
    height: 425px;
    background: white;
    border-radius: 20px 0 0px 0;
    color: #412B04;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.brown-box {
    max-width: 300px;
    height: 405px;
    background: #412B04;
    border-radius: 0 0px 20px 0px;
    color: white;
    text-align: center;
    padding: 20px 20px 0; /* Remove padding na parte inferior */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Começa o conteúdo no topo */
}

.logo {
    display: flex;
    justify-content: center;
    margin-top: -10px; /* Espaço entre a logo e o restante do conteúdo */
}

.logo img {
    width: 120px; /* Ajuste o tamanho da logo se necessário */
    height: auto; /* Mantém proporção */
}
.t1{
    font-size: 20px;
    position: relative;
    top: 15px;
    margin-bottom: 55px;
}
form{
    margin: 10px 25px;
}

.login{
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    align-items: center;
}

.input{
    margin: 7px;
    height: 35px;
    width: 90%;
    border: solid #B1B1B1;
    font-size: 20px;
    padding: 8px 15px;
    background-color: #fff;
    border-radius: 8px;
}
button{
    margin: 20px;
    background-color: #412B04;
    color: #fff;
    border: 0;
    width: 80%;
    height: 55px;
    border-radius: 5px;
    font-size: 20px;
    cursor: pointer;
    text-decoration: none;
}

.botao1 {
    display: flex; /* Ativa o flexbox */
    justify-content: center; /* Centraliza horizontalmente */
    align-items: center; /* Centraliza verticalmente */
    margin: 20px auto; /* Centraliza horizontalmente o botão */
    background-color: #fff;
    width: 80%;
    height: 55px;
    border-radius: 5px;
    font-size: 20px;
    cursor: pointer;
}

.botao1 a {
    display: block; /* Garante que o link ocupe toda a área disponível */
    width: 100%; /* Preenche o espaço do botão */
    height: 100%; /* Preenche o espaço do botão */
    text-align: center; /* Centraliza horizontalmente o texto */
    line-height: 55px; /* Centraliza verticalmente o texto */
    color: #412B04;
    text-decoration: none;
    font-weight: bold; /* Para maior destaque */
}

.botao1 a:hover {
    background-color: #f2f2f2; /* Adiciona um efeito hover */
    color: #684321;
    border-radius: 5px;
}
.barra{
    background-color: #B1B1B1;
    height: 1.5px;
    width: auto;
    margin: 8px 20px;

}
a{
    font-size: 16px;
    color:#412B04;
    text-decoration: none;
}
.image-container {
        display: flex;
        justify-content: center; 
        gap: 20px;
        margin-top: 15px;
}

.image-container img {
    width:35px; 
    height: 35px;
}
</style>