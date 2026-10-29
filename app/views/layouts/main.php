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
</ul>
</div>
</div>
</nav>
</header>
<main class="py-4 flex-grow-1">
<div class="container">
<?php $content(); ?>
</div>
</main>
<footer class="bg-dark text-light py-4 mt-5">
<div class="container text-center small">
&copy; <?= date('Y') ?> ShopOnline &mdash; Đồ án thực hành Website
thương mại điện tử
</div>
</footer>
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.
js"></script>

</body>
</html>