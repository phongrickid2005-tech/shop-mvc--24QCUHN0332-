<div class="d-flex justify-content-end mb-3">

<a href="<?= e(base_url('admin/product/add')) ?>" class="btn btn-
primary">+ Thêm sản phẩm</a>

</div>
<div class="table-responsive">
<table class="table table-bordered bg-white align-middle">
<thead class="table-light">
<tr>
<th>Ảnh</th><th>SKU</th><th>Tên sản phẩm</th><th>Danh mục</th>
<th>Giá</th><th>Tồn</th><th>Số ảnh</th><th>Trạng thái</th>
<th style="width: 140px;">Thao tác</th>
</tr>
</thead>
<tbody>
<?php foreach ($products as $p): ?>
<tr>
<td>
<img src="<?= e(product_image_url($p['image'],
'thumb')) ?>"
width="48" height="48" style="object-fit: cover;"
alt="">
</td>
<td><?= e($p['sku']) ?></td>
<td><?= e($p['name']) ?></td>
<td><?= e($p['category_name']) ?></td>
<td><?= format_vnd($p['price']) ?></td>
<td><?= (int) $p['stock'] ?></td>
<td><?= (int) $p['image_count'] ?>/<?= UPLOAD_MAX_IMAGES
?></td>
<td>
<?php if ($p['status'] === 'active'): ?>
<span class="badge bg-success">Đang bán</span>
<?php else: ?>
<span class="badge bg-secondary">Ngừng bán</span>

<?php endif; ?>
</td>
<td>
<a href="<?= e(base_url('admin/product/edit/' .
$p['id'])) ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
<form method="POST" action="<?=
e(base_url('admin/product/delete')) ?>" class="d-inline"
onsubmit="return confirm('Xoá sản phẩm này và toàn bộ ảnh của nó?');">
<?= csrf_field() ?>
<input type="hidden" name="id" value="<?= (int)
$p['id'] ?>">

<button class="btn btn-sm btn-outline-
danger">Xoá</button>

</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>