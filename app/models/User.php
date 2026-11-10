<?php
// app/models/User.php
class User extends Model
{
protected static string $table = 'users';
/** Tim user theo email, dung cho dang nhap va kiem tra trung khi dang ky */
public static function findByEmail(string $email): ?array

{
$stmt = static::db()->prepare('SELECT * FROM users WHERE email =
:email LIMIT 1');
$stmt->execute(['email' => $email]);
$row = $stmt->fetch();
return $row === false ? null : $row;
}
}