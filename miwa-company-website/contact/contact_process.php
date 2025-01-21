<?php
// データベースファイルへのパス
$dbPath = __DIR__ . '/contact.db'; // 絶対パスを使用

// PDO インスタンスを作成してデータベースに接続
try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // テーブルが存在しない場合は作成する
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            date TEXT NOT NULL,
            message TEXT NOT NULL
        )
    ";
    $pdo->exec($createTableSQL);

    // フォームからのデータを取得
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $date = htmlspecialchars($_POST['date']);
    $message = htmlspecialchars($_POST['message']);

    // データをデータベースに挿入する
    $insertSQL = "
        INSERT INTO contacts (name, email, phone, date, message)
        VALUES (:name, :email, :phone, :date, :message)
    ";
    $stmt = $pdo->prepare($insertSQL);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    echo '<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信完了 - 株式会社三輪</title>
    <style>
        body {
            font-family: \'Helvetica Neue\', Arial, \'Hiragino Kaku Gothic ProN\', \'Hiragino Sans\', Meiryo, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
        }
        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>株式会社三輪</h1>
    </header>
    <main>
        <h2>お問い合わせありがとうございます</h2>
        <p>以下の内容で受け付けました。</p>
        <p>お名前: ' . htmlspecialchars($name) . '</p>
        <p>メールアドレス: ' . htmlspecialchars($email) . '</p>
        <p>電話番号: ' . htmlspecialchars($phone) . '</p>
        <p>希望日: ' . htmlspecialchars($date) . '</p>
        <p>メッセージ: ' . nl2br(htmlspecialchars($message)) . '</p>
        <p><a href="../index.html">トップページに戻る</a></p>
    </main>
    <footer>
        <p>&copy; 2024 株式会社三輪 All Rights Reserved.</p>
    </footer>
</body>
</html>';
} catch (PDOException $e) {
    echo 'データベースエラー: ' . $e->getMessage();
}
?>
