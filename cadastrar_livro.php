<?php
include("conexao.php");

$id = $_POST['id_livro'];
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$genero = $_POST['genero'];
$ano = $_POST['ano'];
$status = $_POST['status']; // deve ser 'disponivel' ou 'emprestado'

$sql = "INSERT INTO livros (id, titulo, autor, genero, ano, status)
        VALUES ('$id', '$titulo', '$autor', '$genero', '$ano', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "Livro cadastrado com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>


