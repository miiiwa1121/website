<!-- <?php
// データベース接続
$pdo = new PDO('sqlite:shop.db');

// 購入履歴を取得
$query = 'SELECT * FROM orders ORDER BY order_date DESC';
$stmt = $pdo->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入履歴 - 株式会社三輪</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 1rem;
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
            margin-top: 20px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>購入履歴</h1>
    </header>
    <main>
        <h2>注文履歴一覧</h2>
        <?php if (!empty($orders)): ?>
            <table>
                <thead>
                    <tr>
                        <th>注文ID</th>
                        <th>注文日</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>数量</th>
                        <th>合計金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td>¥<?php echo htmlspecialchars($order['price']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td>¥<?php echo htmlspecialchars($order['total_price']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>購入履歴がありません。</p>
        <?php endif; ?>
        <a href="shop.php" class="button">ショップページに戻る</a>
    </main>
    <footer>
        <a href="../index.html" class="button">トップページに戻る</a>
    </footer>
</body>
</html> -->
