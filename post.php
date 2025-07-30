<?php
// public/post.php
require_once __DIR__ . '/../includes/header.php';

$post = null;
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $post = get_post_by_slug($slug);
    if ($post) {
        $page_title = $post['title'];
    }
}

if (!$post):
?>
    <section id="post-content">
        <h2>Post não encontrado</h2>
        <p>Parece que o post que você está procurando não existe ou foi removido.</p>
        <p><a href="/curiosidades-na-ti/public/index.php">Voltar para a Home</a></p>
    </section>
<?php
else:
?>
    <section id="post-content">
        <h1><?php echo escape($post['title']); ?></h1>
        <p class="post-meta">
            Publicado em <?php echo format_date($post['created_at']); ?> por <?php echo escape($post['author_name'] ?? 'Autor Desconhecido'); ?>
            <?php if (!empty($post['category_name'])): ?>
                em <a href="/curiosidades-na-ti/public/categorias.php?slug=<?php echo escape(generate_slug($post['category_name'])); ?>"><?php echo escape($post['category_name']); ?></a>
            <?php endif; ?>
        </p>
        <?php if (!empty($post['image'])): ?>
            <img src="/curiosidades-na-ti/public/uploads/<?php echo escape($post['image']); ?>" alt="<?php echo escape($post['title']); ?>">
        <?php endif; ?>
        <div class="post-body">
            <?php echo nl2br(escape($post['content'])); ?>
        </div>

        </section>

    <aside id="sidebar">
        <h3>Categorias</h3>
        <ul>
            <?php $categories = get_categories(); ?>
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
endif;
require_once __DIR__ . '/../includes/footer.php';
?>