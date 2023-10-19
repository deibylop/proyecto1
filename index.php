<?php 
    include('./includes/header.php');
    include('./Class/Tasks.php');
?>
<div class="container-full">
    
    <div class="row m-0">
        <div class="col-2">
            <div class="offcanvas offcanvas-start show text-bg-dark" tabindex="-1" id="offcanvasDark" aria-labelledby="offcanvasDarkLabel" style="--bs-offcanvas-width: 15% !important;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkLabel">To-Do-List</h5>
                </div>
                <div class="offcanvas-body">
                    <div class="d-grid gap-2">
                        <a id="myInput" href="crear.php" class="btn btn-secondary lg">
                            <i class="bi bi-plus"></i> Nueva Tarea
                        </a>
                    </div>
                    <div class="d-grid gap-2 mt-2">
                        <a id="myInput" href="consulta.php" class="btn btn-secondary lg">
                            <i class="bi bi-table me-1"></i> Reportes
                        </a>
                    </div>
                    
                    <!--form action="index.php" method="post">

                        <h5 class="mt-4">Filtros</h5>
                        <select name="state" id="" class="form-control">
                            <option value="" <?php if(!isset($_POST['state'])){echo "selected";}?>>Estatus...</option>
                            <option value="por hacer" <?php if(isset($_POST['state']) and $_POST['state']=="por hacer"){echo "selected";}?>>Por Hacer</option>
                            <option value="en progreso" <?php if(isset($_POST['state']) and $_POST['state']=="en progreso"){echo "selected";}?>>En Progreso</option>
                            <option value="completado" <?php if(isset($_POST['state']) and $_POST['state']=="completado"){echo "selected";}?>>Completado</option>
                        </select>
                        <input  name="task_type" type="text" class="form-control" placeholder="Tipo" aria-label="Tipo" value="<?php if(isset($_POST['task_type'])){echo $_POST['task_type'];} ?>">
                        <input name="due_date1" type="date" class="form-control" placeholder="..." aria-label="Fecha1" value="<?php if(isset($_POST['due_date1'])){echo $_POST['due_date1'];} ?>">
                        <input name="due_date2" type="date" class="form-control" placeholder="..." aria-label="Fecha2" value="<?php if(isset($_POST['due_date2'])){echo $_POST['due_date2'];} ?>">
                        <div class="d-grid gap-2 mt-2">
                            <a href="index.php" class="btn btn-danger btn-block">
                                <i class="bi bi-ban me-1"></i>Borrar Filtros
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-search me-1"></i>Buscar
                            </button>
                        </div>
                    </form-->
                </div>
            </div>
        </div>
        <div class="col-10 row">
            <h1 class="text-center">Lista de Tareas</h1>
            <div class="col-4">
                <div class="card" style="max-height: 700px;">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Por Hacer</h2>
                    </div>
                    <div class="card-body" style="max-height: 450px; overflow-y: scroll;">
                        <table class="table">
                            <tbody>
                                <?php
                                $tasks = new Tasks();
                                $results = $tasks->consultar_tareas("por hacer");
                                echo $results;
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
                                $results = $tasks->consultar_tareas("en progreso");
                                echo $results;
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
                                    $results = $tasks->consultar_tareas("completada");
                                    echo $results;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('./includes/footer.php'); ?>
