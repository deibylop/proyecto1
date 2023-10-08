<?php 
require_once('config.php');

class ModelsDB{
    protected $_db;

    public function __construct()
    {
        $this->_db= new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if($this->_db->connect_errno)
        {
            echo 'Fallo la conexion';
            return;
        }
    }
}
