<?php

$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
echo 'データベースに接続できました' . PHP_EOL;

if (!$link) {
    echo 'データベースの接続に失敗しました' . PHP_EOL;
    echo 'debugging error: ' . mysqli_connect_error() . PHP_EOL;
    exit;
}

$sql = <<<EOT
INSERT INTO companies(
    name,
    establishment_date,
    founder
) VALUES (
    'test inc',
    '2013-02-first',
    'ryota tamaki'
)
EOT;

$result = mysqli_query($link, $sql);
if ($result) {
    echo 'データが追加されました' . PHP_EOL;
} else {
    echo 'データの追加に失敗しました' . PHP_EOL;
    echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
}

mysqli_close($link);
echo 'データベースを切断できました' . PHP_EOL;
