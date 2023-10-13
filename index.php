<?php include('./includes/header.php'); ?>

<div class="container">
    <h1 class="text-center">Lista de Tareas</h1>
    <div class="row">
        <div class="col-4">
            <div class="card" style="max-height: 700px;">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center">Por Hacer</h2>
                </div>
                <div class="card-body" style="max-height: 450px; overflow-y: scroll;">
                    <table class="table">
                        <tbody>
                            <?php
                            include('./Class/Tasks.php');
                            $tasks = new Tasks();
                            $results = $tasks->consultar_tareas("por hacer");
                            if ($results == 400) {
                                echo '<tr>';
                                echo '<td> No hay datos para mostrar</td>';
                                echo '</tr>';
                            } else {
                                foreach ($results as $row) {
                                    echo $tasks->presentar_tarea($row["title"],$row["description"],$row['due_date'],$row['state'],"id");
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="max-height: 700px;">
                <div class="card-header bg-warning">
                    <h2 class="text-center">En Progreso</h2>
                </div>
                <div class="card-body" style="max-height: 450px; overflow-y: scroll;">
                    <table class="table">
                        <tbody>
                            <?php
                            $tasks = new Tasks();
                            $results = $tasks->consultar_tareas('en progreso');
                            if ($results == 400) {
                                echo '<tr>';
                                echo '<td> No hay datos para mostrar</td>';
                                echo '</tr>';
                            } else {
                                foreach ($results as $row) {
                                    echo $tasks->presentar_tarea($row["title"],$row["description"],$row['due_date'],$row['state'],"id");
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="max-height: 700px;">
                <div class="card-header bg-success text-white">
                    <h2 class="text-center">Completadas</h2>
                </div>
                <div class="card-body" style="max-height: 450px; overflow-y: scroll;">
                    <table class="table">
                        <tbody>
                            <?php
                            $tasks = new Tasks();
                            $results = $tasks->consultar_tareas('completada');
                            if ($results == 400) {
                                echo '<tr>';
                                echo '<td> No hay datos para mostrar</td>';
                                echo '</tr>';
                            } else {
                                foreach ($results as $row) {
                                    echo $tasks->presentar_tarea($row["title"],$row["description"],$row['due_date'],$row['state'],"id");
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
        <br>
            <a id="myInput" href="crear.php" class="btn btn-success lg">
                <i class="bi bi-plus"></i> Nueva
            </a>
        </div>
    </div>
</div>
<?php include('./includes/footer.php'); ?>
