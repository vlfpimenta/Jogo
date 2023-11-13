<?php
require_once('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $email = $_POST["email"];
    $nickname = $_POST["nickname"];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $random_id = sprintf("%06d", mt_rand(1, 999999));
        $target_dir = "uploads/";
        $image_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . $random_id . '.' . $image_extension;

        if (file_exists($target_file)) {
            echo "Desculpe, o arquivo já existe.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

                $image_path = $target_file;
                $sql = "INSERT INTO usuarios (user_id, username, password, email, nickname, image_path) VALUES ('$random_id', '$username', '$hashed_password', '$email', '$nickname', '$image_path')";

                if ($conexao->query($sql) === TRUE) {
                    header("Location: perfil.php");
                } else {
                    echo "Erro no cadastro: " . $conexao->error;
                }
            } else {
                echo "Desculpe, houve um erro ao fazer o upload do seu arquivo.";
            }
        }
    } else {
        echo "As senhas não coincidem.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login2.css" />
    <title>Cadastro</title>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var confirmPasswordInput = document.getElementById("confirm_password");

            if (document.getElementById("show_password").checked) {
                passwordInput.type = "text";
                confirmPasswordInput.type = "text";
            } else {
                passwordInput.type = "password";
                confirmPasswordInput.type = "password";
            }
        }
    </script>
</head>
<body>
    <div class="container2">
    <h1>Cadastro de Usuário</h1>
    <div class="box">
        <form method="post" action="cadastro.php" enctype="multipart/form-data">
            <label for="username">Usuário:</label>
            <input type="text" name="username" required><br><br>

            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required><br><br>

            <label for="confirm_password">Confirmar Senha:</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>
            <label for="show_password">Exibir Senhas:</label>
            <input type="checkbox" id="show_password" onclick="togglePassword()"><br><br>

                <label for="email">E-mail:</label>
                <input type="email" name="email" required><br><br>

                <label for="nickname">Nickname:</label>
                <input type="text" name="nickname" required><br><br>

                <label for="image">Imagem:</label>
                <input type="file" name="image" accept="image/*" required><br><br>

                <input type="submit" value="Cadastrar"><br></br>

                <p><a href="login.php">Voltar para o inicio</a></p>
            </form>
        </div>
    </div>

</body>
</html>
