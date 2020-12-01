<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title><?php echo $title ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-left: 20px;">
        <a style="color: #007bff" class="navbar-brand" href="index.php"><strong>Lập trình Web 1 - 18CK1</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin: 0 20px">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php echo $title == 'Trang chủ' ? 'action' : ''; ?>">
                    <a class="nav-link" href="index.php">Trang chủ<?php echo $title == 'Trang chủ' ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                </li>
                <?php if ($curentUser) : ?>
                    <li class="nav-item <?php echo $title == $curentUser['name'] ? 'action' : ''; ?>">
                        <a class="nav-link" href="profile.php"><?php echo $curentUser['name'] ?><?php echo $title == $curentUser['name']  ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                    <li class="nav-item <?php echo $title == 'Bạn bè' ? 'action' : ''; ?>">
                        <a class="nav-link" href="friend.php">Bạn bè<?php echo $title == 'Bạn bè'  ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                    <li class="nav-item <?php echo $title == 'Cộng hai số' ? 'action' : ''; ?>">
                        <a class="nav-link" href="sum.php">Cộng hai số<?php echo $title == 'Cộng hai số' ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                    <li class="nav-item <?php echo $title == 'Trang chủ' ? 'action' : ''; ?>">
                        <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                    <form class="form-inline ">
                        <input class="form-control mr-sm-2" type="search" placeholder="Tìm bạn bè" aria-label="Search">
                        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Tìm Kiếm</button>
                    </form>
                <?php else : ?>
                    <li class="nav-item <?php echo $title == 'Đăng nhập' ? 'action' : ''; ?>">
                        <a class="nav-link" href="login.php">Đăng nhập<?php echo $title == 'Đăng nhập' ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                    <li class="nav-item <?php echo $title == 'Đăng ký' ? 'action' : ''; ?>">
                        <a class="nav-link" href="register.php">Đăng ký<?php echo $title == 'Đăng ký' ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1><?php echo $title; ?></h1>