<?php
// app/controllers/admin/AdminCategoryController.php
class AdminCategoryController extends AdminController
{
public function index(): void
{
$sql = "SELECT c.*, COUNT(p.id) AS product_count
FROM categories c
LEFT JOIN products p ON p.category_id = c.id
GROUP BY c.id

ORDER BY c.name ASC";
$categories = Database::getInstance()->query($sql)->fetchAll();
$this->view('admin/category/index', ['pageTitle' => 'Quản lý danh
mục', 'categories' => $categories]);
}
public function add(): void
{
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->store();
return;
}
$this->view('admin/category/form', ['pageTitle' => 'Thêm danh mục',
'category' => null]);
}
protected function store(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$name = trim($_POST['name'] ?? '');
if ($name === '') {
flash('error', 'Tên danh mục không được để trống.');
$this->redirect('admin/category/add');
return;
}
Category::insert([
'name' => $name,
'slug' => Category::slugify($name),
'status' => isset($_POST['status']) ? 'active' : 'inactive',
]);
flash('success', 'Đã thêm danh mục.');
$this->redirect('admin/category');
}
public function edit($id): void
{
$category = Category::find((int) $id);
if (!$category) {
flash('error', 'Danh mục không tồn tại.');
$this->redirect('admin/category');
return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->updateCategory((int) $id);
return;
}
$this->view('admin/category/form', ['pageTitle' => 'Sửa danh mục',
'category' => $category]);

}
protected function updateCategory(int $id): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$name = trim($_POST['name'] ?? '');
if ($name === '') {
flash('error', 'Tên danh mục không được để trống.');
$this->redirect('admin/category/edit/' . $id);
return;
}
Category::update($id, [
'name' => $name,
'slug' => Category::slugify($name),
'status' => isset($_POST['status']) ? 'active' : 'inactive',
]);
flash('success', 'Đã cập nhật danh mục.');
$this->redirect('admin/category');
}
public function delete(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$id = (int) ($_POST['id'] ?? 0);
if (Category::countProducts($id) > 0) {
flash('error', 'Không thể xoá danh mục đang có sản phẩm. Hãy
chuyển sản phẩm sang danh mục khác hoặc ẩn danh mục này.');
$this->redirect('admin/category');
return;
}
Category::delete($id);
flash('success', 'Đã xoá danh mục.');
$this->redirect('admin/category');
}
}