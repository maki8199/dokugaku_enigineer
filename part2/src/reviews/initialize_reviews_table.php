<?php

require_once __DIR__ . '/lib/mysql.php';


function dropTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS reviews';
    $result = mysqli_query($link, $dropTableSql);

    if ($result) {
        echo 'テーブルを削除しました' . PHP_EOL;
    } else {
        echo 'テーブルの削除に失敗しました' . PHP_EOL;
        echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}


function createTable($link)
{
    $createTableSql = <<< EOT
        CREATE TABLE reviews (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        author VARCHAR(255),
        status VARCHAR(10),
        score INTEGER,
        summary VARCHAR(1000),
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4
    EOT;

    $result = mysqli_query($link, $createTableSql);

    if ($result) {
        echo 'テーブルを作成しました' . PHP_EOL;
    } else {
        echo 'テーブルの作成に失敗しました' . PHP_EOL;
        echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}


$link = connectDB();
dropTable($link);
createTable($link);
mysqli_close($link);
