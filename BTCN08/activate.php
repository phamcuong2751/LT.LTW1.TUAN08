<?php
    require_once 'init.php';

    $title = 'Kích hoạt tài khoản';
    $code = $_GET['code'];
    $id = $_GET['id'];

    $user = findUserById($id);
    if($user)
    {
        if($user['code'] == $code)
        {
            activateUser($id);
            $_SESSION['userId'] = $id;
            header ('Location: index.php');
            exit();
        }
    }
?>

<?php include 'header.php'; ?>
<div class="alert alert-danger" role="alert">
    Mã kích hoạt chưa chính xávs
</div>