<?php $navCategories = Category::activeList(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? e($pageTitle) . ' - ' : '' ?>Shop
Online</title>
<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css"
rel="stylesheet">
<link href="<?= e(asset('css/style.css')) ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<header class="border-bottom shadow-sm bg-white">
<nav class="navbar navbar-expand-lg navbar-light bg-white">
<div class="container">
<a class="navbar-brand fw-bold" href="<?= e(base_url('')) ?>">
Shop<span class="text-primary">Online</span>
</a>

<button class="navbar-toggler" type="button" data-bs-
toggle="collapse" data-bs-target="#mainMenu">

<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="mainMenu">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item">
<a class="nav-link" href="<?= e(base_url(''))
?>">Trang chủ</a>
</li>

<li class="nav-item dropdown">

<a class="nav-link dropdown-toggle" href="#"
role="button" data-bs-toggle="dropdown">

Danh mục
</a>

<ul class="dropdown-menu">

<?php foreach ($navCategories as $nc): ?>
<li>
<a class="dropdown-item" href="<?=
e(base_url('category/show/' . $nc['slug'])) ?>">
<?= e($nc['name']) ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</li>

<li class="nav-item">

<a class="nav-link" href="<?=
e(base_url('contact')) ?>">Liên hệ</a>
</li>
</ul>
<form class="d-flex mx-lg-3 my-2 my-lg-0" method="GET"

action="<?= e(base_url('product/search')) ?>" role="search" style="max-
width: 420px; width: 100%;">

<input class="form-control form-control-sm me-2"
type="search" name="q"
placeholder="Tìm sản phẩm, mã SKU..."
value="<?= e($_GET['q'] ?? '') ?>">
<button class="btn btn-sm btn-outline-primary"
type="submit">Tìm</button>
</form>
<ul class="navbar-nav align-items-lg-center">
<li class="nav-item">
<a class="nav-link" href="<?=
e(base_url('cart/index')) ?>">
Giỏ hàng
<span id="cartBadge" class="badge rounded-pill
bg-danger"><?= Cart::totalQuantity() ?></span>
</a>
</li>

<?php if (Auth::check()): ?>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#"
role="button" data-bs-toggle="dropdown">
<?= e(Auth::user()['full_name']) ?>
</a>

<ul class="dropdown-menu dropdown-menu-end">
<?php if (in_array(Auth::role(), ['admin',
'staff'], true)): ?>
<li><a class="dropdown-item" href="<?=
e(base_url('admin/dashboard')) ?>">Trang quản trị</a></li>
<li><hr class="dropdown-divider"></li>
<?php endif; ?>

<li><a class="dropdown-item" href="<?=

e(base_url('account/profile')) ?>">Hồ sơ cá nhân</a></li>
<li><a class="dropdown-item" href="<?=
e(base_url('auth/logout')) ?>">Đăng xuất</a></li>
</ul>
</li>
<?php else: ?>
<li class="nav-item"><a class="nav-link" href="<?=
e(base_url('auth/login')) ?>">Đăng nhập</a></li>
<li class="nav-item"><a class="nav-link" href="<?=
e(base_url('auth/register')) ?>">Đăng ký</a></li>
<?php endif; ?>
</ul>
</div>
</div>
</nav>
</header>
<main class="py-4 flex-grow-1">
<div class="container">
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
</main>
<footer class="bg-dark text-light py-4 mt-5">
<div class="container text-center small">
<p class="mb-2">

<a href="<?= e(base_url('policy')) ?>" class="text-light text-
decoration-none me-3">Chính sách mua hàng &amp; đổi trả</a>

<a href="<?= e(base_url('contact')) ?>" class="text-light text-
decoration-none">Liên hệ</a>

</p>
&copy; <?= date('Y') ?> ShopOnline &mdash; Đồ án thực hành Website
thương mại điện tử
</div>
</footer>

<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.
js"></script>
</body>
</html>