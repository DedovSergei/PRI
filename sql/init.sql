-- Create table for books
CREATE TABLE IF NOT EXISTS books (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publication_year INT NOT NULL,
    genre VARCHAR(100) NOT NULL,
    summary TEXT
) ENGINE=InnoDB;

-- Insert some sample rows
INSERT INTO books (title, author, publication_year, genre, summary) VALUES
    ('1984', 'George Orwell', 1949, 'Dystopian', 'A chilling depiction of a totalitarian regime that uses surveillance and propaganda to control citizens.'),
    ('To Kill a Mockingbird', 'Harper Lee', 1960, 'Classic', 'A novel set in the American South that tackles themes of racial injustice and moral growth.'),
    ('Pride and Prejudice', 'Jane Austen', 1813, 'Romance', 'A witty exploration of manners, upbringing, morality, and marriage in early 19th century England.'),
    ('The Hobbit', 'J.R.R. Tolkien', 1937, 'Fantasy', 'A prelude to the Lord of the Rings trilogy featuring Bilbo Baggins and his unexpected journey.'),
    ('The Catcher in the Rye', 'J.D. Salinger', 1951, 'Literary Fiction', 'A narrative following Holden Caulfield’s experiences in New York City as he grapples with adolescence.');
