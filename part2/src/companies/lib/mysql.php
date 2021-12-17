<?php

require __DIR__ . '/../../vendor/autoload.php';

function connectDB()
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();

    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];

    $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);

    if (!$link) {
        echo 'データベースの接続に失敗しました' . PHP_EOL;
        echo 'debugging error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    return $link;
}
