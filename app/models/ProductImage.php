<?php
// app/models/ProductImage.php
// Tap trung TOAN BO nghiep vu anh san pham: thu tu hien thi, anh dai dien
// duy nhat, xoa dung trinh tu, chong thao tac cheo san pham.
class ProductImage extends Model 
{
protected static string $table = 'product_images';
/** Anh dai dien luon dung dau, sau do theo sort_order */
public static function forProduct(int $productId): array
{
$stmt = static::db()->prepare(
'SELECT * FROM product_images
WHERE product_id = :pid
ORDER BY is_primary DESC, sort_order ASC, id ASC'
);
$stmt->execute(['pid' => $productId]);
return $stmt->fetchAll();
}

public static function countForProduct(int $productId): int
{
$stmt = static::db()->prepare('SELECT COUNT(*) FROM product_images
WHERE product_id = :pid');
$stmt->execute(['pid' => $productId]);
return (int) $stmt->fetchColumn();
}
public static function nextSortOrder(int $productId): int
{
$stmt = static::db()->prepare(
'SELECT COALESCE(MAX(sort_order), -1) + 1 FROM product_images
WHERE product_id = :pid'
);
$stmt->execute(['pid' => $productId]);
return (int) $stmt->fetchColumn();
}
/**
* Dat anh $imageId lam dai dien cua $productId.
* Dung transaction de dam bao KHONG BAO GIO xay ra tinh trang
* 0 hoac 2 anh dai dien cung luc.
*/
public static function setPrimary(int $imageId, int $productId): void
{
$db = static::db();
$db->beginTransaction();
try {
// XAC NHAN anh nay THUOC DUNG san pham truoc khi doi bat cugi.
// Neu thieu buoc nay: khi $imageId thuoc san pham khac, dongUPDATE o duoi
// van se xoa het is_primary cua san pham hien tai (buoc 1)nhung khong anh
// nao duoc dat lai lam dai dien (buoc 2 khop 0 dong) -> sanpham mat trang
// ca dai dien oan uong. Kiem tra truoc giup thao tac that sula "khong lam gi"
// khi image_id khong thuoc product_id duoc truyen vao.
$check = $db->prepare('SELECT COUNT(*) FROM product_images
WHERE id = :id AND product_id = :pid');
$check->execute(['id' => $imageId, 'pid' => $productId]);
if ((int) $check->fetchColumn() === 0) {
$db->rollBack();
return;
}
$db->prepare('UPDATE product_images SET is_primary = 0 WHERE
product_id = :pid')
->execute(['pid' => $productId]);
$db->prepare('UPDATE product_images SET is_primary = 1 WHERE id

= :id AND product_id = :pid')
->execute(['id' => $imageId, 'pid' => $productId]);
$db->commit();
} catch (Throwable $e) {
$db->rollBack();
throw $e;
}
}
/**
* Xoa MOT anh: xoa ban ghi CSDL truoc, chi xoa tep vat ly SAU KHI
* ban ghi da xoa thanh cong. Neu la anh dai dien thi tu dong chon
* anh co sort_order nho nhat con lai lam dai dien moi.
*/
public static function deleteImage(int $imageId, int $productId): void
{
$db = static::db();
$stmt = $db->prepare('SELECT * FROM product_images WHERE id = :id
AND product_id = :pid LIMIT 1');
$stmt->execute(['id' => $imageId, 'pid' => $productId]);
$image = $stmt->fetch();
if ($image === false) {
// Anh khong ton tai HOAC khong thuoc san pham nay -> khong lamgi,
// day chinh la co che chan "doi ma anh de tac dong anh sanpham khac"
return;
}
$db->beginTransaction();
try {
$db->prepare('DELETE FROM product_images WHERE id = :id')-
>execute(['id' => $imageId]);
if ((int) $image['is_primary'] === 1) {
$nextId = $db->prepare(
'SELECT id FROM product_images WHERE product_id = :pid
ORDER BY sort_order ASC, id ASC LIMIT 1'
);
$nextId->execute(['pid' => $productId]);
$nextImageId = $nextId->fetchColumn();
if ($nextImageId) {
$db->prepare('UPDATE product_images SET is_primary = 1
WHERE id = :id')
->execute(['id' => $nextImageId]);
}
}
$db->commit();
} catch (Throwable $e) {

$db->rollBack();
throw $e;
}
// Chi den day - SAU KHI transaction da commit thanh cong - moidong den tep vat ly
ImageService::deleteFiles($image['file_name']);
}
/** Dung khi xoa het mot san pham: xoa toan bo anh (tep + ban ghi) cuano */
public static function deleteAllForProduct(int $productId): void
{
$images = self::forProduct($productId);
foreach ($images as $image) {
ImageService::deleteFiles($image['file_name']);
}
static::db()->prepare('DELETE FROM product_images WHERE product_id
= :pid')
->execute(['pid' => $productId]);
}
public static function updateAlt(int $imageId, int $productId, string
$altText): void
{
static::db()->prepare(
'UPDATE product_images SET alt_text = :alt WHERE id = :id AND
product_id = :pid'
)->execute(['alt' => $altText, 'id' => $imageId, 'pid' =>
$productId]);
}
/** Doi cho thu tu voi anh lien ke (khong tinh anh dai dien - anh daidien luon dung dau) */
public static function swapOrder(int $imageId, int $productId, string
$direction): void
{
$images = self::forProduct($productId);
$ordered = array_values(array_filter($images, fn($i) => (int)
$i['is_primary'] === 0));
$index = null;
foreach ($ordered as $i => $img) {
if ((int) $img['id'] === $imageId) {
$index = $i;
break;
}
}
if ($index === null) {
return;
}
$swapWith = $direction === 'up' ? $index - 1 : $index + 1;

if ($swapWith < 0 || $swapWith >= count($ordered)) {
return; // da o dau hoac cuoi danh sach
}
$a = $ordered[$index];
$b = $ordered[$swapWith];
$db = static::db();
$db->beginTransaction();
try {
$db->prepare('UPDATE product_images SET sort_order = :s WHERE
id = :id')
->execute(['s' => $b['sort_order'], 'id' => $a['id']]);
$db->prepare('UPDATE product_images SET sort_order = :s WHERE
id = :id')
->execute(['s' => $a['sort_order'], 'id' => $b['id']]);
$db->commit();
} catch (Throwable $e) {
$db->rollBack();
throw $e;
}
}
}