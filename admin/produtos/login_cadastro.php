<?php
//filepath: c:\xampp\htdocs\Canil\admin\produtos\login_cadastro.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login ou Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f3f6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .container h1 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }
        .container form {
            margin-bottom: 20px;
        }
        .container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .container button:hover {
            background-color: #218838;
        }
        .container a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="processar_login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <h1>Cadastro</h1>
        <form action="processar_cadastro.php" method="POST">
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>