<?php

require_once('../app/core/Database.php');
require_once('../app/core/config.php');

class Model {
    public $mysqli;

    public function __construct() {
        $this->mysqli = Database::getInstance()->getConnection();
    }
}
?>