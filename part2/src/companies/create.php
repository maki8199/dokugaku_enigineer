<?php

use Dotenv\Util\Str;

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
    if (!$result) {
        error_log('Error; fail to create company');
        error_log('debugging Error : ' . mysqli_error($link));
    }
}

function validate($company)
{
    $errors = [];

    // 会社名
    if (!strlen($company['name'])) {
        $errors['name'] = '会社名を入力してください';
    } elseif (strlen($company['name']) > 255) {
        $errors['name'] = '会社名は255文字以内で入力してください';
    }

    // 設立日
    $dates = explode('-', $company['establishment_date']);

    if (!strlen($company['establishment_date'])) {
        $errors['establishment_date'] = '設立日を入力してください';
    } elseif (!count($dates) === 3) {
        $errors['establishment_date'] = '設立日を正しい形式で入力してください';
    } elseif (!checkdate($dates[1], $dates[2], $dates[0])) {
        $errors['establishment_date'] = '設立日を正しい形式で入力してください';
    }

    // 代表者
    if (!strlen($company['founder'])) {
        $errors['founder'] = '代表者を入力してください';
    } elseif (strlen($company['founder']) > 255) {
        $errors['founder'] = '代表者名は255文字以内で入力してください';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = [
        'name' => $_POST['name'],
        'establishment_date' => $_POST['establishment_date'],
        'founder' => $_POST['founder']
    ];
    //バリデーションする
    $errors = validate($company);
    //バリデーションエラーがなければ
    if (!count($errors)) {
        $link = connectDB();
        createCompany($link, $company);
        mysqli_close($link);
        header("Location: index.php");
    }
}

include 'views/new.php';
