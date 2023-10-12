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

    public function setTitle($nuevoValor)
    {
        $this->title = $nuevoValor;
    }
    public function setDescription($nuevoValor)
    {
        $this->description = $nuevoValor;
    }
    public function setState($nuevoValor)
    {
        $this->state = $nuevoValor;
    }
    public function setDueDate($nuevoValor)
    {
        $this->due_date = $nuevoValor;
    }
    public function setEdited($nuevoValor)
    {
        $this->edited = $nuevoValor;
    }
    public function setResponsible($nuevoValor)
    {
        $this->responsible = $nuevoValor;
    }
    public function setTaskType($nuevoValor)
    {
        $this->task_type = $nuevoValor;
    }

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


    public function guardar_tarea()
    {

        //Datos
        $title = $this->title;
        $description = $this->description;
        $responsible = $this->responsible;
        $state = $this->state ? $this->state : 'por hacer';
        $due_date = $this->due_date;
        $edited = $this->edited ? $this->edited : '0';
        $task_type = $this->task_type;

        $instruccion = "CALL sp_insert_tasks(
            '$title',
            '$description',
            '$state',
            '$due_date',
            '$edited',
            '$responsible',
            '$task_type'
        )";

        if ($this->_db->query($instruccion) === TRUE) {
            //echo "La consulta se ejecutó con éxito.";
        } else {
            echo "Error al ejecutar la consulta: " . $this->_db->error;
        }
    }
}