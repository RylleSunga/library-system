<?php
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/admin_auth.php';

$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $statement = $pdo->prepare('SELECT * FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY created_at DESC');
    $term = "%$search%";
    $statement->execute([$term, $term]);
} else {
    $statement = $pdo->query('SELECT * FROM books ORDER BY created_at DESC');
}
$books = $statement->fetchAll();
?>
<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Book Records</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<section class="book-section">
<h2>Book Records</h2>
<form method="get"><input name="search" value="<?= e($search) ?>" placeholder="Search title or author"><button type="submit">Search</button></form>
<p><a href="add_record.php">Add a book</a></p>
<table><thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($books as $book): ?><tr><td><?= e((string) $book['id']) ?></td><td><?= e($book['title']) ?></td><td><?= e($book['author']) ?></td><td><?= e($book['genre'] ?? '') ?></td><td><a href="update_record.php?id=<?= e((string) $book['id']) ?>">Edit</a> <a href="delete_record.php?id=<?= e((string) $book['id']) ?>" onclick="return confirm('Delete this book?')">Delete</a></td></tr><?php endforeach; ?>
</tbody></table>
<?php if (!$books): ?><p>No records found.</p><?php endif; ?>
</section>
</body>
</html>
