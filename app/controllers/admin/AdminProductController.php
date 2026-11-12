<?php
// app/controllers/admin/AdminProductController.php
class AdminProductController extends AdminController
{
public function index(): void
{
$sql = "SELECT p.*, c.name AS category_name,
pi.file_name AS image,

(SELECT COUNT(*) FROM product_images WHERE

product_id = p.id) AS image_count
FROM products p
JOIN categories c ON c.id = p.category_id
LEFT JOIN product_images pi ON pi.product_id = p.id AND
pi.is_primary = 1
ORDER BY p.created_at DESC";
$products = Database::getInstance()->query($sql)->fetchAll();
$this->view('admin/product/index', ['pageTitle' => 'Quản lý sản
phẩm', 'products' => $products]);
}
public function add(): void
{
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->store();
return;
}
$this->view('admin/product/form', [
'pageTitle' => 'Thêm sản phẩm',
'categories' => Category::all('name ASC'),
'product' => null,
]);
}

protected function store(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
[$data, $errors] = $this->validateProduct($_POST, null);
if (!empty($errors)) {
flash('error', implode('<br>', array_map('e', $errors)));
$this->redirect('admin/product/add');
return;
}
$productId = Product::insert($data);
flash('success', 'Đã thêm sản phẩm. Hãy tải ảnh cho sản phẩm ở phần
bên dưới.');
$this->redirect('admin/product/edit/' . $productId);
}
public function edit($id): void
{
$product = Product::find((int) $id);
if (!$product) {
flash('error', 'Sản phẩm không tồn tại.');
$this->redirect('admin/product');
return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->updateProduct((int) $id);
return;
}
$this->view('admin/product/form', [
'pageTitle' => 'Sửa sản phẩm',
'categories' => Category::all('name ASC'),
'product' => $product,
'images' => ProductImage::forProduct((int) $id),
]);
}
protected function updateProduct(int $id): void
{
verify_csrf($_POST['csrf_token'] ?? '');
[$data, $errors] = $this->validateProduct($_POST, $id);
if (!empty($errors)) {
flash('error', implode('<br>', array_map('e', $errors)));
$this->redirect('admin/product/edit/' . $id);
return;
}
// Chi cap nhat thong tin san pham - KHONG dong den anh (anh quan

ly rieng,
// xem AdminProductImageController) => sua thong tin KHONG lam mat
anh.
Product::update($id, $data);
flash('success', 'Đã cập nhật sản phẩm.');
$this->redirect('admin/product/edit/' . $id);
}
public function delete(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$id = (int) ($_POST['id'] ?? 0);
// Xoa toan bo anh (tep + ban ghi) TRUOC khi xoa san pham
ProductImage::deleteAllForProduct($id);
Product::delete($id);
flash('success', 'Đã xoá sản phẩm và toàn bộ ảnh liên quan.');
$this->redirect('admin/product');
}
/** @return array{0: array, 1: string[]} [du_lieu_de_luu,
danh_sach_loi] */
protected function validateProduct(array $input, ?int $excludeId):
array
{
$errors = [];
$name = trim($input['name'] ?? '');
$sku = trim($input['sku'] ?? '');
$categoryId = (int) ($input['category_id'] ?? 0);
$price = (float) ($input['price'] ?? 0);
$stock = (int) ($input['stock'] ?? 0);
if ($name === '') {
$errors[] = 'Tên sản phẩm không được để trống.';
}
if ($sku === '') {
$errors[] = 'SKU không được để trống.';
} elseif (Product::skuExists($sku, $excludeId)) {
$errors[] = 'SKU đã tồn tại, vui lòng chọn mã khác.';
}
if ($categoryId <= 0 || !Category::find($categoryId)) {
$errors[] = 'Vui lòng chọn danh mục hợp lệ.';
}
if ($price <= 0) {
$errors[] = 'Giá phải lớn hơn 0.';
}
if ($stock < 0) {
$errors[] = 'Tồn kho không được là số âm.';
}
$data = [

'category_id' => $categoryId,
'sku' => $sku,
'name' => $name,
'brand' => trim($input['brand'] ?? ''),
'description' => trim($input['description'] ?? ''),
'price' => $price,
'stock' => $stock,
'is_featured' => isset($input['is_featured']) ? 1 : 0,
'status' => in_array($input['status'] ?? '', ['active',
'inactive'], true) ? $input['status'] : 'active',
];
return [$data, $errors];
}
}