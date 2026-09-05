<?php
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/validation.php';
require __DIR__ . '/includes/admin_auth.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book = [
        'title' => trim($_POST['title'] ?? ''),
        'author' => trim($_POST['author'] ?? ''),
        'image' => trim($_POST['image'] ?? ''),
        'summary' => trim($_POST['summary'] ?? ''),
        'genre' => trim($_POST['genre'] ?? '')
    ];
    $errors = validateBook($book);

    if (!$errors) {
        if ($book['image'] !== '' && !str_contains($book['image'], '/')) {
            $book['image'] = 'assets/images/' . $book['image'];
        }
        if ($book['image'] !== '' && !str_contains($book['image'], '/')) {
            $book['image'] = 'assets/images/' . $book['image'];
        }
        $statement = $pdo->prepare('INSERT INTO books (title, author, image, summary, genre) VALUES (?, ?, ?, ?, ?)');
        $statement->execute([$book['title'], $book['author'], $book['image'], $book['summary'], $book['genre']]);
        redirect('view_records.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Add Book</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="admin-form-page">
<section class="admin-form-shell"><div class="admin-form-heading"><div><p class="panel-kicker">Catalog management</p><h2>Add a new book</h2><p>Create a complete record for the library collection.</p></div><a href="admin.php"><i class="fa-solid fa-arrow-left"></i> Back to admin</a></div>
<?php foreach ($errors as $error): ?><p class="form-error"><?= e($error) ?></p><?php endforeach; ?>
<form method="post" class="admin-book-form">
<input name="title" placeholder="Book title" required>
<input name="author" placeholder="Author" required>
<input name="image" placeholder="Image path or URL">
<input name="genre" placeholder="Genre">
<textarea name="summary" placeholder="Summary"></textarea>
<button type="submit">Save Book</button>
</form>
</section>
</body>
</html>
