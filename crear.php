<?php
include('./includes/header.php');
?>
<br><br>
<div class="container">
    <div class="container text-center">
        <div class="card" style="width: 25rem;">
            <form action="guardar.php" method="post">
                <div class="card-body">
                    <h5 class="card-title">Nueva Tarea</h5>
                    <p class="card-text"></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <input name="title" type="text" class="form-control" placeholder="Título" aria-label="Título">
                    </li>
                    <li class="list-group-item">
                        <input name="description" type="text" class="form-control" placeholder="Descripción" aria-label="Descripción">
                    </li>
                    <li class="list-group-item">
                        <input name="responsible" type="text" class="form-control" placeholder="Responsable" aria-label="Responsable">
                    </li>
                    <li class="list-group-item">
                        <input name="due_date" type="date" class="form-control" placeholder="Fecha" aria-label="Fecha">
                    </li>
                    <li class="list-group-item">
                        <input name="task_type" type="text" class="form-control" placeholder="Tipo" aria-label="Tipo">
                    </li>
                </ul>
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include('./includes/footer.php');
?>