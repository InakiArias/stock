<?php //FUNCIONES
function formatearFecha($fecha)
{
    $arr = explode("-", $fecha);
    return $arr[2] . "/" . $arr[1] . "/" . $arr[0];
}
?>
<?php

//Validar parametro de ID de factura
if (!$_GET["idFactura"]) {
    header("Location: ventas.php");
    die();
}


//Conectar a la base
$link = mysql_connect("127.0.0.1", "root", "")
    or die("Error de conexion");

mysql_select_db("medicamentos", $link)
    or die("Error al seleccionar base");

mysql_set_charset("utf8");


//Pedir la factura
$consulta = mysql_query("SELECT * from facturaventa WHERE ID = " . $_GET["idFactura"]);

$registroFactura = mysql_fetch_assoc($consulta);

//Validar que la factura existe
if (!$registroFactura) {
    header("Location: ventas.php");
    die();
}

//Pedir nombre de cliente
$consulta = mysql_query("SELECT nombre from cliente WHERE ID = " . $registroFactura["IDcliente"]);

$registroCliente = mysql_fetch_assoc($consulta);

$nombreCliente = $registroCliente["nombre"];

//Pedir articulos
$consultaArticulos = mysql_query("SELECT descripcion, cantidad, preciounitario, subtotal
    FROM facartventa
    INNER JOIN articulo ON facartventa.IDarticulo = articulo.ID
    WHERE facartventa.IDfactura =" . $_GET["idFactura"]);

$consultaTotal =  mysql_query("SELECT SUM(subtotal) AS total
    FROM facartventa
    INNER JOIN articulo ON facartventa.IDarticulo = articulo.ID
    WHERE facartventa.IDfactura =" . $_GET["idFactura"]);

$registroTotal = mysql_fetch_assoc($consultaTotal);

$total = $registroTotal["total"];
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
    <title>Factura</title>
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

        <h1 class="p-4">FACTURA</h1>

        <form class="container mb-5">
            <div class="row row-cols-3">
                <div class="col text-center">
                    <p class="card-text">Cliente: <span class="p-0 m-0 fs-3 fw-bold"><?= $nombreCliente ?></span></p>
                </div>
                <div class="col text-center">
                    <p class="card-text">Fecha: <span class="p-0 m-0 fs-3 fw-bold" id="fecha"><?= formatearFecha($registroFactura["fecha"]) ?></span></span></p>
                </div>
                <div class="col text-center">
                    <p class="card-text">Nro Factura: <span class="p-0 m-0 fs-3 fw-bold" id="fecha"><?= $registroFactura["numfactura"] ?></span></p>
                </div>
            </div>
        </form>


        <form class="container mb-3" id="articulos">
            <input type="number" value=0 id="cantidadAgregados" name="cantidadAgregados" max-numero=0 style="display: none;">

            <div class="row row-cols-4 px-5 py-3 gy-2">
                <div class="col-6 text-center">Articulo</div>
                <div class="col-2 text-center">Cantidad</div>
                <div class="col-2 text-center">Precio Unitario</div>
                <div class="col-2 text-center">Subtotal</div>

                <?php

                while ($registro = mysql_fetch_assoc($consultaArticulos)) {
                    echo '<div class="col-6 text-center">
                        <input class="form-control w-100 m-auto" type="text" value="' . $registro["descripcion"] . '" disabled>
                    </div>';
                    echo '<div class="col-2 text-center">
                        <input class="form-control w-75 m-auto text-center" type="text" value="' . $registro["cantidad"] . '" disabled></input>
                    </div>';
                    echo '<div class="col-2 text-center">
                        <input class="form-control w-75 m-auto text-center" type="text" value="$' . $registro["preciounitario"] . '" disabled></input>
                    </div>';
                    echo '<div class="col-2 text-center">
                        <input class="form-control w-75 m-auto text-center" type="text" value="$' . $registro["subtotal"] . '" disabled></input>
                    </div>';
                }

                mysql_free_result($consulta);

                ?>
            </div>

            <div class="row row-cols-4 px-5 py-3 my-2">
                <div class="col-6 text-center">
                </div>
                <div class="col-2 text-center">
                </div>
                <div class="col-2 text-center">
                    <h4>TOTAL</h4>
                </div>
                <div class="col-2 text-center">
                    <input class="form-control w-75 m-auto text-center" type="text" value="$<?= $total ?>" disabled></input>
                </div>
            </div>

        </form>

        <div class="text-center my-5">
            <button type="button" onclick="location.href = 'venta_agregar_selecCliente.php'" class="btn mx-3 botonNuevo">NUEVA VENTA</button>
        </div>

        <script src="handleNav.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>