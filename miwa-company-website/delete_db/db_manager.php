<?php
require_once '../user/config.php';

session_start();

// ログイン確認
if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbType = $_POST['dbType'] ?? '';
    $recordId = $_POST['recordId'] ?? '';

    if (!empty($dbType) && !empty($recordId)) {
        $table = '';
        switch ($dbType) {
            case 'shop':
                $table = 'orders';
                $dbFile = '../shop/shop.db';
                break;
            case 'worker':
                $table = 'applications';
                $dbFile = '../recruit/worker.db';
                break;
            case 'contact':
                $table = 'contacts';
                $dbFile = '../contact/contact.db';
                break;
            case 'user':
                $table = 'users';
                $dbFile = '../user/user.db';
                break;
            default:
                $error = '無効なデータベースタイプです。';
        }

        if ($table) {
            try {
                $pdo = new PDO("sqlite:$dbFile");
                $stmt = $pdo->prepare("DELETE FROM $table WHERE id = :id");
                $stmt->execute(['id' => $recordId]);
                $success = 'レコードが削除されました。';
            } catch (PDOException $e) {
                $error = 'データベースエラー: ' . $e->getMessage();
            }
        }
    } else {
        $error = 'データベースタイプとレコードIDは必須です。';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データベース管理 - 株式会社三輪</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        select, input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1>データベース管理</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="dbType">データベースを選択:</label>
        <select id="dbType" name="dbType" required>
            <option value="">選択してください</option>
            <option value="shop">Shop (orders)</option>
            <option value="worker">Worker (applications)</option>
            <option value="contact">Contact (contacts)</option>
            <option value="user">User (users)</option>
        </select>

        <label for="recordId">レコードID:</label>
        <input type="number" id="recordId" name="recordId" required>

        <button type="submit">削除</button>
    </form>

    <p><a href="../index.html">トップページに戻る</a></p>
</body>
</html>
