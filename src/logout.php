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
    <link href="./assets/css/login.css" rel="stylesheet">
    <title><?php echo $_ENV['APP_NAME']; ?></title>
</head>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5"><?php echo $_ENV['APP_NAME']; ?></h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <div class="container">
                            <h4 class="text-center mt-5">ログアウトしました</h4>
                            <div class="d-grid mt-4">
                                <a class="btn btn-outline-info btn-md mt-3" href="./login.php">ログインページはこちら</a>
                                <a class="btn btn-outline-info btn-md mt-3" href="./index.php">トップページはこちら</a>
                            </div>                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
