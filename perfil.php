<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // se não logado volta pra pagina de login
    exit();
}
require_once('conexao.php');
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM usuarios WHERE id = $user_id";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $username = $row['username'];
    $email = $row['email'];
    $nickname = $row['nickname'];
    $id_unica = $row['user_id'];
    $image_path = $row['image_path'];
} else {
    echo "Erro ao buscar o usuario.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/perfil.css" />
    <title>Perfil</title>
</head>
<body>
    <h2>Perfil do Usuário</h2>
    <a href="editar_imagem.php"><img src="<?php echo $image_path; ?>" alt="Imagem do Perfil" style="max-height: 200px;"></a>
    <p><strong>Usuário:</strong> <?php echo $username; ?></p>
    <p><strong>E-mail:</strong> <?php echo $email; ?></p>
    <p><strong>Nickname:</strong> <?php echo $nickname; ?></p>
    <p><strong>ID única</strong> <?php echo $id_unica; ?></p>
    
    -------------------

    <p><a href="alterar.php">Alterar dados do cadastro</a></p>
    <p><a href="excluir.php">Excluir cadastro</a></p>
    <p><a href="logout.php">Sair</a></p>
    <br></br>
    <p><a href="index.html">Ir para a pagina principal</a></p>
</body>
</html>