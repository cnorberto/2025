<?php
include 'conexao.php'; // Conexão com o banco

$filtro = "";

if (isset($_GET['busca'])) {
    $busca = $conn->real_escape_string($_GET['busca']);
    $filtro = "WHERE titulo LIKE '%$busca%' OR autor LIKE '%$busca%' OR genero LIKE '%$busca%'";
}

$sql = "SELECT id_livro, titulo, autor, genero, ano, status FROM livros $filtro ORDER BY titulo ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="UTF-8">
  <title>Pesquisar Livros</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top: 15px; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background-color: #f2f2f2; }
    input[type=text] { width: 350px; padding: 6px; }
    button { padding: 6px 12px; }
  </style>
</head>
<body>

<h3>Pesquisar livros</h3>

<form method="GET" action="pesquisar_livros.php">
  <input type="text" name="busca" placeholder="Digite título, autor ou gênero" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
  <button type="submit">Pesquisar</button>
  <button type="button" onclick="window.location='pesquisar_livros.php'">Limpar</button>
</form>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Gênero</th>
            <th>Ano</th>
            <th>Status</th>
          </tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id_livro']) . "</td>";
        echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
        echo "<td>" . htmlspecialchars($row['genero']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ano']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>Nenhum livro encontrado.</p>";
}

$conn->close();
?>

</body>
</html>
