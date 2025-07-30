<?php
// includes/functions.php

function get_posts($limit = null) {
    global $pdo;
    $sql = "SELECT p.*, c.name as category_name, u.username as author_name
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            WHERE p.published = TRUE
            ORDER BY p.created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function get_post_by_slug($slug) {
    global $pdo;
    $sql = "SELECT p.*, c.name as category_name, u.username as author_name
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            WHERE p.slug = :slug AND p.published = TRUE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

function get_categories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    return $stmt->fetchAll();
}

function format_date($date_string) {
    $date = new DateTime($date_string);
    return $date->format('d de F de Y');
}

// Para segurança, evitar XSS
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Função para verificar se o usuário está logado (para o admin)
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Função para verificar se o usuário é admin
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Redirecionar se não estiver logado ou não for admin
function redirect_if_not_admin() {
    if (!is_logged_in() || !is_admin()) {
        header('Location: /curiosidades-na-ti/public/admin/index.php'); // Ajuste o caminho conforme sua estrutura
        exit();
    }
}

// Gerar slugs (URL amigáveis)
function generate_slug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^\w\s-]/', '', $text); // Remove caracteres não alfanuméricos exceto espaços e hifens
    $text = preg_replace('/\s+/', '-', $text);    // Substitui espaços por hifens
    $text = trim($text, '-');                     // Remove hifens extras no início/fim
    return $text;
}

?>