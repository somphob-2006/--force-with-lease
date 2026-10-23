<?php
require_once __DIR__ . '/crud_bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$rows = [];
$stmt = mysqli_prepare($conn, 'SELECT id, skill_name, skill_level FROM skill WHERE user_id = ? ORDER BY id DESC');
$userId = (int)$_SESSION['user_id'];
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $name, $level);
while (mysqli_stmt_fetch($stmt)) {
    $rows[] = ['id' => $id, 'skill_name' => $name, 'skill_level' => $level];
}
mysqli_stmt_close($stmt);

page_start('จัดการ Skills');
if (isset($_GET['success'])) echo '<p class="ok">บันทึกข้อมูลเรียบร้อยแล้ว</p>';
echo '<p><a class="button" href="skill_create.php">+ เพิ่ม Skill</a></p>';
echo '<table><tr><th>ID</th><th>Skill</th><th>Level</th><th>Actions</th></tr>';
foreach ($rows as $row) {
    echo '<tr><td>' . h($row['id']) . '</td><td>' . h($row['skill_name']) . '</td><td>' . h($row['skill_level']) . '</td>';
    echo '<td><a href="skill_edit.php?id=' . urlencode((string)$row['id']) . '">แก้ไข</a> | ';
    echo '<a href="skill_delete.php?id=' . urlencode((string)$row['id']) . '">ลบ</a></td></tr>';
}
echo '</table>';
page_end();
