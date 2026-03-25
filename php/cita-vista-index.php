<?php
require_once __DIR__ . "/lib/manejaErrores.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/lib/devuelveJson.php";

$pdo = Conexion::getInstance()->getConnection();

$stmt = $pdo->query("SELECT cit_cliente, cit_email, cit_fecha, cit_estatus FROM cita ORDER BY cit_fecha DESC");
$model = $stmt->fetchAll();

$render = "";

if (empty($model)) {
    $render = "<tr><td colspan='4'>No hay citas registradas.</td></tr>";
} else {
    foreach ($model as $row) {
        $cliente = htmlspecialchars($row["cit_cliente"]);
        $email = htmlspecialchars($row["cit_email"]);
        $fecha = htmlspecialchars($row["cit_fecha"]);
        $estatus = htmlspecialchars($row["cit_estatus"]);

        $render .= "
            <tr>
                <td>{$cliente}</td>
                <td>{$email}</td>
                <td>{$fecha}</td>
                <td>{$estatus}</td>
            </tr>";
    }
}

devuelveJson([
    "lista" => ["innerHTML" => $render]
]);