<?php
// public/admin/index.php (Login do Admin)
session_start();
require_once __DIR__ . '/../../includes/db.php'; // Ajuste o caminho
require_once __DIR__ . '/../../includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: dashboard.php');
        exit();
    } else {
        $message = '<div class="message error">Usuário ou senha inválidos.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Curiosidades na T.I</title>
    <link rel="stylesheet" href="/curiosidades-na-ti/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #e74c3c;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h2 {
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .login-container .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .login-container .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        .login-container .form-group input[type="text"],
        .login-container .form-group input[type="password"] {
            width: calc(100% - 22px); /* Ajuste para o padding */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1.1em;
        }
        .login-container button {
            background-color: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .login-container button:hover {
            background-color: #2980b9;
        }
        .login-container .message {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Administrativo</h2>
        <?php echo $message; ?>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>