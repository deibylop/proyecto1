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
                    <form action="consulta.php" method="post">
                        <div class="d-grid gap-2">
                            <a id="myInput" href="index.php" class="btn btn-secondary lg">
                                <i class="bi bi-house-door"></i> Inicio
                            </a>
                        </div>
                        <h5 class="mt-4">Modalidad</h5>
                        <select name="mode" id="" class="form-control">
                            <option value="G" <?php if(isset($_POST['mode']) and $_POST['mode']=="G"){echo "selected";}?>>Resumido</option>
                            <option value="D" <?php if(isset($_POST['mode']) and $_POST['mode']=="D"){echo "selected";}?>>Detallado</option>
                        </select>
                        <h5 class="mt-4">Agrupado Por</h5>
                        <select name="group" id="" class="form-control">
                            <option value="state" <?php if(isset($_POST['group']) and $_POST['group']=="state"){echo "selected";}?>>Estado</option>
                            <option value="task_type" <?php if(isset($_POST['group']) and $_POST['group']=="task_type"){echo "selected";}?>>Tipo</option>
                            <option value="due_date_date" <?php if(isset($_POST['group']) and $_POST['group']=="due_date_date"){echo "selected";}?>>Día</option>
                            <option value="due_date_week" <?php if(isset($_POST['group']) and $_POST['group']=="due_date_week"){echo "selected";}?>>Semana</option>
                        </select>
                        <div class="d-grid gap-2 mt-2">
                            <a href="consulta.php" class="btn btn-danger btn-block">
                                <i class="bi bi-ban me-1"></i>Borrar Filtros
                            </a>
                            <button type="submit" class="btn btn-secondary">
                                <i class="bi bi-search me-1"></i>Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-10 row">
            <div class="col-12 mt-4">
                <div class="card" style="max-height: 700px;">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">
                            <?php
                                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                    echo "Por Estado";
                                }else{
                                    if($_POST['group']=="state"){
                                        echo "Por Estado";
                                    }elseif($_POST['group']=="task_type"){
                                        echo "Por Tipo";
                                    }elseif($_POST['group']=="due_date_date"){
                                        echo "Por Día";
                                    }elseif($_POST['group']=="due_date_week"){
                                        echo "Por Semana";
                                    }
                                } 
                            ?>

                        </h2>
                    </div>
                    <div class="card-body" style="max-height: 450px; overflow-y: scroll;">
                        <table class="table">
                            <tbody>
                                <?php
                                $tasks = new Tasks();
                                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                    $results = $tasks->consultar_tareas_x_grupo('G','state');
                                }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
                                    $results = $tasks->consultar_tareas_x_grupo($_POST['mode'],$_POST['group']);
                                } 
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
