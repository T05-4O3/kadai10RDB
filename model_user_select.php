<?php
class User {
    public $id;
    public $name;
    public $loginId;
    public $password;
    public $adminFlag;
    public $lifeFlag;

    public function __construct($id, $name, $loginId, $password, $adminFlag, $lifeFlag) {
        $this->id = $id;
        $this->name = $name;
        $this->loginId = $loginId;
        $this->password = $password;
        $this->adminFlag = $adminFlag;
        $this->lifeFlag = $lifeFlag;
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

// DBから全てのユーザー情報を取得する関数
function getAllUsers($pdo) {
    $stmt = $pdo->prepare('SELECT id, name, lid, lpw, admin_flg, life_flg FROM oneframe_user');
    $stmt->execute();
    $users = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = new User($row['id'], $row['name'], $row['lid'], $row['lpw'], $row['admin_flg'], $row['life_flg']);
    }
    return $users;
}