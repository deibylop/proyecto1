<?php 
    include('./includes/header.php');
    include('./Class/ServiceApi.php');
?>
<div class="container-full" id="consulta">
    
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
                        <select name="mode" id="mode" class="form-control" onchange='myChangeConsulta()'>
                            <option value="G" <?php if(isset($_REQUEST['mode']) and $_REQUEST['mode']=="G"){echo "selected";}?>>Resumido</option>
                            <option value="D" <?php if(isset($_REQUEST['mode']) and $_REQUEST['mode']=="D"){echo "selected";}?>>Detallado</option>
                        </select>
                        <h5 class="mt-4">Agrupado Por</h5>
                        <select name="group" id="group" class="form-control" onchange='myChangeConsulta()'>
                            <option value="state" <?php if(isset($_REQUEST['group']) and $_REQUEST['group']=="state"){echo "selected";}?>>Estado</option>
                            <option value="task_type" <?php if(isset($_REQUEST['group']) and $_REQUEST['group']=="task_type"){echo "selected";}?>>Tipo</option>
                            <option value="due_date_date" <?php if(isset($_REQUEST['group']) and $_REQUEST['group']=="due_date_date"){echo "selected";}?>>Día</option>
                            <option value="due_date_week" <?php if(isset($_REQUEST['group']) and $_REQUEST['group']=="due_date_week"){echo "selected";}?>>Semana</option>
                            <option value="due_date_month" <?php if(isset($_REQUEST['group']) and $_REQUEST['group']=="due_date_month"){echo "selected";}?>>Mes</option>
                            <option value="due_date_year" <?php if(isset($_REQUEST['group']) and $_REQUEST['group']=="due_date_year"){echo "selected";}?>>Año</option>
                        </select>
                        <div class="d-grid gap-2 mt-2">
                            <a href="consulta.php" class="btn btn-danger btn-block">
                                <i class="bi bi-ban me-1"></i>Borrar Filtros
                            </a>
                            <button id="buscar" type="submit" class="btn btn-secondary">
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
                                
                                if(isset($_REQUEST['group'])){
                                    $group = $_REQUEST['group'];
                                    if($group=="state"){
                                        echo "Por Estado";
                                    }elseif($group=="task_type"){
                                        echo "Por Tipo";
                                    }elseif($group=="due_date_date"){
                                        echo "Por Día";
                                    }elseif($group=="due_date_week"){
                                        echo "Por Semana";
                                    }elseif($group=="due_date_month"){
                                        echo "Por Mes";
                                    }elseif($group=="due_date_year"){
                                        echo "Por Año";
                                    }
                                }else{
                                    echo "Por Estado";
                                }
                            ?>

                        </h2>
                    </div>
                    <div class="card-body" style="max-height: 450px; overflow-y: scroll;">
                        <table class="table">
                            <tbody>
                                <?php
                                $consultar_tareas_x_grupo = '{
                                    "procedure_id": 7,
                                    "params":{
                                        "mode":"'.(isset($_REQUEST['mode'])?$_REQUEST['mode']:'G').'",
                                        "group":"'.(isset($_REQUEST['group'])?$_REQUEST['group']:'state').'"
                                    }
                                }';
                                $serviceCall = new ServiceApi();
                                $results = $serviceCall->sendData($consultar_tareas_x_grupo);
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
