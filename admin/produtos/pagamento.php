<?php
session_start();

// Verifica se o total da compra está definido na sessão
if (!isset($_SESSION['total_compra'])) {
    echo "<script>alert('Erro: Total da compra não definido. Retornando ao carrinho.');</script>";
    header("Location: carrinho.php");
    exit;
}

$totalCompra = $_SESSION['total_compra']; // Obtém o total da compra da sessão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meios de Pagamento</title>
    <!-- Link para Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f3f6;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #da70d6;
            margin-bottom: 20px;
        }
        .payment-method {
            margin-bottom: 15px;
        }
        .payment-method label {
            display: flex;
            align-items: center;
            cursor: pointer;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            transition: background-color 0.3s ease;
        }
        .payment-method label:hover {
            background-color: #f0f0f0;
        }
        .payment-method i {
            font-size: 24px;
            margin-right: 10px;
            color: #555;
        }
        .summary {
            margin-top: 20px;
            font-size: 16px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        .summary p {
            margin: 5px 0;
        }
        .summary strong {
            font-size: 18px;
            color: #333;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meios de Pagamento</h1>
        <form method="POST" action="processar_compra.php">
            <div class="payment-method">
                <label>
                    <input type="radio" name="metodo_pagamento" value="Cartão de Crédito" required>
                    <i class="fas fa-credit-card"></i> Cartão de Crédito
                </label>
            </div>
            <div class="payment-method">
                <label>
                    <input type="radio" name="metodo_pagamento" value="Nubank">
                    <i class="fas fa-university"></i> Nubank
                </label>
            </div>
            <div class="payment-method">
                <label>
                    <input type="radio" name="metodo_pagamento" value="Pix">
                    <i class="fas fa-qrcode"></i> Pix
                </label>
            </div>
            <div class="payment-method">
                <label>
                    <input type="radio" name="metodo_pagamento" value="Pix Parcelado">
                    <i class="fas fa-qrcode"></i> Pix Parcelado
                </label>
            </div>
            <div class="summary">
                <p>Produtos (<?= count($_SESSION['carrinho']) ?>): R$ <?= number_format($totalCompra, 2, ',', '.') ?></p>
                <p>Frete: R$ 7,90</p>
                <p><strong>Total: R$ <?= number_format($totalCompra + 7.90, 2, ',', '.') ?></strong></p>
            </div>
            <input type="hidden" name="total_compra" value="<?= $totalCompra ?>">
            <button type="submit" name="comprar" class="btn-submit">Concluir Pagamento</button>
        </form>
    </div>
</body>
</html>