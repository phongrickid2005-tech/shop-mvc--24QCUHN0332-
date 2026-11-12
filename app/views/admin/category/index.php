<div class="d-flex justify-content-end mb-3">

<a href="<?= e(base_url('admin/category/add')) ?>" class="btn btn-
primary">+ Thêm danh mục</a>

</div>
<div class="table-responsive">
<table class="table table-bordered bg-white align-middle">
<thead class="table-light">
<tr>
<th>#</th><th>Tên danh mục</th><th>Slug</th><th>Số sản
phẩm</th><th>Trạng thái</th>

<th style="width: 170px;">Thao tác</th>
</tr>
</thead>
<tbody>
<?php foreach ($categories as $c): ?>
<tr>
<td><?= (int) $c['id'] ?></td>
<td><?= e($c['name']) ?></td>
<td><code><?= e($c['slug']) ?></code></td>
<td><?= (int) $c['product_count'] ?></td>
<td>
<?php if ($c['status'] === 'active'): ?>
<span class="badge bg-success">Hiển thị</span>
<?php else: ?>
<span class="badge bg-secondary">Đang ẩn</span>
<?php endif; ?>
</td>
<td>
<a href="<?= e(base_url('admin/category/edit/' .
$c['id'])) ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
<form method="POST" action="<?=
e(base_url('admin/category/delete')) ?>" class="d-inline"
onsubmit="return confirm('Xoá danh mục này?');">
<?= csrf_field() ?>
<input type="hidden" name="id" value="<?= (int)
$c['id'] ?>">
<button class="btn btn-sm btn-outline-danger"
<?= $c['product_count'] > 0 ? 'disabled
title="Còn sản phẩm, không thể xoá"' : '' ?>>
Xoá
</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>