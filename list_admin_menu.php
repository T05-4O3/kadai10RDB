<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="ja">
    <head prefix="og: https://ogp.me/ns#">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="format-detection" content="telephone=no">
        <meta name="description" content="今日のヒトコマ">
        <meta name="keywords" content="あなたが出会う今日のヒトコマは？">
    
        <meta property="og:type" content="website">
        <meta property="og:title" content="今日のヒトコマ">
        <meta property="og:description" content="あなたが出会う今日のヒトコマは？">
        <meta property="og:url" content="http://observation.jp/t05_4o3_m/focaccia/index.html">
        <meta property="og:image" content="http://observation.jp/t05_4o3_m/focaccia/img/common/ogimage.jpg">
        <meta property="og:site_name" content="今日のヒトコマ">
    
        <meta name="twitter:description" content="今日のヒトコマ" />
        <meta name="twitter:title" content="今日のヒトコマ" />
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="">
    
        <link rel="icon" href="http://observation.jp/t05_4o3_m/img/common/favicon.ico">
        <!-- <link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" rel="stylesheet"> -->
        <script src="https://kit.fontawesome.com/0a7c43b5fe.js" crossorigin="anonymous"></script>

        <title>今日のヒトコマ</title>
    
        <link rel="canonical" href="#">   
        <link rel="stylesheet" href="../css/reset.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <header id="header">
            <h1>管理</h1>
        </header>
        <main id="main">
            <div class="admin_menu">
                <a href="../admin/admin_title_dialogue.php">登録ワード一覧</a>
                <a href="../admin/user.php">ユーザー新規登録</a>
                <a href="../admin/user_select.php">ユーザー一覧</a>
                <a href="../model/model_logout.php">ログアウト</a>
            </div>
            <!-- ログイン状態表示 -->
            <div class="login_status">
                <?php
                    if (isset($_SESSION['admin_flg'])) {
                        $admin_flg = $_SESSION['admin_flg'];
                        if ($admin_flg === 2) {
                            echo '管理者ログイン中';
                        } elseif ($admin_flg === 1) {
                            echo '閲覧者ログイン中';
                        } else {
                            echo 'ログイン中';
                        }
                    } else {
                        echo 'ログアウト中';
                    }
                ?>
            </div>
            <div class="login">
                <form name="form1" action="../model/model_login_act.php" method="post">
                    ID:<input type="text" name="lid" />
                    PW:<input type="password" name="lpw" />
                    <input type="submit" value="LOGIN" />
                </form>
            </div>
            <!-- ログインエラーメッセージ表示 -->
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']); // エラーメッセージを表示したらセッションから削除
            }
            ?>
        </main>
        <footer id="footer">
            <p>copyrights 2023 Observation.jp All RIghts Reserved.</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- <script src="./js/main.js" type="module"></script> -->
        <script src="./js/searchRandumKeywords.js" type="module"></script>
        <script src="./js/searchUserText.js" type="module"></script>
        <script src="./js/social.js" type="module"></script>
    </body>
</html>
