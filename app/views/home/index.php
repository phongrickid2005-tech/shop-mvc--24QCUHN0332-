<div id="homeBanner" class="carousel slide mb-5 rounded overflow-hidden"
data-bs-ride="carousel">
<div class="carousel-inner">
<div class="carousel-item active">
<div class="d-flex align-items-center justify-content-center
text-white text-center"
style="height: 280px; background: linear-gradient(135deg,
#0d6efd, #6610f2);">
<div>
<h2 class="fw-bold">Chào mừng đến ShopOnline</h2>
<p class="mb-0">Hàng ngàn sản phẩm chính hãng, giá tốt
mỗi ngày</p>
</div>
</div>
</div>
<div class="carousel-item">
<div class="d-flex align-items-center justify-content-center
text-white text-center"
style="height: 280px; background: linear-gradient(135deg,
#198754, #20c997);">
<div>

<h2 class="fw-bold">Miễn phí vận chuyển</h2>
<p class="mb-0">Cho đơn hàng từ 500.000đ trở lên</p>
</div>
</div>
</div>
<div class="carousel-item">
<div class="d-flex align-items-center justify-content-center
text-white text-center"
style="height: 280px; background: linear-gradient(135deg,
#fd7e14, #dc3545);">
<div>
<h2 class="fw-bold">Ưu đãi thành viên</h2>
<p class="mb-0">Đăng ký tài khoản để nhận mã giảm
giá</p>
</div>
</div>
</div>
</div>

<button class="carousel-control-prev" type="button" data-bs-
target="#homeBanner" data-bs-slide="prev">

<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-
target="#homeBanner" data-bs-slide="next">

<span class="carousel-control-next-icon"></span>
</button>
</div>
<h2 class="h5 mb-3">Sản phẩm nổi bật</h2>
<?php if (empty($featured)): ?>
<p class="text-muted mb-5">Chưa có sản phẩm nổi bật.</p>
<?php else: ?>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
<?php foreach ($featured as $p): ?>
<?= product_card_html($p) ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
<h2 class="h5 mb-3">Sản phẩm mới nhất</h2>
<?php if (empty($newest)): ?>
<p class="text-muted mb-5">Chưa có sản phẩm nào.</p>
<?php else: ?>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
<?php foreach ($newest as $p): ?>
<?= product_card_html($p) ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
<h2 class="h5 mb-3">Khuyến mãi</h2>
<div class="alert alert-light border text-muted mb-0">
Các mã giảm giá đang áp dụng sẽ hiển thị tại đây từ Buổi 7, sau khi xây

dựng xong chức năng khuyến mãi và tính tiền ở máy chủ.
</div>