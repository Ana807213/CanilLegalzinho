<?php
session_start();

// Receba os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Verifique se o item já está no carrinho
$encontrado = false;
foreach ($_SESSION['carrinho'] as &$item) {
    if ($item['id'] == $data['id']) {
        $item['quantidade'] += (int)$data['quantidade']; // Atualize a quantidade
        $encontrado = true;
        break;
    }
}

// Se o item não estiver no carrinho, adicione-o
if (!$encontrado) {
    $_SESSION['carrinho'][] = [
        'id' => $data['id'],
        'nome' => $data['nome'],
        'imagem' => $data['imagem'],
        'preco' => $data['preco'],
        'quantidade' => (int)$data['quantidade'] // Certifique-se de que a quantidade é um número inteiro
    ];
}

// Retorne o total de itens no carrinho
$totalItens = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $totalItens += $item['quantidade'];
}
echo json_encode(['total' => $totalItens]);