<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// //conectar com db
require_once 'config.php';
$db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die("database is not connected");

// Certifique-se de que a função showPage não está duplicada
if (!function_exists('showPage')) {
    function showPage($page) {
        include "assets/pages/$page.php";
    }
}

//criar o usuario
if (!function_exists('createUser')) {
    function createUser($data) {
        global $db;
        $first_name = mysqli_real_escape_string($db, $data['first_name']);
        $last_name = mysqli_real_escape_string($db, $data['last_name']);
        $email = mysqli_real_escape_string($db, $data['email']);
        $username = mysqli_real_escape_string($db, $data['username']);
        $password = mysqli_real_escape_string($db, $data['password']);
        $password = md5($password);

        $query = "INSERT INTO users (first_name, last_name, email, username, password) 
                  VALUES ('$first_name', '$last_name', '$email', '$username', '$password')";
        if (mysqli_query($db, $query)) {
            return mysqli_insert_id($db); 
        } else {
            return false;
        }
    }
}

if (!function_exists('validateSignupForm')) {
    function validateSignupForm($form_data) {
        $response = array();
        $response['status'] = true;

        // Check for missing fields and add appropriate messages
        if (!$form_data['password']) {
            $response['msg'] = "A senha é obrigatória";
            $response['status'] = false;
            $response['field'] = 'password';
        }

        if (!$form_data['username']) {
            $response['msg'] = "O nome de usuário é obrigatório";
            $response['status'] = false;
            $response['field'] = 'username';
        }

        if (!$form_data['email']) {
            $response['msg'] = "O e-mail é obrigatório";
            $response['status'] = false;
            $response['field'] = 'email';
        }

        if (!$form_data['last_name']) {
            $response['msg'] = "O sobrenome é obrigatório";
            $response['status'] = false;
            $response['field'] = 'last_name';
        }

        if (!$form_data['first_name']) {
            $response['msg'] = "O primeiro nome é obrigatório";
            $response['status'] = false;
            $response['field'] = 'first_name';
        }

        return $response;
    }
}
if (!function_exists('getUser')) {
    function getUser($id) { 
        global $db; // Certifique-se de que $db está definido
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
// functions.php
if (!function_exists('getUsers')) {
    function getUsers() {
        global $db; 
        
        // Prepara a consulta SQL
        $query = "SELECT id, first_name, last_name, username, profile_pic FROM users ORDER BY id DESC LIMIT 10";
        
        // Executa a consulta
        $result = $db->query($query);
        
        // Verifica se a consulta retornou algum resultado
        if ($result) {
            // Retorna os resultados como um array associativo
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Retorna um array vazio em caso de erro
            return [];
        }
    }
}
//atualizar o perfil
if (!function_exists('updateProfile')) {
function updateProfile($data, $imagedata) {
    global $db;
    
    $age = mysqli_real_escape_string($db, $data['age']);
    $job = mysqli_real_escape_string($db, $data['job']);
    $bio = mysqli_real_escape_string($db, $data['bio']);
    
    $profile_pic = "";
    if ($imagedata['name']) {
        $image_name = time() . basename($imagedata['name']);
        $image_dir = "../img/profile/$image_name";
        move_uploaded_file($imagedata['tmp_name'], $image_dir);
        $profile_pic = ", profile_pic = '$image_name'";
    }
    
    $query = "UPDATE users SET age = '$age', job = '$job', bio = '$bio' $profile_pic WHERE id = " . $_SESSION['userdata']['id'];
    
    return mysqli_query($db, $query);
}
}
if (!function_exists('updateProfile1')) {
function updateProfile1($data, $profilePicData, $fundoPicData) {
    global $db;
    
    $age = mysqli_real_escape_string($db, $data['age']);
    $job = mysqli_real_escape_string($db, $data['job']);
    $bio = mysqli_real_escape_string($db, $data['bio']);
    
    $profile_pic = "";
    if ($profilePicData['name']) {
        $image_name = time() . basename($profilePicData['name']);
        $image_dir = "../img/profile/$image_name";
        if (move_uploaded_file($profilePicData['tmp_name'], $image_dir)) {
            $profile_pic = ", profile_pic = '$image_name'";
        } else {
            echo "Erro ao mover a imagem de perfil.";
        }
    }

    $fundo_pic = "";
    if ($fundoPicData['name']) {
        $fundo_image_name = time() . basename($fundoPicData['name']);
        $fundo_image_dir = "../img/fundo/$fundo_image_name";
        if (move_uploaded_file($fundoPicData['tmp_name'], $fundo_image_dir)) {
            $fundo_pic = ", fundo_pic = '$fundo_image_name'";
        } else {
            echo "Erro ao mover a imagem de fundo.";
        }
    }
    
    $query = "UPDATE users SET age = '$age', job = '$job', bio = '$bio' $profile_pic $fundo_pic WHERE id = " . $_SESSION['userdata']['id'];
    
    $result = mysqli_query($db, $query);

    if (!$result) {
        echo "Erro na query: " . mysqli_error($db);
    }

    return $result;
}
}
if (!function_exists('createPost')) {
function createPost($post_text, $post_img, $post_type) {
    global $db;
    $user_id = $_SESSION['userdata']['id']; // Obtém o ID do usuário logado

    $query = "INSERT INTO posts (user_id, post_img, post_text, post_type, created_at) 
              VALUES (?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $post_img, $post_text, $post_type);

    return mysqli_stmt_execute($stmt);
}
}

// function getPost($post_type = null) {
//     global $db;
    
//     // Inicia a query básica
//     $query = "SELECT users.id as uid, posts.id, posts.user_id, posts.post_img, posts.post_text, posts.created_at, users.first_name, users.last_name, users.username, users.profile_pic, posts.post_type 
//               FROM posts 
//               JOIN users ON users.id = posts.user_id";
    
//     // Se o tipo de post for fornecido, adiciona a condição WHERE
//     if ($post_type) {
//         $query .= " WHERE posts.post_type = '$post_type'";
//     }

//     // Ordenar por mais recente
//     $query .= " ORDER BY posts.id DESC";

//     $run = mysqli_query($db, $query);
//     return mysqli_fetch_all($run, true);
// }
if (!function_exists('getPost1')) {
function getPost1($post_type = null) {
    global $db;
    $user_id = $_SESSION['userdata']['id']; // Obtendo o ID do usuário logado
    
    // Inicia a query básica
    $query = "SELECT users.id as uid, posts.id, posts.user_id, posts.post_img, posts.post_text, posts.created_at, users.first_name, users.last_name, users.username, users.profile_pic, posts.post_type 
              FROM posts 
              JOIN users ON users.id = posts.user_id 
              WHERE posts.user_id = $user_id";
    
    // Se o tipo de post for fornecido, adiciona a condição WHERE
    if ($post_type) {
        $query .= " AND posts.post_type = '$post_type'";
    }
    
    // Ordena e limita a quantidade de posts
    $query .= " ORDER BY posts.id DESC LIMIT 3";

    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}
function getUserById($id) { 
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
}
if (!function_exists('getPost2')) {
function getPost2($post_type = null) {
    global $db;
    $user_id = $_SESSION['userdata']['id']; // Obtendo o ID do usuário logado
    
    // Inicia a query básica
    $query = "SELECT users.id as uid, posts.id, posts.user_id, posts.post_img, posts.post_text, posts.created_at, users.first_name, users.last_name, users.username, users.profile_pic, posts.post_type 
              FROM posts 
              JOIN users ON users.id = posts.user_id 
              WHERE posts.user_id = $user_id";
    
    // Se o tipo de post for fornecido, adiciona a condição WHERE
    if ($post_type) {
        $query .= " AND posts.post_type = '$post_type'";
    }
    
    // Ordena e limita a quantidade de posts
    $query .= " ORDER BY posts.id DESC";

    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}
}
if (!function_exists('getPostsByUserId')) {
function getPostsByUserId($user_id) {
    global $db;
    $query = "SELECT * FROM posts WHERE user_id = ? ORDER BY id DESC";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
}
if (!function_exists('followUser')) {
function followUser($follower_id, $following_id) {
    global $db;

    // Verificar se o usuário já segue a pessoa
    $query = "SELECT * FROM follow_list WHERE follower_id = ? AND following_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $follower_id, $following_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Adiciona à tabela de follow se ainda não estiver seguindo
        $query = "INSERT INTO follow_list (follower_id, following_id) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $follower_id, $following_id);
        return $stmt->execute();
    } else {
        // Já segue a pessoa
        return false;
    }
}
}
if (!function_exists('unfollowUser')) {
function unfollowUser($follower_id, $following_id) {
    global $db;

    $query = "DELETE FROM follow_list WHERE follower_id = ? AND following_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $follower_id, $following_id);
    return $stmt->execute();
}
}
if (!function_exists('isFollowing')) {
function isFollowing($follower_id, $following_id) {
    global $db;
    
    $query = "SELECT * FROM follow_list WHERE follower_id = ? AND following_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $follower_id, $following_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}
}
if (!function_exists('getFollowers')) {
function getFollowers($user_id) {
    global $db;

    $query = "
        SELECT users.id, users.first_name, users.last_name, users.username, users.profile_pic 
        FROM follow_list 
        JOIN users ON follow_list.follower_id = users.id 
        WHERE follow_list.following_id = ?
    ";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}
}
if (!function_exists('validateLoginForm')){
function validateLoginForm($form_data){
    $response=array();
    $response['status']=true;
    $blank=false;
      
        if(!$form_data['password']){
            $response['msg']="password esta errada";
            $response['status']=false;
            $response['field']='password';
            $blank=true;
        }
       
        if(!$form_data['username_email']){
            $response['msg']="username/email esta errada";
            $response['status']=false;
            $response['field']='username_email';
            $blank=true;
        }

        if(!$blank && !checkUser($form_data)['status'] ){
            $response['msg']="something errada";
            $response['status']=false;
            $response['field']='checkuser';
        }else{
            $response['user']=checkUser($form_data)['user'];
        }
        
      
    
    
        return $response;
    
    }
}
if (!function_exists('checkUser')){
function checkUser($login_data){
    global $db;
 $username_email = $login_data['username_email'];
 $password=md5($login_data['password']);

 $query = "SELECT * FROM users WHERE (email='$username_email' || username='$username_email') && password='$password'";
 $run = mysqli_query($db,$query);
 $data['user'] = mysqli_fetch_assoc($run)??array();
 if(count($data['user'])>0){
     $data['status']=true;
 }else{
    $data['status']=false;

 }

 return $data;
}
}
if (!function_exists('deletePost')){
function deletePost($post_id) {
    global $db;
    
    // Primeiro, recupera a imagem associada ao post para deletá-la também
    $query = "SELECT post_img FROM posts WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);

    if ($post) {
        // Exclui a imagem do servidor, se houver uma associada ao post
        if (!empty($post['post_img'])) {
            $image_path = $_SERVER['DOCUMENT_ROOT'] . "?home" . $post['post_img'];
            if (file_exists($image_path)) {
                unlink($image_path); // Remove a imagem do servidor
            }
        }

        // Exclui o post do banco de dados
        $query = "DELETE FROM posts WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        
        return mysqli_stmt_execute($stmt);
    }
    
    return false;
}
}
if (!function_exists('likePost')){
function likePost($post_id) {
    global $db;
    $user_id = $_SESSION['userdata']['id'];

    // Verifica se já existe uma curtida
    $query = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insere a nova curtida
        $query = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $post_id, $user_id);
        return $stmt->execute();
    } else {
        // Já existe uma curtida, pode descurtir
        return false;
    }
}
}
if (!function_exists('unlikePost')){
function unlikePost($post_id) {
    global $db;
    $user_id = $_SESSION['userdata']['id'];

    // Remove a curtida
    $query = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $post_id, $user_id);
    return $stmt->execute();
}
}
if (!function_exists('getLikesCount')){
function getLikesCount($post_id) {
    global $db;
    $query = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['like_count'];
}
}
if (!function_exists('isPostLiked')){
function isPostLiked($post_id) {
    global $db;
    $user_id = $_SESSION['userdata']['id'];
    $query = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}
}
if (!function_exists('sendMessage')){
function sendMessage($sender_id, $receiver_id, $message_text) {
    global $db;
    
    $query = "INSERT INTO messages (sender_id, receiver_id, message_text, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "iis", $sender_id, $receiver_id, $message_text);

    return mysqli_stmt_execute($stmt);
}
}
if (!function_exists('getMessages')){

function getMessages($user_id, $contact_id) {
    global $db;
    
    $query = "
        SELECT * FROM messages
        WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
        ORDER BY created_at ASC
    ";
    
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "iiii", $user_id, $contact_id, $contact_id, $user_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
}
?>