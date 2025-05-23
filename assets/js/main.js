$(document).ready(function() {
    const $formularioRegistro = $('form[action*="registro"]');
    if ($formularioRegistro.length) {
        $formularioRegistro.on("submit", function(e) {
            const password = $("#password").val();
            const confirmarPassword = $("#confirmar_password").val();

            if (password !== confirmarPassword) {
                e.preventDefault();
                mostrarToast("Las contraseñas no coinciden", "error");
            }

            if (password.length < 6) {
                e.preventDefault();
                mostrarToast("La contraseña debe tener al menos 6 caracteres", "error");
            }
        });
    }

    const $formularioJuego = $('form[action*="anyadirJuego"]');
    if ($formularioJuego.length) {
        $formularioJuego.on("submit", function(e) {
            const fechaInicio = new Date($("#fecha_inicio").val());
            const fechaFin = new Date($("#fecha_fin").val());

            if (fechaFin < fechaInicio) {
                e.preventDefault();
                mostrarToast("La fecha de finalización no puede ser anterior a la fecha de inicio", "error");
            }

            const caratula = $("#caratula")[0].files[0];
            if (caratula && caratula.size > 2 * 1024 * 1024) {
                e.preventDefault();
                mostrarToast("La imagen de carátula no puede superar los 2MB", "error");
            }
        });
    }

    const $mensajes = $(".mensaje");
    if ($mensajes.length > 0) {
        setTimeout(function() {
            $mensajes.animate({ opacity: 0 }, 500, function() {
                $(this).slideUp();
            });
        }, 5000);
    }

    $(document).on('change', '#avatar', function() {
        const entrada = this;
        const $contenedorVista = $('#avatar-preview-container');
        const $imagenVista = $('#avatar-preview-modal');
        const urlImagenActual = $imagenVista.attr('src');

        if (entrada.files && entrada.files[0]) {
            const archivo = entrada.files[0];
            const tiposPermitidos = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/webp"];
            const tamanoMaximo = 1 * 1024 * 1024;

            if (!tiposPermitidos.includes(archivo.type)) {
                mostrarToast("Formato de imagen no permitido.", "error");
                entrada.value = '';
                $(entrada).val('');
                return;
            }

            if (archivo.size > tamanoMaximo) {
                const tamanoArchivoMB = (archivo.size / (1024 * 1024)).toFixed(2);
                mostrarToast(`La imagen es demasiado grande (${tamanoArchivoMB}MB).`, "error");
                entrada.value = '';
                $(entrada).val('');
                return;
            }

            const lector = new FileReader();

            lector.onload = function(e) {
                $imagenVista.attr('src', e.target.result);
                $contenedorVista.removeClass('d-none');
            }

            lector.readAsDataURL(archivo);
        } else {
            if (urlImagenActual && urlImagenActual !== '#') {
            } else {
                $contenedorVista.addClass('d-none');
                $imagenVista.attr('src', '#');
            }
        }
    });
});