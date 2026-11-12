<?php
// app/services/ImageService.php
// Kiem tra tep anh tai len an toan va xu ly lai bang GD truoc khi luu.
// Day la noi DUY NHAT trong he thong chua logic xu ly anh bang GD.
class ImageService
{
/**
* Kiem tra MOT tep tai len theo dung quy tac o config.php.
* Tra ve mang rong neu hop le, hoac mang cac thong diep loi.
*/
public static function validate(array $file): array
{
$errors = [];
$errorCode = $file['error'] ?? UPLOAD_ERR_NO_FILE;
if ($errorCode !== UPLOAD_ERR_OK) {
$errors[] = self::uploadErrorMessage($errorCode);
return $errors; // loi upload co ban thi khong kiem tra tiep
noi dung
}
// 1) Kiem tra phan mo rong
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, UPLOAD_ALLOWED_EXT, true)) {
$errors[] = 'Định dạng tệp không được hỗ trợ (chỉ nhận ' .

implode(', ', UPLOAD_ALLOWED_EXT) . ').';
}
// 2) Kiem tra dung luong
if (($file['size'] ?? 0) > UPLOAD_MAX_SIZE) {
$errors[] = 'Dung lượng vượt quá ' . (int) (UPLOAD_MAX_SIZE /
1024 / 1024) . ' MB.';
}

// 3) Kiem tra LOAI THAT cua tep bang finfo - KHONG tin Content-
Type trinh duyet gui len,

// vi day la gia tri nguoi dung co the tu sua truoc khi gui
request.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$realMime = $finfo->file($file['tmp_name']);
$allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
if (!in_array($realMime, $allowedMime, true)) {
$errors[] = 'Tệp không phải ảnh hợp lệ (phát hiện loại thật: '
. $realMime . ', ví dụ tệp .php đổi đuôi thành .jpg sẽ bị chặn tại đây).';
}
// 4) Kiem tra tep doc duoc nhu mot anh that va lay kich thuoc
$dimensions = @getimagesize($file['tmp_name']);
if ($dimensions === false) {
$errors[] = 'Không đọc được ảnh, tệp có thể bị hỏng hoặc không
phải ảnh.';
} else {
[$width, $height] = $dimensions;
$shortSide = min($width, $height);
$longSide = max($width, $height);
if ($shortSide < UPLOAD_MIN_SIDE) {
$errors[] = "Ảnh quá nhỏ (cạnh ngắn {$shortSide}px, yêu cầu
tối thiểu " . UPLOAD_MIN_SIDE . "px).";
}
if ($longSide > UPLOAD_MAX_SIDE) {
$errors[] = "Ảnh quá lớn (cạnh dài {$longSide}px, vượt tối
đa " . UPLOAD_MAX_SIDE . "px).";
}
}
return $errors;
}
*
* @throws RuntimeException neu khong doc duoc du lieu anh
*/
public static function processAndSave(array $file): array

{
$raw = file_get_contents($file['tmp_name']);
$source = $raw === false ? false : @imagecreatefromstring($raw);
if ($source === false) {
throw new RuntimeException('Khong tao duoc tai nguyen anh tu
tep tai len.');
}
$srcWidth = imagesx($source);
$srcHeight = imagesy($source);
// Ten ngau nhien - KHONG dung ten goc nguoi dung tai len
$fileName = uniqid('prod_', true) . '.jpg';
self::saveResized($source, $srcWidth, $srcHeight, IMAGE_MAIN_WIDTH,
self::mainPath($fileName));
self::saveResized($source, $srcWidth, $srcHeight,
IMAGE_THUMB_WIDTH, self::thumbPath($fileName));
imagedestroy($source);
return [
'file_name' => $fileName,
'original_name' => $file['name'],
];
}
/** Xoa ca ban chinh va ban thu nho cua MOT anh (dung khi xoa anh hoac  xoa san pham) */
public static function deleteFiles(string $fileName): void
{
foreach ([self::mainPath($fileName), self::thumbPath($fileName)] as
$path) {
if (file_exists($path) && !@unlink($path)) {
// Khong lam hong thao tac cua nguoi dung, chi ghi log de
xu ly sau
error_log('Khong xoa duoc file anh: ' . $path);
}
}
}
/**
* Resize giu nguyen ty le theo chieu rong muc tieu, nen trang cho vung
* trong suot (anh PNG), roi luu thanh JPEG chat luong 85.
*/
private static function saveResized($source, int $srcWidth, int
$srcHeight, int $targetWidth, string $destPath): void
{
// Chi thu nho khi anh goc lon hon muc tieu, khong phong to anh nho
$ratio = min(1, $targetWidth / $srcWidth);
$destWidth = max(1, (int) round($srcWidth * $ratio));
$destHeight = max(1, (int) round($srcHeight * $ratio));

$dest = imagecreatetruecolor($destWidth, $destHeight);
$white = imagecolorallocate($dest, 255, 255, 255);
imagefill($dest, 0, 0, $white);
imagecopyresampled($dest, $source, 0, 0, 0, 0, $destWidth,
$destHeight, $srcWidth, $srcHeight);
imagejpeg($dest, $destPath, 85);
imagedestroy($dest);
}
private static function uploadErrorMessage(int $code): string
{
return match ($code) {
UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Tệp vượt quá dung
lượng cho phép của máy chủ.',
UPLOAD_ERR_PARTIAL => 'Tệp chỉ tải lên được một phần, vui lòng
thử lại.',
UPLOAD_ERR_NO_FILE => 'Chưa chọn tệp.',
UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE,
UPLOAD_ERR_EXTENSION => 'Lỗi hệ thống khi lưu tệp tải lên.',
default => 'Lỗi tải tệp không xác định.',
};
}
public static function mainPath(string $fileName): string
{
return __DIR__ . '/../../public/uploads/products/' . $fileName;
}
public static function thumbPath(string $fileName): string
{
return __DIR__ . '/../../public/uploads/products/thumbs/' .
$fileName;
}
}