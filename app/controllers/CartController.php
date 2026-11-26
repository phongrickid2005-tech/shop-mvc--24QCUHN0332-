<?php
// app/controllers/CartController.php
class CartController extends Controller
{
public function index(): void
{
$cart = CartService::build();
if ($cart['adjusted']) {
flash('error', 'Một số sản phẩm trong giỏ đã được điều chỉnh số
lượng cho đúng tồn kho hiện tại.');
}
if (!empty($cart['removed'])) {
flash('error', 'Đã bỏ khỏi giỏ hàng vì ngừng kinh doanh hoặc
không còn tồn tại: ' . e(implode(', ', $cart['removed'])));
}
$this->view('cart/index', [
'pageTitle' => 'Giỏ hàng',
'cart' => $cart,
]);
}
 public function add(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$productId = (int) ($_POST['product_id'] ?? 0);
$qty = max(1, (int) ($_POST['quantity'] ?? 1));
$product = Product::find($productId);
if (!$product || $product['status'] !== 'active') {
$this->respond(false, 'Sản phẩm không tồn tại hoặc đã ngừng
kinh doanh.');
return;
}
$stock = (int) $product['stock'];
$currentQty = (int) (Cart::items()[$productId] ?? 0);
$newQty = $currentQty + $qty;
if ($stock <= 0) {
$this->respond(false, 'Sản phẩm đã hết hàng.');
return;
}
if ($newQty > $stock) {
Cart::setQuantity($productId, $stock);
$this->respond(true, 'Đã thêm vào giỏ (số lượng được điều chỉnh
về tối đa còn lại: ' . $stock . ').');

return;
}
Cart::add($productId, $qty);
$this->respond(true, 'Đã thêm vào giỏ hàng.');
}
public function update(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
$productId = (int) ($_POST['product_id'] ?? 0);
$qty = (int) ($_POST['quantity'] ?? 0);
$product = Product::find($productId);
if ($product && $product['status'] === 'active' && $qty > 0) {
$qty = min($qty, (int) $product['stock']);
Cart::setQuantity($productId, $qty);
} else {
Cart::remove($productId);
}
$this->redirect('cart/index');
}
public function remove(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
Cart::remove((int) ($_POST['product_id'] ?? 0));
$this->redirect('cart/index');
}
public function clear(): void
{
verify_csrf($_POST['csrf_token'] ?? '');
Cart::clear();
$this->redirect('cart/index');
}
private function respond(bool $success, string $message): void
{
$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') ===
'XMLHttpRequest';
if ($isAjax) {
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
'success' => $success,
'message' => $message,
'cart_count' => Cart::totalQuantity(),
]);

exit;
}
flash($success ? 'success' : 'error', $message);
$this->redirect('product/detail/' . (int) ($_POST['product_id'] ??
0));
}
}