
<?php
// database/seed_images.php
// Script chạy một lần để sinh ảnh demo cho dữ liệu mẫu bằng GD.
// Đây là công cụ chuẩn bị dữ liệu, không thuộc luồng nghiệp vụ chính.

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Database.php';

header('Content-Type: text/html; charset=utf-8');

$pdo = Database::getInstance();

$uploadDir = __DIR__ . '/../public/uploads/products/';
$thumbDir = $uploadDir . 'thumbs/';
$noImageDir = __DIR__ . '/../public/assets/img/';

// Tạo thư mục nếu chưa tồn tại
foreach ([$uploadDir, $thumbDir, $noImageDir] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 1. Tạo ảnh mặc định no-image.png nếu chưa có
$noImagePath = $noImageDir . 'no-image.png';

if (!file_exists($noImagePath)) {
    $img = imagecreatetruecolor(400, 400);

    $bg = imagecolorallocate($img, 230, 230, 230);
    imagefill($img, 0, 0, $bg);

    $gray = imagecolorallocate($img, 130, 130, 130);
    imagestring($img, 5, 140, 190, 'NO IMAGE', $gray);

    imagepng($img, $noImagePath);
    imagedestroy($img);

    echo 'Da tao anh mac dinh: assets/img/no-image.png<br>';
}

// 2. Lấy danh sách sản phẩm
$products = $pdo->query(
    'SELECT id, name FROM products ORDER BY id'
)->fetchAll(PDO::FETCH_ASSOC);

// Hai sản phẩm được cố ý bỏ qua để kiểm tra ảnh mặc định
$skipProductIds = [3, 17];

// Bảng màu ảnh demo
$palette = [
    [41, 128, 185],
    [39, 174, 96],
    [142, 68, 173],
    [230, 126, 34],
    [192, 57, 43],
    [26, 188, 156],
];

// Chuẩn bị câu lệnh thêm ảnh vào database
$insertStmt = $pdo->prepare(
    'INSERT INTO product_images
    (
        product_id,
        file_name,
        original_name,
        alt_text,
        is_primary,
        sort_order,
        created_at
    )
    VALUES
    (
        :product_id,
        :file_name,
        :original_name,
        :alt_text,
        :is_primary,
        :sort_order,
        NOW()
    )'
);

// 3. Sinh ảnh cho từng sản phẩm
foreach ($products as $product) {
    $productId = (int) $product['id'];
    $productName = $product['name'];

    if (in_array($productId, $skipProductIds, true)) {
        echo "Bo qua san pham #{$productId} ({$productName}) - "
            . "de trong de kiem tra anh mac dinh<br>";

        continue;
    }

    $imageCount = random_int(1, 3);

    for ($i = 0; $i < $imageCount; $i++) {
        $fileName = uniqid('seed_', true) . '.jpg';

        [$r, $g, $b] = $palette[array_rand($palette)];

        // Tạo ảnh chính
        $main = imagecreatetruecolor(
            IMAGE_MAIN_WIDTH,
            IMAGE_MAIN_WIDTH
        );

        $bgColor = imagecolorallocate($main, $r, $g, $b);
        imagefill($main, 0, 0, $bgColor);

        $white = imagecolorallocate($main, 255, 255, 255);

        $label = $productName;

        if ($imageCount > 1) {
            $label .= ' (' . ($i + 1) . ')';
        }

        imagestring(
            $main,
            5,
            40,
            (int) (IMAGE_MAIN_WIDTH / 2),
            $label,
            $white
        );

        imagejpeg($main, $uploadDir . $fileName, 85);

        // Tạo ảnh thu nhỏ từ ảnh chính
        $thumb = imagecreatetruecolor(
            IMAGE_THUMB_WIDTH,
            IMAGE_THUMB_WIDTH
        );

        imagecopyresampled(
            $thumb,
            $main,
            0,
            0,
            0,
            0,
            IMAGE_THUMB_WIDTH,
            IMAGE_THUMB_WIDTH,
            IMAGE_MAIN_WIDTH,
            IMAGE_MAIN_WIDTH
        );

        imagejpeg($thumb, $thumbDir . $fileName, 85);

        // Giải phóng bộ nhớ
        imagedestroy($main);
        imagedestroy($thumb);

        // Lưu thông tin ảnh vào database
        $insertStmt->execute([
            'product_id' => $productId,
            'file_name' => $fileName,
            'original_name' => 'seed.jpg',
            'alt_text' => $productName,
            'is_primary' => $i === 0 ? 1 : 0,
            'sort_order' => $i,
        ]);
    }

    echo "Da tao {$imageCount} anh cho san pham "
        . "#{$productId} - {$productName}<br>";
}

// 4. Thông báo hoàn tất
echo '<p><strong>Hoan tat sinh anh mau. '
    . 'Co the xoa hoac giu lai file nay, '
    . 'khong anh huong ung dung chinh.</strong></p>';

?>
