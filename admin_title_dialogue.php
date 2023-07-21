<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// セッションを開始
session_start();

// ログインユーザーのadmin_flgを取得
$admin_flg = isset($_SESSION['admin_flg']) ? $_SESSION['admin_flg'] : 0;

// ログインユーザーのadmin_flgを取得した後に、表示部分を分岐
require_once('../model/model_admin.php');

$pdo = db_connect();
$titlePage = isset($_GET['title_page']) ? $_GET['title_page'] : 1;
$dialoguePage = isset($_GET['dialogue_page']) ? $_GET['dialogue_page'] : 1;

// 1) admin_flgが2の場合の表示
if ($admin_flg === 2) {
    $hide_admin_flg_1 = false; // 初期値をfalseに設定
    require_once('../templates/list_admin.php');
    exit;
}

// 2) admin_flgが1の場合の表示
if ($admin_flg === 1) {
    $hide_admin_flg_1 = true; // 初期値をtrueに設定
    require_once('../templates/list_admin.php');
    exit;
}

require_once('../templates/list_admin.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_keyword1'])) {
        $keyword1 = $_POST['keyword1'];
        add_keyword1($pdo, $keyword1);
    }

    if (isset($_POST['add_keyword2'])) {
        $keyword2 = $_POST['keyword2'];
        add_keyword2($pdo, $keyword2);
    }

    if (isset($_POST['delete_keyword1'])) {
        $keyword1_id = $_POST['keyword1_id'];
        delete_keyword1($pdo, $keyword1_id);
    }

    if (isset($_POST['delete_keyword2'])) {
        $keyword2_id = $_POST['keyword2_id'];
        delete_keyword2($pdo, $keyword2_id);
    }
}