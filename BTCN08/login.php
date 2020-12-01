<?php
require_once 'init.php';

$title = 'Đăng nhập';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = findUserByEmail($email);
    if (!$user) {
        $error = 'Không tìm thấy người dùng!';
    } else {
        if (!(password_verify($password, $user["password"]))) {
            $error = 'Mật khẩu không chính xác!';
        } else {
            if ($user['code']) {
                $error = 'Vui lòng kiểm tra email';
            } else {
                $_SESSION['userID'] = $user['id'];
                header('Location: index.php');
                exit();
            }
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
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Email đăng nhập</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </div>
        <a style="display: block;" href="forgotPassword.php">Bạn đã quên mật khẩu?</a>
        <p>Nếu bạn chưa có tài khoản, đăng ký <a href="register.php">tại đây</a>.</p>
    </form>
<?php endif; ?>

<?php include 'footer.php'; ?>