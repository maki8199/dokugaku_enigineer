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

include 'views/new.php';
