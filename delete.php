<?php
include('./Class/Tasks.php');
include('./Class/ServiceApi.php');
$dataEliminarRegistro = '{
    "procedure_id": 4,
    "params":{
        "id": '.$_POST['id'].'
    }
}';
$serviceCall = new ServiceApi();
$results = $serviceCall->sendData($dataEliminarRegistro);
echo $results;
die();
?>