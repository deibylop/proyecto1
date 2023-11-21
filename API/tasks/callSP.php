<?php

/*
ARCHIVO PARA CENTRALIZAR TODAS LAS PETICIONES API EN UN SOLO LUGAR
VALIDAR DATOS DE USUARIO Y PASS DE LA CONEXION DB
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../configuracion/conexion.php';
include_once '../objetos/Tasks.php';

    $postData = file_get_contents("php://input");
    $requestData = json_decode($postData, true);

    if (isset($requestData['procedure_id'])) {
        $procedureId = $requestData['procedure_id'];

        $params = isset($requestData['params']) ? $requestData['params'] : array();
        $result = callStoredProcedure($procedureId, $params);
        http_response_code(200);
        echo($result);
    } else {
        echo json_encode(array('error' => 'Identificador del procedimiento almacenado no valido.'));
    }

function callStoredProcedure($procedureId, $params)
{
    $conex = new Conexion();
    $db = $conex->obtenerConexion();
    $tasks = new Tasks($db);

    switch($procedureId)
    {
        case 1:
            try{
                $results = $tasks->consultar_tareas($params['estado']);
                return $results;
            }
            catch(ErrorException $error){
                onErroCallService($error);
            }
            break;

        case 2:
                try{
                    $tasks->setTitle($params['title']);
                    $tasks->setDescription($params['description']);
                    $tasks->setResponsible($params['responsible']);
                    $tasks->setDueDate($params['due_date']);
                    $tasks->setTaskType($params['task_type']);
                    $results = $tasks->guardar_tarea();
                    return $results;
                }
                catch(ErrorException $error){
                    onErroCallService($error);
                }
                break;

        case 3:
                try{
                        $results = $tasks->lista_tipos();
                        return $results;
                    }
                catch(ErrorException $error){
                        echo json_encode(array('error' => $error));       
                        onErroCallService($error);
                    }
                break;
                
            case 4:
                    try{
                            $results = $tasks->eliminar_tarea($params['id']);
                            return $results;
                        }
                    catch(ErrorException $error){
                            echo json_encode(array('error' => $error));       
                            onErroCallService($error);
                        }
                    break; 

                case 5:
                        try{
                                $tasks->setTitle($params['title']);
                                $tasks->setDescription($params['description']);
                                $tasks->setResponsible($params['responsible']);
                                $tasks->setDueDate($params['due_date']);
                                $tasks->setTaskType($params['task_type']);
                                $tasks->setState($params['state']);                
                                $results = $tasks->actualizar_tarea($params['id']);
                                return $results;
                            }
                        catch(ErrorException $error){
                                echo json_encode(array('error' => $error));       
                                onErroCallService($error);
                            }
                    break; 

                    case 6:
                        try{              
                                $results = $tasks->consultar_tareasporid($params['id']);
                                return $results;
                            }
                        catch(ErrorException $error){
                                echo json_encode(array('error' => $error));       
                                onErroCallService($error);
                            }
                    break;  

    }}


function onErroCallService($errorString)
{
    http_response_code(400);
    echo json_encode(array('error' => $errorString));
}

?>
