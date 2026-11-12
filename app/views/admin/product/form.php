<?php $isEdit = $product !== null; ?>
<form method="POST"
action="<?= e($isEdit ? base_url('admin/product/edit/' .
$product['id']) : base_url('admin/product/add')) ?>"
class="row g-3 mb-5">
<?= csrf_field() ?>
<div class="col-md-4">
<label class="form-label">SKU</label>
<input type="text" name="sku" class="form-control" value="<?=
e($product['sku'] ?? '') ?>" required>
</div>
<div class="col-md-8">
<label class="form-label">Tên sản phẩm</label>
<input type="text" name="name" class="form-control" value="<?=
e($product['name'] ?? '') ?>" required>

</div>
<div class="col-md-6">
<label class="form-label">Danh mục</label>
<select name="category_id" class="form-select" required>
<option value="">-- Chọn danh mục --</option>
<?php foreach ($categories as $c): ?>
<option value="<?= (int) $c['id'] ?>"
<?= isset($product['category_id']) && (int)
$product['category_id'] === (int) $c['id'] ? 'selected' : '' ?>>
<?= e($c['name']) ?>
</option>
<?php endforeach; ?>
</select>
</div>
<div class="col-md-6">
<label class="form-label">Thương hiệu</label>
<input type="text" name="brand" class="form-control" value="<?=
e($product['brand'] ?? '') ?>">
</div>
<div class="col-12">
<label class="form-label">Mô tả</label>
<textarea name="description" class="form-control" rows="4"><?=
e($product['description'] ?? '') ?></textarea>
</div>
<div class="col-md-4">
<label class="form-label">Giá bán (đ)</label>
<input type="number" name="price" class="form-control" min="1"
step="1000"
value="<?= e((string) ($product['price'] ?? '')) ?>"
required>
</div>
<div class="col-md-4">
<label class="form-label">Tồn kho</label>
<input type="number" name="stock" class="form-control" min="0"
value="<?= e((string) ($product['stock'] ?? 0)) ?>"
required>
</div>
<div class="col-md-4">
<label class="form-label">Trạng thái kinh doanh</label>
<select name="status" class="form-select">
<option value="active" <?= ($product['status'] ?? 'active') ===
'active' ? 'selected' : '' ?>>Đang bán</option>
<option value="inactive" <?= ($product['status'] ?? '') ===
'inactive' ? 'selected' : '' ?>>Ngừng bán</option>
</select>
</div>
<div class="col-12 form-check">
<input type="checkbox" name="is_featured" class="form-check-input"
id="featuredCheck"

<?= !empty($product['is_featured']) ? 'checked' : '' ?>>
<label class="form-check-label" for="featuredCheck">Sản phẩm nổi
bật</label>
</div>
<div class="col-12">
<button type="submit" class="btn btn-primary">
<?= $isEdit ? 'Lưu thay đổi' : 'Thêm sản phẩm, tiếp tục thêm
ảnh' ?>
</button>

<a href="<?= e(base_url('admin/product')) ?>" class="btn btn-
outline-secondary">Huỷ</a>

</div>
</form>
<?php if ($isEdit): ?>
<hr>
<h2 class="h5 mb-3">
Ảnh sản phẩm
<span class="badge bg-secondary"><?= count($images) ?>/<?=
UPLOAD_MAX_IMAGES ?></span>
</h2>
<div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
<?php foreach ($images as $img): ?>
<div class="col">

<div class="card h-100 <?= $img['is_primary'] ? 'border-
primary border-2' : '' ?>">

<img src="<?= e(product_image_url($img['file_name'],
'thumb')) ?>"
class="card-img-top" style="aspect-ratio: 1/1;
object-fit: cover;"
alt="<?= e($img['alt_text'] ?? '') ?>">
<div class="card-body p-2">
<?php if ($img['is_primary']): ?>
<span class="badge bg-primary mb-2 d-block">Ảnh
đại diện</span>
<?php else: ?>
<form method="POST" action="<?=
e(base_url('admin/productImage/setPrimary')) ?>" class="mb-2">
<?= csrf_field() ?>
<input type="hidden" name="product_id"
value="<?= (int) $product['id'] ?>">
<input type="hidden" name="image_id"
value="<?= (int) $img['id'] ?>">

<button class="btn btn-sm btn-outline-
primary w-100">Đặt làm đại diện</button>

</form>
<?php endif; ?>
<form method="POST" action="<?=
e(base_url('admin/productImage/updateAlt')) ?>" class="mb-2">
<?= csrf_field() ?>

<input type="hidden" name="product_id"
value="<?= (int) $product['id'] ?>">
<input type="hidden" name="image_id" value="<?=
(int) $img['id'] ?>">

<input type="text" name="alt_text" class="form-
control form-control-sm mb-1"

value="<?= e($img['alt_text'] ?? '') ?>"
placeholder="Văn bản thay thế (alt)">
<button class="btn btn-sm btn-outline-secondary
w-100">Lưu alt</button>
</form>
<?php if (!$img['is_primary']): ?>
<div class="d-flex gap-1 mb-2">
<form method="POST" action="<?=
e(base_url('admin/productImage/reorder')) ?>">
<?= csrf_field() ?>
<input type="hidden" name="product_id"
value="<?= (int) $product['id'] ?>">
<input type="hidden" name="image_id"
value="<?= (int) $img['id'] ?>">
<input type="hidden" name="direction"
value="up">

<button class="btn btn-sm btn-outline-
dark" title="Lên trước">&uarr;</button>

</form>

<form method="POST" action="<?=

e(base_url('admin/productImage/reorder')) ?>">
<?= csrf_field() ?>
<input type="hidden" name="product_id"
value="<?= (int) $product['id'] ?>">
<input type="hidden" name="image_id"
value="<?= (int) $img['id'] ?>">
<input type="hidden" name="direction"
value="down">

<button class="btn btn-sm btn-outline-
dark" title="Xuống sau">&darr;</button>

</form>
</div>
<?php endif; ?>
<form method="POST" action="<?=
e(base_url('admin/productImage/delete')) ?>"
onsubmit="return confirm('Xoá ảnh này?');">
<?= csrf_field() ?>
<input type="hidden" name="product_id"
value="<?= (int) $product['id'] ?>">
<input type="hidden" name="image_id" value="<?=
(int) $img['id'] ?>">

<button class="btn btn-sm btn-outline-danger w-
100">Xoá ảnh</button>

</form>
</div>

</div>
</div>
<?php endforeach; ?>
<?php if (empty($images)): ?>
<p class="text-muted">Sản phẩm chưa có ảnh nào. Trang chủ và
danh mục sẽ hiển thị ảnh mặc định cho đến khi có ảnh.</p>
<?php endif; ?>
</div>
<?php if (count($images) < UPLOAD_MAX_IMAGES): ?>
<form method="POST" action="<?=
e(base_url('admin/productImage/upload')) ?>"
enctype="multipart/form-data" class="col-md-8">
<?= csrf_field() ?>
<input type="hidden" name="product_id" value="<?= (int)
$product['id'] ?>">
<label class="form-label">
Thêm ảnh mới (có thể chọn nhiều tệp cùng lúc —
jpg/png/webp, tối đa 2MB mỗi ảnh)
</label>
<div class="input-group">
<input type="file" name="images[]" class="form-control"
accept=".jpg,.jpeg,.png,.webp" multiple required>
<button class="btn btn-primary">Tải lên</button>
</div>
</form>
<?php else: ?>
<p class="text-muted">Đã đạt số lượng ảnh tối đa (<?=
UPLOAD_MAX_IMAGES ?> ảnh/sản phẩm).</p>
<?php endif; ?>
<?php endif; ?>