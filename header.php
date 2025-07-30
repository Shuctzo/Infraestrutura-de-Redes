<?php
// includes/header.php
// Garante que a sessão seja iniciada para acesso a $_SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? escape($page_title) . ' | Curiosidades na T.I' : 'Curiosidades na T.I - Seu Blog de Tecnologia'; ?></title>
    <link rel="stylesheet" href="/curiosidades-na-ti/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="/curiosidades-na-ti/public/index.php">Curiosidades na T.I</a></h1>
            <nav>
                <ul>
                    <li><a href="/curiosidades-na-ti/public/index.php">Home</a></li>
                    <li><a href="/curiosidades-na-ti/public/categorias.php">Categorias</a></li>
                    <li><a href="/curiosidades-na-ti/public/sobre.php">Sobre</a></li>
                    <li><a href="/curiosidades-na-ti/public/contato.php">Contato</a></li>
                    <?php if (is_logged_in()): ?>
                        <li><a href="/curiosidades-na-ti/public/admin/dashboard.php">Painel Admin</a></li>
                        <li><a href="/curiosidades-na-ti/public/admin/logout.php">Sair</a></li>
                    <?php else: ?>
                        <li><a href="/curiosidades-na-ti/public/admin/index.php">Login Admin</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">