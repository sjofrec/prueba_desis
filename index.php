<?php
require_once "sql/conexion.php";
require_once "sql/queries.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulario de Votación</title>
<link rel="stylesheet" href="css/styles.css">
<script src="js/jquery.min.js"></script>
<script src="js/funciones.js"></script>
</head>
<body>
<div class="container">
    <h1>FORMULARIO DE VOTACIÓN:</h1>
    <fieldset>
        <form id="formulario" action="proceso.php" method="POST">
            <div class="form_group">
                <label for="nombre">Nombre y Apellido</label>
                <!--Campo no puede quedar vacío-->
                <input type="text" name="nombre" id="nombre" value="" required>
            </div>
            <div class="form_group">
                <label for="alias">Alias</label>
                <!--Campo mínimo 5 carácteres y solo letras y N°-->
                <input type="text" name="alias" id="alias" value="" oninput="validarAlias()" minlength="5">
                <span id="errorAlias"></span>
            </div>
            <div class="form_group">
                <label for="">RUT</label>
                <!--Rut validado Formato Chile-->
                <input type="text" name="rut" id="rut" value="" oninput="checkRut(this)">
                <span id="errorRut"></span>
            </div>    
            <div class="form_group">
                <label for="email">Email</label>
                <!--Formato estándar de Correo validado-->
                <input type="email" name="email" id="email" value="">
                <span id="errorEmail"></span>
            </div>
            <div class="form_group">
                <label for="region">Región</label>
                <?php 
                //ComboBox desde BBDD - Regiones
                echo '<select id="comboRegion" name="comboRegion" onchange="cargarSelect2(this.value);">';

                    while ($row_region = mysqli_fetch_assoc($result_reg)) {
                    echo '<option value="' . $row_region['id_region'] . '">' . $row_region['region'] . '</option>';
                    }

                echo '</select>';
                ?>
            </div>
            <div class="form_group">  
                <label for="comuna">Comuna</label>
                <?php 
                //ComboBox dependiente de región desde BBDD - Comunas
                echo '<select id="comboComuna" name="comboComuna">';

                    while ($row = mysqli_fetch_assoc($result_comuna)) {
                    echo '<option value="' . $row['id_comuna'] . '">' . $row['comuna'] . '</option>';
                    }

                echo '</select>';
                ?>

            </div>
            <div class="form_group">
                <label for="candidato">Candidato</label>
                <?php 
                //ComboBox desde BBDD - Candidato
                echo '<select id="comboCandidato" name="comboCandidato">';

                    while ($row = mysqli_fetch_assoc($result_candidato)) {
                    echo '<option value="' . $row['id_candidato'] . '">' . $row['nombre_candidato'] . '</option>';
                    }

                echo '</select>';
                ?>
            </div>
            <div class="form_group">
                <label>Cómo se enteró de nosotros</label>
                <input type="checkbox" name="opcionWeb" class="checkbox" id="opcionWeb" value="web">
                Web
                <input type="checkbox" name="opcionTv" class="checkbox" id="opcionTv" value="tv">
                TV
                <input type="checkbox" name="opcionRedes" class="checkbox" id="opcionRedes" value="redes">
                Redes Sociales
                <input type="checkbox" name="opcionAmigo" class="checkbox" id="opcionAmigo" value="amigo">
                Amigo
                <span id="errorCheck"></span>
            </div>

            <div class="form_group">
                <input type="submit" value="Enviar">
            </div>

        </form>
        <div id="mensaje"></div>
    </fieldset>
</div>
<script>
    $(document).ready(function() {

    //Enviar Formulario por AJAX
    $("#formulario").submit(function(e) {

             //Evitar que se recargue la página
            e.preventDefault();
            var formData = $(this).serialize(); // Serializa los datos del formulario

            $.ajax({
                type: "POST",
                url: "proceso.php",
                data: formData,
                success: function(response) {
                    // Mostrar mensaje de éxito
                    alert(response);
                },
                error: function() { 
                    // Manejar errores de la solicitud
                    alert("Error al guardar los datos.");
                }
            });
        });
    });
</script>
</body>
</html>
