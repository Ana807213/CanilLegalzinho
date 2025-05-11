<?php
$host = "localhost";
$usuario = "root";
$senha = "An@342035";
$banco = "CANIL";
$porta = 3307;

$con = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($con->connect_error) {
    die("Erro na conexão: " . $con->connect_error);
}
?>