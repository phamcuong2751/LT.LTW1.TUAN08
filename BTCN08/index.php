<?php
require_once 'init.php';
require_once 'functions.php';

$title = 'Trang chủ';
if (isset($_REQUEST['contentStatus'])) {
  $content = $_REQUEST['contentStatus'];
  if ($content = null) {
    header('Location: index.php');
    exit();
  } else {
    postStatus($content, $curentUser['email']);
    header('Location: index.php');
    exit();
  }
}

?>
<?php include 'headers.php'; ?>

<?php if ($curentUser) : ?>
  <form method="REQUEST" action="index.php">
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Xin chào <strong class="text-primary"><?php echo $curentUser['name'] ?></strong> hôm nay của bạn thế nào?</label>
      <textarea class="form-control" id="contentStatus" name="contentStatus" rows="1"></textarea>
    </div>
    <button class="btn btn-primary float-right">Đăng cảm nghĩ</button>
  </form>

  </br>
  </br>
  </br>

  <?php generatePost($curentUser['email']); ?>

<?php else : ?>
    <div class="alert alert-secondary" role="alert">
      Bạn chưa đăng nhập!
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>