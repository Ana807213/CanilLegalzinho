<?php
session_start();

// Receba os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$delta = $data['delta'] ?? 0;

if ($id !== null && isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantidade'] += $delta;
            if ($item['quantidade'] <= 0) {
                $item['quantidade'] = 1; // Impede que a quantidade seja menor que 1
            }
            break;
        }
    }
    unset($item); // Evite referências posteriores
}

echo json_encode(['success' => true]);