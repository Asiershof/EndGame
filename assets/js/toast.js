class NotificacionToast {
    constructor() {
        this.contenedor = null;
        this.duracionPredeterminada = 5000;
        this.crearContenedor();
    }

    crearContenedor() {
        if (!this.contenedor) {
            this.contenedor = $("<div>").addClass("toast-container").appendTo("body");
        }
    }

    mostrar(mensaje, tipo = "info", duracion = this.duracionPredeterminada) {
        const toast = $("<div>").addClass(`toast toast-${tipo}`);

        let icono = "";
        switch (tipo) {
            case "success":
                icono = "✓";
                break;
            case "error":
                icono = "✕";
                break;
            case "warning":
                icono = "⚠";
                break;
            case "info":
            default:
                icono = "ℹ";
                break;
        }

        const contenidoToast = $("<div>").addClass("toast-content").appendTo(toast);
        $("<div>").addClass("toast-icon").text(icono).appendTo(contenidoToast);
        $("<div>").addClass("toast-message").html(mensaje).appendTo(contenidoToast);
        
        $("<button>").addClass("toast-close").text("✕").appendTo(toast);
        
        const progresoToast = $("<div>").addClass("toast-progress").appendTo(toast);
        const barraProgreso = $("<div>").addClass("toast-progress-bar").appendTo(progresoToast);

        this.contenedor.append(toast);

        barraProgreso.css("width", "100%");
        barraProgreso.css("transitionDuration", `${duracion}ms`);

        setTimeout(() => {
            barraProgreso.css("width", "0%");
        }, 10);

        toast.find(".toast-close").on("click", () => {
            this.cerrar(toast);
        });

        const idTemporizador = setTimeout(() => {
            this.cerrar(toast);
        }, duracion);

        toast.data("timeoutId", idTemporizador);

        return toast;
    }

    cerrar(toast) {
        const idTemporizador = toast.data("timeoutId");
        if (idTemporizador) {
            clearTimeout(idTemporizador);
        }

        toast.addClass("hiding");

        setTimeout(() => {
            toast.remove();
        }, 300);
    }

    exito(mensaje, duracion = this.duracionPredeterminada) {
        return this.mostrar(mensaje, "success", duracion);
    }

    error(mensaje, duracion = this.duracionPredeterminada) {
        return this.mostrar(mensaje, "error", duracion);
    }

    info(mensaje, duracion = this.duracionPredeterminada) {
        return this.mostrar(mensaje, "info", duracion);
    }

    advertencia(mensaje, duracion = this.duracionPredeterminada) {
        return this.mostrar(mensaje, "warning", duracion);
    }
}

const toast = new NotificacionToast();

function mostrarToast(mensaje, tipo, duracion) {
    if (toast) {
        toast.mostrar(mensaje, tipo, duracion);
    }
}

$(document).ready(function() {
    const parametrosUrl = new URLSearchParams(window.location.search);
    const mensajeToast = parametrosUrl.get("toast_message");
    const tipoToast = parametrosUrl.get("toast_type") || "info";

    if (mensajeToast) {
        const mensajeDecodificado = decodeURIComponent(mensajeToast);
        mostrarToast(mensajeDecodificado, tipoToast);
        const nuevaUrl = window.location.pathname + window.location.hash;
        window.history.replaceState({}, document.title, nuevaUrl);
    }
});
