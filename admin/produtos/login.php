<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesse sua conta</title>
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
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .login-container h1 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }
        .login-container button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .create-account {
            background-color: #ff9800;
        }
        .create-account:hover {
            background-color: #e68900;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Acesse sua conta</h1>
        <form action="processar_login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <a href="criar_conta.php" class="create-account">Crie sua conta</a>
    </div>
</body>
</html>