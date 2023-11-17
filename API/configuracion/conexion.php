<?php
class Conexion
{
    private $host = "127.0.0.1";
    private $db_name = "proyecto1";
    private $username = "root";
    private $password = "00000000";
    public $_db;
    public function obtenerConexion()
    {
        $this->_db = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        if ($this->_db->connect_errno) {
            echo 'Fallo la conexion';
            return;
        } else {
            return $this->_db;
        }
    }
}
