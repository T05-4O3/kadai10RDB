<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// セッションを開始
session_start();

require_once('../model/model_user_select.php');
require_once('../model/db_connection.php');

// セッションが開始されていない場合はリダイレクト
if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !== session_id()) {
    header('Location: ../templates/list_admin_menu.php');
    exit;
}
// admin_flgが0の場合は/admin/index.phpにリダイレクト
if ($_SESSION['admin_flg'] === 0) {
    header('Location: ../admin/index.php');
    exit;
}

$pdo = db_connect();
// Userクラスをインスタンス化
$user = new User();
$users = $user->getAllUsers($pdo);

// var_dump($users); // デバッグ用

// データが正しく取得されているか確認
// foreach ($users as $user) {
//     // ユーザーデータを表示
//     echo 'ID: ' . $user['id'] . '<br>';
//     echo 'Name: ' . $user['name'] . '<br>';
//     echo 'Login ID: ' . $user['lid'] . '<br>';
//     echo 'Admin Flag: ' . $user['admin_flg'] . '<br>';
//     echo 'Life Flag: ' . $user['life_flg'] . '<br>';
//     echo '<hr>'; // データ間の区切りとして水平線を表示
// }

// 管理者(admin_flgが2)がアクセスした場合の処理
if ($_SESSION['admin_flg'] === 2) {
    // ユーザーの追加がリクエストされた場合の処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    }

    // ユーザーの削除とlife_flgの切り替えボタンが押された場合の処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_user'])) {
            // 削除処理のコードを記述
        } elseif (isset($_POST['toggle_life_flg'])) {
            // life_flg切り替え処理のコードを記述
        }
    }
}

// ./templates/list_user_select.php を読み込んで表示
require_once('../templates/list_user_select.php');

// ./templates/list_user_select.php を読み込んで表示
require_once('../templates/list_user_select.php');