<?php //FUNCIONES
function formatearFecha($fecha)
{
    $arr = explode("-", $fecha);
    return $arr[2] . "/" . $arr[1] . "/" . $arr[0];
}
function formatearNro($numero)
{
    if ($numero < 10)
        return "00" . $numero;
    else if ($numero < 100)
        return "0" . $numero;

    return $numero;
}
?>
<?php

//Conectar a la base
$link = mysql_connect("127.0.0.1", "root", "")
    or die("Error de conexion");

mysql_select_db("medicamentos", $link)
    or die("Error al seleccionar base");

mysql_set_charset("utf8");

//Validar pagina
if ($_GET["pagina"] < 1) {
    $_GET["pagina"] = 1;
}

$pagina = $_GET["pagina"];

//Guardar filtro
$filtro = $_GET["filtro"];


//Pedir ventas
$consultaVentas = mysql_query("SELECT facturaventa.ID, numfactura, nombre, fecha , (
            SELECT SUM( subtotal )
            FROM facartventa
            WHERE facartventa.IDfactura = facturaventa.ID
        ) AS total
    FROM facturaventa
    INNER JOIN cliente ON facturaventa.IDcliente = cliente.ID
    WHERE nombre LIKE '" . $filtro . "%'
    ORDER BY numfactura DESC
    LIMIT " . (($pagina - 1) * 6) . " , 6");

//Validar que haya ventas en la pagina elegida
if ($pagina > 1 && mysql_num_rows($consultaVentas) == 0) {
    header("Location: ventas.php");
    die();
}
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
    <title>Ventas</title>
</head>

<body>

    <div id="sideNav" class="navCerrado" tabindex="-1">
        <button id="botonHome" onclick="location.href='index.php'"><i class="fas fa-home"></i></button>

        <button id="botonCierraNav" onclick="cierraNav()"><i class="far fa-times-circle"></i></button>

        <ul class="menu">
            <li class="itemMenu"><a href="clientes.php">Clientes</a></li>
            <li class="itemMenu"><a href="proveedores.php">Proveedores</a></li>
            <li class="itemMenu"><a href="articulos.php">Artí­culos</a></li>
            <li class="itemMenu"><a href="compras.php">Compras</a></li>
            <li class="itemMenu"><a href="ventas.php">Ventas</a></li>
        </ul>
    </div>

    <div id="overlay" onclick="cierraNav()"></div>

    <div id="main">
        <button id="botonAbreNav" onclick="abreNav()"><i class="fas fa-home"></i></button>

        <h1 class="p-4">VENTAS</h1>

        <form class="container my-2" method="get">
            <div class="row">
                <div class="input-group justify-content-center">
                    <div class="input-group-text">
                        <a class="btn btn-dark px-3 py-0 fs-4 botonBack" href="ventas.php?pagina=<?= $pagina - 1 ?>&filtro=<?= $filtro ?>" role="button"><i class="fas fa-arrow-left"></i></a>
                    </div>

                    <div class="input-group-text ">
                        <input class="py-0 fs-4 inputBusqueda" type="text" name="filtro" value="<?= $filtro ?>" placeholder="Buscar por cliente...">
                        <button class="btn btn-dark px-3 py-0 fs-4 botonBusqueda"><i class="fas fa-search"></i></button>
                    </div>

                    <div class="input-group-text">
                    </div>

                    <div class="input-group-text">
                        <a class="btn btn-dark px-3 py-0 fs-4 botonNuevo" href="venta_agregar_selecCliente.php" role="button">Nueva venta</a>
                    </div>

                    <div class="input-group-text">
                        <a class="btn btn-dark px-3 py-0 fs-4 botonForward" href="ventas.php?pagina=<?= $pagina + 1 ?>&filtro=<?= $filtro ?>" role="button"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </form>


        <div class="container my-4">
            <div class="row row-cols-1 row-cols-md-3 gx-4 gy-4">
                <?php

                while ($registro = mysql_fetch_assoc($consultaVentas)) {
                    echo '
                    <div class="col">
                        <div class="card h-100 m-auto border-0">
                            <div class="card-header py-0 d-flex align-items-center justify-content-between">
                                <p class="p-0 pt-1 m-0">Nro.<span class="p-0 m-0 fs-3"> ' . formatearNro($registro["numfactura"]) . '</span></p>                           
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text">Cliente: <span class="p-0 m-0 fs-5 fw-bold"> ' . $registro["nombre"] . '</span></p>
                                <p class="card-text">Fecha: <span class="p-0 m-0 fs-5 fw-bold"> ' . formatearFecha($registro["fecha"]) . '</span></p>
                                <p class="card-text">Importe: <span class="p-0 m-0 fs-5 fw-bold"> $' . $registro["total"] . '</span></p>
                                <a class="btn btn-dark botonTarjetas px-4 py-1" href="venta_factura.php?idFactura=' . $registro["ID"] . '" role="button">Detalle</a>
                            </div>
                        </div>
                    </div>
                    ';
                }

                mysql_free_result($consultaVentas);

                ?>


            </div>
        </div>

        <script src="handleNav.js"></script>
</body>

</html>