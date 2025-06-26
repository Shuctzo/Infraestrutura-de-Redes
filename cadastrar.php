<!-- cadastrar.php -->
<?php
// Conecta ao banco de dados
$conn = new mysqli("localhost", "root", "", "hospital_marzagaotech");

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$setor = $_POST['setor'];

// Prepara a SQL para inserir
$sql = "INSERT INTO usuarios (nome, email, senha, setor) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $senha, $setor);

if ($stmt->execute()) {
    header("Location: ../index.html");
    exit();
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>
