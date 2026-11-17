<?php
// app/controllers/PolicyController.php
class PolicyController extends Controller
{
public function index(): void
{
$this->view('policy/index', ['pageTitle' => 'Chính sách mua hàng và
đổi trả']);
}
}