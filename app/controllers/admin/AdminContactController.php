<?php
// app/controllers/admin/AdminContactController.php
class AdminContactController extends AdminController
{
public function index(): void
{
$contacts = Contact::all('created_at DESC');
$this->view('admin/contact/index', ['pageTitle' => 'Liên hệ từ
khách hàng', 'contacts' => $contacts]);
}
public function resolve(): void
{
verify_csrf($_POST['csrf_token'] ?? '');

$id = (int) ($_POST['id'] ?? 0);
Contact::update($id, ['status' => 'resolved']);
flash('success', 'Đã đánh dấu đã xử lý.');
$this->redirect('admin/contact');
}
}