<?php
$guardar = false;
$cargar = false;
$borrar = false;
$no_existe = false;
//Dayerlin Lombana c.i: 29.836.247
$file = '';
$dir = './archivos/';

if (isset($_POST["save"]) && isset($_POST['content']) && isset($_POST['filename']) && !empty($_POST['filename'])) {
    $filename = $_POST['filename'];
    if (strpos($filename, ".txt") === false) {
        $filename .= ".txt";
    }
    $content = $_POST['content'];
    $file_handle = fopen($dir . $filename, 'w');
    fwrite($file_handle, $content);
    fclose($file_handle);
    $guardar = true;
}

if (isset($_GET["file"]) && !empty($_GET['file'])) {
    $file = $_GET['file'];
    if (is_file($dir . $file)) {
        $cargar = true;
    } else {
        $no_existe = true;
    }
}

if (isset($_GET["borrar"]) && !empty($_GET['borrar'])) {
    $filename = $_GET['borrar'];
    if (file_exists($dir . $filename)) {
        unlink($dir . $filename);
        $borrar = true;
    }
}

$files = scandir($dir);
$files = array_diff($files, array('.', '..'));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloc de notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="assents/style.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <?php if ($guardar) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>SE HA GUARDADO CORRECTAMENTE EL ARCHIVO</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } else if ($cargar) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ARCHIVO CARGADO</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } else if ($borrar) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>SE HA ELIMINADO EL ARCHIVO</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } else if ($no_existe) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>NO EXISTE EL ARCHIVO</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <h2 class="m-2 text-pink" style="text-align: center;">BLOC DE NOTAS</h2>
            <div class="col-6 m-2 border border-white border-3 p-2">
                <br>
                <h2 class="text-pink" style="text-align: center;">OPCIONES DE ARCHIVO</h2>
                <div class="row-col-6" style="text-align: center;">
                    <br>
                    <a href="./index.php" class="btn btn-light m-1"> Nuevo archivo</a>
                    <br>
                    <button type="button" class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#filesModal">Abrir archivo</button>
                    <br>
                </div>
                <br>
            </div>
            <br>
            <div class="col-12 bg-pink p-2 text-dark bg-opacity-75">
                <br>
                <?php if ($cargar && !empty($file)) { ?>
                    <h3 class="text-white" style="text-align: left;"><?php echo $file ?></h3>
                    <form class="col-12"  method="POST">
                        <div class="form-floating">
                            <textarea placeholder="Escribe aqui tu texto." class="form-control flex-grow-1 shadow-sm bg-body-tertiary rounded" name="content" style="height: 100px" id="floatingTextarea2"><?php echo file_get_contents($dir . $file); ?></textarea>
                            <label for="floatingTextarea2">Escribe aqui tu texto.</label>
                            <input type="hidden" name="filename" value="<?php echo $file ?>">
                        </div>
                        <br>
                        <div class="row-col-7" style="text-align: left;">
                            <button name="save" type="submit" class="btn btn-dark">Guardar</button>
                        </div>
                        <br>
                    </form>
                <?php } else { ?>
                    <form class="col-12" method="POST">
                        <div class="form-floating">
                            <textarea placeholder="Escribe aqui tu texto."class="form-control flex-grow-1 shadow bg-body-secondary rounded" name="content" style="height: 100px" id="floatingTextarea2" ></textarea>
                            <label for="floatingTextarea2">Escribe aqui tu texto.</label>
                            <br>
                            <?php if (!$cargar) { ?>
                                <div class="row-col-7" style="text-align: left;">
                                    <button type="submit" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#saveModal">Guardar archivo</button>
                                </div>
                                <br>
                            <?php } ?>
                        </div>
                        <div class="modal fade" id="saveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="saveModalLabel">Nombre del archivo</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="form-floating m-1">
                                        <input type="text" placeholder="Ingresa el nombre del archivo" class="form-control m-1" id="filename" name="filename" aria-describedby="filename" required>
                                        <label for="filename" class="m-1">Ingresar aqui el nombre del archivo</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button name="save" type="submit" class="btn btn-purple">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>  
            <div class="modal fade" id="filesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filesModalLabel" aria-hidden="true">
                <div class="modal-dialog bg-pink">
                    <div class="modal-content bg-white">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="filesModalLabel">Archivos</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="d-flex flex-column p-0" style="gap: 1rem">
                                <?php foreach ($files as $file_item) { ?>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <a href="index.php?file=<?php echo $file_item ?>"><?php echo $file_item ?></a>
                                        <a class="btn btn-purple" href="?<?php if ($file) echo "file=" . $file ?>&borrar=<?php echo $file_item ?>">Eliminar</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    

       

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>