<?php
require_once __DIR__ . '/crud_bootstrap.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: skills.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($conn, 'SELECT id, password_hash FROM users WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $userId, $passwordHash);

    if (mysqli_stmt_fetch($stmt) && password_verify($password, $passwordHash)) {
        mysqli_stmt_close($stmt);
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$userId;
        header('Location: skills.php');
        exit;
    }
    mysqli_stmt_close($stmt);
    $error = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
}

page_start('เข้าสู่ระบบ');
if ($error !== '') echo '<p class="err">' . h($error) . '</p>';
?>
<form method="post" action="login.php">
  <?php csrf_field(); ?>
  <p><label>อีเมล<br><input type="email" name="email" required autocomplete="username"></label></p>
  <p><label>รหัสผ่าน<br><input type="password" name="password" required autocomplete="current-password"></label></p>
  <button type="submit">เข้าสู่ระบบ</button>
</form>
<?php page_end(); ?>
