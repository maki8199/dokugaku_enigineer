<?php

require_once __DIR__ . '/lib/mysql.php';

function createCompany($link, $company)
{
    $sql = <<<EOT
INSERT INTO companies (
    name,
    establishment_date,
    founder
) VALUE (
    "{$company['name']}",
    "{$company['establishment_date']}",
    "{$company['founder']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '登録に成功しました' . PHP_EOL;
    } else {
        echo '登録に失敗しました' . PHP_EOL;
        echo 'debugging Error: ' . mysqli_error($link) . PHP_EOL;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = [
        'name' => $_POST['name'],
        'establishment_date' => $_POST['establishment_date'],
        'founder' => $_POST['founder']
    ];

    $link = connectDB();

    createCompany($link, $company);

    mysqli_close($link);
}

header("Location: index.php");
