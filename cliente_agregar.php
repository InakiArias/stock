<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
    <title>AGREGAR CLIENTE</title>
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

        <h1 class="p-4">Agregar Cliente</h1>

        <form class="p-4">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre Cliente</label>
                <input type="text" class="form-control" id="exampleInputEmail1">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Razon Social</label>
                <input type="text" class="form-control" id="exampleInputEmail1">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">NÂ° de CUIT</label>
                <input type="number" class="form-control" id="exampleInputPassword1">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Domicilio</label>
                <input type="text" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="text-center">
                <button type="submit" id="enviar" name="enviar" class="btn mx-3 btn-info botonForm"><i class="fas fa-check"></i></button>
                <button type="button" onclick="location.href = 'index.php'" class="btn mx-3 btn-danger botonForm"><i class="fas fa-times"></i></button>
            </div>
             
        </form>

        
    </div>
   
    <script src="handleNav.js"></script>
</body>

</html>