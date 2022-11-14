<?php
// Aldagaiak
$hostDB = 'azterketadawdb.cks43nkvq6vb.us-east-1.rds.amazonaws.com';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenyaDB = 'NausicaA';
$codigo = isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : null;
$titulo = isset($_REQUEST['titulo']) ? $_REQUEST['titulo'] : null;
$autor = isset($_REQUEST['autor']) ? $_REQUEST['autor'] : null;
$disponible = isset($_REQUEST['disponible']) ? $_REQUEST['disponible'] : null;

// Datu basera konektatu
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenyaDB);

// Konprobatu POST-etik datuak datozen
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preparatu UPDATE
    $miUpdate = $miPDO->prepare('UPDATE libros SET titulo = :titulo, autor = :autor, disponible = :disponible WHERE codigo = :codigo');
    // Exekutatu UPDATE datuekin
    $miUpdate->execute(
        [
            'codigo' => $codigo,
            'titulo' => $titulo,
            'autor' => $autor,
            'disponible' => $disponible
        ]
    );
    // irakurri.php-ra bialdu
    header('Location: irakurri.php');
} else {
    // Preparatu SELECT
    $miConsulta = $miPDO->prepare('SELECT * FROM libros WHERE codigo = :codigo;');
    // Exekutatu kontsulta
    $miConsulta->execute(
        [
            codigo => $codigo
        ]
    );
}

// Erantzuna lortu
$libro = $miConsulta->fetch();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear - CRUD PHP</title>
</head>
<body>
    <form method="post">
        <p>
            <label for="titulo">Titulo</label>
            <input id="titulo" type="text" name="titulo" value="<?= $libro['titulo'] ?>">
        </p>
        <p>
            <label for="autor">Autor</label>
            <input id="autor" type="text" name="autor" value="<?= $libro['autor'] ?>">
        </p>
        <p>
            <div>¿Disponible?</div>
            <input id="si-disponible" type="radio" name="disponible" value="1"<?= $libro['disponible'] ? ' checked' : '' ?>> <label for="si-disponible">Si</label>
            <input id="no-disponible" type="radio" name="disponible" value="0"<?= !$libro['disponible'] ? ' checked' : '' ?>> <label for="no-disponible">No</label>
        </p>
        <p>
            <input type="hidden" name="codigo" value="<?= $codigo ?>">
            <input type="submit" value="Modificar">
        </p>
    </form>
</body>
</html>