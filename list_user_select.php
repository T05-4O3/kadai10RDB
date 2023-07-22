<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
            <h1>ユーザー一覧</h1>
        </header>
        <main id="main">
            <div class="admin_menu">
                <a href="../admin/index.php">ログインホーム</a>
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

            <div class="user_list">
                <?php foreach ($users as $user): ?>
                    <div class="user_card <?php echo $adminButtonsClass; ?>">
                        <!-- ユーザー情報の表示 -->
                        <p>ID: <?php echo $user['id']; ?></p>
                        <p>Name: <?php echo $user['name']; ?></p>
                        <p>Login ID: <?php echo $user['lid']; ?></p>
                        <p>Admin Flag: <?php echo $user['admin_flg']; ?></p>
                        <p>Life Flag: <?php echo $user['life_flg']; ?></p>

                        <!-- 管理者(admin_flgが2)のみ削除とlife_flgの切り替えボタンを表示 -->
                        <?php if ($_SESSION['admin_flg'] === 2): ?>
                            <form action="" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete_user">削除</button>
                                <button type="submit" name="toggle_life_flg">Life Flag切り替え</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <footer id="footer">
            <p>copyrights 2023 Observation.jp All RIghts Reserved.</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="../js/loginStatus.js"></script>
        <script src="../js/social.js" type="module"></script>
    </body>
</html>