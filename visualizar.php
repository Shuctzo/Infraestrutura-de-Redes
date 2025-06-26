<!-- visualizar.php -->
<?php
$conn = new mysqli("localhost", "root", "", "hospital_marzagaotech");
if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status && in_array($status, ['funcionando', 'manutencao', 'descartado'])) {
  $sql = "SELECT * FROM equipamentos WHERE status = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $status);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $sql = "SELECT * FROM equipamentos";
  $result = $conn->query($sql);
}

if ($result->num_rows > 0) {
  echo "<table class='tabela-equipamentos'>";
  echo "<tr><th>ID</th><th>Nome</th><th>Setor</th><th>Status</th><th>Descrição</th></tr>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['nome'] . "</td>";
    echo "<td>" . $row['setor'] . "</td>";
    echo "<td class='status-" . $row['status'] . "'>" . ucfirst($row['status']) . "</td>";
    echo "<td>" . $row['descricao'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "<p>Nenhum equipamento encontrado.</p>";
}

$conn->close();
?>