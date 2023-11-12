<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once('conexao.php');
$user_id = $_SESSION['user_id'];

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST["new_username"];
    $new_email = $_POST["new_email"];
    $new_nickname = $_POST["new_nickname"];

    $sql = "UPDATE usuarios SET username = '$new_username', email = '$new_email', nickname = '$new_nickname' WHERE id = $user_id";

    if ($conexao->query($sql) === TRUE) {
        header("Location: perfil.php");
    } else {
        echo "Erro de atualização: " . $conexao->error;
    }
}

$sql_select = "SELECT * FROM usuarios WHERE id = $user_id";
$resultado_select = $conexao->query($sql_select);

if ($resultado_select->num_rows > 0) {
    $row = $resultado_select->fetch_assoc();
    $current_username = $row['username'];
    $current_email = $row['email'];
    $current_nickname = $row['nickname'];
} else {
    echo "Erro ao obter informações";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados</title>
</head>
<body>
    <h2>Alterar Dados</h2>
    <form method="post" action="alterar.php">
        <label for="new_username">Novo Usuário:</label>
        <input type="text" name="new_username" value="<?php echo $current_username; ?>" required><br>

        <label for="new_email">Novo E-mail:</label>
        <input type="email" name="new_email" value="<?php echo $current_email; ?>" required><br>

        <label for="new_nickname">Novo Nickname:</label>
        <input type="text" name="new_nickname" value="<?php echo $current_nickname; ?>" required><br>

        <input type="submit" value="Atualizar Dados">
    </form>
</body>
</html>