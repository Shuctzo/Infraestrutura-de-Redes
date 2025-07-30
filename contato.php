<?php
// public/contato.php
$page_title = 'Contato';
require_once __DIR__ . '/../includes/header.php';
?>

        <section id="post-content">
            <h2>Entre em Contato</h2>
            <p>Tem alguma sugestão, dúvida, ou quer colaborar com o Curiosidades na T.I? Fale conosco!</p>

            <form action="#" method="POST">
                <div class="form-group">
                    <label for="name">Seu Nome:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Seu E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Assunto:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Sua Mensagem:</label>
                    <textarea id="message" name="message" rows="8" required></textarea>
                </div>
                <button type="submit" class="button-primary">Enviar Mensagem</button>
            </form>

            <p style="margin-top: 20px;">Ou envie um e-mail diretamente para: contato@curiosidadesti.com</p>
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
require_once __DIR__ . '/../includes/footer.php';
?>