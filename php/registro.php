<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
    
<?php

$servername = "localhost";
$username = "root";
$password = "minecraft";
$dbname = "site";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber os dados do formulário
$email = $_POST['email'];
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Verificar se as senhas coincidem
if ($password !== $confirmPassword) {
    die("As senhas não coincidem");
}

// Hash da senha (é uma boa prática armazenar senhas de forma segura)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Inserir dados no banco de dados
$sql = "INSERT INTO nome_da_tabela (email, name, username, password) VALUES ('$email', '$name', '$username', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    echo "Registro bem-sucedido";
} else {
    echo "Erro ao registrar: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
</body>
</html>