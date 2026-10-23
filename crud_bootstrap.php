<?php
require_once __DIR__ . '/config/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function csrf_field() {
    echo '<input type="hidden" name="csrf" value="' . h($_SESSION['csrf']) . '">';
}
function verify_csrf() {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
}
function valid_id($value) {
    $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? null : $id;
}
function page_start($title) {
    echo '<!doctype html><html lang="th"><head><meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
    echo '<title>' . h($title) . '</title><link rel="stylesheet" href="assets/css/crud.css">';
    echo '</head><body><main class="wrap"><nav><a href="index.php">หน้าหลัก</a> ';
    echo '<a href="skills.php">จัดการ Skills</a> <a href="skill_create.php">เพิ่ม Skill</a> ';
    if (!empty($_SESSION['user_id'])) echo '<a href="logout.php">ออกจากระบบ</a>';
    echo '</nav><section class="panel"><h1>' . h($title) . '</h1>';
}
function page_end() {
    echo '</section></main></body></html>';
}
