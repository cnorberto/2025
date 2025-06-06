<?php
include 'conexao.php';

// Pega o ID do usuário via GET (para selecionar o usuário)
$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

// Consulta para listar todos os usuários para o select
$sql_usuarios = "SELECT id_usuario, nome FROM usuarios ORDER BY nome ASC";
$result_usuarios = $conn->query($sql_usuarios);

$emprestimos = [];

if ($id_usuario > 0) {
    // Consulta para pegar o histórico de empréstimos do usuário selecionado
    // Supondo que na tabela emprestimos exista uma coluna para identificar o usuário (ex: id_usuario)
    $sql_emprestimos = "SELECT e.id, e.livro_emprestado, e.data_emprestimo, e.data_prevista_devolucao, e.data_devolucao 
                        FROM emprestimos e
                        WHERE e.id_usuario = ?
                        ORDER BY e.data_emprestimo DESC";

    $stmt = $conn->prepare($sql_emprestimos);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result_emprestimos = $stmt->get_result();

    while ($row = $result_emprestimos->fetch_assoc()) {
        $emprestimos[] = $row;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
<meta charset="UTF-8">
<title>Histórico de Empréstimos por Usuário</title>
<style>
    table { border-collapse: collapse; width: 100%; margin-top: 15px; }
    th, td { border: 1px solid #ccc; padding: 8px; }
    th { background-color: #eee; }
</style>
</head>
<body>

<h2>Emprestimos por Usuário</h2>

<form method="GET" action="historico_emprestimos_usuario.php">
    <label for="id_usuario">Selecione o Usuário:</label>
    <select name="id_usuario" id="id_usuario" required>
        <option value="">----Selecione----</option>
        <?php
        if ($result_usuarios->num_rows > 0) {
            while ($usuario = $result_usuarios->fetch_assoc()) {
                $selected = ($usuario['id_usuario'] == $id_usuario) ? "selected" : "";
                echo "<option value='" . $usuario['id_usuario'] . "' $selected>" . htmlspecialchars($usuario['nome']) . "</option>";
            }
        }
        ?>
    </select>
    <button type="submit">Mostrar Histórico</button>
</form>

<?php if ($id_usuario > 0): ?>
    <h3>Empréstimos de: 
        <?php
        // Mostrar o nome do usuário selecionado
        foreach ($result_usuarios as $usuario) {
            if ($usuario['id_usuario'] == $id_usuario) {
                echo htmlspecialchars($usuario['nome']);
                break;
            }
        }
        ?>
    </h3>

    <?php if (count($emprestimos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Empréstimo</th>
                    <th>Livro</th>
                    <th>Data Empréstimo</th>
                    <th>Data Prevista Devolução</th>
                    <th>Data Devolução</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprestimos as $empr): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($empr['id']); ?></td>
                        <td><?php echo htmlspecialchars($empr['livro_emprestado']); ?></td>
                        <td><?php echo htmlspecialchars($empr['data_emprestimo']); ?></td>
                        <td><?php echo htmlspecialchars($empr['data_prevista_devolucao']); ?></td>
                        <td><?php echo htmlspecialchars($empr['data_devolucao'] ?: 'Não devolvido'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há empréstimos registrados para este usuário.</p>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
