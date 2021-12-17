<?php

function connectDB()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

    if (!$link) {
        echo 'データベースの接続に失敗しました' . PHP_EOL;
        echo 'debugging error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    return $link;
}


function validate($review)
{
    $errors = [];

    // 書籍名が正しく入力できているかチェック
    if (!mb_strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (mb_strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }

    // 著者名が正しく入力できているかチェック
    if (!mb_strlen($review['author'])) {
        $errors['author'] = '書籍名を入力してください';
    } elseif (mb_strlen($review['author']) > 255) {
        $errors['author'] = '書籍名は255文字以内で入力してください';
    }

    // 著者名が正しく入力できているかチェック
    if (!in_array($review['status'], ['未読', '読んでいる', '読了'], true)) {
        $errors['status'] = '読書状況は「未読」「読んでる」「読了」のいずれかを入力してください';
    }

    // 評価が正しく入力されているかチェック
    if ($review['score'] < 1 || $review['score'] > 5) {
        $errors['score'] = '評価は1~5の値を入力してください';
    }

    // 感想が正しく入力できているかチェック
    if (!mb_strlen($review['summary'])) {
        $errors['summary'] = '書籍名を入力してください';
    } elseif (mb_strlen($review['author']) > 1000) {
        $errors['summary'] = '書籍名は1000文字以内で入力してください';
    }

    return $errors;
}


function createReview($link)
{
    $review = [];

    echo '読書ログを登録します' . PHP_EOL;
    echo '書籍名: ';
    $review['title'] = trim(fgets(STDIN));
    echo '著者名: ';
    $review['author'] = trim(fgets(STDIN));
    echo '読書状況: ';
    $review['status'] = trim(fgets(STDIN));
    echo '評価: ';
    $review['score'] = (int) trim(fgets(STDIN));
    echo '感想: ';
    $review['summary'] = trim(fgets(STDIN));

    $validated = validate($review);
    if (count($validated) > 0) {
        foreach ($validated as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }
    echo '登録が完了しました' . PHP_EOL;

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

    if ($result) {
        echo 'データを追加しました' . PHP_EOL;
    } else {
        echo 'データの追加に失敗しました' . PHP_EOL;
        echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}


function showReviews($link)
{
    echo '登録されている読書ログを表示します' . PHP_EOL;

    $sql = 'SELECT * FROM reviews';
    $results = mysqli_query($link, $sql);

    while ($review = mysqli_fetch_assoc($results)) {
        echo '------------------------' . PHP_EOL;
        echo '書籍名: ' . $review['title'] . PHP_EOL;
        echo '著者名: ' . $review['author'] . PHP_EOL;
        echo '読書状況: ' . $review['status'] . PHP_EOL;
        echo '評価: ' . $review['score'] . PHP_EOL;
        echo '感想: ' . $review['summary'] . PHP_EOL;
        echo '------------------------' . PHP_EOL;
    }

    mysqli_free_result($results);
}


$reviews = [];
$link = connectDB();

while (True) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください(1,2,9) : ';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        createReview($link);
    } elseif ($num === '2') {
        showReviews($link);
    } elseif ($num === '9') {
        mysqli_close($link);
        echo 'アプリケーションを終了します' . PHP_EOL;
        break;
    }
}
