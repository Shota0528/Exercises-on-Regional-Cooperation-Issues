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
    <script src="../assets/js/board.js"></script>
    <title><?php echo $_ENV['APP_NAME']; ?></title>
</head>

<body>
    <?php include("./components/header.php"); ?>
    <main class="container">
    <div class="my-4">
        <?php
            $category = array(
                'school'=>'学校間',
                'event'=>'イベント',
                'area'=>'地域',
                'other'=>'その他',
            );
            $get_id = $_GET['genre'];
            echo '
            <h4>
                '.$category[$_GET['genre']].'
            </h4>
            ';
            //DBからgetのgenreに当てはまるid
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
                SELECT COUNT(*) FROM poster_table WHERE genre='$get_id';
            ";

            if( ! $recset = $dbcon -> query( $sqlstring ) ){
                echo "<pre>sqlstring = $sqlstring </pre>";
                echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
                print_r($dbcon->errorInfo());
                die("<br>プログラム停止しました");
            }

            $rowdata = $recset -> fetch(PDO::FETCH_ASSOC);
            $count = $rowdata["COUNT(*)"];


            $sqlstring = "
                SELECT * FROM poster_table WHERE genre='$get_id';
            ";

            if( ! $recset = $dbcon -> query( $sqlstring ) ){
                echo "<pre>sqlstring = $sqlstring </pre>";
                echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
                print_r($dbcon->errorInfo());
                die("<br>プログラム停止しました");
            }

            echo '
                <div class="table-responsive poster-table mx-3">
                    <table class="table">
                        <tr>
                            ';
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
            echo '
                        </tr>
                    </table>
                </div>
            ';
            ?>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
