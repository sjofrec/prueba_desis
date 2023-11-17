<?php
require_once "sql/conexion.php";
require_once "sql/queries.php";

//Query get Regiones
$sql_regiones = "SELECT id_region, region FROM regiones";
$result_reg = mysqli_query($conn, $sql_regiones);

//Query get Comunas
$sql_comuna = "SELECT id_comuna, comuna FROM comunas";
$result_comuna = mysqli_query($conn, $sql_comuna);

//Query get Candidatos
$sql_candidato = "SELECT id_candidato, nombre_candidato FROM candidatos";
$result_candidato = mysqli_query($conn, $sql_candidato);

?>