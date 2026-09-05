<?php
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/admin_auth.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $statement = $pdo->prepare('DELETE FROM books WHERE id = ?');
    $statement->execute([$id]);
}

redirect('view_records.php');
