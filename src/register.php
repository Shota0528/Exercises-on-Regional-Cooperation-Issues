<?php
    session_start();
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
    <script src="./assets/js/register.js"></script>
    <title><?php echo $_ENV['APP_NAME']; ?></title>
</head>

<body>
    <?php include("./components/header.php"); ?>
    <main class="container my-5">
        <?php
            if ($_GET["error"]) {
                echo "
                    <div class='alert alert-danger' role='alert'>
                        ポスターの登録に失敗しました.
                    </div>
                ";
            }
        ?>
        <form method="POST" action="./api/register.php" enctype="multipart/form-data" class="row mt-5 px-5">
            <div class="col-12 col-md-4 offset-md-1">
                <div class="card mb-2 p-1">
                    <img id="img-pre" width="100%" height="100%">
                </div>
                <input id="form-img" type="file" name="poster" accept=".jpg" onchange="previewImage(this);" required>
            </div>
            <div class="col-12 col-md-4 offset-md-1 mt-4">
                <div class="row mb-3">
                    <label for="title" class="col-sm-3 col-form-label">タイトル</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="organizer" class="col-sm-3 col-form-label">団体名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="organizer" name="organizer" required>
                    </div>
                </div>
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-3 pt-0">ジャンル</legend>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genre" value="school" id="genre-school" required>
                            <label class="form-check-label" for="genre-school">
                                学校間
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genre" value="event" id="genre-event" required>
                            <label class="form-check-label" for="genre-event">
                                イベント
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genre" value="area" id="genre-area" required>
                            <label class="form-check-label" for="genre-area">
                                地域
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genre" value="other" id="genre-other" checked required>
                            <label class="form-check-label" for="genre-other">
                                その他
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="row mb-3">
                    <label for="explanation" class="col-sm-3 col-form-label">説明</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="explanation" name="explanation" required></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="organizer" class="col-sm-3 col-form-label">Links</label>
                    <div class="col-sm-9">
                        <input type="url" class="form-control my-1" name="link1">
                        <input type="url" class="form-control my-1" name="link2">
                        <input type="url" class="form-control my-1" name="link3">
                        <input type="url" class="form-control my-1" name="link4">
                        <input type="url" class="form-control my-1" name="link5">
                    </div>
                </div>

                <div class="d-grid gap-2 mx-auto mt-5">
                    <button class="btn btn-outline-success my-1 py-2" type="sumbit">登録</button>
                </div>
            </div>
        </form>
    </main>


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
