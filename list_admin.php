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
            <div id="keyword-list">
                <h2>キーワードリスト</h2>
                <h3>漫画タイトル</h3>
                <div class="title keyword-container">
                    <?php
                    $view1 = get_all_keywords1($pdo, 'title', $titlePage);
                    echo $view1['keywords'];
                    ?>
                </div>
                <?php if ($view1['total_pages'] > 1) : ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $view1['total_pages']; $i++) : ?>
                            <a href="?title_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

                <!-- admin_flgが1の閲覧者の場合は非表示 -->
                <?php if ($_SESSION['admin_flg'] !== 1) : ?>
                    <div class="add_keyword-container">
                        <form action="../admin/index.php" method="POST">
                            <input type="text" name="keyword1" placeholder="キーワードを追加" required>
                            <input type="submit" name="add_keyword1" value="追加">
                        </form>
                    </div>
                <?php endif; ?>

                <h3>漫画セリフ</h3>
                <div class="dialogue keyword-container">
                    <?php
                    $view2 = get_all_keywords2($pdo, 'dialogue', $dialoguePage);
                    echo $view2['keywords'];
                    ?>
                </div>
                <?php if ($view2['total_pages'] > 1) : ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $view2['total_pages']; $i++) : ?>
                            <a href="?dialogue_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

                <!-- admin_flgが1の閲覧者の場合は非表示 -->
                <?php if ($_SESSION['admin_flg'] !== 1) : ?>
                    <div class="add_keyword-container">
                        <form action="../admin/index.php" method="POST">
                            <input type="text" name="keyword2" placeholder="キーワードを追加" required>
                            <input type="submit" name="add_keyword2" value="追加">
                        </form>
                    </div>
                <?php endif; ?>

            </div>
        </main>
        <footer id="footer">
            <p>copyrights 2023 Observation.jp All RIghts Reserved.</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="./js/loginStatus.js"></script>
        <script src="./js/social.js" type="module"></script>
    </body>
</html>