<?php
include 'conexao.php';

$data_hoje = date('Y-m-d');

$sql = "
SELECT 
    e.id,
    e.livro_emprestado,
    e.Responsavel,
    e.data_emprestimo,
    e.data_prevista_devolucao,
    e.data_devolucao,
    l.status
FROM emprestimos e
JOIN livros l ON e.id = l.id_livro
WHERE l.status = 'emprestado'
ORDER BY e.data_prevista_devolucao ASC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
<meta charset="UTF-8">
<title>Relatório de Livros Emprestados</title>
<style>
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #eee; }
    .atrasado { background-color:rgb(241, 69, 39); } /* vermelho  */
    .em-dia { background-color:rgb(0, 252, 59); } /* verde  */
</style>
</head>
<body>

<h3>Relatório de Livros</h3>

<table>
    <thead>
        <tr>
            <th>ID Empréstimo</th>
            <th>Livro</th>
            <th>Responsável</th>
            <th>Data Empréstimo</th>
            <th>Data Prevista Devolução</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $atrasado = ($row['data_prevista_devolucao'] < $data_hoje && empty($row['data_devolucao']));
        $classe = $atrasado ? "atrasado" : "em-dia";
        $status = $atrasado ? "Atrasado" : "Em dia";

        echo "<tr class='$classe'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['livro_emprestado']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Responsavel']) . "</td>";
        echo "<td>" . htmlspecialchars($row['data_emprestimo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['data_prevista_devolucao']) . "</td>";
        echo "<td>$status</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Nenhum livro emprestado no momento.</td></tr>";
}
$conn->close();
?>
    </tbody>
</table>

</body>
</html>
