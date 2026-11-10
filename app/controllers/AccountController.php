<?php
// app/controllers/AccountController.php
class AccountController extends Controller
{
public function __construct()
{
Auth::requireLogin();
}
public function profile(): void
{
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->update();
return;
}
$userRow = User::find(Auth::id());
$this->view('account/profile', ['pageTitle' => 'Hồ sơ cá nhân',
'userRow' => $userRow]);
}
protected function update(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$fullName = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
if ($fullName === '') {
flash('error', 'Họ tên không được để trống.');
$this->redirect('account/profile');
return;
}
User::update(Auth::id(), [
'full_name' => $fullName,
'phone' => $phone,
'address' => $address,
]);
// Dong bo lai ten hien thi tren menu (dang luu trong session)
$_SESSION['user']['full_name'] = $fullName;
$newPassword = $_POST['new_password'] ?? '';
if ($newPassword !== '') {
if (strlen($newPassword) < 6) {
flash('error', 'Đã lưu thông tin hồ sơ, nhưng mật khẩu mới
phải có ít nhất 6 ký tự nên chưa đổi.');

$this->redirect('account/profile');
return;
}
User::update(Auth::id(), ['password' =>
password_hash($newPassword, PASSWORD_DEFAULT)]);
}
flash('success', 'Cập nhật hồ sơ thành công.');
$this->redirect('account/profile');
}
}