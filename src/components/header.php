<?php
    $_ENV['APP_NAME'] = "Suwaaa";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
<header class="navbar navbar-light bg-light border-bottom border-secondary">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="/index.php">
            <h3><?php echo $_ENV['APP_NAME']; ?></h3>
        </a>
        <ul class="nav">
        <?php
            if(empty($_SESSION["login_status"])){
                echo '
                    <li class="nav-item top-nav"><a class="btn btn-outline-info" href="http://localhost/signup.php">SIGNUP</a></li>
                    <li style="margin-left: 5px;" class="nav-item top-nav"><a class="btn btn-outline-success" href="http://localhost/login.php">Login</a></li>
                ';
            } else {
                echo '
                    <li class="nav-item top-nav"><a class="btn btn-outline-info" href="http://localhost/mypage.php">MyPage</a></li>
                    <li style="margin-left: 5px;" class="nav-item top-nav"><a class="btn btn-outline-danger" href="http://localhost/api/logout.php">LOGOUT</a></li>
                ';
            }
        ?>
            
        </ul>
    </div>
    <div class="container d-flex justify-content-end">
        <ul class="nav">
            <li class="nav-item top-nav"><a class="btn btn-outline-secondary" href="http://localhost/register.php">ポスター登録</a></li>
        </ul>
        <form method="GET" action="http://localhost/search.php" style="margin-left: 5px;">
            <div class="input-group">
                <input type="text" name="word" class="form-control" aria-label="Text input">
                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    <ul class="container nav justify-content-evenly p-1">
        <li class="nav-item top-nav"><a class="nav-link" href="http://localhost/category.php?genre=school">学校間</a></li>
        <li class="nav-item top-nav"><a class="nav-link" href="http://localhost/category.php?genre=event">イベント</a></li>
        <li class="nav-item top-nav"><a class="nav-link" href="http://localhost/category.php?genre=area">地域</a></li>
        <li class="nav-item top-nav"><a class="nav-link" href="http://localhost/category.php?genre=other">その他</a></li>
    </ul>
</header>