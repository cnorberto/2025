<?php
$servidor = "localhost";
$usuario = "root";
$senha = ""; // ou a senha configurada no seu MySQL
$banco = "biblioteca";

// Criar conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
