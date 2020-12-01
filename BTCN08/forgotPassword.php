<?php
require_once 'init.php';

$title = 'Quên mật khẩu';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    $user = findUserByEmail($email);
    if (!$user) {
        $error = 'Không tìm thấy người dùng!';
    } else {
        if ($password != $re_password)
            $error = 'Xác thực mật khẩu chưa chính xác! Vui lòng nhập lại!';
        else {
            $user = updatePasswordWithEmail($email, password_hash($password, PASSWORD_DEFAULT));
            $_SESSION['userID'] = $user['id'];
            header('Location: index.php');
            exit();
        }
    }
}

?>
<?php include 'headers.php'; ?>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php else : ?>
    <form action="forgotPassword.php" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Email đăng nhập</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Mật khẩu mới</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="re_password" name="re_password">
            </div>
            <button type="submit" class="btn btn-primary">Lấy lại mật khẩu</button>
        </div>
    </form>
<?php endif; ?>

<?php include 'footer.php'; ?>