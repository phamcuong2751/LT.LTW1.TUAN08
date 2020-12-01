<?php
require_once 'init.php';
$title = 'Trang cá nhân';

if (isset($_FILES['avatar'])) {
    $ImageName = 'avr_userid-' . $curentUser['id'] . '.jpg';
    //Convert Image to binary
    $image = addslashes($_FILES['avatar']['tmp_name']);
    $image = file_get_contents($image);
    $image = base64_encode($image);
    postNameImage($ImageName, $image, $curentUser['username']);
	
	//Reload Page
	$curentUser = getCurrentUser();
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
    <div class="d-flex flex-row bd-highlight mb-2">
        <div class="card p-2 bd-highlight" style="width: 15rem;">
            <img src="data:image; base64,<?php echo $curentUser['image_binary'] ?>" class="card-img-top" alt="avr_userid-<?php echo $curentUser['id'] ?>.jpg">
            <div class="card-body">
                <h1><strong class="text text-primary"><?php echo $curentUser['name'] ?></strong></h1>
            </div>
        </div>
        <form class="p-2 bd-highlight" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="avatar" class="font-weight-bold text-primary">Tải ảnh đại diện</label>
                <input type="file" accept=".jpg,.jpeg" class="form-control-file" id="avatar" name="avatar">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
<?php else : ?>
    <div class="alert alert-secondary" role="alert">
        Bạn chưa đăng nhập!
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>