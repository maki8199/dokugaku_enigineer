<?php

function connectDB()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    if (!$link) {
        echo 'データベースへの接続に失敗しました' . PHP_EOL;
        echo 'debugging error: ' . mysqli_connect_error($link) . PHP_EOL;
    }
    return $link;
}


function validate($memo)
{
    $errors = [];

    if (!strlen($memo['title'])) {
        $errors['title'] = 'タイトルが入力されていません';
    } elseif (strlen($memo['title'] > 255)) {
        $errors['title'] = 'タイトルは255文字以内で入力してください';
    }

    if (!strlen($memo['content'])) {
        $errors['content'] = '内容が入力されていません';
    } elseif (strlen($memo['content'] > 1000)) {
        $errors['content'] = '内容は1000文字以内で入力してください';
    }

    return $errors;
}


function createMemo($link)
{
    $memo = [];

    echo 'タイトルを入力してください: ';
    $memo['title'] = trim(fgets(STDIN));

    echo '内容を入力してください: ';
    $memo['content'] = trim(fgets(STDIN));

    $errors = validate($memo);

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }

    $sql = <<< EOT
    INSERT INTO memos(
    title,
    content
    ) VALUES (
        "{$memo['title']}",
        "{$memo['content']}"
    )
    EOT;

    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo 'データの追加に失敗しました' . PHP_EOL;
        echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
    }

    echo 'データを追加しました' . PHP_EOL;
}


function showMemo($link)
{
    $sql = 'SELECT * FROM memos';
    $results = mysqli_query($link, $sql);

    while ($memo = mysqli_fetch_assoc($results)) {
        echo '---------------' . PHP_EOL;
        echo 'タイトル: ' . $memo['title'] . PHP_EOL;
        echo '内容: ' . $memo['content'] . PHP_EOL;
        echo '---------------' . PHP_EOL;
    }
}


$memos = [];

$link = connectDB();

while (True) {
    echo '1. メモを登録' . PHP_EOL;
    echo '2. 登録済のメモを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください(1,2,9) : ';
    $num = trim(fgets(STDIN));

    if ($num === "1") {
        createMemo($link);
    } elseif ($num === "2") {
        showMemo($link);
    } elseif ($num === "9") {
        echo 'アプリケーションを終了します' . PHP_EOL;
        break;
    } else {
        echo '指定した数字を入力してください' . PHP_EOL;
    }
}
