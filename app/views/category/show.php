<nav aria-label="breadcrumb" class="mb-3">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?= e(base_url('')) ?>">Trang
chủ</a></li>
<li class="breadcrumb-item active"><?= e($category['name']) ?></li>
</ol>
</nav>
<h1 class="h4 mb-4"><?= e($category['name']) ?></h1>
<?php if (empty($products)): ?>
<p class="text-muted">Danh mục này hiện chưa có sản phẩm.</p>
<?php else: ?>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
<?php foreach ($products as $p): ?>
<?= product_card_html($p) ?>
<?php endforeach; ?>
</div>
<?php endif; ?>