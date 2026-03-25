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

if ($art_id === false || $art_id === "") {
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Datos incompletos. Falta seleccionar el artista.",
        "type" => "/errors/faltaartista.html"
    ]);
}

if ($cit_cliente === false || $cit_cliente === "") {
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Datos incompletos. Falta el nombre del cliente.",
        "type" => "/errors/faltacliente.html"
    ]);
}

if ($cit_email === false || $cit_email === "") {
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Datos incompletos. Falta el correo electrónico.",
        "type" => "/errors/faltacorreo.html"
    ]);
}

if ($cit_descripcion === false || $cit_descripcion === "") {
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Datos incompletos. Falta la descripción del tatuaje.",
        "type" => "/errors/faltadescripcion.html"
    ]);
}

if ($cit_fecha === false || $cit_fecha === "") {
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Datos incompletos. Falta seleccionar la fecha.",
        "type" => "/errors/faltafecha.html"
    ]);
}

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