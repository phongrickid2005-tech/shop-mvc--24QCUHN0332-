<?php
// app/models/Product.php
class Product extends Model
{
protected static string $table = 'products';
/** Kiem tra SKU da ton tai chua, loai tru 1 id khi dang sua san pham
*/
public static function skuExists(string $sku, ?int $excludeId = null):
bool
{
$sql = 'SELECT COUNT(*) FROM products WHERE sku = :sku';
$params = ['sku' => $sku];
if ($excludeId !== null) {
$sql .= ' AND id != :id';
$params['id'] = $excludeId;
}
$stmt = static::db()->prepare($sql);
$stmt->execute($params);
return ((int) $stmt->fetchColumn()) > 0;
}
}