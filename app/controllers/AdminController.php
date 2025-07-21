<?php
class AdminController {
    public function index() {
        $rota = $_GET['rota'] ?? '';
        switch ($rota) {
            case 'faqs':
                require_once __DIR__ . '/admin/AdminFaqController.php';
                $controller = new AdminFaqController();
                $controller->index();
                break;
            default:
                include __DIR__ . '/../views/admin.php';
        }
    }
} 