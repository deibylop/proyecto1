<?php
include('./includes/header.php');
?>
<br><br>
<div class="container" style="max-width: max-content;">
    <div class="container text-center">
        <div class="card" style="width: 25rem;">

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                include('./Class/Tasks.php');
                $task = new Tasks();
                $task->setTitle($_POST['title']);
                $task->setDescription($_POST['description']);
                $task->setResponsible($_POST['responsible']);
                $task->setDueDate($_POST['due_date']);
                $task->setTaskType($_POST['task_type']);
                $task->guardar_tarea();

                ?>
                <a href="index.php" class="btn btn-primary"><i></i>Regresar</a>
                <?php
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                ?>
                <form action="crear.php" method="post">
                    <div class="card-body">
                        <h5 class="card-title">Nueva Tarea</h5>
                        <p class="card-text"></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input name="title" type="text" class="form-control" placeholder="Título" aria-label="Título">
                        </li>
                        <li class="list-group-item">
                            <input name="description" type="text" class="form-control" placeholder="Descripción"
                                aria-label="Descripción">
                        </li>
                        <li class="list-group-item">
                            <input name="responsible" type="text" class="form-control" placeholder="Responsable"
                                aria-label="Responsable">
                        </li>
                        <li class="list-group-item">
                            <input name="due_date" type="date" class="form-control" placeholder="Fecha" aria-label="Fecha">
                        </li>
                        <li class="list-group-item">
                            <input name="task_type" type="text" class="form-control" placeholder="Tipo" aria-label="Tipo">
                        </li>
                    </ul>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
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