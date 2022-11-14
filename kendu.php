<?php
// Aldagaiak
$hostDB = 'azterketadawdb.cks43nkvq6vb.us-east-1.rds.amazonaws.com';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenyaDB = 'NausicaA';
// Datu basera konektatu
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenyaDB);
// Borratu nahi dugun liburuaren kodea lortu
$codigo = isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : null;
// Preparatu DELETE
$miConsulta = $miPDO->prepare('DELETE FROM libros WHERE codigo = :codigo');
// Exekutatu sententzia SQL
$miConsulta->execute([
    codigo => $codigo
]);
// irakurri.php-era bialdu
header('Location: index.php');
?>