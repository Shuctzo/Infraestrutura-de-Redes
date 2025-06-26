<!-- registrar_manutencao.php -->
<?php
$conn = new mysqli("localhost", "root", "", "hospital_marzagaotech");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$equipamento_id = $_POST['equipamento_id'];
$tecnico_id = $_POST['tecnico_id'];
$status_final = $_POST['status_final'];
$observacoes = $_POST['observacoes'];

$sql = "INSERT INTO manutencao (equipamento_id, tecnico_id, status_final, observacoes) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $equipamento_id, $tecnico_id, $status_final, $observacoes);

if ($stmt->execute()) {
    header("Location: ../painel.html");
    exit();
} else {
    echo "Erro ao registrar manutenção: " . $conn->error;
}
$conn->close();
?>