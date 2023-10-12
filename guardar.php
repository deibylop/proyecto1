<?php

include('./Class/Tasks.php');
$task = new Tasks();
$task->setTitle($_POST['title']);
$task->setDescription($_POST['description']);
$task->setResponsible($_POST['responsible']);
$task->setDueDate($_POST['due_date']);
$task->setTaskType($_POST['task_type']);
$task->guardar_tarea();

?>