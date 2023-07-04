<?php
    session_start();
    //ログインできてなかったらログインページに飛ばす
    if(empty($_SESSION["login_status"])){
        header('Location: http://localhost/login.php');
        exit();
    }
    $name = $_SESSION["name"];
?>
<!DOCTYPE html>
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
        <h3>
            マイページ
        </h3>
        <h5 class="mt-3">
            ユーザー情報
        </h5>
        <div class="container">
            <table class="table">
                <thead>
                    <tr><th></th><th></th></tr>
                </thead>
                <tbody>
                    <tr>
                        <th>名前:</th>
                        <th><?php echo "$name";?></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5 class="mt-3">
            お気に入りポスター
        </h5>
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
            
            $user_id = $_SESSION["user_id"];
            $sqlstring = "
                SELECT * FROM like_table WHERE user_id='$user_id';
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
                                $poster_id = $rowdata["poster_id"];
                                echo "
                                    <td>
                                        <div class='card rounded poster-card m-3'>
                                            <a href='./poster.php?id=$poster_id'><img src='./img/$poster_id.jpg' class='p-3 rounded img-fluid'></a>
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
