<?php
include 'conexao.php'; 

// Inicializa variável de filtro vazia
$filtro = "";

if (isset($_GET['busca'])) {
    // Escapa a entrada para evitar SQL Injection
    $busca = $conn->real_escape_string($_GET['busca']);
    $filtro = "WHERE nome LIKE '%$busca%' OR email LIKE '%$busca%'";
}

$sql = "SELECT id_usuario, nome, email, contato, data_registro FROM usuarios $filtro ORDER BY nome ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="UTF-8">
  <title>Listar Usuários</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top: 15px; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background-color: #f2f2f2; }
    input[type=text] { width: 300px; padding: 6px; }
    button { padding: 6px 12px; }
  </style>
</head>
<body>

<h3>Filtrar usuários</h3>

<form method="GET" action="listar_usuarios.php">
  <input type="text" name="busca" placeholder="Digite nome ou email" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
  <button type="submit">Buscar</button>
  <button type="button" onclick="window.location='listar_usuarios.php'">Limpar</button>
</form>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Contato</th>
            <th>Data Registro</th>
          </tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id_usuario']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['contato']) . "</td>";
        echo "<td>" . htmlspecialchars($row['data_registro']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>Nenhum usuário encontrado.</p>";
}

$conn->close();
?>

</body>
</html>
