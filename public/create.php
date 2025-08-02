<?php
require_once __DIR__ . '/../php/db.php';

$errors = [];
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $year = intval($_POST['publication_year'] ?? 0);
    $genre = trim($_POST['genre'] ?? '');
    $summary = trim($_POST['summary'] ?? '');

    // Simple validation
    if ($title === '') {
        $errors[] = 'Title is required.';
    }
    if ($author === '') {
        $errors[] = 'Author is required.';
    }
    if ($year <= 0) {
        $errors[] = 'Publication year must be a positive number.';
    }
    if ($genre === '') {
        $errors[] = 'Genre is required.';
    }

    if (empty($errors)) {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare('INSERT INTO books (title, author, publication_year, genre, summary) VALUES (:title, :author, :year, :genre, :summary)');
            $stmt->execute([
                ':title' => $title,
                ':author' => $author,
                ':year' => $year,
                ':genre' => $genre,
                ':summary' => $summary,
            ]);
            // Regenerate XML to include new record
            ob_start();
            require_once __DIR__ . '/../php/generate_xml.php';
            ob_end_clean();
            // Redirect to list page
            header('Location: /index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Failed to insert record: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="nav">
        <a href="/index.php">Home</a>
        <a href="/create.php">Add Book</a>
        <a href="/filter.php">Filter/Search</a>
    </nav>
    <h1>Add a New Book</h1>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="" method="post" class="book-form">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>

        <label for="publication_year">Publication Year:</label>
        <input type="number" id="publication_year" name="publication_year" min="0" required>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required>

        <label for="summary">Summary:</label>
        <textarea id="summary" name="summary" rows="4"></textarea>

        <button type="submit">Create Book</button>
    </form>
</body>
</html>
