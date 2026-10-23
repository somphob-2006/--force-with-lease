<?php
require_once __DIR__ . '/crud_bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$id = valid_id($_GET['id'] ?? null);
if ($id === null) { http_response_code(400); exit('Invalid ID'); }
$userId = (int)$_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    page_start('ยืนยันการลบ');
    ?>
    <form method="post">
      <?php csrf_field(); ?>
      <p>ต้องการลบ Skill รายการนี้หรือไม่?</p>
      <button type="submit">ยืนยันการลบ</button>
      <a href="skills.php">ยกเลิก</a>
    </form>
    <?php
    page_end();
    exit;
}
verify_csrf();
$stmt = mysqli_prepare($conn, 'DELETE FROM skill WHERE id = ? AND user_id = ?');
mysqli_stmt_bind_param($stmt, 'ii', $id, $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
header('Location: skills.php?success=1');
exit;
