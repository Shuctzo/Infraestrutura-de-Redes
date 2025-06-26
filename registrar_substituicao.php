<!-- registrar_substituicao.php -->
<?php
$conn = new mysqli("localhost", "root", "", "hospital_marzagaotech");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$equipamento_antigo = $_POST['equipamento_antigo'];
$equipamento_novo = $_POST['equipamento_novo'];
$setor = $_POST['setor'];
$motivo = $_POST['motivo'];

$sql = "INSERT INTO substituicoes (equipamento_antigo, equipamento_novo, setor, motivo) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $equipamento_antigo, $equipamento_novo, $setor, $motivo);

if ($stmt->execute()) {
    header("Location: ../painel.html");
    exit();
} else {
    echo "Erro ao registrar substituição: " . $conn->error;
}
$conn->close();
?>
