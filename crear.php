<?php
include('./includes/header.php');
include('./Class/ServiceApi.php');

?>
<br><br>
<div class="container" style="max-width: max-content;">
    <div class="container text-center">
        <div class="card" style="width: 25rem;">

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $dataCrearTarea = '{
                      "procedure_id": 2,
                      "params": 
                        {
                        "title":"'.$_POST['title'].'",
                        "description":"'.$_POST['description'].'",
                        "responsible":"'.$_POST['responsible'].'",
                        "due_date":"'.$_POST['due_date'].'",
                        "task_type":"'.$_POST['task_type'].'"
                    }
                  }';
                $serviceCall = new ServiceApi();
                $results = $serviceCall->sendData($dataCrearTarea);
                echo $results;
                header('Location: index.php'); die();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                ?>
                <form action="crear.php" method="post" class="was-validated" >
                    <div class="card-body">
                        <h5 class="card-title">Nueva Tarea</h5>
                        <p class="card-text"></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input name="title" type="text" class="form-control" placeholder="Título" aria-label="Título" required>
                        </li>
                        <li class="list-group-item">
                            <input name="description" type="text" class="form-control" placeholder="Descripción" 
                                aria-label="Descripción" required>
                        </li>
                        <li class="list-group-item">
                            <input name="responsible" type="text" class="form-control" placeholder="Responsable"
                                aria-label="Responsable" required>
                        </li>
                        <li class="list-group-item">
                            <input name="due_date" type="datetime-local" class="form-control" placeholder="Fecha" aria-label="Fecha" required>
                        </li>
                        <li class="list-group-item">
                            <select name="task_type" class="form-control" aria-label="Tipo" required>
                            <?php
                                $listar_tipos = '{
                                    "procedure_id": 3,
                                    "params":{}
                                }';
                                $serviceCall = new ServiceApi();
                                $results = $serviceCall->sendData($listar_tipos);
                                echo $results;
                             ?>
                            </select>
                        </li>
                    </ul>
                    <div class="card-body">
                        <a id="myInput" href="index.php" class="btn btn-secondary lg">
                            <i class="bi bi-arrow-left"></i> Retornar
                        </a>
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