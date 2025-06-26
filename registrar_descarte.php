<!-- registrar_descarte.php -->
<?php
$conn = new mysqli("localhost", "root", "", "hospital_marzagaotech");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$equipamento_id = $_POST['equipamento_id'];
$responsavel_id = $_POST['responsavel_id'];
$motivo = $_POST['motivo'];

$sql = "INSERT INTO descartes (equipamento_id, motivo, responsavel_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $equipamento_id, $motivo, $responsavel_id);

if ($stmt->execute()) {
    header("Location: ../painel.html");
    exit();
} else {
    echo "Erro ao registrar descarte: " . $conn->error;
}
$conn->close();
?>