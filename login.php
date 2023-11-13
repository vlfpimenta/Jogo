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
    <link rel="stylesheet" href="./css/login2.css" />
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1 class="secondH1">Bem-vindo!</h1>
        <div class="box">
            <form method="post" action="login.php">

                <label for="login">Usuário ou Nickname:</label>
                <input type="text" name="login" required><br>

                <label for="password">Senha:</label>
                <input type="password" name="password" required><br>

                <input type="submit" value="Entrar">
                <br></br>
                <p><a href="cadastro.php">Não tem cadastro? cadsatre-se já!</a></p>
            </form>
        </div>
    </div>

</body>
</html>