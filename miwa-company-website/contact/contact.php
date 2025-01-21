<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ - 株式会社三輪</title>
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

        nav {
            background-color: #333;
            color: white;
            padding: 0.5rem;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 1rem;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        input, textarea {
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

        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        .button-container a {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .button-container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>株式会社三輪</h1>
    </header>
    <main>
        <h2>お問い合わせ</h2>
        <p>以下のフォームに必要事項を入力し、アポイントメントをリクエストしてください。</p>
        <form action="contact_process.php" method="post">
            <label for="name">お名前:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">電話番号:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="date">希望日:</label>
            <input type="date" id="date" name="date" required>

            <label for="message">メッセージ:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">送信</button>
        </form>
        <div class="button-container">
            <a href="../index.html">トップページへ戻る</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 株式会社三輪 All Rights Reserved.</p>
    </footer>
</body>
</html>
