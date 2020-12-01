<?php
require_once 'init.php';

$title = 'Đăng ký';

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    $user = findUserByEmail($email);
    if (!$user) {
        $check = checkRigister($name, $email, $password, $re_password);
    }
}
?>

<?php include 'headers.php'; ?>

<?php if (isset($value)) : ?>
    <?php if ($value == -1) : ?>
        <div class="alert alert-danger" role="alert">
            Mật khẩu không khớp
        </div>

    <?php elseif ($value == -2) : ?>
        <div class="alert alert-danger" role="alert">
            Đăng ký thất bại
        </div>

    <?php elseif ($value == 0) : ?>
        <div class="alert alert-danger" role="alert">
            Tài khoản đã tồn tại
        </div>
    <?php endif; ?>
<?php else : ?>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Họ tên</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email đăng ký</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="re_password" name="re_password">
            </div>
            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </div>
    </form>
<?php endif; ?>
<?php include 'footer.php'; ?>