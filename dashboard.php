<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';

$statement = $pdo->query('SELECT id, title, author, image, summary, genre FROM books ORDER BY created_at DESC');
$books = $statement->fetchAll();
$summary = [
	'total_books' => (int) $pdo->query('SELECT COUNT(*) FROM books')->fetchColumn(),
	'total_genres' => (int) $pdo->query("SELECT COUNT(DISTINCT NULLIF(TRIM(genre), '')) FROM books")->fetchColumn(),
	'borrowed_books' => (int) $pdo->query('SELECT COUNT(*) FROM borrowed_books WHERE returned_at IS NULL')->fetchColumn()
];
$genreStats = $pdo->query("SELECT COALESCE(NULLIF(TRIM(genre), ''), 'Other') AS genre, COUNT(*) AS total FROM books GROUP BY COALESCE(NULLIF(TRIM(genre), ''), 'Other') ORDER BY total DESC, genre")->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Library System - Dashboard</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<header class="navbar">
	<div class="archive-bar">INTERNET ARCHIVE</div>
	<div class="logo"><h1>Library System</h1></div>
	<nav><ul><li><a href="mybooks.html"><i class="fa-solid fa-book-bookmark"></i> My Books</a></li><li><a href="#genre-filter"><i class="fa-solid fa-layer-group"></i> Genres</a></li><li><a href="#analytics"><i class="fa-solid fa-chart-simple"></i> Analytics</a></li><li><a href="#about"><i class="fa-solid fa-circle-info"></i> About Us</a></li><li><a href="contact.php"><i class="fa-solid fa-envelope"></i> Contact</a></li></ul></nav>
	<div class="search-login"><form class="search-bar"><input type="text" placeholder="Search books, authors..."><button type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button></form><a href="logout.php" class="login-btn">Logout</a></div>
</header>
<section class="welcome"><p class="eyebrow">Welcome to Open Library</p><div class="welcome-cards"><div class="card"><i class="fa-solid fa-book-open-reader"></i><div><h3><?= e((string) $summary['total_books']) ?> Books</h3><p>In the library collection.</p></div></div><div class="card"><i class="fa-solid fa-layer-group"></i><div><h3><?= e((string) $summary['total_genres']) ?> Genres</h3><p>Available to explore.</p></div></div><div class="card"><i class="fa-solid fa-book-bookmark"></i><div><h3><?= e((string) $summary['borrowed_books']) ?> Borrowed</h3><p>Currently checked out.</p></div></div></div></section>
<section class="book-section"><div class="library-heading"><h2>Library Books</h2><label for="genre-filter">Filter by genre</label><select id="genre-filter"><option value="">All genres</option><?php $genres = array_unique(array_filter(array_map(fn ($book) => trim($book['genre'] ?? ''), $books))); sort($genres); foreach ($genres as $genre): ?><option value="<?= e($genre) ?>"><?= e($genre) ?></option><?php endforeach; ?></select></div><div class="book-grid"><?php foreach ($books as $book): ?><?php $image = $book['image'] ?? ''; if ($image !== '' && !str_contains($image, '/')) { $image = 'assets/images/' . $image; } ?><div class="book-card" data-title="<?= e($book['title']) ?>" data-author="<?= e($book['author']) ?>" data-image="<?= e($image) ?>" data-summary="<?= e($book['summary'] ?? '') ?>" data-genre="<?= e($book['genre'] ?? '') ?>"><img src="<?= e($image) ?>" alt="<?= e($book['title']) ?>" onerror="this.src='https://placehold.co/190x275/e8e3d3/4b4841?text=Book+Cover';"><h3><?= e($book['title']) ?></h3><p>by <?= e($book['author']) ?></p><?php if ($book['genre']): ?><p><em><?= e($book['genre']) ?></em></p><?php endif; ?><form method="post" action="borrow_record.php"><input type="hidden" name="book_id" value="<?= e((string) $book['id']) ?>"><button type="submit">Borrow</button></form></div><?php endforeach; ?></div><p id="no-results" hidden>No books match your filters.</p><?php if (!$books): ?><p>No books have been added yet.</p><?php endif; ?></section>
<section id="analytics" class="dashboard-panel"><div><p class="panel-kicker">Collection intelligence</p><h2>Analytics</h2><p class="panel-muted">A quick view of how your library is organized.</p></div><div class="analytics-grid"><div class="analytics-chart"><?php foreach ($genreStats as $stat): ?><div class="genre-stat"><div><strong><?= e($stat['genre']) ?></strong><span><?= e((string) $stat['total']) ?> books</span></div><div class="stat-track"><span style="width: <?= e((string) round(((int) $stat['total'] / max(1, $summary['total_books'])) * 100)) ?>%"></span></div></div><?php endforeach; ?></div><div class="insight-card"><i class="fa-solid fa-lightbulb"></i><h3>Collection insight</h3><p>Your most represented genre is <strong><?= e($genreStats[0]['genre'] ?? 'not available') ?></strong>.</p><a href="#genre-filter">Explore genres <i class="fa-solid fa-arrow-right"></i></a></div></div></section>
<section id="about" class="dashboard-panel split-panel"><div><p class="panel-kicker">About the system</p><h2>Built for curious readers</h2></div><p>Library System keeps your collection organized, searchable, and easy to share. Browse covers, inspect book details, borrow titles, and manage your reading list from one calm workspace.</p></section>
<section id="contact" class="dashboard-panel contact-panel"><div><p class="panel-kicker">Need a hand?</p><h2>Contact the library team</h2><p class="panel-muted">For catalog corrections, cover updates, or account help.</p></div><a class="contact-link" href="mailto:library@localhost">library@localhost <i class="fa-solid fa-arrow-up-right-from-square"></i></a></section>
<script src="assets/js/script.js/dashboard.js"></script>
</body>
</html>
