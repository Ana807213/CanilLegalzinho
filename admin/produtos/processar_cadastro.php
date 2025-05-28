<?php
// filepath: c:\xampp\htdocs\Canil\admin\produtos\processar_cadastro.php
require_once __DIR__ . '/../banco.php'; // Caminho correto para o arquivo de conexão

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verifica se o email já está cadastrado
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Este email já está cadastrado. Tente outro.'); window.location.href='login_cadastro.php';</script>";
    exit;
}

// Insere o novo usuário no banco de dados
$senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $senhaHash);

if ($stmt->execute()) {
    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login_cadastro.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href='login_cadastro.php';</script>";
}
?>