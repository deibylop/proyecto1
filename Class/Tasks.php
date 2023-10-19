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

    public function consultar_tareas($state)
    {
        $instruccion = "CALL sp_get_tasksbystate('".$state."')";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        $html = '';
        if (!$resultado) {
            return "<tr><td> No hay datos para mostrar</td></tr>";
        } else {
            foreach ($resultado as $row) {
                $html = $html . '<tr>' .
                                    '<td>' .
                                        '<div class="card">' .
                                            '<div class="card-body">' .
                                                '<h5 class="card-title">' . $row["title"] . '</h5>' .
                                                '<p class="card-text">' . $row["description"] . '</p>' .
                                                '<p class="card-text">'. 
                                                    'Fecha de Vencimiento: ' . date('j/n/Y', strtotime($row['due_date'])) . '<br>' . 
                                                    'Tipo: '.$row["icon"].' '.$row["tipo"].'  -  '.
                                                    '<a href=editar.php?id='.$row["id"].'><i class="bi bi-pencil"></i> Editar</a>'.
                                                '</p>' . 
                                                
                                            '</div>' .
                                        '</div>' .
                                    '</td>' .
                                '</tr>';
            }
            return $html;
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

    public function tasks_query($state,$task_type,$due_date1,$due_date2){
        if($task_type=="null" or $task_type == '' or $task_type == null){
            $task_type='null';
        }else{
            $task_type = "'".$task_type."'";
        }
        if($due_date1=="null" or $due_date1 == '' or $due_date1 == null){
            $due_date1='null';
        }else{
            $due_date1 = "'".$due_date1."'";
        }
        if($due_date2=="null" or $due_date2 == '' or $due_date2 == null){
            $due_date2='null';
        }else{
            $due_date2 = "'".$due_date2."'";
        }
        $instruccion = "CALL sp_get_tasksbyfilters('".$state."',".$task_type.",".$due_date1.",".$due_date2.")";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        $html = '';
        if (!$resultado) {
            return "<tr><td> No hay datos para mostrar</td></tr>";
        } else {
            foreach ($resultado as $row) {
                $html = $html . '<tr>' .
                                    '<td>' .
                                        '<div class="card">' .
                                            '<div class="card-body">' .
                                                '<h5 class="card-title">' . $row["title"] . '</h5>' .
                                                '<p class="card-text">' . $row["description"] . '</p>' .
                                                '<p class="card-text">Fecha de Vencimiento: ' . date('j/n/Y', strtotime($row['due_date'])) . '</p>' . 
                                                '<p class="card-text">Estado: ' . $row['state'] . '</p>' . 
                                            '</div>' .
                                        '</div>' .
                                    '</td>' .
                                '</tr>';
            }
            return $html;
            $resultado->close();
            $this->_db->close();
        }
    }  

    
    public function lista_tipos()
    {
        $instruccion = 'CALL sp_get_tasktype()';
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        if (!$resultado) {
            return 400;
        } else {
            $html = '<option value="" disabled selected>Tipo...</option>';
            foreach ($resultado as $row) {
                $html = $html . '<option value="'.$row["id"].'">'.$row["title"].'</option>';
            }
            return $html;
            $resultado->close();
            $this->_db->close();
        }
    }

    public function consultar_tareasporid($id)
    {
        $instruccion = "CALL sp_get_tasksbyid('".$id."')";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        $html = '';
        if (!$resultado) {
            return "<tr><td> No hay datos para mostrar</td></tr>";
        } else {
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }

    public function actualizar_tarea($id)
    {

        //Datos
        $title = $this->title;
        $description = $this->description;
        $responsible = $this->responsible;
        $state = $this->state ? $this->state : 'por hacer';
        $due_date = $this->due_date;
        $edited = $this->edited ? $this->edited : '0';
        $task_type = $this->task_type;

        $instruccion = "CALL sp_update_task(
            '$id',
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