<?php global $user; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frella/assets/php/functions.php';
$users = getUsers1();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Navbar</title>
        
    </head>
    <body>
        <header>
        <div class="p1">
                <img class="search-button" src="/_frella/assets/img/navbar/pesquisa.png">
            </img>
            <div class="search-container">
                    <input type="text" class="search-bar" id="search-bar" placeholder="Pesquisar">
                    <div id="userSearchResults">
                <!-- Resultados da pesquisa serão exibidos aqui -->
            </div>
                </div>
            </div>
            <div id="userSearchResults">
            <!-- Resultados da pesquisa serão exibidos aqui -->
        </div>
            <div class="p2">
            <div class="perfil-container">
    <a href="?meuperfill">
        <img class="img1" src="/_frella/assets/img/navbar/perfil.png" alt="Perfil">
    </a>
    <form method="get" class="logout-form">
        <button type="submit" name="logout">Sair</button>
    </form>
</div>
                <a href="" id="addPostBtn">
                    <img class="img2" src="/_frella/assets/img/navbar/mais.png"></img>
                </a>
                <a href="#" id="openChatModal">
                <img class="img3" src="/_frella/assets/img/navbar/conversas.png" alt="Chat">
            </a>
                <a href="#"><img class="img4" src="/_frella/assets/img/navbar/sino.png"></a>
                <a href="?home"><img class="img5" src="/_frella/assets/img/navbar/logo.png"></img></a>
            </div>
        </header>
        <div id="chatModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <ul class="user-list" id="userList">
            <!-- Usuários serão carregados aqui -->
        </ul>
    </div>
</div>
        <div id="postForm" class="post-form hidden">
            <h3>Adicionar Post</h3>
            <form action="assets/pages/add_post.php" method="POST" enctype="multipart/form-data">
                <label for="post_img">Imagem do Post</label>
                <input type="file" id="post_img" name="post_img" accept="image/*">
                <label for="post_text">Texto do Post</label>
                <select name="post_type">
                    <option value="design">Design</option>
                    <option value="site">Site</option>
                </select>
                <textarea id="post_text" name="post_text" rows="3" placeholder="Escreva algo..."></textarea>
                <button type="submit">Postar</button>
            </form>
        </div>
        <script>
            
            document.getElementById('chatModal').addEventListener('click', function(event) {
    if (event.target === this) {
        this.style.display = 'none';
    }
});
       const users = <?php echo json_encode($users, JSON_UNESCAPED_UNICODE); ?>;

            // Exibir usuários ao carregar a página
            document.getElementById('search-bar').addEventListener('input', function(event) {
    const searchTerm = event.target.value.toLowerCase();
    const resultsContainer = document.getElementById('userSearchResults');
    resultsContainer.innerHTML = ''; // Limpar resultados anteriores

    if (searchTerm.trim() !== '') { // Apenas pesquisar se houver texto
        users.forEach(function(user) {
            if (user.username.toLowerCase().includes(searchTerm)) {
                const userElement = document.createElement('div');
                userElement.textContent = user.username;
                userElement.addEventListener('click', function() {
                    window.location.href = `profile.php?user=${user.id}`;
                });
                resultsContainer.appendChild(userElement);
            }
        });

        if (resultsContainer.innerHTML === '') {
            resultsContainer.innerHTML = '<div>Nenhum usuário encontrado.</div>';
        }
    }
});

            // Pesquisar usuários
            document.getElementById('search-bar').addEventListener('input', function(event) {
                const searchTerm = event.target.value.toLowerCase();
                const resultsContainer = document.getElementById('userSearchResults');
                resultsContainer.innerHTML = ''; // Limpar resultados anteriores
                
                users.forEach(function(user) {
                    if (user.username.toLowerCase().includes(searchTerm)) {
                        const userElement = document.createElement('div');
                        userElement.textContent = user.username;
                        userElement.addEventListener('click', function() {
                            window.location.href = `?profile=${user.id}`;
                        });
                        resultsContainer.appendChild(userElement);
                    }
                });

                if (resultsContainer.innerHTML === '') {
                    resultsContainer.innerHTML = 'Nenhum usuário encontrado.';
                }
            });

            document.getElementById('openChatModal').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('chatModal').style.display = 'block';
            loadUserList();  // Carregar a lista de usuários
        });

        // Fechar Modal
        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('chatModal').style.display = 'none';
        });

        function loadUserList() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/_frella/assets/pages/get_users.php', true); // Altere para o caminho correto do seu script PHP
    xhr.onload = function() {
        if (xhr.status === 200) {
            const users = JSON.parse(xhr.responseText);
            const userList = document.getElementById('userList');
            userList.innerHTML = '';

            users.forEach(user => {
                const userItem = document.createElement('li');
                userItem.textContent = user.username;
                userItem.addEventListener('click', function() {
    openChatWindow(user.id, user.username);
});
                userList.appendChild(userItem);
            });
        }
    };
    xhr.send();
}
function closeChatWindow(button) {
    const chatWindow = button.closest('.chat-window');
    chatWindow.style.display = 'none';
}
function openChatWindow(userId, username) {
    const existingChat = document.querySelector(`.chat-window[data-user-id="${userId}"]`);
    if (existingChat) {
        existingChat.style.display = 'block'; // Mostra a janela existente
        return;
    }

    const chatWindow = document.createElement('div');
    chatWindow.className = 'chat-window';
    chatWindow.setAttribute('data-user-id', userId); // Identifica o usuário
    chatWindow.innerHTML = `
        <div class="chat-header">
            <span>Chat com ${username}</span>
            <button class="close-chat" onclick="closeChatWindow(this)">×</button>
        </div>
        <div class="chat-messages" id="chatMessages${userId}"></div>
        <textarea class="chat-input" id="chatInput${userId}" placeholder="Digite sua mensagem..."></textarea>
        <button onclick="sendMessage(${userId})">Enviar</button>
    `;
    document.body.appendChild(chatWindow);
    loadMessages(userId);
}
function sendMessage(receiverId) {
    const input = document.getElementById(`chatInput${receiverId}`);
    const message = input.value.trim();
    
    if (message) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/_frella/assets/pages/send_message.php', true);  // Envia para o PHP que processa a mensagem
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const messagesContainer = document.getElementById(`chatMessages${receiverId}`);
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message me';
                messageDiv.textContent = `Você: ${message}`;
                messagesContainer.appendChild(messageDiv);

                input.value = '';  // Limpar o campo de entrada
                messagesContainer.scrollTop = messagesContainer.scrollHeight;  // Rola para o final da conversa
            }
        };
        
        // Envia os dados para o PHP processar
        xhr.send(`receiver_id=${receiverId}&message=${encodeURIComponent(message)}`);
    }
}
function loadMessages(userId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `/_frella/assets/pages/get_messages.php?userId=${userId}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const messages = JSON.parse(xhr.responseText);
            const messagesContainer = document.getElementById(`chatMessages${userId}`);
            messagesContainer.innerHTML = '';
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = msg.sender === 'me' ? 'message me' : 'message other';
                messageDiv.textContent = msg.sender === 'me' 
                    ? `Você: ${msg.message}` 
                    : `${msg.sender}: ${msg.message}`;
                messagesContainer.appendChild(messageDiv);
            });
            messagesContainer.scrollTop = messagesContainer.scrollHeight; // Rola para o final
        }
    };
    xhr.send();
}

// Atualizar mensagens automaticamente a cada 5 segundos
setInterval(() => {
    const openChatWindows = document.querySelectorAll('.chat-window[data-user-id]');
    openChatWindows.forEach(chatWindow => {
        const userId = chatWindow.getAttribute('data-user-id');
        loadMessages(userId);
    });
}, 5000);

            document.getElementById('addPostBtn').addEventListener('click', function(event) {
                event.preventDefault();
                var postForm = document.getElementById('postForm');
                if (postForm.classList.contains('hidden')) {
                    postForm.classList.remove('hidden');
                } else {
                    postForm.classList.add('hidden');
                }
            });
        </script>
    </body>
    <style> 
    .chat-window {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    max-width: 90%; /* Ajusta para telas menores */
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 200; /* Certifique-se de que esteja acima de outros elementos */
    padding: 20px;
}
.chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 10px;
}
.chat-messages {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #f9f9f9;
}
.chat-input {
    width: calc(100% - 90px); /* Espaço para o botão Enviar */
    margin-right: 10px;
}
.chat-window button {
    cursor: pointer;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s;
}
.chat-window button:hover {
    background-color: #0056b3;
}
.close-chat {
    background-color: transparent;
    border: none;
    font-size: 16px;
    cursor: pointer;
}
    .post-form {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 1px solid #ccc;
    padding: 20px;
    width: 100%;
    max-width: 400px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 100; /* Certifique-se de que o z-index seja maior que o da navbar */
}

.hidden {
    display: none;
}
    .perfil-container {
    display: flex;
    align-items: center;
    gap: 10px; /* Espaço entre o ícone e o botão */
}

.logout-form {
    margin: 0; /* Remove margens do formulário */
}

.logout-form button {
    background-color: transparent; /* Sem fundo */
    color: #fff; /* Cor do texto */
    border: none; /* Sem borda */
    cursor: pointer;
    font-size: 14px; /* Tamanho do texto */
}


#userSearchResults div {
    padding: 10px;
    cursor: pointer;
}


.logout-form button:hover {
    text-decoration: underline; /* Destacar o botão ao passar o mouse */
}
        header{
            position: fixed;
            height: 80px;
            width: auto;
            left: 0px;
            right: 0px;
            top: 0px;
            z-index: 10;
             /* background-color:black; aplicar */
            background-color: none;  /* trocar para ficar sem fundo*/
        }
        .p1{
           position: relative;
           top: 10px; 
           float: left;
           align-items: center;
           display: flex;
           justify-content: center;
           gap: 10px;
           margin-left: 30px;     
        }
        .search-container {
        margin-top: 10px;
        border: 0.8px solid #fff;
        border-radius: 12px;
        width: 300px;
        }
        .search-bar {
        color: white;
        padding: 10px;
        background-color: transparent;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        }

        .search-bar:focus {
            outline: none;
        }
        .search-bar::placeholder{
            color: #fff;
        }
        .search-button {
            position: relative;
            top: 5px;
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
        .search-button:hover {
        outline: none;    
        }
        .p2{
            position: relative;
            float: right;
            bottom: 10px;
            align-items: center;
            display: flex;
            justify-content: center;
            gap: 20px; 
            margin-right: 30px;
        }
        a{
            text-decoration: none;
        }
        .img1{
            width: 40px;
            height: 40px;
        }
        .img2{
            width: 30px;
            height: 30px;
        }
        .img3{
            width: 40px;
            height: 40px;
        }
        .img4{
            width: 40px;
            height: 40px;
        }
        .img5{
            width: 100px;
            height: 100px;
        }
        .post-form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .post-form input, .post-form textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .post-form button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .post-form button:hover {
            background-color: #0056b3;
        }
        .post-form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .hidden {
            display: none;
        }
    </style>
</html>