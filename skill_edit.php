<?php
require_once __DIR__ . '/crud_bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$id = valid_id($_GET['id'] ?? null);
$userId = (int)$_SESSION['user_id'];
if ($id === null) { http_response_code(400); exit('Invalid ID'); }

$stmt = mysqli_prepare($conn, 'SELECT skill_name, skill_level FROM skill WHERE id = ? AND user_id = ?');
mysqli_stmt_bind_param($stmt, 'ii', $id, $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name, $level);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if (!$found) { http_response_code(404); exit('Skill not found'); }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['skill_name'] ?? '');
    $level = trim($_POST['skill_level'] ?? '');
    if ($name === '' || $level === '') {
        $error = 'กรุณากรอกข้อมูลให้ครบ';
    } else {
        $stmt = mysqli_prepare($conn, 'UPDATE skill SET skill_name = ?, skill_level = ? WHERE id = ? AND user_id = ?');
        mysqli_stmt_bind_param($stmt, 'ssii', $name, $level, $id, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: skills.php?success=1');
        exit;
    }
}
page_start('แก้ไข Skill');
if ($error) echo '<p class="err">' . h($error) . '</p>';
?>
<form method="post">
  <?php csrf_field(); ?>
  <p><label>ชื่อ Skill<br><input name="skill_name" required maxlength="100" value="<?= h($name) ?>"></label></p>
  <p><label>ระดับ<br><input name="skill_level" required maxlength="50" value="<?= h($level) ?>"></label></p>
  <button type="submit">บันทึกการแก้ไข</button>
</form>
<?php page_end(); ?>
