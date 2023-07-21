<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// セッションを開始
session_start();

require_once('../templates/list_admin_menu.php');
require_once('../model/db_connection.php');

// セッションが開始されていない場合はリダイレクト
if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !== session_id()) {
    header('Location: ../templates/list_admin_menu.php');
    exit;
}

$pdo = db_connect();

// ログイン処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 省略 (既存のPOST処理をそのまま残す)
}