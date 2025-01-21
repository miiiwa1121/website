<?php
session_start();

// カートの初期化
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// カートに商品を追加
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'clear') {
            // カートをクリア
            $_SESSION['cart'] = array();
        } elseif ($_POST['action'] === 'update') {
            // 数量の更新
            foreach ($_POST['quantity'] as $index => $quantity) {
                $quantity = intval($quantity);
                if ($quantity > 0) {
                    $_SESSION['cart'][$index]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$index]);
                }
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']); // インデックスを振り直す
        } elseif ($_POST['action'] === 'add') {
            // 商品情報をカートに追加
            $product = $_POST['product'];
            $price = $_POST['price'];

            // 商品が既にカートに存在する場合、数量を増やす
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product'] === $product && $item['price'] === $price) {
                    $item['quantity']++;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $_SESSION['cart'][] = array('product' => $product, 'price' => $price, 'quantity' => 1);
            }
        }
    }
}

// カート内の合計金額を計算
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>野菜の購入 - 株式会社三輪</title>
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
            position: relative;
            padding-right: 300px;
        }

        .products {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .product {
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 5px;
            width: calc(33.333% - 1rem);
            box-sizing: border-box;
        }

        .product img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .product h2 {
            margin: 0 0 10px;
        }

        .product p {
            margin: 0 0 10px;
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

        .cart {
            position: fixed;
            right: 0;
            top: 60px;
            width: 300px;
            height: calc(100vh - 60px);
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            overflow-y: auto;
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

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100px;
            margin-top: 5px;
        }

        .quantity-controls button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
        }

        .quantity-controls input {
            width: 40px;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header>
        <h1>野菜の購入</h1>
    </header>
    <main>
        <!-- 商品一覧 -->
        <div class="products">
            <?php
            $products = [
                ['name' => 'ほうれん草', 'price' => 300, 'image' => '../images/spinach.jpg'],
                ['name' => 'にんじん', 'price' => 200, 'image' => '../images/carrot.jpg'],
                ['name' => 'じゃがいも', 'price' => 150, 'image' => '../images/potato.jpg'],
                ['name' => 'キャベツ', 'price' => 250, 'image' => '../images/cabbage.jpg'],
                ['name' => 'レタス', 'price' => 180, 'image' => '../images/lettuce.jpg'],
                ['name' => 'ブロッコリー', 'price' => 220, 'image' => '../images/broccoli.jpg'],
                ['name' => 'トマト', 'price' => 300, 'image' => '../images/tomato.jpg'],
                ['name' => '玉ねぎ', 'price' => 100, 'image' => '../images/onion.jpg'],
                ['name' => 'ピーマン', 'price' => 250, 'image' => '../images/pepper.jpg'],
            ];

            foreach ($products as $product):
            ?>
            <section class="product">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p>価格: ¥<?php echo htmlspecialchars($product['price']); ?></p>
                <form method="post" action="">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product" value="<?php echo htmlspecialchars($product['name']); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                    <button type="submit" class="button">カートへ</button>
                </form>
            </section>
            <?php endforeach; ?>
        </div>

        <!-- カートの内容 -->
        <div class="cart">
            <h2>カート内の商品</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <form method="post" action="">
                    <input type="hidden" name="action" value="update">
                    <ul>
                        <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                            <li>
                                <?php echo htmlspecialchars($item['product']) . ' - ¥' . htmlspecialchars($item['price']); ?>
                                <div class="quantity-controls">
                                    <button type="submit" name="quantity[<?php echo $index; ?>]" value="<?php echo $item['quantity'] - 1; ?>">-</button>
                                    <input type="number" name="quantity[<?php echo $index; ?>]" value="<?php echo $item['quantity']; ?>" min="0">
                                    <button type="submit" name="quantity[<?php echo $index; ?>]" value="<?php echo $item['quantity'] + 1; ?>">+</button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p><strong>合計金額: ¥<?php echo $total_price; ?></strong></p>
                    <button type="submit" class="button">数量を更新</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="button">カートをクリア</button>
                </form>
                <a href="shop_detail.php" class="button">購入手続き</a>
            <?php else: ?>
                <p>カートに商品がありません。</p>
            <?php endif; ?>
            <!-- <a href="shop_log.php" class="button">購入履歴を見る</a> -->
        </div>
    </main>

    <footer>
        <a href="../index.html" class="button back-to-home">トップページに戻る</a>
    </footer>
</body>
</html>
