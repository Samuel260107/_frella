
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login _frella</title>
<body>
    <div class="logo">
        <img src="/_frella/assets/img/login/logo.png" alt="">
    </div>
    <div class="form-box">
        <div class="t1">
            <h1>Entrar</h1>
        </div>
        <form method="POST" action="assets/php/action.php?login">
            <div class="login">
                <input type="text" class="input" name="username_email" placeholder="username_email" required>
                <input type="password" class="input" name="password" placeholder="Senha" required>
            </div>
            <a href="?signup">Não tem uma conta? Cadastrar</a>
            <div class="botao">
                <button type="submit">Entrar</button>
            </div>
        </form>
        <div class="barra"></div>
        <a>Entrar com:</a>
        <div class="image-container">
            <?php
                $imagens = [
                    '/frella/assets/img/login/img1.png',
                    '/frella/assets/img/login/img2.png',
                    '/frella/assets/img/login/img3.png'
                ];

                foreach ($imagens as $imagem) {
                    echo "<img src='$imagem'>";
                }
            ?>
        </div>
    </div>
</body>    
<style>
body{
    background-image: url("/_frella/assets/img/login/fundologin.png");
   }
.logo{
    display: flex;
    justify-content: center;
    align-items: center; 
    position: relative;
    top: 40px;
}
.form-box {
    position: relative;
    max-width: 405px;
    height: 425px;
    background:white;
    border-radius:20px 0 20px 0;
    color: #412B04;
    margin: auto;
    bottom: 30px;
    text-align: center;
}
.t1{
    font-size: 20px;
    position: relative;
    top: 15px;
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
    margin: 10px;
    background-color: #412B04;
    color: #fff;
    border: 0;
    width: 80%;
    height: 55px;
    border-radius: 10px;
    font-size: 20px;
    cursor: pointer;
    text-decoration: none;
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