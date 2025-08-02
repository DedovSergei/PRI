<?php
/**
 * Simple API endpoint that returns all books as JSON.
 */
require_once __DIR__ . '/../../src/php/db.php';
$pdo = Database::getConnection();

header('Content-Type: application/json; charset=utf-8');

try {
    $stmt = $pdo->query('SELECT id, title, author, publication_year, genre, summary FROM books ORDER BY id');
    $books = $stmt->fetchAll();
    echo json_encode($books);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
