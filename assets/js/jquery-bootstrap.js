/* =================================================================
  Implementación de funcionalidades de Bootstrap utilizando jQuery
================================================================= */
$(document).ready(function() {
    $('.navbar-toggler').on('click', function() {
        const objetivo = $(this).data('bs-target');
        $(objetivo).toggleClass('show');
    });

    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        const $menuDesplegable = $(this).next('.dropdown-menu');
        $('.dropdown-menu').not($menuDesplegable).removeClass('show');
        $menuDesplegable.toggleClass('show');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });

    $('[data-bs-toggle="tooltip"]').each(function() {
        $(this).tooltip({
            title: $(this).data('bs-title') || $(this).attr('title'),
            placement: $(this).data('bs-placement') || 'top',
            trigger: $(this).data('bs-trigger') || 'hover focus'
        });
    });

    $('[data-bs-toggle="popover"]').each(function() {
        $(this).popover({
            content: $(this).data('bs-content'),
            title: $(this).data('bs-title'),
            placement: $(this).data('bs-placement') || 'top',
            trigger: $(this).data('bs-trigger') || 'click'
        });
    });

    $('[data-bs-toggle="modal"]').on('click', function() {
        const objetivo = $(this).data('bs-target');
        $(objetivo).modal('mostrar');
    });

    $('.modal .btn-close, .modal [data-bs-dismiss="modal"]').on('click', function() {
        $(this).closest('.modal').modal('ocultar');
    });

    $.fn.modal = function(accion) {
        return this.each(function() {
            if (accion === 'mostrar') {
                $(this).addClass('show').css('display', 'block');
                $('body').addClass('modal-open').append('<div class="modal-backdrop fade show"></div>');
            } else if (accion === 'ocultar') {
                $(this).removeClass('show').css('display', 'none');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            }
        });
    };
});