<?php

session_start();

require_once "cfg/conexion.php";
require_once "crud/crud.php";

$estado = $_POST['estado'];


if ($estado == 'guardar_historial_impresion') {
  $usuario = $_POST['usuario'];
  $tipo = $_POST['tipo'];
  $nota = $_POST['nota'];
  $mesa = $_POST['mesa'];
  $orden = $_POST['orden'];
  $txthist = $_POST['txthist'];

  $info = new crud();

  $result_f = $info->guardar_hist_impresion($usuario,$tipo,$nota,$mesa,$orden,$txthist);

  echo $result_f;

}

?>