<?php
// includes/db.php

$host = 'localhost'; // Geralmente 'localhost' para ambiente local
$dbname = 'blog_curiosidades_ti'; // Nome do banco de dados que criamos
$user = 'root'; // Usuário do MySQL (padrão XAMPP/WAMP/MAMP)
$password = ''; // Senha do MySQL (padrão XAMPP/WAMP/MAMP, geralmente vazia)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retorna arrays associativos por padrão
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>