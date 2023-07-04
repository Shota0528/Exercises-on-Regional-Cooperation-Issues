<?php
    session_start();
?>
<?php
    $get_id = $_GET['id'];
    //カウント数が記録してあるファイルを読み書きできるモードで開く
    $fp = fopen("./counts/count".$get_id.".dat", 'r+b');

    //ファイルを排他ロックする
    flock($fp, LOCK_EX);

    //ファイルからカウント数を取得する
    $access_count = fgets($fp);

    //カウント数を1増やす
    $access_count++;
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./assets/css/header.css" rel="stylesheet">
    <link href="./assets/css/stylesheet.css" rel="stylesheet">
    <link href="./assets/css/poster.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <title><?php echo $_ENV['APP_NAME']; ?></title>
</head>

<body>
    <?php include("./components/header.php"); ?>
    <?php
        $get_id = $_GET['id'];

        $dsn = 'mysql:host=db;dbname=sampledb';
        $username = 'root';
        $password = '1234';
    
        try{
            $dbcon = new PDO($dsn, $username, $password);
        }
        catch(PDOException $e){
            die("DSNを使ったデータベースの接続に失敗しました".$e->getMessage() );
        }

        $sqlstring = "SELECT * FROM poster_table WHERE id=$get_id;";

        if( ! $recset = $dbcon -> query( $sqlstring ) ){
            echo "<pre>sqlstring = $sqlstring </pre>";
            echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
            print_r($dbcon->errorInfo());
            die("<br>プログラム停止しました");
        }
        $rowdata = $recset -> fetch(PDO::FETCH_ASSOC);

        // echo "id : ".$get_id.", ".$rowdata["id"]."<br>";
        $title = $rowdata["title"];
        $organizer = $rowdata["organizer"];
        $genre = $rowdata["genre"];
        $explanation = $rowdata["explanation"];
        $link1 = $rowdata["link1"];
        $link2 = $rowdata["link2"];
        $link3 = $rowdata["link3"];
        $link4 = $rowdata["link4"];
        $link5 = $rowdata["link5"];

        //ここでDBにlikeしてるかを取りに行く
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
            SELECT COUNT(*) FROM like_table WHERE user_id= '$user_id' AND poster_id='$get_id';
        ";

        if( ! $recset = $dbcon -> query( $sqlstring ) ){
            echo "<pre>sqlstring = $sqlstring </pre>";
            echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
            print_r($dbcon->errorInfo());
            die("<br>プログラム停止しました");
        }

        $rowdata = $recset -> fetch(PDO::FETCH_ASSOC);

        $imgPATH = "./img/$get_id.jpg";
        echo '
        <main class="container mb-5">
            <!-- ポスター情報-行 -->
            <div class="row mt-5 px-5">
                <div class="col-12 col-md-4 offset-md-1">
                    <div class="card">
                        <img src='.$imgPATH.' class="img-fluid"></img>
                    </div>
                </div>
                <div class="col-12 col-md-4 offset-md-1 mt-4">
                    <div style="text-align: right;">
                        <p>閲覧数: '.$access_count.'</p>
                    </div>
                    <div style="text-align: right;">
        ';
        if($rowdata["COUNT(*)"] == 0){
            echo "<a class='btn btn-outline-danger mb-2' href='./api/like.php?poster=$get_id'><i class='bi bi-heart-fill'></i> お気に入り登録</a>";
        }else{
            echo "<a class='btn btn-danger mb-2' href='./api/like.php?poster=$get_id'><i class='bi bi-heart'></i> お気に入り解除</a>";
        }
        echo '
                    </div>
                    <h3>
                        '.$title.'
                    </h3>
                    <h4>
                        '.$organizer.'
                    </h4>
                    <p class="my-4">
                        '.$explanation.'
                    </p>
                    <div class="d-grid gap-2 mx-auto mt-5">
        ';

        //Tmp Function
        function rename_link($link) {
            if (mb_strlen($link) >= 42) {
                return substr($link, 0, 35).'...';
            } else {
                return $link;
            }
        }

        //urlを入れたらそのurlのページのtitleを返す(もしなかったらポスターのタイトルを返す)関数。でもうまく動かないからコメントアウト
        // function toTitle($url){
        //     //ソースの取得
        //     $source = @file_get_contents($url);
        //     //文字コードをUTF-8に変換し、正規表現でタイトルを抽出
        //     if (preg_match('/<title>(.*?)<\/title>/i', mb_convert_encoding($source, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
        //         $linktitle = $result[1];
        //     } else {
        //         //TITLEタグが存在しない場合
        //         $linktitle = $title;
        //     }
        //     return $linktitle;
        // }
        // if(!empty($link1)){
        //     echo '<a href="'.$link1.'" class="btn btn-outline-success my-1 py-2">'.toTitle($link1).'</a>';
        // }

        
        if(!empty($link1)){
            $url = $link1;
            $source = @file_get_contents($url);
            if (preg_match('/<title>(.*?)<\/title>/i', mb_convert_encoding($source, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
                $linktitle = $result[1];
            } else {
                $linktitle = $title;
            }
            echo '<a href="'.$link1.'" class="btn btn-outline-success my-1 py-2">'.$linktitle.'</a>';
        }
        if(!empty($link2)){
            $url = $link2;
            $source = @file_get_contents($url);
            if (preg_match('/<title>(.*?)<\/title>/i', mb_convert_encoding($source, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
                $linktitle = $result[1];
            } else {
                $linktitle = $title;
            }
            echo '<a href="'.$link2.'" class="btn btn-outline-success my-1 py-2">'.$linktitle.'</a>';
        }
        if(!empty($link3)){
            $url = $link3;
            $source = @file_get_contents($url);
            if (preg_match('/<title>(.*?)<\/title>/i', mb_convert_encoding($source, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
                $linktitle = $result[1];
            } else {
                $linktitle = $title;
            }
            echo '<a href="'.$link3.'" class="btn btn-outline-success my-1 py-2">'.$linktitle.'</a>';
        }
        if(!empty($link4)){
            $url = $link4;
            $source = @file_get_contents($url);
            if (preg_match('/<title>(.*?)<\/title>/i', mb_convert_encoding($source, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
                $linktitle = $result[1];
            } else {
                $linktitle = $title;
            }
            echo '<a href="'.$link4.'" class="btn btn-outline-success my-1 py-2">'.$linktitle.'</a>';
        }
        if(!empty($link5)){
            $url = $link5;
            $source = @file_get_contents($url);
            if (preg_match('/<title>(.*?)<\/title>/i', mb_convert_encoding($source, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
                $linktitle = $result[1];
            } else {
                $linktitle = $title;
            }
            echo '<a href="'.$link5.'" class="btn btn-outline-success my-1 py-2">'.$linktitle.'</a>';
        }
        echo '
                    </div>
                </div>
            </div>
        </main>
        ';
?>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>
<?php
    //ポインターをファイルの先頭に戻す
    rewind($fp);

    //最新のアクセス数をファイルに書き込む
    fwrite($fp, $access_count);

    //ファイルのロックを解除する
    flock($fp, LOCK_UN);

    //ファイルを閉じる
    fclose($fp);
?>
