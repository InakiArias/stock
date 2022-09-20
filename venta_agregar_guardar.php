<?php
//Conectar con la base
$link = mysql_connect("127.0.0.1", "root", "")
    or die("Error de conexion");

mysql_select_db("medicamentos", $link)
    or die("Error al seleccionar base");

mysql_set_charset("utf8");

//Calcular el nro de factura de venta maximo
$consulta = mysql_query("SELECT MAX( numfactura ) AS maxnro FROM `facturaventa`");

$registro = mysql_fetch_assoc($consulta);

$numfactura = $registro["maxnro"] + 1;

//Insertar la nueva factura
$instruccion = "INSERT INTO facturaventa (numfactura, fecha, IDcliente) VALUES";

$valores = "'" . $numfactura . "', ";
$valores .= "CURDATE(), ";
$valores .= "'" . $_GET["idCliente"] . "'";

$consulta = mysql_query($instruccion . "(" . $valores . ")");

//Validar que la factura se haya creado
if (!$consulta) {
    header("Location: venta_agregar_selecCliente.php");
    die();
}

//Obtener ID factura
$consulta = mysql_query("SELECT ID FROM `facturaventa` WHERE numfactura=" . $numfactura);

$registro = mysql_fetch_assoc($consulta);

$IDfactura = $registro["ID"];

//Insertar registros en facartventa
$indice = 1;

$cantTotal = $_POST["cantidadAgregados"];
$agregados = 0;

while ($agregados < $cantTotal) {
    if ($_POST["articulo" . $indice]) {
        $instruccion = "INSERT INTO facartventa (IDfactura, IDarticulo, cantidad, preciounitario, subtotal) VALUES";

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

header("Location: venta_factura.php?idFactura=".$IDfactura);