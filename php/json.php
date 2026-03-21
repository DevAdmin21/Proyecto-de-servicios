<?php
require_once __DIR__ . "/lib/recibeJson.php";
require_once __DIR__ . "/lib/devuelveJson.php";

$json = recibeJson();

// Lógica del Estudio de Tatuajes
$tamano = $json->tamano ?? 0;
$esColor = $json->esColor ?? false;

$precioBase = 600; // Pesos
$precioPorCm = 150;
$extraColor = 400;

$total = $precioBase + ($tamano * $precioPorCm);
if ($esColor) {
    $total += $extraColor;
}

$resultado = [
    "cotizacion" => $total,
    "mensaje" => "Presupuesto estimado: $" . $total . " MXN.",
    "detalles" => "Tatuaje de {$tamano}cm" . ($esColor ? " a color." : " en sombras.")
];

devuelveJson($resultado);