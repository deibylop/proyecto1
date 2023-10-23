<?php
include('./Class/Tasks.php');
$task = new Tasks();
$task->eliminar_tarea($_POST['id']);
?>