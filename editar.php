<?php
include('./includes/header.php');
include('./Class/Tasks.php');
?>
<br><br>
<div class="container" style="max-width: max-content;">
    <div class="container text-center">
        <div class="card" style="width: 25rem;">

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                
                $task = new Tasks();
                $task->setTitle($_POST['title']);
                $task->setDescription($_POST['description']);
                $task->setResponsible($_POST['responsible']);
                $task->setDueDate($_POST['due_date']);
                $task->setTaskType($_POST['task_type']);
                $task->actualizar_tarea($_POST['id']);
                header('LOCATION:index.php'); die();
                ?>
                <a href="index.php" class="btn btn-primary"><i></i>Regresar</a>
                <?php
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $tasks = new Tasks();
                $results = $tasks->consultar_tareasporid($_GET['id']);
                foreach ($results as $row) {
                    $title = $row['title'];
                    $description = $row['description'];
                    $responsible = $row['responsible'];
                    $due_date = date('Y-n-j', strtotime($row['due_date']));
                    $task_type = $row['task_type'];
                }
                ?>
                <form action="editar.php" method="post" class="was-validated" >
                    <input name="id" type="hidden" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                    <div class="card-body">
                        <h5 class="card-title">Nueva Tarea</h5>
                        <p class="card-text"></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input name="title" type="text" class="form-control" placeholder="Título" aria-label="Título" value="<?php if(isset($title)){echo $title;} ?>" required>
                        </li>
                        <li class="list-group-item">
                            <input name="description" type="text" class="form-control" placeholder="Descripción" 
                                aria-label="Descripción" value="<?php if(isset($description)){echo $description;} ?>" required>
                        </li>
                        <li class="list-group-item">
                            <input name="responsible" type="text" class="form-control" placeholder="Responsable"
                                aria-label="Responsable" value="<?php if(isset($responsible)){echo $responsible;} ?>" required>
                        </li>
                        <li class="list-group-item">
                            <input name="due_date" type="date" class="form-control" placeholder="Fecha" aria-label="Fecha" value="<?php if(isset($due_date)){echo $due_date;} ?>" required>
                        </li>
                        <li class="list-group-item">
                            <select name="task_type" class="form-control" aria-label="Tipo" required>
                                <?php
                                $tasks = new Tasks();
                                $options = $tasks->lista_tipos();
                                if($options){
                                    $options = str_replace('value="'.$task_type.'"','value="'.$task_type.'" selected ',$options);
                                }
                                echo $options;
                                ?>
                            </select>
                        </li>
                    </ul>
                    <a id="myInput" href="index.php" class="btn btn-secondary lg">
                            <i class="bi bi-arrow-left"></i> Retornar
                        </a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
                <?php
            } else {
                echo "Solicitud no válida";
            }
            ?>
        </div>
    </div>
</div>
<?php
include('./includes/footer.php');
?>