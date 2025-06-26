<!-- login.php -->
<?php
// Conecta ao banco de dados
$conn = new mysqli("localhost", "root", "", "hospital_marzagaotech");

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta SQL com proteção contra SQL Injection
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    if (password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido
        session_start();
        $_SESSION['usuario'] = $usuario['nome'];
        header("Location: ../painel.html");
        exit();
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}

$conn->close();
?>