<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';

$statement = $pdo->prepare('SELECT borrowed_books.id, books.title, books.author, books.image, books.genre, books.summary, borrowed_books.borrowed_at FROM borrowed_books JOIN books ON books.id = borrowed_books.book_id WHERE borrowed_books.user_id = ? AND borrowed_books.returned_at IS NULL ORDER BY borrowed_books.borrowed_at DESC');
$statement->execute([$_SESSION['user_id']]);
$borrowedBooks = $statement->fetchAll();
$flashMessage = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);
?>
<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>My Books</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<section class="book-section">
<h2>My Borrowed Books</h2>
<p><a href="dashboard.php">Back to dashboard</a></p>
<?php if ($flashMessage): ?><div class="flash-message <?= e($flashMessage['type']) ?>" role="status"><?= e($flashMessage['text']) ?></div><?php endif; ?>
<?php if (!$borrowedBooks): ?><p>You have no borrowed books.</p><?php else: ?>
<div class="book-grid my-books-grid">
<?php foreach ($borrowedBooks as $book): ?>
<div class="book-card borrowed-card"><img src="<?= e($book['image'] ?? '') ?>" alt="<?= e($book['title']) ?>" onerror="this.src='https://placehold.co/190x275/e8e3d3/4b4841?text=Book+Cover';"><h3><?= e($book['title']) ?></h3><p>by <?= e($book['author']) ?></p><p><em><?= e($book['genre'] ?? '') ?></em></p><p class="book-summary"><?= e($book['summary'] ?? 'No summary available.') ?></p><p class="borrowed-date">Borrowed on<br><strong><?= e(date('F j, Y \a\t g:i A', strtotime($book['borrowed_at']))) ?></strong></p><form method="post" action="return_record.php"><input type="hidden" name="borrowed_id" value="<?= e((string) $book['id']) ?>"><button type="submit">Return</button></form></div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>
</body>
</html>
