<?php
// config/config.php
// Cau hinh ket noi CSDL va cac hang so dung chung toan he thong
define('DB_HOST', 'localhost');
define('DB_NAME', 'shop_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
// Doi lai cho dung may cua ban, vi du: http://localhost/shop/public/
define('BASE_URL', 'http://localhost/shop/public/');
// Cau hinh cho phan quan ly anh san pham (se dung tu Buoi 3)
define('UPLOAD_ALLOWED_EXT', ['jpg', 'jpeg', 'png', 'webp']);
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2 MB
define('UPLOAD_MIN_SIDE', 300); // px
define('UPLOAD_MAX_SIDE', 5000); // px
define('UPLOAD_MAX_IMAGES', 8); // anh / san pham
define('IMAGE_MAIN_WIDTH', 1200); // px - anh chinh
define('IMAGE_THUMB_WIDTH', 400); // px - anh thu nho
// ?>