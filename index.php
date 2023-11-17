<?php 
    include('./includes/header.php');
    include('./Class/ServiceApi.php');
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
                                $data = '{
                                    "procedure_id": 1,
                                    "params": 
                                      {
                                        "estado": "por hacer"
                                      }
                                  }';
                                  
                                $serviceCall = new ServiceApi();
                                $results = $serviceCall->sendData($data);
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
                                $data = '{
                                    "procedure_id": 1,
                                    "params": 
                                      {
                                        "estado": "en progreso"
                                      }
                                  }';                            
                                $postData = new ServiceApi();
                                $results = $postData->sendData($data);
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
                                $data = '{
                                    "procedure_id": 1,
                                    "params": 
                                      {
                                        "estado": "completada"
                                      }
                                  }';                                
                                    $postData = new ServiceApi();
                                    $results = $postData->sendData($data);
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
