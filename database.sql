CREATE DATABASE IF NOT EXISTS library_system;
USE library_system;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS books (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    image VARCHAR(500) DEFAULT NULL,
    summary TEXT,
    genre VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS borrowed_books (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    book_id INT UNSIGNED NOT NULL,
    borrowed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    returned_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_borrowed_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_borrowed_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

INSERT INTO books (title, author, image, summary, genre)
SELECT 'The Hobbit', 'J.R.R. Tolkien', 'assets/images/hobbit.jpg', 'Bilbo Baggins goes on an epic adventure.', 'Fantasy'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'The Hobbit');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Atomic Habits', 'James Clear', 'assets/images/atomic_habits.jpg', 'A practical guide to building good habits and breaking bad ones through small, consistent changes that compound into success.', 'Self-Help'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Atomic Habits');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'The 7 Habits of Highly Effective People', 'Stephen R. Covey', 'assets/images/seven_habits.jpg', 'A timeless framework for personal and professional effectiveness, focusing on principles like proactivity, prioritization, and synergy.', 'Self-Help'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'The 7 Habits of Highly Effective People');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'The Power of Now', 'Eckhart Tolle', 'assets/images/power_of_now.jpg', 'A spiritual guide to living fully in the present moment, freeing yourself from past regrets and future anxieties.', 'Self-Help / Spirituality'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'The Power of Now');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Dune', 'Frank Herbert', 'assets/images/dune.jpg', 'A sweeping saga set on the desert planet Arrakis, where young Paul Atreides must fulfill his destiny amid politics, religion, and ecology.', 'Science Fiction'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Dune');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Jurassic Park', 'Michael Crichton', 'assets/images/jurassic_park.jpg', 'Genetic engineering brings dinosaurs back to life in a theme park, but chaos erupts when the creatures escape, raising ethical questions about science and ambition.', 'Science Fiction / Thriller'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Jurassic Park');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Fahrenheit 451', 'Ray Bradbury', 'assets/images/fahrenheit_451.jpg', 'In a future where books are banned and burned, fireman Guy Montag begins to question society and seeks truth through literature.', 'Science Fiction / Dystopia'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Fahrenheit 451');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Harry Potter and the Sorcerer''s Stone', 'J.K. Rowling', 'assets/images/harry_potter_sorcerers_stone.jpg', 'This first book in the Harry Potter series introduces readers to the magical world of Hogwarts.', 'Fantasy'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Harry Potter and the Sorcerer''s Stone');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Circe', 'Madeline Miller', 'assets/images/circe.jpg', 'Circe reimagines the life of the Greek goddess known for her witchcraft.', 'Mythological Fantasy'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Circe');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Naruto, Vol. 1: Uzumaki Naruto', 'Masashi Kishimoto', 'assets/images/naruto_vol1.jpg', 'The first volume introduces Naruto Uzumaki, a mischievous orphan ostracized by his village because he carries the Nine-Tailed Fox spirit inside him. Determined to prove his worth and become Hokage, Naruto begins his training as a ninja. Along the way, he forms bonds with teammates Sasuke and Sakura, and his teacher Kakashi. The story blends humor, action, and heartfelt themes of perseverance and acceptance, setting the stage for one of the most popular shonen series ever.', 'Anime / Manga (Shonen)'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Naruto, Vol. 1: Uzumaki Naruto');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'One Piece, Vol. 1: Romance Dawn', 'Eiichiro Oda', 'assets/images/one_piece_vol1.jpg', 'Monkey D. Luffy, a boy who gains rubber-like powers after eating a Devil Fruit, sets out to become King of the Pirates. In this first volume, he begins gathering his crew and embarks on his quest for the legendary treasure known as the One Piece. With its mix of comedy, epic battles, and themes of freedom and loyalty, One Piece has become the longest-running and most beloved adventure manga worldwide.', 'Anime / Manga (Adventure)'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'One Piece, Vol. 1: Romance Dawn');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Attack on Titan, Vol. 1', 'Hajime Isayama', 'assets/images/attack_on_titan_vol1.jpg', 'Humanity lives within giant walled cities to protect themselves from Titans, monstrous humanoid creatures that devour humans. When the Colossal Titan breaches the wall, Eren Yeager, Mikasa Ackerman, and Armin Arlert vow to fight back. This first volume sets the stage for a gripping saga of survival, mystery, and rebellion, exploring themes of fear, freedom, and the cost of war.', 'Anime / Manga (Dark Fantasy)'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Attack on Titan, Vol. 1');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Death Note, Vol. 1: Boredom', 'Tsugumi Ohba & Takeshi Obata', 'assets/images/death_note_vol1.jpg', 'High school student Light Yagami discovers a mysterious notebook that allows him to kill anyone whose name he writes in it. Believing he can rid the world of evil, Light begins a crusade to become a god-like figure. However, his actions attract the attention of the genius detective known only as L. This first volume sets up a tense battle of wits between two brilliant minds, exploring morality, justice, and corruption.', 'Anime / Manga (Psychological Thriller)'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Death Note, Vol. 1: Boredom');

INSERT INTO books (title, author, image, summary, genre)
SELECT 'Demon Slayer: Kimetsu no Yaiba, Vol. 1', 'Koyoharu Gotouge', 'assets/images/demon_slayer_vol1.jpg', 'Tanjiro Kamado, a kind-hearted boy living in the mountains, returns home to find his family slaughtered by demons. His sister Nezuko survives but is transformed into a demon herself. Determined to save her and avenge his family, Tanjiro joins the Demon Slayer Corps. The first volume introduces a world of breathtaking sword fights, emotional struggles, and the bond between siblings that drives the entire series.', 'Anime / Manga (Action / Dark Fantasy)'
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Demon Slayer: Kimetsu no Yaiba, Vol. 1');
