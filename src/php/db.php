<?php
/**
 * Database connection helper using PDO.
 *
 * Reads connection parameters from environment variables provided
 * by docker-compose:
 *  - DB_HOST: database host
 *  - DB_NAME: database name
 *  - DB_USER: database user
 *  - DB_PASS: database password
 */

class Database
{
    private static $instance = null;

    /**
     * Get a PDO instance (singleton).
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: 'db';
            $dbname = getenv('DB_NAME') ?: 'booksdb';
            $user = getenv('DB_USER') ?: 'books_user';
            $pass = getenv('DB_PASS') ?: 'books_pass';
            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // In production, consider logging this instead of displaying
                die('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}

?>
