<?php
//Khởi tạo session
session_start();
//Composer autoload
require_once './vendor/autoload.php';

//Thông báo lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Conect to Database
$host = 'remotemysql.com';
$dbname = 'fPxGPOfSK5';
$charset = 'utf8mb4';
$userdb = 'fPxGPOfSK5';
$passdb = 'QwcVHNdhGy';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$db = new PDO($dsn, $userdb, $passdb); 

require_once 'functions.php';

$curentUser = getCurrentUser();