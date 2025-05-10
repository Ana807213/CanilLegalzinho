<?php
session_start();
include '../../config/conexao.php';

$result = $con->query("SELECT COUNT(*) AS total FROM categoria");
$total = $result->fetch_assoc()['total'];


if ($total == 0) {
    $stmt = $con->prepare("INSERT INTO CATEGORIA (NOME) VALUES (?), (?)");
    $stmt -> bind_param ("ss", $nome1, $nome2);

    $nome1 = "GATO";
    $nome2 = "CACHORRO";
    
if ($stmt -> execute()) {
    echo "Categorias GATO e CACHORRO criadas com sucesso!";
} else {
    echo "Erro ao criar categorias: " . $stmt->error;
}
$stmt -> close();
} else {
    echo "Categorias já existem!";
}
$con -> close();
?>

