<?php
require_once __DIR__ . '/../../config/database.php';

class BaseModel {
    protected $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }
}
