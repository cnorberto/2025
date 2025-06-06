<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "biblioteca";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_emprestimo = intval($_POST['id_emprestimo']);
    $data_devolucao = $_POST['data_devolucao'];

    
    $sql = "UPDATE emprestimos SET data_devolucao = ? WHERE id_emprestimo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $data_devolucao, $id_emprestimo);

    if ($stmt->execute()) {
        
        $sql_info = "SELECT id_usuario, id_livro FROM emprestimos WHERE id_emprestimo = ?";
        $stmt_info = $conn->prepare($sql_info);
        $stmt_info->bind_param("i", $id_emprestimo);
        $stmt_info->execute();
        $resultado = $stmt_info->get_result();
        $emprestimo = $resultado->fetch_assoc();

        $id_usuario = $emprestimo['id_usuario'];
        $id_livro = $emprestimo['id_livro'];

        
        $conn->query("UPDATE livros SET status = 'disponivel' WHERE id_livro = $id_livro");
        $conn->query("UPDATE usuarios SET livros_emprestados = livros_emprestados - 1 WHERE id_usuario = $id_usuario");

        echo "Devolução registrada com sucesso.";
    } else {
        echo "Erro ao registrar devolução: " . $stmt->error;
    }
} else {
    echo "Método de requisição inválido.";
}

$conn->close();
?>
