<?php
require_once "sql/conexion.php";

if (isset($_POST["region_id"])) {
    $region_id = $_POST["region_id"];

    // Consulta SQL para obtener las comunas de la región seleccionada
    $sql = "SELECT id_comuna, comuna FROM comunas WHERE region_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $region_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $comunas = array();

    while ($row = $result->fetch_assoc()) {
        $comunas[] = $row;
    }

    echo json_encode($comunas);
}
?>