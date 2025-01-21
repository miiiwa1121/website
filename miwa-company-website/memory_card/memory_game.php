<!DOCTYPE html>
<html lang="ja">
<?php
// 画像ファイルと名前の対応
$imageNames = [
    "images/hourensou.png" => "ほうれん草",
    "images/keru.png" => "ケール",
    "images/komatuna.png" => "小松菜",
    "images/mituba.png" => "三つ葉",
    "images/moroheiya.png" => "モロヘイヤ",
    "images/paseri.png" => "パセリ",
    "images/shungiku.png" => "春菊",
    "images/tingensai.png" => "チンゲン菜",
];

// 画像ファイルを用意
$images = array_keys($imageNames);
$cards = array_merge($images, $images); // 画像を2つずつ用意
shuffle($cards); // ランダムに並べ替え
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お野菜メモリーカードゲーム</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .game-board {
            position: relative;
        }
        .game-over {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 2em;
            text-align: center;
            line-height: 100vh;
        }
        .navbar {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }
        .navbar a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.2em;
        }
        .card-name {
            display: none;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="../index.html">トップページに戻る</a>
</div>

<h1>お野菜メモリーカードゲーム</h1>

<div class="game-board">
    <?php foreach ($cards as $index => $card): ?>
        <div class="card" data-id="<?= $index ?>" data-image="<?= $card ?>">
            <div class="card-back">?</div>
            <div class="card-front"><img src="<?= $card ?>" alt="Card Image"></div>
            <div class="card-name" data-name="<?= $imageNames[$card] ?>"></div>
        </div>
    <?php endforeach; ?>
    <div class="game-over" id="game-over">ゲームクリア！</div>
</div>

<script src="script.js"></script>
</body>
</html>
