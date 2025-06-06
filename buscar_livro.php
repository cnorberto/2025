<?php
include("conexao.php");

// Verifica se o ID do livro foi enviado (via GET)
if (!isset($_GET['id_livro']) || empty($_GET['id_livro'])) {
    die(json_encode(['erro' => 'ID do livro não fornecido']));
}

$id_livro = intval($_GET['id_livro']);

if ($id_livro <= 0) {
    die(json_encode(['erro' => 'ID do livro inválido']));
}

// Consulta preparada para evitar SQL injection
$stmt = $conn->prepare("SELECT id, titulo, autor, genero, ano, status FROM livros WHERE id = ?");
$stmt->bind_param("i", $id_livro);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['erro' => 'Livro não encontrado']);
} else {
    $livro = $result->fetch_assoc();
    echo json_encode($livro);
}

$stmt->close();
$conn->close();
?>
