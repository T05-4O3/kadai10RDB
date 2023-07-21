<?php
// 最初にSESSIONを開始
session_start();

// POST値を受け取る
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

// 1. DB接続
require_once('db_connection.php');
$pdo = db_connect();

// 2. データ取得SQL作成
$stmt = $pdo->prepare('SELECT * FROM oneframe_user WHERE lid = :lid');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

// 3. SQL実行時にエラーがある場合STOP
if ($status === false) {
    exit('DB Error');
}

// データを取得
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// ログイン処理
if ($val && $lpw === $val['lpw']) {
    // ログイン成功時の処理
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['admin_flg'] = $val['admin_flg']; // admin_flgをセッションに保存

    // ログイン成功時にはエラーメッセージを削除
    unset($_SESSION['login_error']);

    header('Location: ../admin/index.php');
    exit(); // ログイン成功したので、ここで処理を終了させる
} else {
    // Login失敗時
    $_SESSION['login_error'] = 'ログイン失敗しました。IDとパスワードを確認してください。';
    header('Location: ../templates/list_admin_menu.php');
    exit(); // ログイン失敗したので、ここで処理を終了させる
}