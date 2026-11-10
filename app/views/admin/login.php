<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? 'Đăng nhập quản trị') ?></title>
<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>

<body class="bg-dark d-flex align-items-center justify-content-center vh-
100">

<div class="card shadow" style="width: 360px;">
<div class="card-body p-4">
<h1 class="h5 text-center mb-4">Đăng nhập khu vực quản trị</h1>
<?php if ($f = flash('error')): ?>
<div class="alert alert-danger"><?= $f['message'] ?></div>
<?php endif; ?>
<form method="POST" action="<?= e(base_url('admin/auth/login'))
?>">

<?= csrf_field() ?>
<div class="mb-3">
<label class="form-label">Email</label>

<input type="email" name="email" class="form-control"

required autofocus>
</div>
<div class="mb-3">
<label class="form-label">Mật khẩu</label>

<input type="password" name="password" class="form-
control" required>

</div>
<button type="submit" class="btn btn-dark w-100">Đăng
nhập</button>
</form>
</div>
</div>
</body>
</html>