<?php
// app/controllers/ProductController.php
class ProductController extends Controller
{
private const PER_PAGE = 12;
public const SORT_LABELS = [
'newest' => 'Mới nhất',
'price_asc' => 'Giá tăng dần',
'price_desc' => 'Giá giảm dần',
'bestseller' => 'Bán chạy',
];
public function detail($id): void
{
$product = Product::find((int) $id);
if (!$product || $product['status'] !== 'active') {
$this->abort404();
return;
}
$category = Category::find((int) $product['category_id']);
$images = ProductImage::forProduct($product['id']);
$related = $this->fetchRelated((int) $product['category_id'],
$product['id']);

$this->view('product/detail', [
'pageTitle' => $product['name'],
'product' => $product,
'category' => $category,
'images' => $images,
'related' => $related,
]);
}
public function search(): void
{
Database::$queryCount = 0; // reset de dem rieng cho trang nay
$filters = [
'q' => trim((string) ($_GET['q'] ?? '')),
'category' => $_GET['category'] ?? '',
'brand' => $_GET['brand'] ?? [],
'price_from' => $_GET['price_from'] ?? '',
'price_to' => $_GET['price_to'] ?? '',
'sort' => $_GET['sort'] ?? 'newest',
];
$page = max(1, (int) ($_GET['page'] ?? 1));
$result = Product::search($filters, $page, self::PER_PAGE);
$this->view('product/search', [
'pageTitle' => 'Tìm kiếm sản phẩm',
'filters' => $filters,
'categories' => Category::activeList(),
'brands' => Product::distinctBrands(),
'result' => $result,
'sortLabels' => self::SORT_LABELS,
]);
}
/** $limit = 4 la hang so co dinh trong ma nguon, khong phai du lieu nguoi dung */
private function fetchRelated(int $categoryId, int $excludeProductId):
array
{
$sql = "SELECT p.*, pi.file_name AS image
FROM products p
LEFT JOIN product_images pi
ON pi.product_id = p.id AND pi.is_primary = 1
WHERE p.category_id = :cid AND p.id != :pid AND p.status =
'active'
ORDER BY p.created_at DESC
LIMIT 4";
$stmt = Database::getInstance()->prepare($sql);
$stmt->execute(['cid' => $categoryId, 'pid' => $excludeProductId]);
return $stmt->fetchAll();
}
}