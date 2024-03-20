$(document).on('click', '.button-ajax', function (e) {
    e.preventDefault();

    var button = $(this);
    var form = button.closest('form'); // Encuentra el formulario más cercano al botón
    var action = form.attr('action');
    var method = form.attr('method');
    var csrf = form.find('input[name="_token"]').val(); // Ajusta según cómo tengas configurado tu formulario
    var reload = button.data('reload');

    // Ocultar el contenido del botón y mostrar el mensaje "Please Wait..."
    var buttonContent = button.find('.indicator-label');
    var pleaseWaitMessage = button.find('.indicator-progress');

    buttonContent.hide();
    pleaseWaitMessage.show();

    var formData = new FormData(form[0]); // Crea un objeto FormData con los datos del formulario

    $.ajax({
        url: action,
        method: method,
        data: formData, // Enviar datos como FormData
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            // Verificar si la respuesta contiene mensajes de éxito
            // if (response.success) {
                // Mostrar un mensaje de éxito con Toastr
                toastr.success(response.message);
                // Después de que se cierre el mensaje, recargar la página si es necesario
                if (reload) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500); // Tiempo en milisegundos antes de recargar
                }
            // }
        },
        error: function (xhr) {
            // Manejar la respuesta de error
            console.log(xhr.responseJSON);

            // Verificar si la respuesta contiene mensajes de error
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                // Mostrar mensajes de error específicos con SweetAlert
                var errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error al procesar la solicitud',
                    html: errorMessage
                });
            } else {
                // Mostrar mensaje de error genérico con SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error al procesar la solicitud',
                    text: 'Por favor, verifica los campos e inténtalo de nuevo.'
                });
            }
        },
        complete: function () {
            // Ocultar el mensaje "Please Wait..." y mostrar el contenido del botón después de completar la solicitud
            buttonContent.show();
            pleaseWaitMessage.hide();
        }
    });
});
