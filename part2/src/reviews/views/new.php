<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログ</title>
</head>

<body>
    <h1>読書ログ</h1>
    <h2>読書ログの登録</h2>
    <ul>
        <?php if (count($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <li>
                    <?php echo $error; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <form action="create.php" method='post'>
        <div>
            <label for="title">書籍名</label>
            <input type="text" name="title" id="title" value=<?php echo $review['title']; ?>>
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" name="author" id="author" value=<?php echo $review['author']; ?>>
        </div>
        <div>
            <label>読書状況</label>
            <input type="radio" name="status" value="未読" id="status1" <?php echo ($review['status'] === '未読') ? 'checked' : ''; ?>>
            <label for="status1">未読</label>
            <input type="radio" name="status" value="読んでいる" id="status2" <?php echo ($review['status'] === '読んでいる') ? 'checked' : ''; ?>>
            <label for="status2">読んでいる</label>
            <input type="radio" name="status" value="読了" id="status3" <?php echo ($review['status'] === '読了') ? 'checked' : ''; ?>>
            <label for="status3">読了</label>
        </div>
        <div>
            <label for="score">評価</label>
            <input type="number" name="score" id="score" value=<?php echo $review['score']; ?>>
        </div>
        <div>
            <label for="summary">感想</label>
            <textarea type="text" name="summary" id="summary"><?php echo $review['summary']; ?></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>


</body>

</html>
