<?php
header('Content-Type: application/json');

// Receba o CEP enviado via POST
$data = json_decode(file_get_contents('php://input'), true);
$cep = $data['cep'] ?? null;

if (!$cep) {
    echo json_encode(['success' => false, 'message' => 'CEP inválido.']);
    exit;
}

// Simulação de cálculo de frete
$frete = rand(10, 50); // Valor do frete entre R$10 e R$50
$prazo = rand(2, 7); // Prazo de entrega entre 2 e 7 dias

echo json_encode(['success' => true, 'frete' => $frete, 'prazo' => $prazo]);