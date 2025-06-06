<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "biblioteca";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$sql = "SELECT id_livro, titulo, autor, genero, ano, status FROM livros";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Livros</title>
</head>
<body>
    <h1>Lista de Livros 📚</h1>

    <?php
    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Título</th><th>Autor</th><th>Gênero</th><th>Ano</th><th>Status</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id_livro']) . '</td>';
            echo '<td>' . htmlspecialchars($row['titulo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['autor']) . '</td>';
            echo '<td>' . htmlspecialchars($row['genero']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ano']) . '</td>';
            echo '<td>' . htmlspecialchars($row['status']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "<p>Nenhum livro encontrado.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
