<?php

require_once __DIR__ . "/lib/manejaErrores.php";
require_once __DIR__ . "/lib/BAD_REQUEST.php";
require_once __DIR__ . "/lib/recibeTexto.php";
require_once __DIR__ . "/lib/ProblemDetailsException.php";
require_once __DIR__ . "/lib/devuelveJson.php";

$nombre = recibeTexto("nombre");
$apellidos = recibeTexto("apellidos");
$numero = recibeTexto("numero");
$correo = recibeTexto("correo");

if (
 $nombre === false
 || $nombre === ""
)
 throw new ProblemDetailsException([
  "status" => BAD_REQUEST,
  "title" => "Falta el nombre.",
  "type" => "/errors/faltanombre.html"
 ]);

 if (
 $apellidos === false
 || $apellidos === ""
)
 throw new ProblemDetailsException([
  "status" => BAD_REQUEST,
  "title" => "Falta el nombre.",
  "type" => "/errors/faltapaellidos.html"
 ]);

if (
 $numero === false
 || $numero === ""
)
 throw new ProblemDetailsException([
  "status" => BAD_REQUEST,
  "title" => "Falta el nombre.",
  "type" => "/errors/faltanombre.html"
 ]);

 if (
 $correo === false
 || $correo === ""
)
 throw new ProblemDetailsException([
  "status" => BAD_REQUEST,
  "title" => "Falta el nombre.",
  "type" => "/errors/faltanombre.html"
 ]);

$resultado = "{$nombre}{$apellidos}{$numero}{$correo}.";

devuelveJson($resultado);
