<?php
class CartService
{
public static function build(): array
{
$items = Cart::items();
if (empty($items)) {
return ['lines' => [], 'subtotal' => 0.0, 'adjusted' => false,
'removed' => []];
}
$products = Product::findManyWithImage(array_keys($items));
$lines = [];
$subtotal = 0.0;
$adjusted = false;
$removed = [];
foreach ($items as $productId => $qty) {
$productId = (int) $productId;
$product = $products[$productId] ?? null;
if (!$product || $product['status'] !== 'active') {

Cart::remove($productId);
$removed[] = $product['name'] ?? ('#' . $productId);
continue;
}
$qty = (int) $qty;
$stock = (int) $product['stock'];
if ($qty > $stock) {
$adjusted = true;
if ($stock <= 0) {
Cart::remove($productId);
$removed[] = $product['name'];
continue;

}
$qty = $stock;
Cart::setQuantity($productId, $qty);
}
$lineTotal = (float) $product['price'] * $qty;
$subtotal += $lineTotal;
$lines[] = [
'product_id' => $productId,
'name' => $product['name'],
'price' => (float) $product['price'],
'quantity' => $qty,
'stock' => $stock,
'line_total' => $lineTotal,
'image' => $product['image'],
];
}
return [
'lines' => $lines,
'subtotal' => $subtotal,
'adjusted' => $adjusted,
'removed' => $removed,
];
}
}