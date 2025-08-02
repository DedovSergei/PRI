<?php
require_once __DIR__ . '/../php/db.php';

$pdo = Database::getConnection();
$errors = [];

// Ensure an ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid book ID');
}

$id = (int)$_GET['id'];

// Fetch existing data
try {
    $stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $book = $stmt->fetch();
    if (!$book) {
        die('Book not found');
    }
} catch (PDOException $e) {
    die('Error fetching book: ' . $e->getMessage());
}

// Handle update on POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $year = intval($_POST['publication_year'] ?? 0);
    $genre = trim($_POST['genre'] ?? '');
    $summary = trim($_POST['summary'] ?? '');

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
            $update = $pdo->prepare('UPDATE books SET title = :title, author = :author, publication_year = :year, genre = :genre, summary = :summary WHERE id = :id');
            $update->execute([
                ':title' => $title,
                ':author' => $author,
                ':year' => $year,
                ':genre' => $genre,
                ':summary' => $summary,
                ':id' => $id,
            ]);
            // Regenerate XML
            ob_start();
            require_once __DIR__ . '/../php/generate_xml.php';
            ob_end_clean();
            header('Location: /index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Update failed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="nav">
        <a href="/index.php">Home</a>
        <a href="/create.php">Add Book</a>
        <a href="/filter.php">Filter/Search</a>
    </nav>
    <h1>Edit Book #<?php echo htmlspecialchars($id); ?></h1>
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
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

        <label for="publication_year">Publication Year:</label>
        <input type="number" id="publication_year" name="publication_year" value="<?php echo htmlspecialchars($book['publication_year']); ?>" min="0" required>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>" required>

        <label for="summary">Summary:</label>
        <textarea id="summary" name="summary" rows="4"><?php echo htmlspecialchars($book['summary']); ?></textarea>

        <button type="submit">Update Book</button>
    </form>
</body>
</html>
