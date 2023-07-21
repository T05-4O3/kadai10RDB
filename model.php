<?php

// 1. DB接続ファイルを読み込む
require_once('../path/to/db_connection.php'); // 適切なファイルパスを指定してください

function get_random_keyword_from_db($pdo) {
    $stmt = $pdo->prepare('SELECT title FROM oneframe_keywords1 ORDER BY RAND() LIMIT 1;');
    $status = $stmt->execute();

    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {
        $result = $stmt->fetch();
        return $result['title'];
    }
}

function get_random_dialogue_from_db($pdo) {
    $stmt = $pdo->prepare('SELECT dialogue FROM oneframe_keywords2 ORDER BY RAND() LIMIT 1;');
    $status = $stmt->execute();

    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {
        $result = $stmt->fetch();
        return $result['dialogue'];
    }
}

// カッコの中に$pdoを入れることで、関数の中でpdoが使えるようになる
function get_all_posts($pdo) {
    //２．データ登録SQL作成
    $stmt = $pdo->prepare('SELECT * FROM oneframe_user;');
    $status = $stmt->execute();

    //３．データ表示
    $view = '';
    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $name = htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8');
            $id = htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8');
            //GETデータ送信リンク作成
            // <a>で囲う。
            $view .= '<p>';
            $view .= '<a href="detail.php?id=' . $result['id'] . '">';
            $view .= $result['indate'] . '：' . $result['name'];
            $view .= '</a>';
            $view .= '</p>';
        }
        return $view;
    }
}

function get_posts_by_id($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM oneframe_user WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意
    $status = $stmt->execute(); //実行

    $result = '';
    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {
        $result = $stmt->fetch();
    }
    return $result;
}