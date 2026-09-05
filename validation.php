<?php
function validateBook(array $input): array
{
    $errors = [];

    if (trim($input['title'] ?? '') === '') {
        $errors[] = 'Title is required.';
    }

    if (trim($input['author'] ?? '') === '') {
        $errors[] = 'Author is required.';
    }

    return $errors;
}
