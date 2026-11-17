<?php
// app/controllers/HomeController.php
class HomeController extends Controller
{
public function index(): void
{
$featured = $this->fetchProducts("p.is_featured = 1 AND p.status =
'active'", 8);
$newest = $this->fetchProducts("p.status = 'active'", 8);
$this->view('home/index', [
'pageTitle' => 'Trang chủ',
'featured' => $featured,
'newest' => $newest,
]);
}
private function fetchProducts(string $where, int $limit): array
{
$sql = "SELECT p.*, pi.file_name AS image
FROM products p
LEFT JOIN product_images pi
ON pi.product_id = p.id AND pi.is_primary = 1
WHERE {$where}
ORDER BY p.created_at DESC
LIMIT {$limit}";
return Database::getInstance()->query($sql)->fetchAll();
}
}