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
                $dataActualizarTarea = '{
                    "procedure_id": 5,
                    "params": 
                      {
                      "title":"'.$_POST['title'].'",
                      "description":"'.$_POST['description'].'",
                      "responsible":"'.$_POST['responsible'].'",
                      "due_date":"'.$_POST['due_date'].'",
                      "task_type":"'.$_POST['task_type'].'",
                      "state":"'.$_POST['state'].'",
                      "id":"'.$_POST['id'].'"
                    }
                  }';
                $serviceCall = new ServiceApi();
                $results = $serviceCall->sendData($dataActualizarTarea);
                if(isset($_POST['mode'])){
                    header('Location: consulta.php?mode='.$_POST['mode'].'&group='.$_POST['group']); die();
                }else{
                    header('Location: index.php'); die();
                }
            ?>
                <?php
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $dataConsultaPorId = '{
                    "procedure_id": 6,
                    "params": 
                      {
                      "id":'.$_GET['id'].'
                    }
                  }';
                $serviceCall = new ServiceApi();
                $results = $serviceCall->sendData($dataConsultaPorId);
                $result = json_decode($results,true);
                foreach ($result as $row) {
                    $title = $row['title'];
                    $description = $row['description'];
                    $responsible = $row['responsible'];
                    $due_date = $row['due_date'];
                    $task_type = $row['task_type'];
                    $state = $row['state'];
                }
                ?>
                <form action="editar.php" method="post" class="was-validated" >
                    <input id="myid" name="id" type="hidden" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                    <div class="card-body">
                        <h5 class="card-title">
                        <?php 
                            if(isset($_REQUEST['id'])){
                                echo "Editar Tarea (".$_REQUEST['id'].")";
                            }else{
                                echo "Nueva Tarea";
                            }
                        ?>    
                        </h5>
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
                            <input name="due_date" type="datetime-local" class="form-control" placeholder="Fecha" aria-label="Fecha" value="<?php if(isset($due_date)){echo $due_date;} ?>" required>
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
                                if($results){
                                    $results = str_replace('value="'.$task_type.'"','value="'.$task_type.'" selected ',$results);
                                }
                                echo $results;
                                ?>
                            </select>
                        </li>
                        <li class="list-group-item">
                            <select name="state" class="form-control" aria-label="Estado" required>
                                <option value="" disabled>Estado...</option>
                                <option value="por hacer" <?php if(isset($state) and $state=="por hacer"){echo "selected";}?>>Por Hacer</option>
                                <option value="en progreso" <?php if(isset($state) and $state=="en progreso"){echo "selected";}?>>En Progreso</option>
                                <option value="completada" <?php if(isset($state) and $state=="completada"){echo "selected";}?>>Completada</option>
                            </select>
                        </li>
                    </ul>
                    <a id="myInput" <?php if(isset($_GET['mode'])){echo 'href="consulta.php?mode='.$_GET['mode'].'&group='.$_GET['group'].'"';}else{echo 'href="index.php"';}  ?> class="btn btn-secondary lg">
                        <i class="bi bi-arrow-left"></i> Retornar
                    </a>
                    <button type="button" class="btn btn-danger" onclick='<?php echo (isset($_GET['mode'])?'myDelete("C")':'myDelete("I")'); ?>'><i class="bi bi-trash"></i> Delete</button>
                    <?php
                        if(isset($_GET['mode'])){
                            echo '<input name="mode" type="hidden" value="'.$_GET['mode'].'">';
                        }
                        if(isset($_GET['group'])){
                            echo '<input name="group" type="hidden" value="'.$_GET['group'].'">';
                        }
                    ?>
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