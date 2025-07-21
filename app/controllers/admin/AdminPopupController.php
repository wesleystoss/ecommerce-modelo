<?php
// require_once __DIR__ . '/../../../models/Popup.php';

class AdminPopupController {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function index() {
        $popups = Popup::all($this->db);
        include __DIR__ . '/../../views/admin/popups/index.php';
    }

    public function create() {
        include __DIR__ . '/../../views/admin/popups/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Popup::create($this->db, $_POST);
            header('Location: ?rota=popups');
            exit;
        }
    }

    public function edit($id) {
        $popup = Popup::find($this->db, $id);
        if ($popup) {
            include __DIR__ . '/../../views/admin/popups/edit.php';
        } else {
            // Not found
            header('Location: ?rota=popups');
            exit;
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Popup::update($this->db, $id, $_POST);
            header('Location: ?rota=popups');
            exit;
        }
    }

    public function delete($id) {
        Popup::delete($this->db, $id);
        header('Location: ?rota=popups');
        exit;
    }
} 