<div class="table-responsive">
<table class="table table-bordered bg-white align-middle">
<thead class="table-light">
<tr>
<th>Họ tên</th><th>Email</th><th>Nội dung</th><th>Thời
gian</th><th>Trạng thái</th>
<th style="width: 120px;">Thao tác</th>
</tr>
</thead>
<tbody>
<?php foreach ($contacts as $c): ?>
<tr>
<td><?= e($c['full_name']) ?></td>
<td><?= e($c['email']) ?></td>
<td><?= nl2br(e($c['message'])) ?></td>
<td><?= e(date('d/m/Y H:i', strtotime($c['created_at'])))
?></td>
<td>
<?php if ($c['status'] === 'resolved'): ?>
<span class="badge bg-success">Đã xử lý</span>
<?php else: ?>
<span class="badge bg-warning text-dark">Mới</span>
<?php endif; ?>
</td>
<td>
<?php if ($c['status'] !== 'resolved'): ?>
<form method="POST" action="<?=
e(base_url('admin/contact/resolve')) ?>">
<?= csrf_field() ?>
<input type="hidden" name="id" value="<?= (int)
$c['id'] ?>">

<button class="btn btn-sm btn-outline-
success">Đánh dấu đã xử lý</button>

</form>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>