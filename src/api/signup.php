<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuwaAreaAadvisor(仮) sign up</title>
</head>
<body>
    <?php
        $name = $_POST["name"];
        $pw = $_POST["pw"];
        $checkpw = $_POST["checkpw"];
        
        $dsn = "mysql:host=db;dbname=sampledb";
        $username = "root";
        $password = "1234";


        if(empty($name) or empty($pw) or empty($checkpw)){
            header('Location: http://localhost/signup.php?error=1');
            exit();
        }
        if($pw != $checkpw){
            header('Location: http://localhost/signup.php?error=2');
            exit();
        }

        try{
            $dbcon = new PDO($dsn, $username, $password);
        }
        catch(PDOException $e){
            die("DSNを使ったデータベースの接続に失敗しました<pre>".$e->getMessage()."</pre>" );
        }

        $sqlstring = "
            INSERT INTO user_table(NAME, pw)
            VALUES ('$name', '$pw')
        ";
        if( ! $recset = $dbcon -> query( $sqlstring ) ){
            echo "<pre>sqlstring = $sqlstring \n";
            echo "SQLのqueryでエラー。エラーメッセ―は次の通り \n";
            print_r($dbcon->errorInfo());
            die("プログラム停止しました</pre>");
        }

echo <<< HTML
        <div style="text-align: center">
            ご登録ありがとうございます.<br>
            <a class="a" href="../login.php">ログインはこちら</a>
        </div>
HTML;

    ?>
</body>
</html>