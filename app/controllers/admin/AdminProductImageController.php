<?php
// app/controllers/admin/AdminProductImageController.php
// Nhan request AJAX/POST tu khu vuc "Anh san pham" trong trang sua san
pham.
class AdminProductImageController extends AdminController
{
/** Tai len nhieu anh cung luc - moi anh xu ly doc lap, tra ket quarieng cho tung anh */
public function upload(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$productId = (int) ($_POST['product_id'] ?? 0);
$product = Product::find($productId);
if (!$product) {
flash('error', 'Sản phẩm không tồn tại.');
$this->redirect('admin/product');
return;
}
$currentCount = ProductImage::countForProduct($productId);
$files = $this->normalizeFiles($_FILES['images'] ?? []);
if (empty($files)) {
flash('error', 'Vui lòng chọn ít nhất một tệp ảnh.');

$this->redirect('admin/product/edit/' . $productId);
return;
}
$results = [];
foreach ($files as $file) {
if ($currentCount >= UPLOAD_MAX_IMAGES) {
$results[] = e($file['name']) . ': đã đạt tối đa ' .UPLOAD_MAX_IMAGES . ' ảnh, bỏ qua.';
continue;
}
$errors = ImageService::validate($file);
if (!empty($errors)) {
$results[] = e($file['name']) . ': ' . e(implode('; ',$errors));
continue;
}
try {
$saved = ImageService::processAndSave($file);
} catch (Throwable $e) {
error_log('ImageService::processAndSave loi: ' . $e->getMessage());
$results[] = e($file['name']) . ': lỗi xử lý ảnh phía máychủ.';
continue;
}
$isFirstImage = $currentCount === 0;
ProductImage::insert([
'product_id' => $productId,
'file_name' => $saved['file_name'],
'original_name' => $saved['original_name'],
'alt_text' => $product['name'],
'is_primary' => $isFirstImage ? 1 : 0,
'sort_order' => ProductImage::nextSortOrder($productId),
]);
$currentCount++;
$results[] = e($file['name']) . ': tải lên thành công.';
}
// Luu y: moi dong trong $results da duoc e() tu truoc, nen khonge() lai o day
flash('success', implode('<br>', $results));
$this->redirect('admin/product/edit/' . $productId);
}
public function setPrimary(): void
{
verify_csrf($_POST['csrf_token'] ?? '');

$productId = (int) ($_POST['product_id'] ?? 0);
$imageId = (int) ($_POST['image_id'] ?? 0);
ProductImage::setPrimary($imageId, $productId);
flash('success', 'Đã đặt làm ảnh đại diện.');
$this->redirect('admin/product/edit/' . $productId);
}
public function delete(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$productId = (int) ($_POST['product_id'] ?? 0);
$imageId = (int) ($_POST['image_id'] ?? 0);
ProductImage::deleteImage($imageId, $productId);
flash('success', 'Đã xoá ảnh.');
$this->redirect('admin/product/edit/' . $productId);
}
public function reorder(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$productId = (int) ($_POST['product_id'] ?? 0);
$imageId = (int) ($_POST['image_id'] ?? 0);
$direction = ($_POST['direction'] ?? '') === 'down' ? 'down' :'up';
ProductImage::swapOrder($imageId, $productId, $direction);
$this->redirect('admin/product/edit/' . $productId);
}
public function updateAlt(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$productId = (int) ($_POST['product_id'] ?? 0);
$imageId = (int) ($_POST['image_id'] ?? 0);
$altText = trim($_POST['alt_text'] ?? '');
ProductImage::updateAlt($imageId, $productId, $altText);
flash('success', 'Đã cập nhật văn bản thay thế.');
$this->redirect('admin/product/edit/' . $productId);
}
/** Chuan hoa $_FILES['images'] (mang nhieu tep) thanh mang cac teprieng le, de lap de */
protected function normalizeFiles(array $filesArray): array
{

if (empty($filesArray['name'])) {
return [];
}
$normalized = [];
$count = count($filesArray['name']);
for ($i = 0; $i < $count; $i++) {
if (($filesArray['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
continue;
}
$normalized[] = [
'name' => $filesArray['name'][$i],
'type' => $filesArray['type'][$i],
'tmp_name' => $filesArray['tmp_name'][$i],
'error' => $filesArray['error'][$i],
'size' => $filesArray['size'][$i],
];
}
return $normalized;
}
}