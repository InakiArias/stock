<?php

function conectar($ip = "127.0.0.1", $user = "root", $pass = "") {
    $link = mysql_connect($ip, $user, $pass)
    or die("Error de conexion");

    mysql_select_db("medicamentos", $link)
        or die("Error al seleccionar base");

    mysql_set_charset("utf8");

    return $link;
}

?>