<?php
include 'conexao.php';

$sql = "SELECT COUNT(*) AS total FROM livros";
$totalLivros = $conn->query($sql)->fetch_assoc()['total'];

$sql = "SELECT COUNT(*) AS total FROM livros WHERE status = 'disponivel'";
$livrosDisponiveis = $conn->query($sql)->fetch_assoc()['total'];

$sql = "SELECT COUNT(*) AS total FROM livros WHERE status = 'emprestado'";
$livrosEmprestados = $conn->query($sql)->fetch_assoc()['total'];

$dataHoje = date('Y-m-d');
$sql = "SELECT COUNT(*) AS total FROM emprestimos WHERE (data_devolucao IS NULL OR data_devolucao = '') AND data_prevista_devolucao < '$dataHoje'";
$emprestimosAtrasados = $conn->query($sql)->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
<meta charset="UTF-8" />
<title>Relatorio</title>
<style>
  body { font-family: 'Times New Roman', Times, serif; margin: 10px; }
  h1 { margin-bottom: 30px; }
  .estatisticas {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
    gap: 10px;
  }
  .card {
    background:rgba(224, 219, 166, 0.88);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(233, 6, 6, 0.89);
    text-align: center;
  }
  .card h2 {
    font-size: 48px;
    margin: 0;
    color: #333;
  }
  .card p {
    margin-top: 8px;
    font-weight: bold;
    color: #666;
  }
</style>
</head>
<body>

<h3>Dashboard com estatísticas rápidas</h3>

<div class="estatisticas">
  <div class="card">
    <h4><?php echo $livrosEmprestados; ?></h4>
    <p>Livros Emprestados</p>
  </div>

  <div class="card">
    <h4><?php echo $emprestimosAtrasados; ?></h4>
    <p>Livros Atrasados</p>
  </div>
</div>

</body>
</html>
