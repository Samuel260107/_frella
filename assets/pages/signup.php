<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro _frella</title>
    <style>
        body {
            background-image: url("/_frella/assets/img/login/fundologin.png");
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0;
        }

        .form-box {
            position: relative;
            max-width: 405px;
            height: 400px;
            background: white;
            border-radius: 20px 0 0px 0;
            color: #412B04;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .brown-box {
            max-width: 300px;
            height: 420px;
            background: #412B04;
            border-radius: 0 0px 20px 0px;
            color: white;
            text-align: center;
            padding: 20px 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            justify-content: center;
        }

        .brown-box h2 {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .brown-box p {
            margin-bottom: 60px;
        }

        .brown-box a {
    display: block;  /* Faz o link ocupar toda a largura disponível */
    width: 80%;      /* Ajusta a largura do link */
    margin: 0 auto;  /* Centraliza o link */
    padding: 15px 20px; /* Aumenta o espaço interno para o link */
    background-color: white;
    color: #412B04;
    text-decoration: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.brown-box a:hover {
    background-color: #f2f2f2;
}
        .form-box h1 {
            margin-bottom: 20px;
        }

        .form-box form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .form-box .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            width: 100%; /* Para garantir que ocupe toda a largura do formulário */
        }

        .form-box input {
            width: 85%;
            padding: 10px;
            border: 1px solid #B1B1B1;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-box input[name="first_name"],
        .form-box input[name="last_name"] {
            width: calc(40% - 10px); /* Ajuste do nome e sobrenome */
        }

        .form-box button {
            display: block;  /* Faz o link ocupar toda a largura disponível */
    width: 80%;      /* Ajusta a largura do link */
    margin: 10px auto;  /* Centraliza o link */
    padding: 15px 20px; /* Aumenta o espaço interno para o link */
    background-color: #412B04;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
        }

        .form-box button:hover {
            background-color: #684321;
        }

        .brown-box .logo {
            margin-bottom: 10px;
        }
        .logo img{
            width: 120px;

        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Div Branca -->
        <div class="form-box">
            <h1>Criar nova conta</h1>
            <form method="post" action="assets/php/action.php?signup">
                <!-- Nome e Sobrenome -->
                <div class="d-flex">
                    <input type="text" name="first_name" placeholder="Nome" required>
                    <input type="text" name="last_name" placeholder="Sobrenome" required>
                </div>
                <!-- Email -->
                <input type="email" name="email" placeholder="Email" required>
                <!-- Usuário -->
                <input type="text" name="username" placeholder="Usuário" required>
                <!-- Senha -->
                <input type="password" name="password" placeholder="Senha" required>
                <!-- Botão de Cadastro -->
                <button type="submit">Cadastrar</button>
            </form>
        </div>

        <!-- Div Marrom -->
        <div class="brown-box">
            <div class="logo">
                <img src="/_frella/assets/img/login/logo.png" alt="" width="100">
            </div>
            <h2>Bem-vindo ao FREELA!</h2>
            <p>Já tem uma conta?<br> Faça login!</p>
            <a href="?login">Entrar</a>
        </div>
    </div>
</body>
</html>
