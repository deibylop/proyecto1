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

    //tareas pagina principal
    public function consultar_tareas($state){
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
                                                '<div class="row">'.
                                                    '<div class="col-10">'.
                                                        '<h5 class="card-title">' . $row["title"] . '</h5>' .
                                                    '</div>'.
                                                    '<!--div class="col-2">'.
                                                        '<h5><a href=status_change.php?id='.$row["id"].'><i class="ms-1 bi bi-check-square-fill"></i></a></h5>'.
                                                    '</div-->'.
                                                '</div>'.
                                                
                                                '<p class="card-text">' . $row["description"] . '</p>' .
                                                '<p class="card-text">'. 
                                                    'Fecha de Vencimiento: ' . date('j/n/Y', strtotime($row['due_date'])) . '<br>' . 
                                                    ($row["edited"]=="1"?'<span style="color:red" data-toggle="tooltip" data-placement="top" title="Editado"><i class="bi bi-pencil me-2" ></i></span>':'').
                                                    $row["icon"].' '.$row["tipo"]. ' '.
                                                    '<a href=editar.php?id='.$row["id"].'><i class="bi bi-pencil-square"></i> Editar</a>'.
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

    //crud insert
    public function guardar_tarea(){
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

    //tareas desde pagina de consulta(repoorte) 
    public function consultar_tareas_x_grupo($mode,$group){
        $instruccion = "CALL sp_get_tasksbygroup('".$mode."','".$group."')";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        $html = '';
        if (!$resultado) {
            return "<tr><td> No hay datos para mostrar</td></tr>";
        } else {
            //detallado
            if($mode=='D'){
                if($group=="state"){
                    $encabezado = "Estado";
                }elseif($group=="task_type"){
                    $encabezado = "Tipo";
                }elseif($group=="due_date_date"){
                    $encabezado = "Día";
                }elseif($group=="due_date_week"){
                    $encabezado = "Semana";
                }elseif($group=="due_date_month"){
                    $encabezado = "Mes";
                }elseif($group=="due_date_year"){
                    $encabezado = "Año";
                }
                $html = "<tr><th>".$encabezado."</th><th>Titulo</th><th>Estado</th><th>Fecha</th><th>Tipo</th></tr>";
                foreach ($resultado as $row) {
                    if($row["group_total"]=='0'){
                        $colgroup = '';
                    }else{
                        
                        $colgroup = '<td rowspan="'.$row["group_total"].'" ><b>' . $row["group_column"] . '</b></td>';
                    }
                    $html = $html . '<tr>' .
                                        $colgroup.
                                        '<td><a href=editar.php?id='.$row["id"].'&mode='.$mode.'&group='.$group.'><i class="bi bi-pencil"></i></a>  ' . $row["title"] . '</td>' .
                                        '<td>' . $row["state"] . '</td>'.
                                        '<td>' . $row["due_date"] . '</td>' .
                                        '<td>' . $row["tipo"]. '</td>'.
                                    '</tr>';
                }
            }else{
                //agrupado
                $html = "<tr><th>Descripción</th><th>Cantidad</th></tr>";
                foreach ($resultado as $row) {
                    $html = $html . '<tr>' .
                                        '<td>' . $row["group_column"] . '</td>' .
                                        '<td>' . $row["total"] . '</td>'.
                                    '</tr>';
                }
            }

            return $html;
            $resultado->close();
            $this->_db->close();
        }
    }  

    //lista de valores tipos
    public function lista_tipos(){
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

    //detalle de una tarea
    public function consultar_tareasporid($id){
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

    //crud update
    public function actualizar_tarea($id) {
        //Datos
        $title = $this->title;
        $description = $this->description;
        $responsible = $this->responsible;
        $state = $this->state ? $this->state : 'por hacer';
        $due_date = $this->due_date;
        $edited = $this->edited ? $this->edited : '1';
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

    //crud delete
    public function eliminar_tarea($id){

        $instruccion = "CALL sp_delete_task('".$id."')";
        if ($this->_db->query($instruccion) === TRUE) {
            //echo "La consulta se ejecutó con éxito.";
        } else {
            echo "Error al ejecutar la consulta: " . $this->_db->error;
        }
    }
}