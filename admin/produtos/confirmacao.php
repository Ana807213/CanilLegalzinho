<?php
session_start();
require_once __DIR__ . '/../banco.php'; // Inclua o arquivo de conexão com o banco de dados

if (!isset($_GET['compra_id'])) {
    echo "<script>alert('Compra não encontrada.');</script>";
    header("Location: carrinho.php");
    exit;
}

$compraId = $_GET['compra_id'];

// Conexão com o banco de dados
$con = getConnection();

// Obtém os dados da compra
$stmt = $con->prepare("SELECT c.total, c.metodo_pagamento, c.frete, c.data_compra, u.nome AS usuario_nome 
                        FROM compras c 
                        JOIN usuarios u ON c.usuario_id = u.id 
                        WHERE c.id = ?");
$stmt->execute([$compraId]);
$compra = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtém os itens da compra
$stmt = $con->prepare("SELECT p.nome, ic.quantidade, ic.preco 
                        FROM itens_compra ic 
                        JOIN produtos p ON ic.produto_id = p.id 
                        WHERE ic.compra_id = ?");
$stmt->execute([$compraId]);
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Concluída</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f3f6;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #28a745;
        }
        .dog-image {
            width: 150px;
            margin: 20px auto;
        }
        .summary {
            text-align: left;
            margin-top: 20px;
        }
        .summary p {
            margin: 5px 0;
        }
        .btn-home {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-home:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Compra Concluída com Sucesso!</h1>
        <img src="dog_success.png" alt="Cachorrinho feliz" class="dog-image">
        <p>Obrigado por sua compra, <strong><?= htmlspecialchars($compra['usuario_nome']) ?></strong>!</p>
        <div class="summary">
            <h3>Resumo da Compra</h3>
            <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($compra['data_compra'])) ?></p>
            <p><strong>Método de Pagamento:</strong> <?= htmlspecialchars($compra['metodo_pagamento']) ?></p>
            <p><strong>Frete:</strong> R$ <?= number_format($compra['frete'], 2, ',', '.') ?></p>
            <p><strong>Total:</strong> R$ <?= number_format($compra['total'], 2, ',', '.') ?></p>
            <h4>Itens:</h4>
            <ul>
                <?php foreach ($itens as $item): ?>
                    <li><?= htmlspecialchars($item['nome']) ?> (<?= $item['quantidade'] ?>x) - R$ <?= number_format($item['preco'], 2, ',', '.') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="caes_disponiveis.php" class="btn-home">Voltar para a Loja</a>
    </div>
</body>
</html>