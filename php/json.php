<?php 
require_once __DIR__ . "/lib/manejaErrores.php";
require_once __DIR__ . "/lib/recibeJson.php";
require_once __DIR__ . "/lib/devuelveJson.php";  

$json = recibeJson();  

// Lógica del Estudio de Tatuajes
$tamano = $json->tamano ?? 0; 
$esColor = $json->esColor ?? false;  

// Validación
if ($tamano <= 0) {
    devuelveJson([
        "error" => true,
        "mensaje" => "El tamaño del tatuaje debe ser mayor a 0 cm."
    ]);
    exit;
}

$precioBase = 600;
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