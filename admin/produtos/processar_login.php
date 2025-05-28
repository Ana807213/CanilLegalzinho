<?php
// filepath: c:\xampp\htdocs\Canil\admin\produtos\processar_login.php
session_start();
require_once __DIR__ . '/../banco.php'; // Caminho correto para o arquivo de conexão

// Verifica se a conexão foi estabelecida
if (!$conn) {
    die("Erro: Conexão com o banco de dados não foi estabelecida.");
}

$email = $_POST['email'];
$senha = $_POST['senha'];

// Busca o usuário pelo email
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Email ou senha inválidos.'); window.location.href='login_cadastro.php';</script>";
    exit;
}

$usuario = $result->fetch_assoc();

// Verifica a senha
if (password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario'] = $usuario['id']; // Armazena o ID do usuário na sessão

    // Redireciona para a página salva na sessão ou para a página padrão
    $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'pagamento.php';
    unset($_SESSION['redirect_after_login']); // Remove a variável da sessão
    header("Location: $redirect");
    exit;
} else {
    echo "<script>alert('Email ou senha inválidos.'); window.location.href='login_cadastro.php';</script>";
}
?>