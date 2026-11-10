<?php
// app/core/Auth.php
// Quan ly phien dang nhap va kiem tra quyen truy cap
class Auth
{
/** Dang nhap: luu thong tin can thiet vao session, doi session id */

public static function login(array $user): void
{
session_regenerate_id(true);
$_SESSION['user'] = [
'id' => $user['id'],
'full_name' => $user['full_name'],
'email' => $user['email'],
'role' => $user['role'],
];
}
/** Dang xuat: xoa thong tin dang nhap va doi session id */
public static function logout(): void
{
unset($_SESSION['user']);
session_regenerate_id(true);
}
public static function check(): bool
{
return isset($_SESSION['user']);
}
public static function user(): ?array
{
return $_SESSION['user'] ?? null;
}
public static function id(): ?int
{
return isset($_SESSION['user']['id']) ? (int)
$_SESSION['user']['id'] : null;
}
public static function role(): ?string
{
return $_SESSION['user']['role'] ?? null;
}
/** Chan truy cap neu chua dang nhap */
public static function requireLogin(): void
{
if (!self::check()) {
flash('error', 'Vui lòng đăng nhập để tiếp tục.');
header('Location: ' . base_url('auth/login'));
exit;
}
}
/** Chan truy cap neu da dang nhap nhung khong thuoc danh sach vai tro cho phep */
public static function requireRole(array $roles): void
{
self::requireLogin();

if (!in_array(self::role(), $roles, true)) {
http_response_code(403);
require __DIR__ . '/../views/errors/403.php';
exit;
}
}
}