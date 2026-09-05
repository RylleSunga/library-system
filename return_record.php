<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';

$borrowedId = filter_input(INPUT_POST, 'borrowed_id', FILTER_VALIDATE_INT);
if ($borrowedId) {
    $statement = $pdo->prepare('SELECT books.title FROM borrowed_books JOIN books ON books.id = borrowed_books.book_id WHERE borrowed_books.id = ? AND borrowed_books.user_id = ? AND borrowed_books.returned_at IS NULL');
    $statement->execute([$borrowedId, $_SESSION['user_id']]);
    $book = $statement->fetch();
    $statement = $pdo->prepare('UPDATE borrowed_books SET returned_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ? AND returned_at IS NULL');
    $statement->execute([$borrowedId, $_SESSION['user_id']]);
    if ($book) {
        $_SESSION['flash_message'] = ['type' => 'success', 'text' => "\"{$book['title']}\" has been returned."];
    }
}

redirect('mybooks.php');
