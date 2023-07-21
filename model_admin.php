<?php
// ログインユーザーのadmin_flgを取得
$admin_flg = isset($_SESSION['admin_flg']) ? $_SESSION['admin_flg'] : 0;

// 3) admin_flgが0の場合の処理
if ($admin_flg === 0) {
    // リダイレクトしてアクセス権限がないことを表示
    header('Location: ../admin/index.php?error=1');
    exit;
}

require_once 'db_connection.php'; 

// キーワード表示
function get_all_keywords1($pdo, $type, $page) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM oneframe_keywords1;');
    $stmt->execute();
    $count = $stmt->fetchColumn();

    $view1 = '';
    $offset = ($page - 1) * 5;

    if ($type === 'title') {
        $stmt = $pdo->prepare('SELECT * FROM oneframe_keywords1 LIMIT :offset, 5;');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $view1 .= '<p>';
            $view1 .= 'id' . htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') . ': ' . htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8');

            // admin_flgが1の場合は削除ボタンを非表示
            if ($_SESSION['admin_flg'] !== 1) {
                $view1 .= ' <form action="../admin/index.php" method="POST">';
                $view1 .= '<input type="hidden" name="keyword1_id" value="' . htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') . '">';
                $view1 .= '<button type="submit" name="delete_keyword1">削除</button>';
                $view1 .= '</form>';
            }
            $view1 .= '</p>';
        }

        $total_pages = ceil($count / 5);

        return array(
            'keywords' => $view1,
            'total_pages' => $total_pages
        );
    }
}

function add_keyword1($pdo, $keyword1) {
    if (!empty($keyword1)) {
        $stmt = $pdo->prepare('INSERT INTO oneframe_keywords1 (title) VALUES (:title);');
        $stmt->bindValue(':title', $keyword1, PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status === false) {
            $error = $stmt->errorInfo();
            exit('SQLError:' . print_r($error, true));
        } else {
            header('Location: ../admin/index.php');
            exit;
        }
    }
}

function get_all_keywords2($pdo, $type, $page) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM oneframe_keywords2;');
    $stmt->execute();
    $count = $stmt->fetchColumn();

    $view2 = '';
    $offset = ($page - 1) * 5;

    if ($type === 'dialogue') {
        $stmt = $pdo->prepare('SELECT * FROM oneframe_keywords2 LIMIT :offset, 5;');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $view2 .= '<p>';
            $view2 .= 'id' . $result['id'] . ': ' . $result['dialogue'];

            // admin_flgが1の場合は削除ボタンを非表示
            if ($_SESSION['admin_flg'] !== 1) {
                $view2 .= ' <form action="../admin/index.php" method="POST">';
                $view2 .= '<input type="hidden" name="keyword2_id" value="' . $result['id'] . '">';
                $view2 .= '<button type="submit" name="delete_keyword2">削除</button>';
                $view2 .= '</form>';
            }
            $view2 .= '</p>';
        }

        $total_pages = ceil($count / 5);

        return array(
            'keywords' => $view2,
            'total_pages' => $total_pages
        );
    }
}

function add_keyword2($pdo, $keyword2) {
    if (!empty($keyword2)) {
        $stmt = $pdo->prepare('INSERT INTO oneframe_keywords2 (dialogue) VALUES (:dialogue);');
        $stmt->bindValue(':dialogue', $keyword2, PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status === false) {
            $error = $stmt->errorInfo();
            exit('SQLError:' . print_r($error, true));
        } else {
            header('Location: ../admin/index.php');
            exit;
        }
    }
}

function delete_keyword1($pdo, $keyword1_id) {
    if (isset($_SESSION['admin_flg']) && $_SESSION['admin_flg'] === 1) {
        // admin_flgが1の場合は非表示
        header('Location: ../admin/index.php');
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM oneframe_keywords1 WHERE id = :id;');
    $stmt->bindValue(':id', $keyword1_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {
        header('Location: ../admin/index.php');
        exit;
    }
}

function delete_keyword2($pdo, $keyword2_id) {
    if (isset($_SESSION['admin_flg']) && $_SESSION['admin_flg'] === 1) {
        // admin_flgが1の場合は非表示
        header('Location: ../admin/index.php');
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM oneframe_keywords2 WHERE id = :id;');
    $stmt->bindValue(':id', $keyword2_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {
        header('Location: ../admin/index.php');
        exit;
    }
}

// ログアウト処理
if (isset($_POST['logout'])) {
    // セッションを破棄してログアウト
    session_destroy();
    header('Location: ../model/model_logout.php');
    exit;
}
