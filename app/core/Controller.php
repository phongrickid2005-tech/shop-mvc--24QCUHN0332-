<?php

abstract class Controller
{
 protected function view(string $view, array $data = [], string|false
$layout = 'main'): void
{
$viewFile = __DIR__ . '/../views/' . $view . '.php';
if (!file_exists($viewFile)) {
die('Khong tim thay view: ' . e($view));
}
if ($layout === false) {
extract($data);
require $viewFile;
return;
}
 $layoutFile = __DIR__ . '/../views/layouts/' . $layout . '.php';
if (!file_exists($layoutFile)) {
die('Khong tim thay layout: ' . e($layout));
}
 $content = function () use ($viewFile, $data) {
extract($data);
require $viewFile;
};
require $layoutFile;
}
  protected function redirect(string $path): void
{
header('Location: ' . base_url($path));
exit;
}


protected function abort404(): void
{
http_response_code(404);
require __DIR__ . '/../views/errors/404.php';
exit;
  }
 }