<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';

$bookId = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);
$borrowedTitle = '';
if ($bookId) {
    $statement = $pdo->prepare('SELECT id, title FROM books WHERE id = ?');
    $statement->execute([$bookId]);
    $book = $statement->fetch();
    if ($book) {
        $borrowedTitle = $book['title'];
        $statement = $pdo->prepare('SELECT id FROM borrowed_books WHERE user_id = ? AND book_id = ? AND returned_at IS NULL');
        $statement->execute([$_SESSION['user_id'], $bookId]);
        if (!$statement->fetch()) {
            $statement = $pdo->prepare('INSERT INTO borrowed_books (user_id, book_id) VALUES (?, ?)');
            $statement->execute([$_SESSION['user_id'], $bookId]);
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => "\"$borrowedTitle\" is now in your books."];
        } else {
            $_SESSION['flash_message'] = ['type' => 'info', 'text' => "\"$borrowedTitle\" is already in your books."];
        }
    }
}

redirect('mybooks.php');
