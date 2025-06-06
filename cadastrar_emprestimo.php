<?php
include("conexao.php");

$id = $_POST['id'];
$livro = $_POST['livro_emprestado'];
$responsavel = $_POST['Responsavel'];
$data_emprestimo = $_POST['data_emprestimo'];
$data_prevista = $_POST['data_prevista_devolucao'];
$data_devolucao = $_POST['data_devolucao'];

$sql = "INSERT INTO emprestimos (id, livro_emprestado, responsavel, data_emprestimo, data_prevista_devolucao, data_devolucao)
        VALUES ('$id', '$livro', '$responsavel', '$data_emprestimo', '$data_prevista', '$data_devolucao')";

if ($conn->query($sql) === TRUE) {
    echo "Empréstimo registrado com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>
