<?php
// app/core/helpers.php
// Cac ham ho tro dung chung toan he thong (khong thuoc class nao)
/**
* Chong XSS: escape chuoi truoc khi in ra HTML.
*/
function e(string $value): string
{
return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
/**
* Dung duong dan tuyet doi tu BASE_URL.
*/
function base_url(string $path = ''): string
{
return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}
/**
* Dung duong dan toi file tinh trong public/assets/
*/
function asset(string $path): string
{
return base_url('assets/' . ltrim($path, '/'));
}
/**
* Dinh dang so tien theo kieu Viet Nam: 1990000 -> "1.990.000 đ"
*/
function format_vnd($number): string
{
return number_format((float) $number, 0, ',', '.') . ' đ';
}
/**
* HAM DUNG CHUNG DUY NHAT de lay dia chi anh san pham.
* Moi noi trong he thong (trang chu, danh muc, chi tiet, gio hang,
* don hang, trang quan tri...) deu phai goi ham nay, KHONG tu ghep
* duong dan rieng. Nho vay neu sau nay doi quy uoc thu muc anh,
* chi can sua dung MOT cho.
*
* @param string|null $fileName Ten file luu trong CSDL (cot file_name)
* @param string $size 'thumb' (mac dinh) hoac 'full'

*/
function product_image_url(?string $fileName, string $size = 'thumb'):
string
{
if (empty($fileName)) {
return asset('img/no-image.png');
}
$folder = $size === 'full' ? 'uploads/products/' :
'uploads/products/thumbs/';
$diskPath = __DIR__ . '/../../public/' . $folder . $fileName;
// Con ban ghi trong CSDL nhung file vat ly da mat -> van tra ve anh mac dinh
if (!file_exists($diskPath)) {
return asset('img/no-image.png');
}
return base_url($folder . $fileName);
}// ---------------------------------------------------------------
// Bo sung Buoi 2: chong CSRF va thong bao flash (session-based)
// ---------------------------------------------------------------
/**
* Sinh (hoac tai su dung) token CSRF luu trong session.
*/
function csrf_token(): string
{
if (empty($_SESSION['csrf_token'])) {
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
return $_SESSION['csrf_token'];
}
/**
* Tra ve input hidden de nhung vao MOI form POST.
*/
function csrf_field(): string
{
return '<input type="hidden" name="csrf_token" value="' .
e(csrf_token()) . '">';
}
/**

* Doi chieu token gui len voi token trong session.
* Goi o DAU moi ham xu ly POST, truoc khi dong cham den du lieu.
*/
function verify_csrf(string $token): void
{
if (empty($_SESSION['csrf_token']) ||
!hash_equals($_SESSION['csrf_token'], $token)) {
http_response_code(419);
die('Phien lam viec da het han hoac yeu cau khong hop le. Vui long
tai lai trang va thu lai.');
}
}
/**
* Thong bao flash: hien thi MOT LAN roi tu xoa.
* - Goi flash('success', 'Noi dung') de LUU thong bao truoc khi redirect.
* - Goi flash('success') (khong co $message) de LAY va xoa thong bao.
*/
function flash(string $key, ?string $message = null, string $type =
'success'): ?array
{
if ($message !== null) {
$_SESSION['flash'][$key] = ['message' => $message, 'type' =>
$type];
return null;
}
if (!empty($_SESSION['flash'][$key])) {
$data = $_SESSION['flash'][$key];
unset($_SESSION['flash'][$key]);
return $data;
}
return null;
}
function product_card_html(array $product): string
{
$url = e(base_url('product/detail/' . $product['id']));
$img = e(product_image_url($product['image'] ?? null, 'thumb'));
$name = e($product['name']);
$price = format_vnd($product['price']);
return <<<HTML
<div class="col">
<a href="{$url}" class="text-decoration-none text-dark">
<div class="card h-100 shadow-sm">
<img src="{$img}" class="card-img-top" loading="lazy"
alt="{$name}">
<div class="card-body d-flex flex-column">
<h3 class="h6 card-title">{$name}</h3>

<p class="text-danger fw-bold mt-auto mb-
0">{$price}</p>

</div>
</div>
</a>
</div>
HTML;}
function query_url(array $override = []): string
{
$params = array_merge($_GET, $override);
$params = array_filter($params, function ($v) {
return $v !== '' && $v !== null && $v !== [];
});
$query = http_build_query($params);
return base_url('product/search') . ($query !== '' ? '?' . $query :
'');
}
/**
* Tra ve HTML thanh phan trang Bootstrap. $page: trang hien tai (tu 1),
* $totalPages: tong so trang. Tra ve chuoi rong neu chi co 1 trang.
*/
function pagination_html(int $page, int $totalPages): string
{
if ($totalPages <= 1) {
return '';
}

$html = '<nav aria-label="Phân trang"><ul class="pagination justify-
content-center">';

$prevDisabled = $page <= 1 ? ' disabled' : '';
$prevUrl = e(query_url(['page' => max(1, $page - 1)]));
$html .= "<li class=\"page-item{$prevDisabled}\"><a class=\"page-link\"

href=\"{$prevUrl}\">&laquo; Trước</a></li>";
for ($i = 1; $i <= $totalPages; $i++) {
$active = $i === $page ? ' active' : '';
$url = e(query_url(['page' => $i]));
$html .= "<li class=\"page-item{$active}\"><a class=\"page-link\"
href=\"{$url}\">{$i}</a></li>";
}
$nextDisabled = $page >= $totalPages ? ' disabled' : '';
$nextUrl = e(query_url(['page' => min($totalPages, $page + 1)]));
$html .= "<li class=\"page-item{$nextDisabled}\"><a class=\"page-link\"
href=\"{$nextUrl}\">Sau &raquo;</a></li>";
$html .= '</ul></nav>';
return $html;
}