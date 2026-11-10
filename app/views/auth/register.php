<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card shadow-sm">
<div class="card-body p-4">
<h1 class="h4 mb-4 text-center">Đăng ký tài khoản</h1>
<form method="POST" action="<?=
e(base_url('auth/register')) ?>">
<?= csrf_field() ?>
<div class="mb-3">

<label class="form-label">Họ tên</label>

<input type="text" name="full_name" class="form-
control"

value="<?= e($old['full_name'] ?? '') ?>"
required>
</div>

<div class="mb-3">

<label class="form-label">Email</label>

<input type="email" name="email" class="form-
control"

value="<?= e($old['email'] ?? '') ?>"
required>
</div>

<div class="mb-3">
<label class="form-label">Mật khẩu</label>

<input type="password" name="password" class="form-
control" minlength="6" required>

</div>

<div class="mb-3">

<label class="form-label">Xác nhận mật khẩu</label>
<input type="password" name="password_confirm"
class="form-control" minlength="6" required>
</div>

<button type="submit" class="btn btn-primary w-
100">Đăng ký</button>

</form>
<p class="text-center mt-3 mb-0">
Đã có tài khoản? <a href="<?= e(base_url('auth/login'))
?>">Đăng nhập</a>
</p>
</div>
</div>
</div>
</div>
