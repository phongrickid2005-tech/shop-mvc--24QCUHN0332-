<?php
class Cart
{
private const SESSION_KEY = 'cart';
private static function ensure(): void
{
if (!isset($_SESSION[self::SESSION_KEY]) ||
!is_array($_SESSION[self::SESSION_KEY])) {
$_SESSION[self::SESSION_KEY] = [];
}
}
/** Toan bo gio hang hien co: [product_id => quantity] */
public static function items(): array
{
self::ensure();
return $_SESSION[self::SESSION_KEY];
}

public static function add(int $productId, int $qty): void
{
self::ensure();
$qty = max(1, $qty);
$current = $_SESSION[self::SESSION_KEY][$productId] ?? 0;
$_SESSION[self::SESSION_KEY][$productId] = $current + $qty;
}
public static function setQuantity(int $productId, int $qty): void
{
self::ensure();
if ($qty <= 0) {
unset($_SESSION[self::SESSION_KEY][$productId]);
return;
}
$_SESSION[self::SESSION_KEY][$productId] = $qty;
}
public static function remove(int $productId): void
{
self::ensure();
unset($_SESSION[self::SESSION_KEY][$productId]);
}
public static function clear(): void
{
$_SESSION[self::SESSION_KEY] = [];
}
public static function totalQuantity(): int
{
self::ensure();
return (int) array_sum($_SESSION[self::SESSION_KEY]);
}
}