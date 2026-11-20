<?php
// app/core/Database.php
// Ket noi CSDL bang PDO, chi tao MOT ket noi duy nhat dung chung
(singleton)
class Database
{
private static ?PDO $instance = null;

/** Bo dem thu cong, phuc vu BAI TAP quan sat so truy van tren 1 trang(xem Buoi 5, muc 5).
* KHONG phai co che tu dong - noi nao muon dem thi tu tang bien naytruoc khi execute(). */
public static int $queryCount = 0;
/**
* Tra ve doi tuong PDO duy nhat cho toan ung dung.
*/
public static function getInstance(): PDO
{
if (self::$instance === null) {
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .
';charset=' . DB_CHARSET;
try {
self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,

]);
} catch (PDOException $e) {
// KHONG duoc in ten may chu / tai khoan / mat khau ra man
hinh
error_log('Loi ket noi CSDL: ' . $e->getMessage());
http_response_code(500);
die('Xin loi, he thong dang gap su co. Vui long thu lai
sau.');
}
}
return self::$instance;
}
// Khong cho phep tao doi tuong hay sao chep tu ben ngoai
private function __construct()
{
}
private function __clone()
{
}
}