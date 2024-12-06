<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = '_freela';
$username = 'root';
$password = 'root';


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Capturar o termo de pesquisa da URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Se o campo de pesquisa não estiver vazio
if ($query != '') {
    // Prevenir injeção SQL
    $query = $conn->real_escape_string($query);

    // Buscar usuários no banco de dados que correspondam ao termo de pesquisa
    $sql = "SELECT id, first_name, last_name, username, email, profile_pic FROM users 
            WHERE first_name LIKE '%$query%' 
            OR last_name LIKE '%$query%' 
            OR username LIKE '%$query%' 
            OR email LIKE '%$query%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Resultados da Pesquisa:</h2>";
        while ($row = $result->fetch_assoc()) {
            // Exibindo nome completo (first_name + last_name), usuário e e-mail
            echo "<div>
                    <img src='" . htmlspecialchars($row['profile_pic']) . "' alt='Profile' width='50' height='50'>
                    <strong>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</strong><br>
                    Usuário: " . htmlspecialchars($row['username']) . "<br>
                    E-mail: " . htmlspecialchars($row['email']) . "
                  </div><hr>";
        }
    } else {
        echo "Nenhum usuário encontrado.";
    }
} else {
    echo "Digite um termo de pesquisa.";
}

$conn->close();
?>