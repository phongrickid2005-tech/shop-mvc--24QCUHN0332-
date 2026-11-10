<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? e($pageTitle) . ' - ' : '' ?>Quản trị -
Shop Online</title>
<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css"
rel="stylesheet">
<link href="<?= e(asset('css/style.css')) ?>" rel="stylesheet">
</head>
<body>
<div class="d-flex">
<nav class="bg-dark text-light p-3" style="width: 240px; min-height:
100vh;">
<a href="<?= e(base_url('admin/dashboard')) ?>" class="d-block
text-light text-decoration-none fw-bold fs-5 mb-4">
Shop<span class="text-primary">Admin</span>
</a>

<ul class="nav nav-pills flex-column gap-1">
<li class="nav-item">
<a class="nav-link text-light" href="<?=
e(base_url('admin/dashboard')) ?>">Tổng quan</a>
</li>
<li class="nav-item">
<a class="nav-link text-light" href="<?=
e(base_url('admin/category')) ?>">Danh mục</a>
</li>
<li class="nav-item">
<a class="nav-link text-light" href="<?=
e(base_url('admin/product')) ?>">Sản phẩm</a>
</li>
<?php if (Auth::role() === 'admin'): ?>
<li class="nav-item">
<a class="nav-link text-light" href="<?=
e(base_url('admin/user')) ?>">Người dùng</a>
</li>
<?php endif; ?>
<li class="nav-item mt-3">
<a class="nav-link text-light" href="<?= e(base_url(''))
?>">&larr; Về trang khách</a>
</li>
<li class="nav-item">
<a class="nav-link text-light" href="<?=
e(base_url('admin/auth/logout')) ?>">Đăng xuất</a>
</li>
</ul>
</nav>
<div class="flex-grow-1 p-4">

<div class="d-flex justify-content-between align-items-center mb-
4">

<h1 class="h4 mb-0"><?= isset($pageTitle) ? e($pageTitle) : ''
?></h1>
<span class="text-muted">
Xin chào, <?= e(Auth::user()['full_name'] ?? '') ?>
(<?= e(Auth::role() ?? '') ?>)
</span>
</div>
<?php if ($f = flash('success')): ?>
<div class="alert alert-success alert-dismissible fade show"
role="alert">
<?= $f['message'] ?>

<button type="button" class="btn-close" data-bs-
dismiss="alert"></button>

</div>
<?php endif; ?>
<?php if ($f = flash('error')): ?>
<div class="alert alert-danger alert-dismissible fade show"
role="alert">
<?= $f['message'] ?>

<button type="button" class="btn-close" data-bs-
dismiss="alert"></button>

</div>
<?php endif; ?>
<?php $content(); ?>
</div>
</div>
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.
js"></script>
</body>
</html>