<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// セッションを開始
session_start();

require_once('../model/db_connection.php');
require_once('../model/model_user_select.php');

// セッションが開始されていない場合はリダイレクト
if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !== session_id()) {
    header('Location: ../templates/list_admin_menu.php');
    exit;
}

$pdo = db_connect();
$users = getAllUsers($pdo);

if ($_SESSION['admin_flg'] === 2) {
    // 管理者の場合は削除とlife_flgの切り替えボタンを表示
    // 省略 (削除とlife_flgの切り替えボタンの実装)
}

// ./templates/list_user_select.php を読み込んで表示
require_once('../templates/list_user_select.php');