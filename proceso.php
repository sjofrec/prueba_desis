<?php
require_once "sql/conexion.php";
require_once "sql/queries.php";

//Reunir datos para envío
$nombre       = $_POST["nombre"];
$alias        = $_POST["alias"];
$rut          = $_POST["rut"];
$email        = $_POST["email"];
$id_region    = $_POST["comboRegion"];
$id_comuna    = $_POST["comboComuna"];
$id_candidato = $_POST["comboCandidato"];
$opcion_web   = isset($_POST["opcionWeb"]) ? $_POST["opcionWeb"] : "";
$opcion_tv    = isset($_POST["opcionTv"]) ? $_POST["opcionTv"] : "";
$opcion_redes = isset($_POST["opcionRedes"]) ? $_POST["opcionRedes"] : "";
$opcion_amigo = isset($_POST["opcionAmigo"]) ? $_POST["opcionAmigo"] : "";


// Consultar si la persona ya votó anteriormente 
$sql = "SELECT * FROM votos WHERE rut = '$rut'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "No puede votar. Ya ha votado previamente.";

} else {

    //Guardar registros en BBDD - votos
    $sql_insert =  "INSERT INTO votos (nombre_apellido, alias, rut, email, region_id, comuna_id, candidato_id) 
                        VALUES ('$nombre', '$alias', '$rut', '$email', '$id_region', '$id_comuna', '$id_candidato')";
    
    $voto = $conn->insert_id;// Se obtiene el ID del voto recién insertado

    //Guardar registros en BBDD - medios_comunicación
    $sql_comunicacion =  "INSERT INTO medios_comunicacion (voto_id, web, tv, red_social, amigo) 
                        VALUES ('$voto', '$opcion_web', '$opcion_tv', '$opcion_redes', '$opcion_amigo')";

    if ($conn->query($sql_insert) && $conn->query($sql_comunicacion) === TRUE) {
        echo "¡Voto registrado exitosamente!.";
    } else {
        echo "Error al registrar el voto: " . $conn->error;
    }

}

?>