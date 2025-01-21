<?php
session_start();

// カートの初期化
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// カート内の合計金額を計算
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// データベースの初期化
$db_file = 'shop.db';
$db = new PDO("sqlite:$db_file");

// テーブルが存在しない場合は作成する
$db->exec("
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product TEXT NOT NULL,
        price INTEGER NOT NULL,
        quantity INTEGER NOT NULL,
        total_price INTEGER NOT NULL,
        order_date DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");

// 送信された注文情報の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'confirm') {
        // 注文情報をデータベースに保存する
        $stmt = $db->prepare("
            INSERT INTO orders (product, price, quantity, total_price) VALUES (:product, :price, :quantity, :total_price)
        ");

        foreach ($_SESSION['cart'] as $item) {
            $stmt->execute([
                ':product' => $item['product'],
                ':price' => $item['price'],
                ':quantity' => $item['quantity'],
                ':total_price' => $item['price'] * $item['quantity']
            ]);
        }

        $_SESSION['cart'] = array(); // 注文後にカートをクリア
        header('Location: success.php'); // 成功ページへリダイレクト
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入手続き - 株式会社三輪</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 1rem;
        }

        main {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .cart {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .cart h2 {
            margin-top: 0;
        }

        .cart ul {
            list-style: none;
            padding: 0;
        }

        .cart li {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
        }

        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 1rem;
            margin-top: 20px;
        }

        .back-to-home {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>購入手続き</h1>
    </header>
    <main>
        <!-- カートの内容 -->
        <div class="cart">
            <h2>カート内の商品</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <ul>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <li>
                            <?php echo htmlspecialchars($item['product']) . ' - ¥' . htmlspecialchars($item['price']) . ' × ' . htmlspecialchars($item['quantity']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>合計金額: ¥<?php echo $total_price; ?></strong></p>
                <form method="post" action="">
                    <input type="hidden" name="action" value="confirm">
                    <button type="submit" class="button">注文を確定する</button>
                </form>
            <?php else: ?>
                <p>カートに商品がありません。</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <a href="shop.php" class="button back-to-home">ショッピングページに戻る</a>
    </footer>
</body>
</html>
