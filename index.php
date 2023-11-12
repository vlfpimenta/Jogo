<?php
require_once('conexao.php');

$check_table_query = "SHOW TABLES LIKE 'usuarios'";
$check_table_result = $conexao->query($check_table_query);

if ($check_table_result->num_rows == 0) {
    // Se a tabela não existir, crie-a
    $create_table_query = "CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id VARCHAR(6),
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        nickname VARCHAR(255) NOT NULL,
        image_path VARCHAR(255),
        UNIQUE(username),
        UNIQUE(email)
    )";

    if ($conexao->query($create_table_query) === TRUE) {
        echo "Tabela 'usuarios' criada com sucesso.";
    } else {
        echo "Erro ao criar a tabela: " . $conexao->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE username = '$login' OR nickname = '$login'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            header("Location: perfil.php");
            exit();
        } else {
            echo "Senha incorreta";
        }
    } else {
        echo "Usuário não encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Bem-vindo!</h2>
    <form method="post" action="index.php">

        <label for="login">Usuário ou Nickname:</label>
        <input type="text" name="login" required><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Entrar">
        
        <p><a href="cadastro.php">Não tem cadastro? cadsatre-se já!</a></p>
    </form>
</body>
</html>