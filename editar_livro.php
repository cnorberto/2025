<?php
include("conexao.php");

// Verificar se o formulário foi enviado corretamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $id = isset($_POST['id_livro']) ? intval($_POST['id_livro']) : 0;
    $titulo = isset($_POST['titulo']) ? $conn->real_escape_string($_POST['titulo']) : '';
    $autor = isset($_POST['autor']) ? $conn->real_escape_string($_POST['autor']) : '';
    $genero = isset($_POST['genero']) ? $conn->real_escape_string($_POST['genero']) : '';
    $ano = isset($_POST['ano']) ? intval($_POST['ano']) : null;
    $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : '';

    // Validação simples
    if ($id <= 0 || empty($titulo) || empty($autor) || empty($status)) {
        echo "Erro: Todos os campos obrigatórios devem ser preenchidos.";
        exit;
    }

    // Atualizar o livro no banco de dados
    $sql = "UPDATE livros SET titulo = ?, autor = ?, genero = ?, ano = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $titulo, $autor, $genero, $ano, $status, $id);

    if ($stmt->execute()) {
        echo "Livro atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o livro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Erro: Requisição inválida.";
}
?>
