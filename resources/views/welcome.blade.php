<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autogestión SINEA</title>
    <link rel="stylesheet" href="{{ asset('assets/icons/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logos/inea.ico') }}" type="image/x-icon">
</head>

<body>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <div class="card">
                <div class="card-body">
                    <div class="modal show" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Gestión de Credenciales de Acceso en SINEA</h5>
                                    <button type="button" class="btn-close" onclick="resetForm()" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="alert" style="display:none;"></div>
                                    <form id="resetPasswordForm" class="was-validated">
                                        <div class="mb-3">
                                            <label for="cedula" class="form-label">Ingrese únicamente los dígitos numéricos de su documento de identificación:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input type="number" class="form-control" id="cedula" placeholder="Ej: 12345678">
                                            </div>
                                            <div class="invalid-feedback">Por favor, ingrese su cédula de identidad.</div>
                                            <div class="text-center mt-2">
                                                <button class="btn btn-success" type="button" onclick="buscarSolicitante()">Buscar <i class="fa-solid fa-magnifying-glass"></i></button>
                                            </div>
                                        </div>

                                        <div class="mb-3" id="solicitanteInfo" style="display:none;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="fas fa-user"></i> Información del Usuario</h5>
                                                    <br>
                                                    <div class="list-group col-12">
                                                        <div class="list-group-item d-flex align-items-center">
                                                            <div class="d-none">
                                                                <i class="fas fa-id-badge me-2"></i>
                                                                <div class="w-100">
                                                                    <strong>UserId</strong> <span id="user_id_display"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item d-flex align-items-center">
                                                            <i class="fas fa-user-circle me-2"></i>
                                                            <div class="w-100">
                                                                <strong>Nombre completo/Razón Social:</strong> <span id="nombre_completo_display"></span>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item d-flex align-items-center">
                                                            <i class="fas fa-envelope me-2"></i>
                                                            <div class="w-100">
                                                                <strong>Correo vinculado:</strong> <span id="email_display"></span>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item d-flex align-items-center">
                                                            <i class="fas fa-sign-in-alt me-2"></i>
                                                            <div class="w-100">
                                                                <strong>Usuario:</strong> <span id="login_display"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3" id="preguntasSeguridad" style="display:none;">
                                            <h5 class="alert alert-warning fw-bold fs-6">Para restablecer sus datos de acceso al SINEA, por favor, responda las siguientes preguntas de verificación <i class="fa-solid fa-circle-info"></i></h5>
                                            <div id="preguntas"></div>
                                        </div>

                                        <div class="mb-3" id="emailContainer" style="display:none;">
                                            <label for="email" class="form-label alert alert-warning fw-bold fs-6">
                                                Por favor, ingrese la dirección de correo electrónico donde desea recibir sus nuevas credenciales de acceso
                                                <i class="fa-solid fa-circle-info"></i>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control" placeholder="email@example.com" id="email" required>
                                                <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                                            </div>
                                        </div>

                                        <div class="mb-3" id="emailReportarCaso" style="display:none;">
                                            <label for="emailReportarCasoInput" class="form-label alert alert-warning fw-bold fs-6">
                                                Por favor, ingrese la dirección de correo electrónico para reportar caso.
                                                <i class="fa-solid fa-circle-info"></i>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control" placeholder="email@example.com" id="emailReportarCasoInput" required>
                                                <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                                            </div>
                                        </div>

                                        <div class="mb-3" id="reportarCasoButton" style="display:none;">
                                            <button type="button" class="btn btn-warning" id="btnReportarCaso">Reportar Caso <i class="fas fa-paper-plane"></i></button>
                                        </div>

                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-danger" onclick="resetForm()">
                                                <i class="fas fa-times-circle"></i> Borrar campos
                                            </button>
                                            <button type="button" class="btn btn-success" id="resetPasswordButton" style="display:none;">
                                                <i class="fas fa-check-circle"></i> Validar Respuestas
                                            </button>
                                            <button type="button" class="btn btn-success" id="solicitarContraseñaButton" style="display:none;">
                                                <i class="fas fa-key"></i> Solicitar Contraseña
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#exampleModal').modal('show');

            // Evento para el botón de reportar caso por duplicados
            $('#btnReportarCaso').click(function() {
                const email = $('#emailReportarCasoInput').val();
                const rif = $('#user_id_display').text();

                if (!email || !validateEmail(email)) {
                    mostrarAlerta('Por favor ingrese un correo electrónico válido', 'error');
                    $('#emailReportarCasoInput').addClass('is-invalid');
                    return;
                }

                $.ajax({
                    url: '{{ route('sinea.enviarCorreoDuplicados') }}',
                    method: 'POST',
                    data: {
                        emailReportarCaso: email,
                        rif: rif,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            mostrarAlerta(response.message, 'success');
                            resetForm();
                        } else {
                            mostrarAlerta(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        const errorMessage = errors ? Object.values(errors).flat().join(' ') :
                            'Error al reportar el caso. Intente nuevamente.';
                        mostrarAlerta(errorMessage, 'error');
                    }
                });
            });
        });

        function buscarSolicitante() {
            const cedula = $('#cedula').val();
            if (!cedula) {
                mostrarAlerta('Por favor ingrese su número de cédula', 'error');
                return;
            }

            $.ajax({
                url: '{{ route('sinea.buscarSolicitante') }}',
                method: 'GET',
                data: { cedula },
                success: function(response) {
                    console.log('Respuesta del servidor:', response); // Para depuración

                    if (response.success === false) {
                        if (response.message.includes('existe más de una vez')) {
                            // Caso de duplicados
                            mostrarDatosSolicitante(response.data, true);
                        } else {
                            // Otros casos de error
                            resetForm();
                            mostrarAlerta(response.message, 'error');
                        }
                    } else {
                        // Caso normal
                        mostrarDatosSolicitante(response.data, false);
                        mostrarAlerta('Datos encontrados con éxito.', 'success');
                    }
                },
                error: function(xhr) {
                    console.error('Error en la solicitud:', xhr); // Para depuración
                    resetForm();
                    mostrarAlerta('Error al buscar el solicitante. Intente nuevamente.', 'error');
                }
            });
        }

        function mostrarDatosSolicitante(data, esDuplicado) {
            // Mostrar información general del solicitante
            $('#nombre_completo_display').text(data.nombre || 'No disponible');
            $('#user_id_display').text(data.user_id || 'No disponible');
            $('#email_display').text(data.email || 'No disponible');
            $('#login_display').text(data.login || 'No disponible');
            $('#solicitanteInfo').show();

            // Ocultar todos los elementos primero para evitar superposiciones
            $('#emailReportarCaso, #reportarCasoButton, #preguntasSeguridad, #resetPasswordButton, #solicitarContraseñaButton').hide();

            if (esDuplicado) {
                mostrarCamposDuplicados();
            } else {
                mostrarPreguntasSeguridad(data.preguntas || {});
            }
        }

        function mostrarCamposDuplicados() {
            $('#emailReportarCaso, #reportarCasoButton').show(); // Mostrar el campo de email y botón
            $('#preguntasSeguridad, #resetPasswordButton, #solicitarContraseñaButton').hide(); // Ocultar otros elementos
            $('#emailReportarCasoInput').val('').removeClass('is-invalid'); // Limpiar el campo de email
            mostrarAlerta('La cédula existe más de una vez. Por favor, ingrese su correo para reportar su caso.', 'warning'); // Alerta específica
        }

        function mostrarPreguntasSeguridad(preguntas) {
            $('#preguntasSeguridad, #resetPasswordButton').show(); // Mostrar preguntas y botón de reset
            $('#emailReportarCaso, #reportarCasoButton').hide(); // Ocultar elementos de duplicados
            mostrarPreguntas(preguntas); // Mostrar preguntas de seguridad
        }

        function mostrarPreguntas(preguntas) {
            const preguntasContainer = $('#preguntas');
            preguntasContainer.empty();
            for (const key in preguntas) {
                let inputField = '';
                if (key === 'estado_civil') {
                    inputField = `
                        <div class="mb-3 form-floating">
                            <select class="form-select" id="floatingSelect${key}" data-key="${key}" required>
                                <option value="" selected>Seleccione...</option>
                                <option value="1">Soltero</option>
                                <option value="2">Casado</option>
                                <option value="3">Viudo</option>
                            </select>
                            <label for="floatingSelect${key}">${key.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, char => char.toUpperCase())}:</label>
                            <div class="invalid-feedback">Por favor, seleccione su estado civil.</div>
                        </div>
                    `;
                } else if (key === 'fecha_nacimiento') {
                    inputField = `
                        <div class="mb-3">
                            <label>${key.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, char => char.toUpperCase())}:</label>
                            <input type="date" class="form-control" data-key="${key}" required>
                            <div class="invalid-feedback">Por favor, ingrese su fecha de nacimiento.</div>
                        </div>`;
                } else if (key === 'sexo') {
                    inputField = `
                        <div class="mb-3 form-floating">
                            <select class="form-select" id="floatingSelect${key}" data-key="${key}" required>
                                <option value="" selected>Seleccione...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                            <label for="floatingSelect${key}">${key.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, char => char.toUpperCase())}:</label>
                            <div class="invalid-feedback">Por favor, seleccione su sexo.</div>
                        </div>
                    `;
                } else if (key === 'telefono') {
                    inputField = `
                        <div class="mb-3 form-floating">
                            <input type="tel" class="form-control" id="telefonoInput" data-key="${key}" required pattern="0[0-9]*" placeholder="Ej: 0123456789">
                            <label for="telefonoInput">${key.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, char => char.toUpperCase())}:</label>
                            <div class="invalid-feedback">Por favor, ingrese un número de teléfono válido que comience con 0.</div>
                        </div>`;
                } else {
                    inputField = `
                        <div class="mb-3">
                            <label>${key.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, char => char.toUpperCase())}:</label>
                            <input type="text" class="form-control" data-key="${key}" required>
                            <div class="invalid-feedback">Por favor, complete este campo.</div>
                        </div>`;
                }
                preguntasContainer.append(inputField);
            }
            preguntasContainer.show();
        }

        $('#resetPasswordButton').click(function() {
            const userId = $('#user_id_display').text();
            const respuestas = {};
            let valid = true;

            $('#preguntas input, #preguntas select').each(function() {
                const isRequired = $(this).prop('required');
                if (isRequired && !$(this).val()) {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                }
                respuestas[$(this).data('key')] = $(this).val();
            });

            if (!valid) {
                mostrarAlerta('Por favor, complete todos los campos obligatorios.', 'error');
                return;
            }

            $.ajax({
                url: '{{ route('sinea.validarPreguntas') }}',
                method: 'POST',
                data: {
                    user_id: userId,
                    respuestas,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#preguntas input, #preguntas select').each(function() {
                            $(this).removeClass('is-invalid').addClass('is-valid');
                        });
                        $('#emailContainer').show();
                        $('#solicitarContraseñaButton').show();
                        $('#resetPasswordButton').hide();
                    } else {
                        const errores = response.errores;
                        for (const [key, respuestaIncorrecta] of Object.entries(errores)) {
                            const inputField = $(`#preguntas [data-key="${key}"]`);
                            inputField.addClass('is-invalid');
                            inputField.find('.invalid-feedback').remove();
                            inputField.append(
                                `<div class="invalid-feedback">Respuesta incorrecta: ${respuestaIncorrecta}. Corrija por favor.</div>`
                            );
                            inputField.find('input, select').val('').focus();
                        }
                        mostrarAlerta('Algunas respuestas son incorrectas. Corrija los campos resaltados.', 'error');
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    const errorMessage = errors ? Object.values(errors).flat().join(' ') :
                        'Error al validar las respuestas. Intente nuevamente.';
                    mostrarAlerta(errorMessage, 'error');
                }
            });
        });

        $('#solicitarContraseñaButton').click(function() {
            const userId = $('#user_id_display').text();
            const email = $('#email').val();
            enviarNuevaContraseña(userId, email);
        });

        function enviarNuevaContraseña(userId, email) {
            $.ajax({
                url: '{{ route('sinea.updatePassword') }}',
                method: 'POST',
                data: {
                    user_id: userId,
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: `Se ha enviado un correo a ${email} con los detalles para acceder al sistema.`,
                        });
                        resetForm();
                    } else {
                        mostrarAlerta(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    const errorMessage = errors ? Object.values(errors).flat().join(' ') :
                        'Error al restablecer la contraseña. Intente nuevamente.';
                    mostrarAlerta(errorMessage, 'error');
                }
            });
        }

        function resetForm() {
            $('#resetPasswordForm')[0].reset();
            $('#solicitanteInfo, #preguntasSeguridad, #resetPasswordButton, #alert, #emailContainer, #reportarCasoButton, #solicitarContraseñaButton').hide();
            $('#nombre_completo_display, #user_id_display, #email_display, #login_display').text('');
            $('#preguntas').empty();
            $('#cedula, #email, #emailReportarCasoInput').removeClass('valid invalid');
            $('#preguntas input, #preguntas select').removeClass('is-invalid is-valid');
        }

        function mostrarAlerta(mensaje, tipo) {
            const icon = tipo === 'success' ? 'success' : 'error';
            Swal.fire({
                icon: icon,
                title: tipo === 'error' ? 'Error' : 'Éxito',
                text: mensaje,
                timer: 5000,
                showConfirmButton: false
            });
        }

        // Función auxiliar para validar email
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
</body>

</html>
