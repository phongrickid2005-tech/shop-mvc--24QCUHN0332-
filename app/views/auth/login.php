<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card shadow-sm">
<div class="card-body p-4">
<h1 class="h4 mb-4 text-center">Đăng nhập</h1>
<form method="POST" action="<?= e(base_url('auth/login'))
?>">
<?= csrf_field() ?>
<div class="mb-3">

<label class="form-label">Email</label>

<input type="email" name="email" class="form-
control" required autofocus>

</div>

<div class="mb-3">

<label class="form-label">Mật khẩu</label>

<input type="password" name="password" class="form-
control" required>

</div>

<button type="submit" class="btn btn-primary w-
100">Đăng nhập</button>

</form>
<p class="text-center mt-3 mb-0">
Chưa có tài khoản? <a href="<?=
e(base_url('auth/register')) ?>">Đăng ký ngay</a>
</p>
</div>
</div>
</div>
</div>