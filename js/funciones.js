
    function validarAlias() {
        const alias = document.getElementById("alias");
        const valor = alias.value;
        const contieneLetras = /[a-zA-Z]/.test(valor);
        const contieneNumeros = /\d/.test(valor);

        if (contieneLetras && contieneNumeros || valor === "") {
            document.getElementById("errorAlias").textContent = "";
        } else {
            document.getElementById("errorAlias").textContent = "El campo debe contener letras y números.";
        }
    }

    function checkRut(rut) {

        // Despejar puntos y guiones
        var valor = rut.value.replace('.','');
        valor = valor.replace('-','');
        
        // Aislar Cuerpo y Dígito Verificador
        cuerpo = valor.slice(0,-1);
        dv = valor.slice(-1).toUpperCase();
        
        // Formatear RUN
        rut.value = cuerpo + '-'+ dv
        
        // Si no cumple con el mínimo ej. (n.nnn.nnn)
        if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
        
        // Calcular Dígito Verificador
        suma = 0;
        multiplo = 2;
        
        // Para cada dígito del Cuerpo
        for(i=1;i<=cuerpo.length;i++) {
        
            // Obtener su Producto con el Múltiplo Correspondiente
            index = multiplo * valor.charAt(cuerpo.length - i);
            
            // Sumar al Contador General
            suma = suma + index;
            
            // Consolidar Múltiplo dentro del rango [2,7]
            if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
      
        }
        
        // Calcular Dígito Verificador en base al Módulo 11
        dvEsperado = 11 - (suma % 11);
        
        // Casos Especiales (0 y K)
        dv = (dv == 'K')?10:dv;
        dv = (dv == 0)?11:dv;
        
        // Validar que el Cuerpo coincide con su Dígito Verificador
        if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
        
        // Si todo sale bien, eliminar errores (decretar que es válido)
        rut.setCustomValidity('');
    }
    
    $(document).ready(function() {

        //Restringir campo para que sea solo números o letras
        $('#alias').on('keydown', function(e) {
            // Obtiene el código de la tecla presionada
            var key = e.which;
    
            // Verifica si la tecla presionada es una letra, número o la tecla de borrar (Backspace)
            if ((key >= 48 && key <= 57) || // Números
                (key >= 65 && key <= 90) || // Letras mayúsculas
                (key >= 97 && key <= 122) || // Letras minúsculas
                key === 8) { // Backspace
                return true; // Permitir la entrada
            } else {
                return false; // Bloquear la entrada
            }
        });

        $('#email').on('keyup',function(){
            const email = document.getElementById("email");
            const valor = email.value;
            var val = $(this).val().trim(),
                reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            
            if( reg.test(val) != false || valor === ""){
                document.getElementById("errorEmail").textContent = "";
            }
            else{
              document.getElementById("errorEmail").textContent = "Email ingresado no es un email válido";
            }
          });

        // Evento Changue para el cambio en la dependencia de Selects
        $('#comboRegion').on('change', function () {
            
            var region_id = $(this).val();

            // Petición AJAX para comunas según dependencia
            $.ajax({
                url: 'get_comunas.php',
                type: 'POST',
                data: { region_id: region_id },
                dataType: 'json',
                success: function (comunas) {
                    var comunaSelect = $('#comboComuna');
                    comunaSelect.empty();
                    comunaSelect.append('<option value="">Selecciona una comuna</option>');

                    $.each(comunas, function (key, comuna) {
                        comunaSelect.append('<option value="' + comuna.id_comuna + '">' + comuna.comuna + '</option>');
                    });
                },
                error: function () {
                    alert('Error al cargar las comunas.');
                }
            });
        });

        //Validar que seleccione más de dos Checkbox
        $('.checkbox').on('change', function() {
            var checksSeleccionados = $('.checkbox:checked').length;

            if (checksSeleccionados > 2) {
                $('#errorCheck').text('');
            } else {
                $('#errorCheck').text('Selecciona al menos dos opciones.');
            }
        });

    });