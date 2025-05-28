<?php
session_start();

// Receba o ID do item enviado via POST
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if ($id !== null && isset($_SESSION['carrinho'])) {
    // Filtre os itens do carrinho, removendo o item com o ID correspondente
    $_SESSION['carrinho'] = array_filter($_SESSION['carrinho'], function ($item) use ($id) {
        return $item['id'] != $id;
    });
}

// Retorne o total de itens restantes no carrinho
$totalItens = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $totalItens += $item['quantidade'];
}
echo json_encode(['total' => $totalItens]);