<div class="row justify-content-center">
<div class="col-md-7 col-lg-6">
<h1 class="h4 mb-4">Hồ sơ cá nhân</h1>
<form method="POST" action="<?= e(base_url('account/profile')) ?>">
<?= csrf_field() ?>
<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" class="form-control" value="<?=
e($userRow['email']) ?>" disabled>
</div>
<div class="mb-3">
<label class="form-label">Họ tên</label>
<input type="text" name="full_name" class="form-control"
value="<?= e($userRow['full_name']) ?>" required>
</div>
<div class="mb-3">
<label class="form-label">Số điện thoại</label>
<input type="text" name="phone" class="form-control"
value="<?= e($userRow['phone'] ?? '') ?>">
</div>
<div class="mb-3">
<label class="form-label">Địa chỉ</label>
<input type="text" name="address" class="form-control"
value="<?= e($userRow['address'] ?? '') ?>">
</div>
<hr>
<div class="mb-3">
<label class="form-label">Đổi mật khẩu (để trống nếu không
đổi)</label>

<input type="password" name="new_password" class="form-
control" minlength="6">

</div>
<button type="submit" class="btn btn-primary">Lưu thay
đổi</button>
</form>
</div>
</div>