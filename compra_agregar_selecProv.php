<?php
//Conectar a la base
require_once "utils/bd.php";
$link = conectar();

//Pedir proveedores
$consulta = mysql_query("SELECT ID, nombre, razonSocial FROM proveedor WHERE estado = 1 ORDER BY nombre");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="estilo.css">
    <script src="utils/themes.js"></script>
    
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
    <title>Nueva Compra</title>
</head>

<body>
    <div id="sideNav" class="navCerrado" tabindex="-1">
        <button id="botonHome" onclick="location.href='index.php'"><i class="fas fa-home"></i></button>

        <button id="botonCierraNav" onclick="cierraNav()"><i class="far fa-times-circle"></i></button>

        <ul class="menu">
            <li class="itemMenu"><a href="clientes.php">Clientes</a></li>
            <li class="itemMenu"><a href="proveedores.php">Proveedores</a></li>
            <li class="itemMenu"><a href="articulos.php">ArtÃ­culos</a></li>
            <li class="itemMenu"><a href="compras.php">Compras</a></li>
            <li class="itemMenu"><a href="ventas.php">Ventas</a></li>
        </ul>
    </div>

    <div id="overlay" onclick="cierraNav()"></div>

    <div id="main">
        <button id="botonAbreNav" onclick="abreNav()"><i class="fas fa-home"></i></button>

        <h1 class="p-4">NUEVA COMPRA</h1>

        <form class="p-4">
            <div class="mb-3 m-auto text-center">
                <label for="exampleInputEmail1" class="form-label">Seleccionar Proveedor</label>

                <select class="form-select" onchange="location.href='compra_agregar_cargarArt.php?idProveedor=' + event.target.value">
                    <option value="" disabled selected></option>
                    <?php

                    while ($registro = mysql_fetch_assoc($consulta)) {
                        echo '<option value="'.$registro["ID"].'">'.$registro["nombre"].' | Razon Social: '.$registro["razonSocial"].' </option>';
                    }

                    mysql_free_result($consulta);

                    ?>
                </select>
            </div>
        </form>

        <div class="text-center my-5">
            <button type="button" onclick="location.href = 'compras.php'" class="btn btn-danger fs-3"><i class="fas fa-undo-alt"></i></button>
        </div>

    </div>

    <script src="handleNav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>