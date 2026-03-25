<?php
require_once __DIR__ . "/lib/manejaErrores.php";
require_once __DIR__ . "/lib/BAD_REQUEST.php";
require_once __DIR__ . "/lib/resibeTexto.php"; 
require_once __DIR__ . "/lib/ProblemDetailsException.php";
require_once __DIR__ . "/lib/devuelveJson.php";
require_once __DIR__ . "/Bd.php"; 

$art_id = intval(recibeTexto("art_id"));
$cit_cliente = recibeTexto("cit_cliente");
$cit_email = recibeTexto("cit_email");
$cit_descripcion = recibeTexto("cit_descripcion");
$cit_fecha = recibeTexto("cit_fecha");


if ($art_id <= 0) {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Artista inválido",
        "detail" => "Debes seleccionar un artista."
    ]);
}

if (trim($cit_cliente) === "") {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Nombre requerido",
        "detail" => "El nombre del cliente es obligatorio."
    ]);
}

if (trim($cit_email) === "") {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Correo requerido",
        "detail" => "El correo es obligatorio."
    ]);
}

if (trim($cit_descripcion) === "") {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Descripción requerida",
        "detail" => "Debes ingresar una descripción."
    ]);
}

if (trim($cit_fecha) === "") {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Fecha requerida",
        "detail" => "Debes seleccionar una fecha."
    ]);
}

if (!filter_var($cit_email, FILTER_VALIDATE_EMAIL)) {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Correo inválido",
        "detail" => "El correo electrónico no tiene un formato válido."
    ]);
}

$fechaIngresada = DateTime::createFromFormat('Y-m-d', $cit_fecha);

if (!$fechaIngresada) {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Formato de fecha inválido",
        "detail" => "La fecha no tiene un formato válido."
    ]);
}


$hoy = new DateTime();
$limite = (new DateTime())->modify('+2 months');

$hoy->setTime(0, 0, 0);
$limite->setTime(0, 0, 0);

if ($fechaIngresada < $hoy) {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Fecha inválida",
        "detail" => "No se permiten fechas pasadas."
    ]);
}

if ($fechaIngresada > $limite) {
    devuelveJson([
        "status" => BAD_REQUEST,
        "title" => "Fecha inválida",
        "detail" => "La fecha no puede ser mayor a 2 meses desde hoy."
    ]);
}


try {
    $pdo = Conexion::getInstance()->getConnection();
    
    $stmt = $pdo->prepare("INSERT INTO cita 
        (art_id, cit_cliente, cit_email, cit_descripcion, cit_fecha, cit_estatus) 
        VALUES (?, ?, ?, ?, ?, 'Pendiente')");
    
    $stmt->execute([
        $art_id,
        $cit_cliente,
        $cit_email,
        $cit_descripcion,
        $cit_fecha
    ]);

    devuelveJson([
        "status" => 200,
        "message" => "Cita guardada correctamente."
    ]);

} catch (PDOException $e) {
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Error de base de datos",
        "detail" => $e->getMessage()
    ]);
}