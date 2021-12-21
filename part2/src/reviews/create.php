<?php

require_once __DIR__ . '/lib/mysql.php';

function createReview($link, $review)
{
    $query = <<< EOT
    INSERT INTO reviews(
        title,
        author,
        status,
        score,
        summary
    ) VALUES (
        "{$review['title']}",
        "{$review['author']}",
        "{$review['status']}",
        "{$review['score']}",
        "{$review['summary']}"
    )
    EOT;

    $result = mysqli_query($link, $query);

    if (!$result) {
        echo 'Error; fail to create review' . PHP_EOL;
        echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}


function validate($review)
{
    // 書籍名
    if (!strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }

    // 著者名
    if (!strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (strlen($review['author']) > 255) {
        $errors['author'] = '著者名は255文字以内で入力してください';
    }

    // 読書状況
    if (!in_array($review['status'], ['未読', '読んでいる', '読了'])) {
        $errors['status'] = '読書状況は[未読][読んでいる][読了]の中から選択してください';
    }

    // 評価
    if ($review['score'] < 1 || 5 < $review['score']) {
        $errors['score'] = '評価は1〜5の整数を入力してください';
    }

    // 感想
    if (!strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    } elseif (strlen($review['summary']) > 1000) {
        $errors['summary'] = '感想は1000文字以内で入力してください';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'status' => $_POST['status'],
        'score' => $_POST['score'],
        'summary' => $_POST['summary']
    ];

    $errors = validate($review);

    if (!count($errors)) {
        $link = connectDB();
        createReview($link, $review);
        mysqli_close($link);
        header("Location: index.php");
    }
}

?>

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
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" name="author" id="author">
        </div>
        <div>
            <label>読書状況</label>
            <input type="radio" name="status" value="未読" id="status1">
            <label for="status1">未読</label>
            <input type="radio" name="status" value="読んでいる" id="status2">
            <label for="status2">読んでいる</label>
            <input type="radio" name="status" value="読了" id="status3">
            <label for="status3">読了</label>
        </div>
        <div>
            <label for="score">評価</label>
            <input type="number" name="score" id="score">
        </div>
        <div>
            <label for="summary">感想</label>
            <textarea type="text" name="summary" id="summary"></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>


</body>

</html>
