<?php
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/validation.php';
require __DIR__ . '/includes/admin_auth.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    redirect('view_records.php');
}

$statement = $pdo->prepare('SELECT * FROM books WHERE id = ?');
$statement->execute([$id]);
$book = $statement->fetch();
if (!$book) {
    redirect('view_records.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book = array_merge($book, [
        'title' => trim($_POST['title'] ?? ''),
        'author' => trim($_POST['author'] ?? ''),
        'image' => trim($_POST['image'] ?? ''),
        'summary' => trim($_POST['summary'] ?? ''),
        'genre' => trim($_POST['genre'] ?? '')
    ]);
    $errors = validateBook($book);

    if (!$errors) {
        $statement = $pdo->prepare('UPDATE books SET title = ?, author = ?, image = ?, summary = ?, genre = ? WHERE id = ?');
        $statement->execute([$book['title'], $book['author'], $book['image'], $book['summary'], $book['genre'], $id]);
        redirect('view_records.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Update Book</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<section class="book-section">
<h2>Update Book Record</h2>
<?php foreach ($errors as $error): ?><p class="form-error"><?= e($error) ?></p><?php endforeach; ?>
<form method="post">
<input type="hidden" name="id" value="<?= e((string) $id) ?>">
<input name="title" value="<?= e($book['title']) ?>" placeholder="Book title" required>
<input name="author" value="<?= e($book['author']) ?>" placeholder="Author" required>
<input name="image" value="<?= e($book['image'] ?? '') ?>" placeholder="Image path or URL">
<input name="genre" value="<?= e($book['genre'] ?? '') ?>" placeholder="Genre">
<textarea name="summary" placeholder="Summary"><?= e($book['summary'] ?? '') ?></textarea>
<button type="submit">Update Book</button>
</form>
</section>
</body>
</html>
