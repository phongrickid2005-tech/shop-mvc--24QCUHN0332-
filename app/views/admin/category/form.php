<?php $isEdit = $category !== null; ?>
<form method="POST"
action="<?= e($isEdit ? base_url('admin/category/edit/' .
$category['id']) : base_url('admin/category/add')) ?>"
class="col-md-6">
<?= csrf_field() ?>
<div class="mb-3">
<label class="form-label">Tên danh mục</label>
<input type="text" name="name" class="form-control" value="<?=
e($category['name'] ?? '') ?>" required>
</div>
<div class="form-check mb-3">

<input type="checkbox" name="status" class="form-check-input"
id="statusCheck"
<?= (!$isEdit || $category['status'] === 'active') ?
'checked' : '' ?>>
<label class="form-check-label" for="statusCheck">Hiển thị danh
mục</label>
</div>
<button type="submit" class="btn btn-primary"><?= $isEdit ? 'Lưu thay
đổi' : 'Thêm danh mục' ?></button>

<a href="<?= e(base_url('admin/category')) ?>" class="btn btn-outline-
secondary">Huỷ</a>

</form>