<?php
// app/core/Model.php
// Lop Model co so - cac Model con ke thua de dung chung CRUD co ban
abstract class Model
{
protected static string $table = '';
protected static string $primaryKey = 'id';
protected static function db(): PDO
{
return Database::getInstance();
}
/** Lay toan bo ban ghi, co the sap xep */
public static function all(string $orderBy = ''): array

{
$sql = 'SELECT * FROM ' . static::$table;
if ($orderBy !== '') {
$sql .= ' ORDER BY ' . $orderBy;
}
return static::db()->query($sql)->fetchAll();
}
/** Tim theo khoa chinh, tra ve null neu khong thay */
public static function find($id): ?array
{
$stmt = static::db()->prepare(
'SELECT * FROM ' . static::$table . ' WHERE ' .
static::$primaryKey . ' = :id LIMIT 1'
);
$stmt->execute(['id' => $id]);
$row = $stmt->fetch();
return $row === false ? null : $row;
}
/** Xoa theo khoa chinh */
public static function delete($id): bool
{
$stmt = static::db()->prepare(
'DELETE FROM ' . static::$table . ' WHERE ' .
static::$primaryKey . ' = :id'
);
return $stmt->execute(['id' => $id]);
}
/** Them moi, tra ve id vua tao */
public static function insert(array $data): int
{
$columns = array_keys($data);
$placeholders = array_map(fn($c) => ':' . $c, $columns);
$sql = 'INSERT INTO ' . static::$table
. ' (' . implode(', ', $columns) . ')'
. ' VALUES (' . implode(', ', $placeholders) . ')';
$stmt = static::db()->prepare($sql);
$stmt->execute($data);
return (int) static::db()->lastInsertId();
}
/** Cap nhat theo khoa chinh */
public static function update($id, array $data): bool
{
$sets = array_map(fn($c) => $c . ' = :' . $c, array_keys($data));
$sql = 'UPDATE ' . static::$table
. ' SET ' . implode(', ', $sets)
. ' WHERE ' . static::$primaryKey . ' = :pk_value';

$data['pk_value'] = $id;
$stmt = static::db()->prepare($sql);
return $stmt->execute($data);
}
/** Dem tong so ban ghi */
public static function count(): int
{
return (int) static::db()->query('SELECT COUNT(*) FROM ' .
static::$table)->fetchColumn();
}
}
?>
