<?php
// public/index.php
$page_title = 'Home';
require_once __DIR__ . '/../includes/header.php';

$posts = get_posts(6); // Pega os 6 posts mais recentes
$categories = get_categories();
?>

        <section id="latest-posts">
            <h2>Últimas Publicações</h2>
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
                    <p>Nenhuma publicação encontrada ainda.</p>
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