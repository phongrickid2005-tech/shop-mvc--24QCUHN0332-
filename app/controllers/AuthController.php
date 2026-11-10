<?php
// app/controllers/AuthController.php
class AuthController extends Controller
{
public function register(): void
{
if (Auth::check()) {
$this->redirect('');
return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->handleRegister();
return;
}
$old = $_SESSION['old_register'] ?? [];
unset($_SESSION['old_register']);
$this->view('auth/register', ['pageTitle' => 'Đăng ký', 'old' =>
$old]);
}
protected function handleRegister(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['password_confirm'] ?? '';
$errors = [];
if ($fullName === '') {
$errors[] = 'Vui lòng nhập họ tên.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
$errors[] = 'Email không hợp lệ.';
} elseif (User::findByEmail($email)) {

$errors[] = 'Email này đã được đăng ký.';
}
if (strlen($password) < 6) {
$errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
}
if ($password !== $passwordConfirm) {
$errors[] = 'Xác nhận mật khẩu không khớp.';
}
if (!empty($errors)) {
flash('error', implode('<br>', array_map('e', $errors)));
$_SESSION['old_register'] = ['full_name' => $fullName, 'email'
=> $email];
$this->redirect('auth/register');
return;
}
User::insert([
'full_name' => $fullName,
'email' => $email,
'password' => password_hash($password, PASSWORD_DEFAULT),
'role' => 'customer',
'status' => 'active',
]);
flash('success', 'Đăng ký thành công, vui lòng đăng nhập.');
$this->redirect('auth/login');
}
public function login(): void
{
if (Auth::check()) {
$this->redirect('');
return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->handleLogin();
return;
}
$this->view('auth/login', ['pageTitle' => 'Đăng nhập']);
}
protected function handleLogin(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$user = User::findByEmail($email);
if (!$user || !password_verify($password, $user['password'])) {

flash('error', 'Email hoặc mật khẩu không đúng.');
$this->redirect('auth/login');
return;
}
if ($user['status'] !== 'active') {
flash('error', 'Tài khoản của bạn đã bị khoá.');
$this->redirect('auth/login');
return;
}
Auth::login($user);
flash('success', 'Đăng nhập thành công.');
$this->redirect('');
}
public function logout(): void
{
Auth::logout();
$this->redirect('auth/login');
}
}