<?php
require_once 'init.php';

requireLoggedIn();

$title = 'Cộng hai số';

if (isset($_POST['numberOne']) && isset($_POST['numberTwo'])) {
    $a = $_POST['numberOne'];
    $b = $_POST['numberTwo'];
    $result = $a + $b;
}
?>

<?php include 'headers.php'; ?>
<?php if ($curentUser) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Xin chào <?php echo $curentUser['name']; ?>!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <?php if (isset($result)) : ?>
        <div class="alert alert-primary" role="alert">
            Kết quả của <?php echo $a ?> cộng <?php echo $b ?> là: <?php echo $result; ?>
        </div>
    <?php else : ?>
        <form action="sum.php" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Nhập số thứ nhất: </label>
                <input type="number" class="form-control" name="numberOne">
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nhập số thứ hai:</label>
                    <input type="number" class="form-control" name="numberTwo">
                </div>
                <button type="submit" class="btn btn-primary">Tính tổng</button>
        </form>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-secondary" role="alert">
        Bạn chưa đăng nhập, vui lòng đăng nhập để sử dụng chương trình!
    </div>
<?php endif; ?>
<?php include 'footer.php'; ?>