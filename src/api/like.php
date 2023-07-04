<?php
    session_start();
    //ログインできてなかったらログインページに飛ばす
    if(empty($_SESSION["login_status"])){
        header('Location: http://localhost/login.php');
        exit();
    }

    $get_id = $_GET["poster"];

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
        SELECT COUNT(*) FROM like_table WHERE user_id='$user_id' AND poster_id='$get_id';
    ";

    if( ! $recset = $dbcon -> query( $sqlstring ) ){
        echo "<pre>sqlstring = $sqlstring </pre>";
        echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
        print_r($dbcon->errorInfo());
        die("<br>プログラム停止しました");
    }

    $rowdata = $recset -> fetch(PDO::FETCH_ASSOC);

    if($rowdata["COUNT(*)"] == 0){
        $sqlstring = "
            INSERT INTO like_table(user_id, poster_id)
            VALUES ($user_id, $get_id)
        ";

        if( ! $recset = $dbcon -> query( $sqlstring ) ){
            echo "<pre>sqlstring = $sqlstring \n";
            echo "SQLのqueryでエラー。エラーメッセ―は次の通り \n";
            print_r($dbcon->errorInfo());
            die("プログラム停止しました</pre>");
        }
    }else{
        $sqlstring = "
            DELETE FROM like_table WHERE user_id=$user_id AND poster_id=$get_id;
        ";
        if( ! $recset = $dbcon -> query( $sqlstring ) ){
            echo "<pre>sqlstring = $sqlstring \n";
            echo "SQLのqueryでエラー。エラーメッセ―は次の通り \n";
            print_r($dbcon->errorInfo());
            die("プログラム停止しました</pre>");
        }
    }
    header("Location: http://localhost/poster.php?id=$get_id");
    exit();
?>
