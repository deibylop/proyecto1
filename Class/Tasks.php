<?php
require_once('./DB/models.php');

class Tasks extends ModelsDB
{
    protected $title;
    protected $description;
    protected $state;
    protected $due_date;
    protected $edited;
    protected $responsible;
    protected $task_type;


    public function __construct()
    {
        parent::__construct();
    }

    public function consultar_noticias()
    {
        $instruccion = 'CALL sp_get_tasks()';
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
            if (!$resultado) {
                return 400;
            } else {
                return $resultado;
                $resultado->close();
                $this->_db->close();
            }
        }
    }