<?php
// app/controllers/CategoryController.php
class CategoryController extends Controller
{
public function show($slug): void
{
$category = Category::findBySlug((string) $slug);
if (!$category || $category['status'] !== 'active') {
$this->abort404();
return;
}
$sql = "SELECT p.*, pi.file_name AS image
FROM products p
LEFT JOIN product_images pi
ON pi.product_id = p.id AND pi.is_primary = 1
WHERE p.category_id = :cid AND p.status = 'active'

ORDER BY p.created_at DESC";
$stmt = Database::getInstance()->prepare($sql);
$stmt->execute(['cid' => $category['id']]);
$products = $stmt->fetchAll();
$this->view('category/show', [
'pageTitle' => $category['name'],
'category' => $category,
'products' => $products,
]);
}
}