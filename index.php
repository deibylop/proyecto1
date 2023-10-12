<?php
include('./includes/header.php');
?>

<div class="container">
    <h1>Lista de tareas</h1>
    <div class="row">
        <div class="col-4">
            <h2>Por Hacer</h2>
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
                            echo $tasks->presentar_tarea($row["title"],$row["description"],"id");
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <h2>En Progreso</h2>
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
                            echo $tasks->presentar_tarea($row["title"],$row["description"],"id");
                        }
                    }

                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <h2>Completadas</h2>
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
                            echo $tasks->presentar_tarea($row["title"],$row["description"],"id");
                        }
                    }

                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <a id="myInput" href="crear.php" class="btn btn-success pull-right">
                <i class="bi bi-plus"></i> Nueva
            </a>
        </div>

    </div>
    


</div>
<script>
</script>
<?php
include('./includes/footer.php');
?>