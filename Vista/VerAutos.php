<?php

$titulo = "TP4 - Ejercicio 3";
include_once("estructura/header.php");
include_once("../control/ABMAuto.php");
include_once("../control/ABMPersona.php"); 

$ABMAuto = new ABMAuto;
$ABMPersona = new ABMPersona;
// devuelvo todos los autos
$lista = $ABMAuto->buscar(null);

?>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h1 class="h4">Lista de autos</h1>
        </div>
        <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <th>Patente</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Nombre Dueño</th>
                <th>Apellido Dueño</th>
            </thead>
            <tbody>
                <?php
                    if (is_array($lista) && count($lista)>0){
                        foreach($lista as $auto){
                            echo '<tr>';
                            echo '<td>' . $auto['patente'] . '</td>';
                            echo '<td>' . $auto['marca'] . '</td>';
                            echo '<td>' . $auto['modelo'] . '</td>';
                            echo '<td>' . $ABMPersona->buscar($auto['dniduenio'])[0]['nombre'] . '</td>';
                            echo '<td>' . $ABMPersona->buscar($auto['dniduenio'])[0]['apellido'] . '</td>';
                            echo '<tr>';
                        }
                    } else echo '<tr><td colspan="5">No hay autos cargados.</td></tr>';
                ?>
            </tbody>
        </table>
        </div>

    </div>
</div>

<?php include_once("estructura/footer.php"); ?>

</body>