<?php
    session_start();

    $title = $_POST["title"];
    $organizer = $_POST["organizer"];
    $genre = $_POST["genre"];
    $explanation = $_POST["explanation"];
    $link1 = $_POST["link1"];
    $link2 = $_POST["link2"];
    $link3 = $_POST["link3"];
    $link4 = $_POST["link4"];
    $link5 = $_POST["link5"];

    $dsn = 'mysql:host=db;dbname=sampledb';
    $username = 'root';
    $password = '1234';

    try{
        $dbcon = new PDO($dsn, $username, $password);
    }
    catch(PDOException $e){
        die("DSNを使ったデータベースの接続に失敗しました".$e->getMessage() );
    }

    //poster_tableに各情報を登録
    $sqlstring = "
    INSERT INTO poster_table(title, organizer, genre, explanation, link1, link2, link3, link4, link5)
    VALUES ('${title}', '${organizer}', '${genre}', '${explanation}', '${link1}', '${link2}', '${link3}', '${link4}', '${link5}');
    ";

    if( ! $recset = $dbcon -> query( $sqlstring ) ){
        echo "<pre>sqlstring = $sqlstring </pre>";
        echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
        print_r($dbcon->errorInfo());
        die("<br>プログラム停止しました");
    }

    //poster_tableのidを降順で並び換えて一番大きいもの(今登録したもの)を取得する
    $sqlstring = "
        SELECT * FROM poster_table ORDER BY id DESC;
    ";

    if( ! $recset = $dbcon -> query( $sqlstring ) ){
        echo "<pre>sqlstring = $sqlstring </pre>";
        echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
        print_r($dbcon->errorInfo());
        die("<br>プログラム停止しました");
    }

    $rowdata = $recset -> fetch(PDO::FETCH_ASSOC);

    //投稿されたポスターのid
    $id = $rowdata["id"];

    //画像を保存
    $flag = 0;
    if ($_FILES["poster"]["error"]) {
        //echo "uploadError";
        $flag = 1;
    } else {
        $res = move_uploaded_file($_FILES['poster']['tmp_name'], "../img/${id}.jpg");
        if ($res) {
            //echo "saveSuccess";
        } else {
            //echo "saveError";
            $flag = 1;
        }
    }

    if($flag==1){
        $sqlstring = "
            DELETE FROM poster_table WHERE id = $id;
        ";

        if( ! $recset = $dbcon -> query( $sqlstring ) ){
            echo "<pre>sqlstring = $sqlstring </pre>";
            echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
            print_r($dbcon->errorInfo());
            die("<br>プログラム停止しました");
        }
        header("Location: http://localhost/register.php?error=1");
        exit();
    }

    //count{id}.datを作成. これがないと閲覧数が数えられない. 
    //パーミッションはとりあえず脳死で777
    $fp = fopen("../counts/count${id}.dat",'w');
    chmod("../counts/count${id}.dat", 0777);
    fwrite($fp, 0);
    fclose($fp);

    header("Location: http://localhost/poster.php?id=$id");
    exit();
?>