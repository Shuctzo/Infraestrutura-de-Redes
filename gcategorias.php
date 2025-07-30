<?php
// public/admin/categories.php
session_start();
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
redirect_if_not_admin();

$page_title = 'Gerenciar Categorias';
$message = '';

// Lógica para adicionar/editar/excluir categorias
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Adicionar Categoria
        if ($action === 'add_category') {
            $name = $_POST['name'];
            $slug = generate_slug($name);

            // Verificar se a categoria já existe
            $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE slug = :slug");
            $stmt_check->execute([':slug' => $slug]);
            if ($stmt_check->fetchColumn() > 0) {
                $message = '<div class="message error">Categoria com este nome já existe.</div>';
            } else {
                $stmt = $pdo->prepare("INSERT INTO categories (name, slug) VALUES (:name, :slug)");
                if ($stmt->execute([':name' => $name, ':slug' => $slug])) {
                    $message = '<div class="message success">Categoria adicionada com sucesso!</div>';
                } else {
                    $message = '<div class="message error">Erro ao adicionar categoria.</div>';
                }
            }
        }

        // Editar Categoria
        if ($action === 'edit_category') {
            $id = $_POST['category_id'];
            $name = $_POST['name'];
            $slug = generate_slug($name);

            // Verificar se o novo slug já existe para outra categoria
            $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE slug = :slug AND id != :id");
            $stmt_check->execute([':slug' => $slug, ':id' => $id]);
            if ($stmt_check->fetchColumn() > 0) {
                $message = '<div class="message error">Categoria com este nome já existe.</div>';
            } else {
                $stmt = $pdo->prepare("UPDATE categories SET name = :name, slug = :slug WHERE id = :id");
                if ($stmt->execute([':name' => $name, ':slug' => $slug, ':id' => $id])) {
                    $message = '<div class="message success">Categoria atualizada com sucesso!</div>';
                } else {
                    $message = '<div class="message error">Erro ao atualizar categoria.</div>';
                }
            }
        }

        // Excluir Categoria
        if ($action === 'delete_category') {
            $id = $_POST['category_id'];

            // Opcional: Você pode querer verificar se existem posts associados a esta categoria
            // e impedir a exclusão ou reassociá-los a uma categoria padrão.
            // Por simplicidade, onDelete SET NULL na FK resolverá para este exemplo.

            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
            if ($stmt->execute([':id' => $id])) {
                $message = '<div class="message success">Categoria excluída com sucesso!</div>';
            } else {
                $message = '<div class="message error">Erro ao excluir categoria.</div>';
            }
        }
    }
}

// Obter categorias para exibição
$categories = get_categories();

// Verificar se estamos editando
$edit_category = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute([':id' => $category_id]);
    $edit_category = $stmt->fetch();
    if (!$edit_category) {
        $message = '<div class="message error">Categoria para edição não encontrada.</div>';
    }
}

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="admin-container">
    <h2><?php echo $edit_category ? 'Editar Categoria' : 'Adicionar Nova Categoria'; ?></h2>
    <?php echo $message; ?>

    <form action="categories.php" method="POST">
        <input type="hidden" name="action" value="<?php echo $edit_category ? 'edit_category' : 'add_category'; ?>">
        <?php if ($edit_category): ?>
            <input type="hidden" name="category_id" value="<?php echo escape($edit_category['id']); ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="name">Nome da Categoria:</label>
            <input type="text" id="name" name="name" value="<?php echo $edit_category ? escape($edit_category['name']) : ''; ?>" required>
        </div>

        <button type="submit" class="button-primary"><?php echo $edit_category ? 'Atualizar Categoria' : 'Adicionar Categoria'; ?></button>
        <?php if ($edit_category): ?>
            <a href="categories.php" class="button-danger" style="margin-left: 10px;">Cancelar Edição</a>
        <?php endif; ?>
    </form>

    <h2 style="margin-top: 40px;">Categorias Existentes</h2>
    <?php if (!empty($categories)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Slug</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo escape($category['id']); ?></td>
                        <td><?php echo escape($category['name']); ?></td>
                        <td><?php echo escape($category['slug']); ?></td>
                        <td>
                            <a href="categories.php?action=edit&id=<?php echo escape($category['id']); ?>">Editar</a>
                            <form action="categories.php" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria? Isso pode afetar posts associados.');">
                                <input type="hidden" name="action" value="delete_category">
                                <input type="hidden" name="category_id" value="<?php echo escape($category['id']); ?>">
                                <button type="submit" class="button-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma categoria encontrada.</p>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>