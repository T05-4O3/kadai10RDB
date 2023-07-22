<?php
class User {
    public $id;
    public $name;
    public $loginId;
    public $password;
    public $adminFlag;
    public $lifeFlag;

    public function __construct($id = null, $name = null, $loginId = null, $password = null, $adminFlag = null, $lifeFlag = null) {
        $this->id = $id;
        $this->name = $name;
        $this->loginId = $loginId;
        $this->password = $password;
        $this->adminFlag = $adminFlag;
        $this->lifeFlag = $lifeFlag;
    }

    // ユーザー情報を取得する静的メソッド
    public static function getAllUsers($pdo) {
        $stmt = $pdo->prepare('SELECT * FROM oneframe_user');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($users); // デバッグ用
        return $users;
    }

    // ユーザーの情報を更新するメソッド
    public function updateUserInfo($name, $loginId, $password, $adminFlag, $lifeFlag) {
        $this->name = $name;
        $this->loginId = $loginId;
        $this->password = $password;
        $this->adminFlag = $adminFlag;
        $this->lifeFlag = $lifeFlag;
    }

    // ユーザーを削除するメソッド
    public function deleteUser() {
        // ユーザーの削除処理を実装する
        // 例：データベースから該当するユーザーを削除するなど
    }

    // ユーザー情報を表示するメソッド
    public function displayUserInfo() {
        echo 'ID: ' . $this->id . '<br>';
        echo 'Name: ' . $this->name . '<br>';
        echo 'Login ID: ' . $this->loginId . '<br>';
        echo 'Admin Flag: ' . $this->adminFlag . '<br>';
        echo 'Life Flag: ' . $this->lifeFlag . '<br>';
    }
}

function addUser($pdo, $name, $loginId, $password, $adminFlag, $lifeFlag) {
    $stmt = $pdo->prepare('INSERT INTO users (name, loginId, password, adminFlag, lifeFlag) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$name, $loginId, $password, $adminFlag, $lifeFlag]);
}

function deleteUser($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$id]);
}

function updateLifeFlag($pdo, $id, $lifeFlag) {
    $stmt = $pdo->prepare('UPDATE users SET lifeFlag = ? WHERE id = ?');
    $stmt->execute([$lifeFlag, $id]);
}

// ページネーションのための $totalPages 変数を計算する関数を追加
function calculateTotalPages($users, $usersPerPage) {
    $totalUsers = count($users); // 総ユーザー数
    $totalPages = ceil($totalUsers / $usersPerPage); // 総ページ数を計算
    return $totalPages;
}