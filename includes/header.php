<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<script>
    function myDelete(origen) {
        var numtarea = document.getElementById("myid").value; 
        var confirma = confirm("Desea Eliminar la tarea #"+numtarea+" !?");
        if(confirma){
            fetch("delete.php", {
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: "id="+numtarea
            }).then(res => {
            console.log("Request complete! response:", res);
            if(origen=='I'){
                location = "index.php";
            }else{
                location = "consulta.php";
            }
            });//
        }
    }
    function myChangeConsulta() {
        var buscar = document.getElementById("buscar"); 
        buscar.click();
    }
</script>

<body >
    
