<?php
require_once __DIR__ . '/crud_bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['skill_name'] ?? '');
    $level = trim($_POST['skill_level'] ?? '');
    if ($name === '' || $level === '') {
        $error = 'กรุณากรอกข้อมูลให้ครบ';
    } else {
        $userId = (int)$_SESSION['user_id'];
        $stmt = mysqli_prepare($conn, 'INSERT INTO skill (user_id, skill_name, skill_level) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'iss', $userId, $name, $level);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: skills.php?success=1');
        exit;
    }
}
page_start('เพิ่ม Skill');
if ($error) echo '<p class="err">' . h($error) . '</p>';
?>
<form method="post">
  <?php csrf_field(); ?>
  <p><label>ชื่อ Skill<br><input name="skill_name" required maxlength="100"></label></p>
  <p><label>ระดับ<br><input name="skill_level" required maxlength="50" placeholder="เช่น Beginner, Intermediate, Advanced"></label></p>
  <button type="submit">บันทึก</button>
</form>
<?php page_end(); ?>
