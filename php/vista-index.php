<?php

require_once __DIR__ . "/lib/manejaErrores.php";
require_once __DIR__ . "/lib/devuelveJson.php";
require_once __DIR__ . "/Bd.php";

//  conexión
$pdo = Conexion::getInstance()->getConnection();

//  consulta a TU tabla real
$sql = "SELECT 
 art_id,
 art_nombre,
 art_foto,
 art_especialidad,
 art_experiencia,
 art_disponible
 FROM artista
 WHERE art_disponible = 1
 ORDER BY art_nombre";

$stmt = $pdo->query($sql);
$lista = $stmt->fetchAll();

$render = "";

foreach ($lista as $a) {

 $id = htmlentities(urlencode($a["art_id"]));
 $nombre = htmlentities($a["art_nombre"]);
 $especialidad = htmlentities($a["art_especialidad"]);
 $experiencia = htmlentities($a["art_experiencia"]);
 $foto = htmlentities($a["art_foto"]);

 $render .= "
  <div class='card'>
   <img src='$foto' alt='$nombre' width='200' height='200'>
   <h3>$nombre</h3>
   <p>Especialidad: $especialidad</p>
   <p>Experiencia: $experiencia años</p>
  </div>
 ";
}


devuelveJson([ "lista" => ["innerHTML" => $render]]);