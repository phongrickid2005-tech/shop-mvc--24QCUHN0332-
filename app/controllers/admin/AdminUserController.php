<?php
// app/controllers/admin/AdminUserController.php
class AdminUserController extends AdminController
{
public function index(): void
{
$users = User::all('created_at DESC');
$this->view('admin/user/index', ['pageTitle' => 'Quản lý người
dùng', 'users' => $users]);
}
/** Doi vai tro - CHI admin duoc phep */
public function role(): void
{
if (Auth::role() !== 'admin') {
http_response_code(403);
require __DIR__ . '/../../views/errors/403.php';
exit;
}
verify_csrf($_POST['csrf_token'] ?? '');
$userId = (int) ($_POST['user_id'] ?? 0);
$newRole = $_POST['role'] ?? '';
if ($userId === Auth::id()) {
flash('error', 'Không thể tự đổi vai trò của chính mình.');
$this->redirect('admin/user');
return;
}
if (!in_array($newRole, ['admin', 'staff', 'customer'], true)) {
flash('error', 'Vai trò không hợp lệ.');
$this->redirect('admin/user');
return;
}
User::update($userId, ['role' => $newRole]);
flash('success', 'Đã cập nhật vai trò người dùng.');
$this->redirect('admin/user');
}
/** Khoa / mo khoa tai khoan - admin va staff deu duoc phep */
public function status(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$userId = (int) ($_POST['user_id'] ?? 0);
$newStatus = $_POST['status'] ?? '';

if ($userId === Auth::id()) {
flash('error', 'Không thể tự khoá tài khoản của chính mình.');
$this->redirect('admin/user');
return;
}
if (!in_array($newStatus, ['active', 'locked'], true)) {
flash('error', 'Trạng thái không hợp lệ.');
$this->redirect('admin/user');
return;
}
User::update($userId, ['status' => $newStatus]);
flash('success', 'Đã cập nhật trạng thái tài khoản.');
$this->redirect('admin/user');
}
}