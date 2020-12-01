<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sum($a, $b)
{
    return $a + $b;
}

function findUserByID($userID)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute(array($userID));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findUserByUsername($username)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute(array($username));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findUserByEmail($email)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute(array($email));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createUser($name, $password, $username)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO users (name, password, username) VALUES (?, ?, ?)");
    $stmt->execute(array($name, $username, $password));
    return findUserByID($db->lastInsertId());
}

function createUserWithEmail($name, $email, $password, $code)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO users (name, email, password, code) VALUES (?, ?, ?, ?)");
    $stmt->execute(array($name, $email, $password, $code));
    return findUserByID($db->lastInsertId());
}

function postNameImage($ImageName, $ImageBinary, $username)
{
    global $db;
    $stmt = $db->prepare("UPDATE users SET image = ? WHERE username = ?");
    $stmt->execute(array($ImageName, $username));
    $stmt = $db->prepare("UPDATE users SET 	image_binary = ? WHERE username = ?");
    $stmt->execute(array($ImageBinary, $username));
}

function postStatus($status, $email)
{
    global $db;
    $max_index = $db->prepare("SELECT MAX(serial) FROM status WHERE email = ?");
    $max_index->execute(array($email));
    $index = $max_index->fetch(PDO::FETCH_ASSOC);
    $int_index = (int)$index['MAX(serial)'];
    $int_index += 1;
    $stmt = $db->prepare("INSERT INTO status (email, serial, status) VALUES (?, ?, ?)");
    $stmt->execute(array($email, $int_index, $status));
}


function generatePost($email)
{
    global $db;
    $stmt = $db->prepare("SELECT usr.name, st.status, st.time 
                          FROM `status` AS st INNER JOIN `users` AS usr ON st.email = usr.email
                          WHERE st.email = ?
						  ORDER BY st.time DESC");
    $stmt->execute(array($email));
    $status = $stmt->fetchALL(PDO::FETCH_ASSOC);
    foreach ($status as $item) {
        echo '<div class="card mt-3">'
            . '<div class="card-header font-weight-bold " style="font-size: 1.5rem;">'
            . $item['name']
            . "<p class='font-weight-light' style='font-size: 0.75rem;'>" . $item['time'] . "</p>"
            . '</div>'
            . '<div class="card-body">'
            . "<h5 class='card-text'>" . $item['status'] . "</h5>"
            . '</div>'
            . '</div>';
    }
}

function updatePassword($username, $password)
{
    global $db;
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->execute(array($password, $username));
}

function updatePasswordWithEmail($email, $password)
{
    global $db;
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute(array($password, $email));
}

function getCurrentUser()
{
    if (isset($_SESSION['userID'])) {
        return findUserByID($_SESSION['userID']);
    }
    return null;
}

function resizeImage($filename, $max_width, $max_height)
{
    list($orig_width, $orig_height) = getimagesize($filename);

    $width = $orig_width;
    $height = $orig_height;

    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }

    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }

    $image_p = imagecreatetruecolor($width, $height);

    $image = imagecreatefromjpeg($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

    return $image_p;
}

function requireLoggedIn()
{
    global $curentUser;
    if (!($curentUser)) {
        header('Location: index.php');
        exit();
    }
}

function sendEmail($to, $subject, $content)
{
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = '18600038.pppcuong@gmail.com';          // SMTP username
        $mail->Password   = 'cuong18600038';                        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom('18600038.pppcuong@gmail.com', 'LT WEB1 - 18K1');
        $mail->addAddress($to);     // Add a recipient

        // Content
        $mail->isHTML(true);        // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->send();

        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function activateUser($id)
{
    global $db;
    $stmt = $db->prepare("UPDATE users SET code=NULL WHERE id=?");
    $stmt->execute(array($id));
}

function checkAccountRecoveryEmail($email)
{
    $user = findUserByEmail($email);
    if (!$user) {
        return -1;
    } else {
        $newPassword = strtoupper(bin2hex(random_bytes(4)));
        updatePassword($user, $newPassword);
        sendEmail($email, 'Khôi phục tài khoản', 'Mật khẩu khôi phục tài khoản của bạn: <h1>' . $newPassword . '</h1>');
        return 1;
    }
}

function checkRigister($name, $email, $password, $passwordconfirm)
{
    if ($password == $passwordconfirm) {
        //tìm xem username đã tồn tại chưa
        $user = findUserByEmail($email);

        //nếu username đã tồn tại
        if ($user) {
            return 0;
        } else {
            global $db;
            $code = strtoupper(bin2hex(random_bytes(4)));
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $user = createUserWithEmail($name, $email, $hashPassword, $code);
            $link = 'https://ltw-tuan08-18600038.herokuapp.com/BTCN08/activate.php';
            $send = sendEmail($email, 'Kích hoạt tài khoản', 'Vui lòng click vào link ' . $link . '?id=' . $user['id'] . '&code=' . $code);

            //không gửi được email
            if (!$send) {
                $stmt = $db->prepare("DELETE FROM users WHERE id=?");
                $stmt->execute(array($user['id']));
                return -2;
            }
            header('Location: login.php');
            exit();
        }
    }
    return -1;
}
