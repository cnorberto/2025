<?php
include("conexao.php");

$id = $_POST['id_usuario'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$contato = $_POST['contato'];
$data_registro = $_POST['data_registro'];

$sql = "INSERT INTO usuarios (id, nome, email, contato, data_registro)
        VALUES ('$id', '$nome', '$email', '$contato', '$data_registro')";

if ($conn->query($sql) === TRUE) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>
