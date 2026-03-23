<?php
require_once __DIR__ . "/lib/manejaErrores.php";
require_once __DIR__ . "/lib/BAD_REQUEST.php";
require_once __DIR__ . "/lib/recibeTexto.php";
require_once __DIR__ . "/lib/ProblemDetailsException.php";
require_once __DIR__ . "/lib/devuelveJson.php";

$art_id = recibeTexto("art_id");
$cit_cliente = recibeTexto("cit_cliente");
$cit_email = recibeTexto("cit_email");
$cit_descripcion = recibeTexto("cit_descripcion");
$cit_fecha = recibeTexto("cit_fecha");

if ($cit_cliente === false || $cit_cliente === "")
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Falta el nombre del cliente.",
        "type" => "/errors/faltacliente.html"
    ]);

if ($cit_email === false || $cit_email === "")
    throw new ProblemDetailsException([
        "status" => BAD_REQUEST,
        "title" => "Falta el correo.",
        "type" => "/errors/faltacorreo.html"
    ]);

// Solo devuelve el JSON con los datos validados
$resultado = "{$cit_cliente} {$cit_email} {$cit_descripcion}";
devuelveJson($resultado);