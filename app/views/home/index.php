<h1 class="h3 mb-4">Sản phẩm mới nhất</h1>
<?php if (empty($products)): ?>
<p class="text-muted">Chưa có sản phẩm nào.</p>
<?php else: ?>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
<?php foreach ($products as $p): ?>
<div class="col">
<div class="card h-100 shadow-sm">
<img src="<?= e(product_image_url($p['image'],
'thumb')) ?>"
class="card-img-top"
alt="<?= e($p['name']) ?>">
<div class="card-body d-flex flex-column">
<h2 class="h6 card-title"><?= e($p['name']) ?></h2>
<p class="text-danger fw-bold mt-auto mb-0">
<?= format_vnd($p['price']) ?>
</p>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>