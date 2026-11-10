<div class="table-responsive">
<table class="table table-bordered align-middle bg-white">
<thead class="table-light">
<tr>
<th>#</th>
<th>Họ tên</th>
<th>Email</th>
<th>Vai trò</th>
<th>Trạng thái</th>
<th>Ngày tạo</th>
<?php if (Auth::role() === 'admin'): ?><th style="width:
220px;">Thao tác</th><?php endif; ?>
</tr>
</thead>
<tbody>
<?php foreach ($users as $u): ?>
<tr>
<td><?= (int) $u['id'] ?></td>
<td><?= e($u['full_name']) ?></td>
<td><?= e($u['email']) ?></td>
<td><span class="badge bg-secondary"><?= e($u['role'])
?></span></td>
<td>
<?php if ($u['status'] === 'active'): ?>
<span class="badge bg-success">Đang hoạt
động</span>
<?php else: ?>
<span class="badge bg-danger">Đã khoá</span>
<?php endif; ?>
</td>
<td><?= e(date('d/m/Y', strtotime($u['created_at'])))
?></td>

<?php if (Auth::role() === 'admin'): ?>
<td>
<?php if ((int) $u['id'] === (int) Auth::id()): ?>
<span class="text-muted small">Tài khoản của
bạn</span>
<?php else: ?>
<div class="d-flex flex-column gap-2">
<form method="POST" action="<?=
e(base_url('admin/user/role')) ?>" class="d-flex gap-1">
<?= csrf_field() ?>

<input type="hidden" name="user_id"

value="<?= (int) $u['id'] ?>">
<select name="role" class="form-select
form-select-sm">
<?php foreach (['customer',
'staff', 'admin'] as $r): ?>
<option value="<?= $r ?>" <?=
$u['role'] === $r ? 'selected' : '' ?>>
<?= $r ?>
</option>
<?php endforeach; ?>
</select>

<button class="btn btn-sm btn-outline-
primary">Lưu</button>

</form>

<form method="POST" action="<?=

e(base_url('admin/user/status')) ?>">
<?= csrf_field() ?>

<input type="hidden" name="user_id"

value="<?= (int) $u['id'] ?>">
<input type="hidden" name="status"
value="<?= $u['status'] ===
'active' ? 'locked' : 'active' ?>">
<button class="btn btn-sm <?=
$u['status'] === 'active' ? 'btn-outline-danger' : 'btn-outline-success'
?>">
<?= $u['status'] === 'active' ?
'Khoá' : 'Mở khoá' ?>
</button>
</form>
</div>
<?php endif; ?>
</td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>