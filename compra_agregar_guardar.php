<?php
//Conectar con la base
require_once "utils/bd.php";
$link = conectar();

//Insertar la nueva factura
$instruccion = "INSERT INTO facturacompra (numfactura, fecha, IDproveedor) VALUES";

$valores = "'" . $_POST["numfactura"] . "', ";
$valores .= "'" . $_POST["fecha"] . "', ";
$valores .= "'" . $_GET["idProveedor"] . "'";

$consulta = mysql_query($instruccion . "(" . $valores . ")");

//Validar que la factura se haya creado
if (!$consulta) {
    header("Location: compra_agregar_selecProv.php");
    die();
}

//Obtener ID factura
$consulta = mysql_query("SELECT ID FROM `facturacompra` WHERE numfactura=" . $_POST["numfactura"]. " AND IDproveedor=". $_GET["idProveedor"]);

$registro = mysql_fetch_assoc($consulta);

$IDfactura = $registro["ID"];

//Insertar registros en facartcompra
$indice = 1;

$cantTotal = $_POST["cantidadAgregados"];
$agregados = 0;

while ($agregados < $cantTotal) {
    if ($_POST["articulo" . $indice]) {
        $instruccion = "INSERT INTO facartcompra (IDfactura, IDarticulo, cantidad, preciounitario, subtotal) VALUES";

        $valores = "'" . $IDfactura . "', ";
        $valores .= "'" . $_POST["articulo" . $indice] . "', ";
        $valores .= "'" . $_POST["cantidad" . $indice] . "', ";
        $valores .= "'" . $_POST["precio" . $indice] . "', ";
        $valores .= "'" . ($_POST["cantidad" . $indice] * $_POST["precio" . $indice]) . "'";

        $consulta = mysql_query($instruccion . "(" . $valores . ")");

        $agregados++;
    }
    $indice++;
}

header("Location: compra_detalle.php?idFactura=".$IDfactura);