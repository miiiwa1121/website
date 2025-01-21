<?php
$dsn = 'sqlite:' . __DIR__ . '/user.db';
$username = null;
$password = null;

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the users table exists, if not, create it
    $tableCheckQuery = "SELECT name FROM sqlite_master WHERE type='table' AND name='users'";
    $stmt = $pdo->query($tableCheckQuery);
    $tableExists = $stmt->fetchColumn();

    if (!$tableExists) {
        $createTableQuery = "
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $pdo->exec($createTableQuery);
    }

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
