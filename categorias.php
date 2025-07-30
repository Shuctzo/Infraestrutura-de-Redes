<?php
// public/categorias.php
require_once __DIR__ . '/../includes/header.php';

$selected_category = null;
$category_id = null;
$posts = [];

if (isset($_GET['slug'])) {
    $category_slug = $_GET['slug'];
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = :slug");
    $stmt->execute([':slug' => $category_slug]);
    $selected_category = $stmt->fetch();

    if ($selected_category) {
        $category_id = $selected_category['id'];
        $page_title = "Categoria: " . $selected_category['name'];
        $stmt_posts = $pdo->prepare("SELECT p.*, c.name as category_name, u.username as author_name
                                     FROM posts p
                                     LEFT JOIN categories c ON p.category_id = c.id
                                     LEFT JOIN users u ON p.author_id = u.id
                                     WHERE p.category_id = :category_id AND p.published = TRUE
                                     ORDER BY p.created_at DESC");
        $stmt_posts->execute([':category_id' => $category_id]);
        $posts = $stmt_posts->fetchAll();
    } else {
        $page_title = 'Categoria não encontrada';
    }
} else {
    $page_title = 'Todas as Categorias';
    $posts = get_posts(); // Se não houver slug, exibe todos os posts (pode-se ajustar para exibir apenas uma lista de categorias)
}

$categories = get_categories(); // Para exibir a lista de categorias na sidebar
?>

        <section id="latest-posts">
            <?php if ($selected_category): ?>
                <h2>Publicações na Categoria: <?php echo escape($selected_category['name']); ?></h2>
            <?php else: ?>
                <h2>Todas as Publicações</h2>
            <?php endif; ?>

            <div class="post-list">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <article class="post-card">
                            <?php if (!empty($post['image'])): ?>
                                <img src="/curiosidades-na-ti/public/uploads/<?php echo escape($post['image']); ?>" alt="<?php echo escape($post['title']); ?>">
                            <?php endif; ?>
                            <div class="post-card-content">
                                <h3><a href="/curiosidades-na-ti/public/post.php?slug=<?php echo escape($post['slug']); ?>"><?php echo escape($post['title']); ?></a></h3>
                                <p class="post-meta">
                                    Publicado em <?php echo format_date($post['created_at']); ?> por <?php echo escape($post['author_name'] ?? 'Autor Desconhecido'); ?>
                                    <?php if (!empty($post['category_name'])): ?>
                                        em <a href="/curiosidades-na-ti/public/categorias.php?slug=<?php echo escape(generate_slug($post['category_name'])); ?>"><?php echo escape($post['category_name']); ?></a>
                                    <?php endif; ?>
                                </p>
                                <p><?php echo substr(escape($post['content']), 0, 150); ?>...</p>
                                <a href="/curiosidades-na-ti/public/post.php?slug=<?php echo escape($post['slug']); ?>" class="read-more">Leia Mais</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma publicação encontrada nesta categoria ainda.</p>
                <?php endif; ?>
            </div>
        </section>

        <aside id="sidebar">
            <h3>Categorias</h3>
            <ul>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <li><a href="/curiosidades-na-ti/public/categorias.php?slug=<?php echo escape($category['slug']); ?>"><?php echo escape($category['name']); ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Nenhuma categoria encontrada.</li>
                <?php endif; ?>
            </ul>

            <h3>Assine nossa Newsletter</h3>
            <form action="#" method="POST">
                <input type="email" placeholder="Seu melhor e-mail" required>
                <button type="submit">Assinar</button>
            </form>
        </aside>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>