<h1 class="h4 mb-4">Giỏ hàng của bạn</h1>
<?php if (empty($cart['lines'])): ?>
<div class="alert alert-light border text-center py-5">
Giỏ hàng đang trống. <a href="<?= e(base_url('')) ?>">Tiếp tục mua
sắm</a>.
</div>
<?php else: ?>
<div class="table-responsive">

<table class="table align-middle bg-white">
<thead>
<tr>
<th>Sản phẩm</th>
<th>Đơn giá</th>
<th style="width: 160px;">Số lượng</th>
<th>Thành tiền</th>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach ($cart['lines'] as $line): ?>
<tr>
<td>
<div class="d-flex align-items-center gap-3">
<img src="<?=
e(product_image_url($line['image'], 'thumb')) ?>"
alt="<?= e($line['name']) ?>"

style="width: 64px; height: 64px; object-
fit: cover;"

class="rounded border">
<a href="<?= e(base_url('product/detail/' .
$line['product_id'])) ?>" class="text-decoration-none text-dark">
<?= e($line['name']) ?>
</a>
</div>
</td>

<td><?= format_vnd($line['price']) ?></td>
<td>

<form method="POST" action="<?=
e(base_url('cart/update')) ?>" class="d-flex gap-1">
<?= csrf_field() ?>

<input type="hidden" name="product_id"

value="<?= (int) $line['product_id'] ?>">
<input type="number" name="quantity" value="<?=
(int) $line['quantity'] ?>"
min="1" max="<?= (int) $line['stock']
?>"
class="form-control form-control-sm"
style="width: 70px;">

<button type="submit" class="btn btn-sm btn-
outline-secondary">Cập nhật</button>

</form>
</td>

<td class="text-danger fw-bold"><?=

format_vnd($line['line_total']) ?></td>
<td>
<form method="POST" action="<?=
e(base_url('cart/remove')) ?>">
<?= csrf_field() ?>

<input type="hidden" name="product_id"

value="<?= (int) $line['product_id'] ?>">
<button type="submit" class="btn btn-sm btn-

outline-danger">Xóa</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<div class="d-flex justify-content-between align-items-center mt-4">
<form method="POST" action="<?= e(base_url('cart/clear')) ?>"
onsubmit="return confirm('Xóa toàn bộ giỏ hàng?');">
<?= csrf_field() ?>

<button type="submit" class="btn btn-outline-secondary btn-
sm">Xóa toàn bộ giỏ hàng</button>

</form>
<div class="text-end">

<p class="h5 mb-3">Tổng tiền hàng: <span class="text-
danger"><?= format_vnd($cart['subtotal']) ?></span></p>

<button class="btn btn-primary" disabled title="Sẽ hoàn thiện ở
Buổi 7-8">Tiến hành thanh toán</button>
</div>
</div>
<?php endif; ?>