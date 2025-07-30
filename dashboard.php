<?php
// public/admin/dashboard.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
redirect_if_not_admin(); // Redireciona se não for admin

$page_title = 'Dashboard Admin';
require_once __DIR__ . '/../../includes/header.php'; // Usaremos o header normal, mas com algumas modificações no CSS para o admin

// Conte posts, categorias, etc.
$stmt_posts_count = $pdo->query("SELECT COUNT(*) FROM posts");
$total_posts = $stmt_posts_count->fetchColumn();

$stmt_categories_count = $pdo->query("SELECT COUNT(*) FROM categories");
$total_categories = $stmt_categories_count->fetchColumn();
?>
<style>
    /* Estilos específicos para o painel admin */
    main {
        flex-direction: column; /* Colunas empilhadas no admin */
    }
    .admin-container {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        width: 100%;
        margin-top: 20px;
    }
    .admin-menu ul {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    .admin-menu ul li {
        background-color: #3498db;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .admin-menu ul li:hover {
        background-color: #2980b9;
    }
    .admin-menu ul li a {
        display: block;
        padding: 15px 20px;
        color: #fff;
        text-decoration: none;
        font-weight: bold;
    }
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    .stat-card {
        background: #f0f0f0;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 1px 5px rgba(0,0,0,0.05);
    }
    .stat-card h4 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 1.2rem;
    }
    .stat-card p {
        font-size: 2.5rem;
        font-weight: bold;
        color: #e74c3c;
    }
</style>

<div class="admin-container">
    <h2>Bem-vindo, <?php echo escape($_SESSION['username']); ?>!</h2>

    <nav class="admin-menu">
        <ul>
            <li><a href="posts.php">Gerenciar Posts</a></li>
            <li><a href="categories.php">Gerenciar Categorias</a></li>
            <li><a href="users.php">Gerenciar Usuários</a></li>
            <li><a href="settings.php">Configurações</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>

    <h3>Estatísticas Rápidas</h3>
    <div class="stats-cards">
        <div class="stat-card">
            <h4>Total de Posts</h4>
            <p><?php echo $total_posts; ?></p>
        </div>
        <div class="stat-card">
            <h4>Total de Categorias</h4>
            <p><?php echo $total_categories; ?></p>
        </div>
        </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>