<?php
session_start();
require_once __DIR__ . '/../banco.php'; // Inclua o arquivo de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os dados necessários estão disponíveis
    if (!isset($_SESSION['carrinho'], $_SESSION['total_compra'], $_POST['metodo_pagamento'])) {
        echo "<script>alert('Erro ao processar a compra. Retorne ao carrinho.');</script>";
        header("Location: carrinho.php");
        exit;
    }

    $carrinho = $_SESSION['carrinho'];
    $totalCompra = $_SESSION['total_compra'];
    $metodoPagamento = $_POST['metodo_pagamento'];
    $frete = 7.90; // Valor fixo do frete (pode ser dinâmico)

    // Conexão com o banco de dados
    $con = getConnection(); // Função que retorna a conexão com o banco

    try {
        // Inicia uma transação
        $conn->beginTransaction();

        // Insere os dados da compra na tabela "compras"
        $stmt = $con->prepare("INSERT INTO compras (usuario_id, total, metodo_pagamento, frete, data_compra) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['usuario']['id'], $totalCompra + $frete, $metodoPagamento, $frete]);

        // Obtém o ID da compra recém-criada
        $compraId = $con->lastInsertId();

        // Insere os itens do carrinho na tabela "itens_compra"
        $stmt = $con->prepare("INSERT INTO itens_compra (compra_id, produto_id, quantidade, preco) VALUES (?, ?, ?, ?)");
        foreach ($carrinho as $item) {
            $stmt->execute([$compraId, $item['id'], $item['quantidade'], $item['preco']]);
        }

        // Confirma a transação
        $con->commit();

        // Limpa o carrinho da sessão
        unset($_SESSION['carrinho'], $_SESSION['total_compra']);

        // Redireciona para a página de confirmação
        header("Location: confirmacao.php?compra_id=$compraId");
        exit;
    } catch (Exception $e) {
        // Reverte a transação em caso de erro
        $con->rollBack();
        echo "Erro ao processar a compra: " . $e->getMessage();
    }
}
?>