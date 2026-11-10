<?php
// app/controllers/admin/AdminDashboardController.php
class AdminDashboardController extends AdminController
{
public function index(): void
{
$this->view('admin/dashboard/index', ['pageTitle' => 'Tổng quan']);
}
}