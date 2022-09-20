<?php

//Validar parametro de ID de cliente
if (!$_GET["idCliente"]) {
    header("Location: venta_agregar_selecCliente.php");
    die();
}

//Conectar a la base
require_once "utils/bd.php";
$link = conectar();


//Consultar cliente
$consulta = mysql_query("SELECT nombre from cliente WHERE ID = " . $_GET["idCliente"]);

$registro = mysql_fetch_assoc($consulta);

//Validar que el cliente exista
if (!$registro) {
    header("Location: venta_agregar_selecCliente.php");
    die();
}

//Pedir todos los articulos
$consulta = mysql_query("SELECT ID, descripcion, precioVenta from articulo WHERE ESTADO = 1");
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
    <title>Nueva Venta</title>
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

        <h1 class="p-4">NUEVA VENTA</h1>

        <form class="container mb-5">
            <div class="row row-cols-3">
                <div class="col text-center">
                    <p class="card-text">Cliente: <span class="p-0 m-0 fs-3 fw-bold"><?= $registro["nombre"] ?></span></p>
                </div>
                <div class="col text-center">
                    <p class="card-text">Fecha: <span class="p-0 m-0 fs-3 fw-bold" id="fecha"><?= date("d/m/Y")?></span></p>
                </div>
            </div>
        </form>


        <form class="container mb-3" action="venta_agregar_guardar.php?idCliente=<?= $_GET["idCliente"] ?>" method="post" onsubmit="return validar()" id="articulos">
            <input type="number" value=0 id="cantidadAgregados" name="cantidadAgregados" max-numero=0 style="display: none;">

            <div class="row row-cols-4 px-5 py-3 gy-2">
                <div class="col-6 text-center">Articulo</div>
                <div class="col-2 text-center">Cantidad</div>
                <div class="col-3 text-center">Precio Unitario</div>
                <div class="col-1 text-center"></div>

                <div class="col-6 text-center">
                    <select class="form-select" id="articulo" name="articulo" onchange="actualizarPrecio()">
                        <option value="" disabled selected></option>
                        <?php

                        while ($registro = mysql_fetch_assoc($consulta)) {
                            echo '<option value="' . $registro["ID"] . '" precio="' . $registro["precioVenta"] . '">' . $registro["descripcion"] . '</option>';
                        }

                        mysql_free_result($consulta);

                        ?>
                    </select>
                </div>
                <div class="col-2 text-center">
                    <input class="form-control w-75 m-auto" type="number" value=1 min="1" id="cantidad">
                </div>
                <div class="col-3 text-center">
                    <input class="form-control w-75 m-auto" type="number" value=0 id="precio" disabled></input>
                </div>
                <div class="col-1 text-center">
                    <button type="button" onclick="sumarArticulo()" class="btn btn-dark botonTarjetas px-4 py-1 h-100 text-center border-0" role="button"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="row text-center m-auto">
                <div class="col fs-4 fw-bold">Items Agregados</div>
            </div>
            <div class="row row-cols-4 px-5 py-3 gy-2" id="agregados">

            </div>
            <div class="text-center my-5">
                <button type="submit" id="enviar" class="btn mx-3 btn-info botonForm"><i class="fas fa-check"></i></button>
                <button type="button" onclick="location.href = 'venta_agregar_selecCliente.php'" class="btn mx-3 btn-danger botonForm"><i class="fas fa-times"></i></button>
            </div>
        </form>

    </div>

    <script src="handleNav.js"></script>
    <script src="cargaArticulos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>