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
                <img class="search-button" src="/_frella/assets/img/navbar/pesquisa.png"></img>
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Pesquisar">
                </div>
            </div>
            <div class="p2">
                <a href="?meuperfill"><img class="img1" src="/_frella/assets/img/navbar/perfil.png" alt=""></a>
                <a href="" id="addPostBtn">
                    <img class="img2" src="/_frella/assets/img/navbar/mais.png"></img>
                </a>
                <a href=""><img class="img3" src="/_frella/assets/img/navbar/conversas.png"></img></a>
                <a href="#"><img class="img4" src="/_frella/assets/img/navbar/sino.png"></a>
                <a href="?home"><img class="img5" src="/_frella/assets/img/navbar/logo.png"></img></a>
            </div>
        </header>
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