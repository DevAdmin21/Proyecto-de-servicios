<?php
require_once __DIR__ . "/lib/manejaErrores.php";
require_once __DIR__ . "/lib/BAD_REQUEST.php";
require_once __DIR__ . "/lib/resibeTexto.php"; 
require_once __DIR__ . "/lib/ProblemDetailsException.php";
require_once __DIR__ . "/lib/devuelveJson.php";
require_once __DIR__ . "/Bd.php"; 

$art_id = recibeTexto("art_id");
$cit_cliente = recibeTexto("cit_cliente");
$cit_email = recibeTexto("cit_email");
$cit_descripcion = recibeTexto("cit_descripcion");
$cit_fecha = recibeTexto("cit_fecha");

try {
    $pdo = Conexion::getInstance()->getConnection();
    
    $stmt = $pdo->prepare("INSERT INTO cita (art_id, cit_cliente, cit_email, cit_descripcion, cit_fecha, cit_estatus) 
                           VALUES (?, ?, ?, ?, ?, 'Pendiente')");
    
    $stmt->execute([$art_id, $cit_cliente, $cit_email, $cit_descripcion, $cit_fecha]);

    devuelveJson("Cita guardada correctamente.");

} catch (PDOException $e) {
    throw new ProblemDetailsException([
        "status" => 500,
        "title" => "Error de base de datos",
        "detail" => $e->getMessage()
    ]);
}