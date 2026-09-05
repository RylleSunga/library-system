<?php
require __DIR__ . '/includes/admin_auth.php';
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';

$stats = [
    'books' => (int) $pdo->query('SELECT COUNT(*) FROM books')->fetchColumn(),
    'genres' => (int) $pdo->query("SELECT COUNT(DISTINCT NULLIF(TRIM(genre), '')) FROM books")->fetchColumn(),
    'borrowed' => (int) $pdo->query('SELECT COUNT(*) FROM borrowed_books WHERE returned_at IS NULL')->fetchColumn(),
    'users' => (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn()
];
$recentBooks = $pdo->query('SELECT title, author, genre, created_at FROM books ORDER BY created_at DESC LIMIT 6')->fetchAll();
$genreStats = $pdo->query("SELECT COALESCE(NULLIF(TRIM(genre), ''), 'Other') AS genre, COUNT(*) AS total FROM books GROUP BY COALESCE(NULLIF(TRIM(genre), ''), 'Other') ORDER BY total DESC, genre LIMIT 6")->fetchAll();
?>
<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Dashboard - Library System</title><link rel="stylesheet" href="assets/css/style.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></head>
<body class="admin-page">
<header class="navbar"><div class="archive-bar">LIBRARY OPERATIONS</div><div class="logo"><h1>Admin Console</h1></div><nav><ul><li><a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a></li><li><a href="#analytics"><i class="fa-solid fa-chart-simple"></i> Analytics</a></li><li><a href="add_record.php"><i class="fa-solid fa-plus"></i> Add Book</a></li><li><a href="view_records.php"><i class="fa-solid fa-table-list"></i> Manage Records</a></li></ul></nav><div class="search-login"><a href="logout.php" class="login-btn">Logout</a></div></header>
<main class="admin-main">
<section class="admin-hero"><div><p class="panel-kicker">Management overview</p><h2>Good morning, <?= e($_SESSION['username'] ?? 'Librarian') ?></h2><p>Keep the collection healthy, current, and easy to discover.</p></div><a class="admin-primary-link" href="add_record.php"><i class="fa-solid fa-plus"></i> Add new book</a></section>
<section class="admin-stats"><div class="admin-stat"><i class="fa-solid fa-book"></i><span>Total books</span><strong><?= e((string) $stats['books']) ?></strong></div><div class="admin-stat"><i class="fa-solid fa-layer-group"></i><span>Genres</span><strong><?= e((string) $stats['genres']) ?></strong></div><div class="admin-stat"><i class="fa-solid fa-book-open"></i><span>Currently borrowed</span><strong><?= e((string) $stats['borrowed']) ?></strong></div><div class="admin-stat"><i class="fa-solid fa-users"></i><span>Registered users</span><strong><?= e((string) $stats['users']) ?></strong></div></section>
<section id="analytics" class="admin-grid"><div class="admin-panel"><div class="panel-title"><div><p class="panel-kicker">Collection analytics</p><h2>Genre balance</h2></div><i class="fa-solid fa-chart-line"></i></div><?php foreach ($genreStats as $genre): ?><div class="admin-genre"><div><strong><?= e($genre['genre']) ?></strong><span><?= e((string) $genre['total']) ?> books</span></div><div class="admin-track"><span style="width: <?= e((string) round(((int) $genre['total'] / max(1, $stats['books'])) * 100)) ?>%"></span></div></div><?php endforeach; ?></div><div class="admin-panel admin-actions"><p class="panel-kicker">Quick actions</p><h2>Manage the library</h2><a href="add_record.php"><i class="fa-solid fa-plus"></i><span>Add a new book<small>Create a complete record</small></span></a><a href="view_records.php"><i class="fa-solid fa-magnifying-glass"></i><span>Search records<small>Find, edit, or delete books</small></span></a><a href="dashboard.php"><i class="fa-solid fa-eye"></i><span>Preview catalog<small>See the public dashboard</small></span></a></div></section>
<section class="admin-panel recent-panel"><div class="panel-title"><div><p class="panel-kicker">Latest activity</p><h2>Recently added books</h2></div><a href="view_records.php">View all records <i class="fa-solid fa-arrow-right"></i></a></div><div class="recent-table"><div class="recent-row recent-header"><span>Title</span><span>Author</span><span>Genre</span><span>Added</span></div><?php foreach ($recentBooks as $book): ?><div class="recent-row"><strong><?= e($book['title']) ?></strong><span><?= e($book['author']) ?></span><span><?= e($book['genre'] ?? 'Other') ?></span><time><?= e(date('M j, Y', strtotime($book['created_at']))) ?></time></div><?php endforeach; ?></div></section>
</main>
</body>
</html>
