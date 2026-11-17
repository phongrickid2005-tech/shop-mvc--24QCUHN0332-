<nav aria-label="breadcrumb" class="mb-3">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?= e(base_url('')) ?>">Trang
chủ</a></li>
<li class="breadcrumb-item">
<a href="<?= e(base_url('category/show/' . $category['slug']))
?>"><?= e($category['name']) ?></a>
</li>
<li class="breadcrumb-item active"><?= e($product['name']) ?></li>
</ol>
</nav>
<div class="row g-4">
<div class="col-md-6">
<?php $mainImage = $images[0]['file_name'] ?? null; ?>
<img id="mainImage"
src="<?= e(product_image_url($mainImage, 'full')) ?>"
alt="<?= e($images[0]['alt_text'] ?? $product['name']) ?>"
class="img-fluid rounded border mb-3"
style="aspect-ratio: 1/1; object-fit: cover; width: 100%;">
<?php if (count($images) > 1): ?>

<div class="d-flex gap-2 flex-wrap">
<?php foreach ($images as $img): ?>
<img src="<?= e(product_image_url($img['file_name'],
'thumb')) ?>"
alt="<?= e($img['alt_text'] ?? $product['name'])
?>"
class="border rounded thumb-select <?=
$img['is_primary'] ? 'border-primary border-2' : '' ?>"
style="width: 70px; height: 70px; object-fit:
cover; cursor: pointer;"
data-full="<?=
e(product_image_url($img['file_name'], 'full')) ?>"
data-alt="<?= e($img['alt_text'] ??
$product['name']) ?>">
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
<div class="col-md-6">
<h1 class="h3"><?= e($product['name']) ?></h1>
<p class="text-muted mb-2">
Thương hiệu: <?= e($product['brand'] ?: 'Đang cập nhật') ?>
&middot;
Mã SP: <?= e($product['sku']) ?>
</p>
<?php if ((int) $product['stock'] > 0): ?>
<span class="badge bg-success mb-3">Còn hàng</span>
<?php else: ?>
<span class="badge bg-danger mb-3">Hết hàng</span>
<?php endif; ?>
<p class="fs-3 text-danger fw-bold"><?=
format_vnd($product['price']) ?></p>
<p style="white-space: pre-line;"><?= e($product['description'])
?></p>
</div>
</div>
<?php if (!empty($related)): ?>
<hr class="my-5">
<h2 class="h5 mb-3">Sản phẩm liên quan</h2>
<div class="row row-cols-2 row-cols-md-4 g-4">
<?php foreach ($related as $r): ?>
<?= product_card_html($r) ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
<script>
document.querySelectorAll('.thumb-select').forEach(function (thumb) {

thumb.addEventListener('click', function () {
document.getElementById('mainImage').src = this.dataset.full;
document.getElementById('mainImage').alt = this.dataset.alt;
document.querySelectorAll('.thumb-select').forEach(function (t) {
t.classList.remove('border-primary', 'border-2');
});
this.classList.add('border-primary', 'border-2');
});
});
</script>