<?php
// app/controllers/ContactController.php
class ContactController extends Controller
{
public function index(): void
{
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->send();
return;
}
$this->view('contact/index', ['pageTitle' => 'Liên hệ']);
}
protected function send(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');
$errors = [];
if ($fullName === '') {
$errors[] = 'Vui lòng nhập họ tên.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$errors[] = 'Email không hợp lệ.';
}
if ($message === '') {
$errors[] = 'Vui lòng nhập nội dung cần liên hệ.';
}
if (!empty($errors)) {
flash('error', implode('<br>', array_map('e', $errors)));
$this->redirect('contact');
return;
}
Contact::insert([
'full_name' => $fullName,
'email' => $email,
'message' => $message,
'status' => 'new',

]);
flash('success', 'Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm
nhất.');
$this->redirect('contact');
}
}