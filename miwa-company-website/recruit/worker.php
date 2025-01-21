<?php
// データベース接続とテーブル作成
$db = new SQLite3('worker.db');
$db->exec("CREATE TABLE IF NOT EXISTS applications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    email TEXT,
    phone TEXT,
    position TEXT,
    message TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// フォーム送信の処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = SQLite3::escapeString($_POST['name']);
    $email = SQLite3::escapeString($_POST['email']);
    $phone = SQLite3::escapeString($_POST['phone']);
    $position = SQLite3::escapeString($_POST['position']);
    $message = SQLite3::escapeString($_POST['message']);

    $stmt = $db->prepare("INSERT INTO applications (name, email, phone, position, message) VALUES (:name, :email, :phone, :position, :message)");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
    $stmt->bindValue(':position', $position, SQLITE3_TEXT);
    $stmt->bindValue(':message', $message, SQLITE3_TEXT);

    $result = $stmt->execute();

    if ($result) {
        // 応募成功の場合、新しいページにリダイレクト
        header("Location: success.php");
        exit;
    } else {
        $error_message = "エラーが発生しました。もう一度お試しください。";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>株式会社三輪 - 求人応募</title>
    <style>
        /* 応募フォーム用のスタイル */
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        label, input, textarea {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>株式会社三輪</h1>
    </header>

    <main>
        <section id="apply">
            <h2>求人応募</h2>
            <?php
            if (isset($error_message)) {
                echo "<div class='message error'>$error_message</div>";
            }
            ?>
            <form method="post" action="worker.php">
                <label for="name">お名前：</label>
                <input type="text" id="name" name="name" required>

                <label for="email">メールアドレス：</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">電話番号：</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="position">希望職種：</label>
                <input type="text" id="position" name="position" required>

                <label for="message">志望動機：</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <input type="submit" value="応募する">
            </form>
            <!-- トップページに戻るボタンを追加 -->
            <a href="../index.html" class="back-button">トップページに戻る</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 株式会社三輪 All Rights Reserved.</p>
    </footer>
</body>
</html>
