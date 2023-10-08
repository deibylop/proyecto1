<?php
include('./includes/header.php');
?>

<div class="container">
    <h1>Lista de tareas</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Estado</th>
                <th>Fecha límite</th>
                <th>Responsable</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('./Class/Tasks.php');
            $tasks = new Tasks();
            $results = $tasks->consultar_noticias();
            if ($results == 400) {
                echo '<tr>';
                echo '<td> No hay datos para mostrar</td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '<td> </td>';
                echo '</tr>';
            } else {
                foreach ($results as $row) {
                    echo '<tr>';
                    echo '<td>' . $row["title"] . '</td>';
                    echo '<td>' . $row["state"] . '</td>';
                    echo '<td>' . $row["due_date"] . '</td>';
                    echo '<td>' . $row["responsible"] . '</td>';
                    echo '<td>' . $row["task_type"] . '</td>';
                    echo '</tr>';
                }
            }

            ?>
        </tbody>
    </table>
</div>

<?php
include('./includes/footer.php');
?>