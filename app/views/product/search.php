<h1 class="h4 mb-1">
<?php if ($filters['q'] !== ''): ?>
Kết quả tìm kiếm cho “<?= e($filters['q']) ?>”
<?php else: ?>
Tất cả sản phẩm
<?php endif; ?>
</h1>

<p class="text-muted mb-4">Tìm thấy <?= (int) $result['total'] ?> sản
phẩm.</p>
<div class="row">
<div class="col-md-3 mb-4">
<form method="GET" action="<?= e(base_url('product/search')) ?>"
class="card card-body shadow-sm">
<input type="hidden" name="q" value="<?= e($filters['q']) ?>">
<input type="hidden" name="sort" value="<?= e($filters['sort'])
?>">
<h2 class="h6">Danh mục</h2>

<select name="category" class="form-select form-select-sm mb-
3">

<option value="">Tất cả danh mục</option>
<?php foreach ($categories as $c): ?>
<option value="<?= (int) $c['id'] ?>"
<?= (string) $filters['category'] === (string)
$c['id'] ? 'selected' : '' ?>>
<?= e($c['name']) ?>
</option>
<?php endforeach; ?>
</select>
<?php if (!empty($brands)): ?>
<h2 class="h6">Thương hiệu</h2>
<?php foreach ($brands as $b): ?>
<div class="form-check">
<input class="form-check-input" type="checkbox"
name="brand[]"
value="<?= e($b) ?>" id="brand_<?= e($b) ?>"
<?= in_array($b, (array) $filters['brand'],

true) ? 'checked' : '' ?>>
<label class="form-check-label small"
for="brand_<?= e($b) ?>"><?= e($b) ?></label>
</div>
<?php endforeach; ?>
<?php endif; ?>
<h2 class="h6 mt-3">Khoảng giá (đ)</h2>
<div class="input-group input-group-sm mb-2">
<input type="number" name="price_from" class="form-control"
placeholder="Từ" min="0"
value="<?= e((string) $filters['price_from']) ?>">
<input type="number" name="price_to" class="form-control"
placeholder="Đến" min="0"
value="<?= e((string) $filters['price_to']) ?>">
</div>
<button type="submit" class="btn btn-sm btn-primary mt-2">Áp
dụng lọc</button>

<a href="<?= e(base_url('product/search')) ?>" class="btn btn-
sm btn-outline-secondary mt-2">Xóa lọc</a>

</form>
</div>
<div class="col-md-9">
<div class="d-flex justify-content-end mb-3">
<div class="dropdown">

<button class="btn btn-sm btn-outline-secondary dropdown-
toggle" type="button" data-bs-toggle="dropdown">

Sắp xếp: <?= e($sortLabels[$filters['sort']] ??
$sortLabels['newest']) ?>
</button>
<ul class="dropdown-menu dropdown-menu-end">
<?php foreach ($sortLabels as $key => $label): ?>
<li>
<a class="dropdown-item" href="<?=
e(query_url(['sort' => $key, 'page' => 1])) ?>">
<?= e($label) ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php if (empty($result['items'])): ?>
<div class="alert alert-light border text-center py-5">
Không tìm thấy sản phẩm phù hợp. Hãy thử từ khóa khác hoặc
bỏ bớt điều kiện lọc.
</div>
<?php else: ?>
<div class="row row-cols-2 row-cols-md-3 g-4 mb-4">
<?php foreach ($result['items'] as $p): ?>
<?= product_card_html($p) ?>
<?php endforeach; ?>
</div>
<?= pagination_html($result['page'], $result['totalPages']) ?>
<?php endif; ?>
<?php if (isset($_GET['debug'])): ?>
<p class="text-muted small mt-3">
[Debug] Số truy vấn CSDL phát sinh trong
<code>Product::search()</code>:
<?= (int) Database::$queryCount ?>
</p>
<?php endif; ?>
</div>
</div>