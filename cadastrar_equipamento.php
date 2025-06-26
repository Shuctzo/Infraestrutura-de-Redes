<!-- cadastrar_equipamento.php -->
<?php
$conn = new mysqli("localhost", "root", "", "hospital_marzagaotech");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$modelo = $_POST['modelo'];
$numero_serie = $_POST['numero_serie'];
$setor = $_POST['setor'];
$descricao = $_POST['descricao'];

$sql = "INSERT INTO equipamentos (nome, modelo, numero_serie, setor, descricao) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nome, $modelo, $numero_serie, $setor, $descricao);

if ($stmt->execute()) {
    header("Location: ../painel.html");
    exit();
} else {
    echo "Erro ao cadastrar equipamento: " . $conn->error;
}
$conn->close();
?>