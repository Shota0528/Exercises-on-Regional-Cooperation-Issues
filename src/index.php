<?php
session_start();
?>
<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="./assets/css/stylesheet.css" rel="stylesheet">
    <link href="./assets/css/header.css" rel="stylesheet">
    <link href="./assets/css/board.css" rel="stylesheet">

    <link href="./assets/css/top.css" rel="stylesheet">
    <link href="./assets/css/board.css" rel="stylesheet">
    <script src="./assets/js/board.js"></script>
    <title><?php echo $_ENV['APP_NAME']; ?></title>
</head>

<body>
    <?php include("./components/header.php"); ?>
    <main class="container">
        <div id="board" class="mt-3">
            <h4 style="text-align: center;">
                ～ 掲示板 ～
            </h4>
            <div id="board-container">
                <canvas id="board-canvas" width=5000 height=5000></canvas>
                <?php
                    //閲覧数を降順で格納する配列
                    $number_of_pages_viewed = [];
                    // $folderpath = './counts/';
                    // $file = glob(($folderpath . "/*"));
                    // $countfile = 0;
                    // if ($file != false ){
                    //     $countfile = count($file);
                    // }
                    // for($i=1; $i<=$countfile; $i++){
                    //     echo "<img src='./img/$i.jpg' class='poster' name='$i'>";
                    // }
                    $imgs = glob("./img/*.jpg");
                    foreach($imgs as $img) {
                        $id = explode('.', explode('/', $img)[2])[0];
                        echo "<img src='${img}' class='poster' name='${id}'>";
                    }
                ?>
            </div>
        </div>

        <div class="my-4">
            <?php
                $dsn = 'mysql:host=db;dbname=sampledb';
                $username = 'root';
                $password = '1234';
            
                try{
                    $dbcon = new PDO($dsn, $username, $password);
                }
                catch(PDOException $e){
                    die("DSNを使ったデータベースの接続に失敗しました".$e->getMessage() );
                }
                $sqlstring = "
                    SELECT * FROM poster_table ORDER BY id DESC LIMIT 5 ;
                ";
            
                if( ! $recset = $dbcon -> query( $sqlstring ) ){
                    echo "<pre>sqlstring = $sqlstring </pre>";
                    echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
                    print_r($dbcon->errorInfo());
                    die("<br>プログラム停止しました");
                }
            
            ?>
            <h4>
                新着-5件
            </h4>
            <div class="table-responsive poster-table mx-3">
                <table class="table">
                    <tr>
                        <?php
                        while($rowdata = $recset -> fetch(PDO::FETCH_ASSOC)){
                            $poster_id = $rowdata["id"];
                            $fp = fopen("./counts/count".$poster_id.".dat", 'r+b');
                            //ファイルを排他ロックする
                            flock($fp, LOCK_EX);
                            //ファイルからカウント数を取得する
                            $access_count = fgets($fp);
                            echo "
                                <td>
                                    <div class='card rounded poster-card m-3'>
                                        <a href='./poster.php?id=$poster_id'><img src='./img/$poster_id.jpg' class='p-3 rounded img-fluid'></a>
                                        <div class='card-body'>
                                            <p class='card-text'>閲覧数: $access_count</p>
                                        </div>
                                    </div>
                                </td>";
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="my-4">
            <?php
                try{
                    $dbcon = new PDO($dsn, $username, $password);
                }
                catch(PDOException $e){
                    die("DSNを使ったデータベースの接続に失敗しました".$e->getMessage() );
                }
                $sqlstring = "
                    SELECT * FROM poster_table;
                ";
            
                if( ! $recset = $dbcon -> query( $sqlstring ) ){
                    echo "<pre>sqlstring = $sqlstring </pre>";
                    echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
                    print_r($dbcon->errorInfo());
                    die("<br>プログラム停止しました");
                }
                while($rowdata = $recset -> fetch(PDO::FETCH_ASSOC)){
                    $poster_id = $rowdata["id"];
                    //カウント数が記録してあるファイルを読み書きできるモードで開く
                    $fp = fopen("./counts/count".$poster_id.".dat", 'r+b');
                    //ファイルを排他ロックする
                    flock($fp, LOCK_EX);
                    //ファイルからカウント数を取得する
                    $access_count = fgets($fp);
                    $number_of_pages_viewed[$poster_id] = $access_count;
                }
                arsort($number_of_pages_viewed);
            ?>
            <h4>
                あなたへのおすすめ
            </h4>
            <div class="table-responsive poster-table mx-3">
                <table class="table">
                    <tr>
                    <?php
                        $i = 1;
                        foreach($number_of_pages_viewed as $key => $val){
                            $fp = fopen("./counts/count".$key.".dat", 'r+b');
                            //ファイルを排他ロックする
                            flock($fp, LOCK_EX);
                            //ファイルからカウント数を取得する
                            $access_count = fgets($fp);
                            echo "
                                <td>
                                    <div class='card rounded poster-card m-3'>
                                        <a href='./poster.php?id=$key'><img src='./img/$key.jpg' class='p-3 rounded img-fluid'></a>
                                        <div class='card-body'>
                                            <p class='card-text'>閲覧数: $access_count</p>
                                        </div>
                                    </div>
                                </td>";
                            $i++;
                            if($i > 5){
                                break;
                            }
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>

        <div id="wordcloud" class="mt-3">
            <h4 style="text-align: center;">
                ～ ワードクラウド ～
            </h4>
            <div id="wordcloud-wrap">
                <?php include("./assets/html/word_cloud.html"); ?>
            </div>
        </div>

        <div class="my-4">
            <h4>
                DEBUG-BTN
            </h4>
            <a class="btn btn-primary" href="signage/index.html">デジタルサイネージ</a>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>