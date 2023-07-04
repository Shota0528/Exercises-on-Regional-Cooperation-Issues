<?php
    session_start();
    //passwordとuser_nameがPOSTされていたら，DBにアクセスして確認
    if( !empty($_POST["name"]) && !empty($_POST["pw"])){
        //Data Source Nameの指定
        $dsn = 'mysql:host=db;dbname=sampledb';
        $username = 'root';
        $password = '1234';

        try{
            $dbcon = new PDO($dsn, $username, $password);
        }
        catch(PDOException $e){
            die("DSNを使ったデータベースの接続に失敗しました".$e->getMessage() );
        }

        $name = $_POST["name"];
        $pw = $_POST["pw"];
        $sqlstring = "
            SELECT * 
            FROM user_table 
            WHERE name='$name' AND pw='$pw';
        ";

        if( ! $recset = $dbcon -> query( $sqlstring ) ){
            echo "<pre>sqlstring = $sqlstring </pre>";
            echo "SQLのqueryでエラー。エラーメッセ―は次の通り<br>";
            print_r($dbcon->errorInfo());
            die("<br>プログラム停止しました");
        }

        $rowdata = $recset -> fetch(PDO::FETCH_ASSOC);

        if( isset( $rowdata["name"]) ){
            $_SESSION["login_status"] = "TRUE";
            $_SESSION["name"] = $rowdata["name"];
            $_SESSION["user_id"] = $rowdata["id"];
        }
        else{
            $not_login = "TURE";
            // ログインできなかった時?
            header('Location: http://localhost/login.php?error=1');
            exit();
        }

    } else {
        // 空の時リダイレクト
        header('Location: http://localhost/login.php');
        exit();
    }
    //もし，ログインしていた場合自動的にトップページにリダイレクトする
    if( !empty($_SESSION["login_status"]) ){
        header('Location: http://localhost/index.php');
        exit();
    }
?>