<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once('conexao.php');
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql_delete = "DELETE FROM usuarios WHERE id = $user_id";

    if ($conexao->query($sql_delete) === TRUE) {
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao excluir perfil: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Perfil</title>
</head>
<body>
    <h2>Excluir Perfil</h2>
    <p>Tem certeza de que deseja excluir seu perfil? Esta ação é irreversível.</p>
    <form method="post" action="excluir.php">
        <input type="submit" value="Excluir Perfil">
    </form>
</body>
</html>