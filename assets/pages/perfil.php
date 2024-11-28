<?php global $user; ?>
<div class="container1">
    <div class="container">
        <div class="back-icon">
            <!-- Ícone ou botão de retorno -->
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </div>

        <form method="post" action="/_frella/assets/php/action.php?perfil" enctype="multipart/form-data" class="profile-form">
            <div class="profile-area">
                <div class="profile-pic">
                    <!-- Tornando a imagem um botão clicável -->
                    <label for="formFile" class="profile-label">
                    <img src="assets/img/profile/<?=$user['profile_pic']?>" alt="Profile Picture" id="profilePic">

                    </label>
                    <input type="file" class="file-input" name="profile_pic" id="formFile" style="display: none;">
                </div>

                <div class="input-group">
                    <input type="text" name="first_name" value="<?= $user['first_name'] . ' ' . $user['last_name'] ?>" placeholder="Seu Nome" class="form-control">
                </div>

                <div class="input-group">
                    <input type="number" name="age" placeholder="Idade" class="form-control">
                </div>

                <div class="input-group">
                    <select name="job" class="form-control">
                        <option value="Desenvolvedor">Desenvolvedor</option>
                        <option value="Designer">Designer</option>
                    </select>
                </div>

                <div class="input-group">
                    <textarea name="bio" placeholder="Sobre Você" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<style>
    .container1 {
        background-image: url('../_frella/assets/img/fundo/background.png');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container {
        font-family: Arial, sans-serif;
        width: 100%;
        max-width: 430px;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
    }

    .back-icon {
        font-size: 24px;
        margin: 10px 0;
        cursor: pointer;
    }

    .profile-pic {
        display: flex;
        justify-content: center;
        position: relative;
        margin-top: 20px;
    }

    .profile-label {
        cursor: pointer; /* Torna a área da imagem clicável */
    }

    .profile-pic img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 3px solid #D9D9D9;
        object-fit: cover;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-pic img:hover {
        transform: scale(1.1);
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }

    .file-input {
        display: none; /* Oculta o input */
    }

    .form-group, .input-group {
        margin: 20px 20px;
    }

    .profile-form input, .profile-form select, .profile-form textarea, .profile-form button {
        width: 100%;
        padding: 10px;
        border: 2px solid #D9D9D9;
        border-radius: 10px;
        box-sizing: border-box;
        appearance: none;
    }

    .profile-form textarea {
        resize: none; /* Impede o redimensionamento do campo de texto */
    }

    .profile-form textarea::placeholder {
        color: #888;
        font-size: 14px;
    }

    .profile-form button {
        display: block;
        width: 90%;
        padding: 10px;
        margin: 20px auto;
        background-color: #000;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .profile-form button:hover {
        background-color: #333;
    }
</style>
<script>
    document.getElementById('formFile').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePic').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

