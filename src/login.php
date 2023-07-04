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
    <link href="./assets/css/login.css" rel="stylesheet">
    <title><?php echo $_ENV['APP_NAME']; ?></title>
</head>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5"><a id="title" href="./index.php"><?php echo $_ENV['APP_NAME']; ?></a></h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="./api/login.php" method="post">
                            <h3 class="text-center">ログイン</h3>
                            <div class="form-group">
                                <?php
                                    if($_GET['error'] == 1) {
                                        echo '
                                        <p class="alert alert-danger text-center">
                                            名前またはパスワードが間違っています.
                                        </p>
                                        ';
                                    }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="username">名前:</label><br>
                                <input type="text" name="name" id="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">パスワード:</label><br>
                                <input type="password" name="pw" id="password" class="form-control" required>
                            </div>
                            <div class="form-group d-grid">
                                <input type="submit" name="submit" class="btn btn-outline-info btn-md" value="ログイン">
                            </div>
                            <div class="form-group">
                                <a href="./signup.php">登録はこちら</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
