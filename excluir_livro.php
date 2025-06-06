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
    $id_livro = intval($_POST['id_livro']);

    if ($id_livro > 0) {
   
        $sql = "DELETE FROM livros WHERE id_livro = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id_livro);

            if ($stmt->execute()) {
                echo "Livro com ID $id_livro foi excluído com sucesso.";
            } else {
                echo "Erro ao excluir o livro: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    } else {
        echo "ID do livro inválido.";
    }
} else {
    echo "Método de requisição inválido.";
}


$conn->close();
?>
