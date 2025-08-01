<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('assets/icons/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
</head>

<body>

    <div
        class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row"> 

                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Olvidé mi Contraseña</button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Solicitud de Restablecimiento de
                                            Contraseña</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="alert" style="display:none;"></div>

                                        <form id="resetPasswordForm" class="was-validated">
                                            <div class="mb-3">
                                                <label for="cedula" class="col-form-label">Cédula de
                                                    identidad:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                    <input type="number" class="form-control" id="cedula"
                                                        onchange="buscarSolicitante()" required
                                                        onkeydown="return soloNumeros(event)">
                                                </div>
                                                <div class="invalid-feedback">Por favor, ingrese su cédula de identidad.
                                                </div>
                                            </div>

                                            <div class="mb-3" id="solicitanteInfo" style="display:none;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><i class="fas fa-user"></i> Información
                                                            del Usuario</h5>
                                                        <br>
                                                        <div class="list-group col-12">
                                                            <div class="list-group-item d-flex align-items-center">
                                                                <i class="fas fa-id-badge me-2"></i>
                                                                <div class="w-100">
                                                                    <strong>UserId</strong> <span
                                                                        id="user_id_display"></span>
                                                                </div>
                                                            </div>
                                                            <div class="list-group-item d-flex align-items-center">
                                                                <i class="fas fa-user-circle me-2"></i>
                                                                <div class="w-100">
                                                                    <strong>Nombre Completo:</strong> <span
                                                                        id="nombre_completo_display"></span>
                                                                </div>
                                                            </div>
                                                            <div class="list-group-item d-flex align-items-center">
                                                                <i class="fas fa-envelope me-2"></i>
                                                                <div class="w-100">
                                                                    <strong>Correo vinculado:</strong> <span
                                                                        id="email_display"></span>
                                                                </div>
                                                            </div>
                                                            <div class="list-group-item d-flex align-items-center">
                                                                <i class="fas fa-sign-in-alt me-2"></i>
                                                                <div class="w-100">
                                                                    <strong>Login:</strong> <span
                                                                        id="login_display"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3" id="preguntasSeguridad" style="display:none;">
                                                <h5>Responda las siguientes preguntas de seguridad:</h5>
                                                <div id="preguntas"></div>
                                            </div>

                                            <div class="mb-3" id="emailContainer" style="display:none;">
                                                <label for="email" class="col-form-label">Ingrese su correo
                                                    electrónico:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-envelope"></i></span>
                                                    <input type="email" class="form-control"
                                                        placeholder="email@example.com" id="email" required>
                                                </div>
                                                <div class="invalid-feedback">Por favor, ingrese un correo electrónico
                                                    válido.</div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="resetPasswordButton" style="display:none;">Validar
                                                    Respuestas</button>
                                                <button type="button" class="btn btn-success"
                                                    id="solicitarContraseñaButton" style="display:none;">Solicitar
                                                    Contraseña</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div
                class="bg-[#fff2f2] dark:bg-[#1D0002] relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">
                {{-- Aquí puedes agregar el logo de Laravel o cualquier otro contenido --}}
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function buscarSolicitante() {
            const cedula = $('#cedula').val();
            $.ajax({
                url: '{{ route('sinea.buscarSolicitante') }}',
                method: 'GET',
                data: {
                    cedula
                },
                success: function(response) {
                    if (response.success) {
                        mostrarDatosSolicitante(response.data);
                        mostrarAlerta('Datos encontrados con éxito.', 'success');
                    } else {
                        resetForm();
                        mostrarAlerta(response.message, 'error');
                    }
                },
                error: function() {
                    resetForm();
                    mostrarAlerta('Error al buscar el solicitante. Intente nuevamente.', 'error');
                }
            });
        }

        function mostrarDatosSolicitante(data) {
            $('#nombre_completo_display').text(data.nombre);
            $('#user_id_display').text(data.user_id);
            $('#email_display').text(data.email);
            $('#login_display').text(data.login);
            $('#solicitanteInfo, #preguntasSeguridad, #resetPasswordButton').show();
            $('#emailContainer, #solicitarContraseñaButton').hide();
            mostrarPreguntas(data.preguntas);
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
                            <input type="tel" class="form-control" id="telefonoInput" data-key="${key}" required pattern="0[0-9]*" placeholder="Ej: 0123456789" onkeydown="return soloNumeros(event)">
                            <label for="telefonoInput">${key.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, char => char.toUpperCase())}:</label>
                            <div class="invalid-feedback">Por favor, ingrese un número de teléfono válido que comience con 0.</div>
                        </div>`;
                } else {
                    inputField = `
                        <div class="mb-3">
                            <label>${key.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, char => char.toUpperCase())}:</label>
                            <input type="text" class="form-control" data-key="${key}" required>
                            <div class="invalid-feedback">Por favor, complete su lugar de nacimiento.</div>
                        </div>`;
                }
                preguntasContainer.append(inputField);
            }
            preguntasContainer.show();
        }

        $('#resetPasswordButton').click(function() {
            const userId = $('#user_id_display').text();
            const email = $('#email').val();
            const respuestas = {};
            let valid = true;

            $('#preguntas input, #preguntas select').each(function() {
                const isRequired = $(this).prop('required');
                if (isRequired && !$(this).val()) {
                    $(this).addClass('invalid');
                    valid = false;
                } else {
                    $(this).removeClass('invalid').addClass('valid');
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
                            mostrarAlerta(
                                'Algunas respuestas son incorrectas. Corrija los campos resaltados.',
                                'error');
                        }
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
            $('#solicitanteInfo, #preguntasSeguridad, #resetPasswordButton, #alert, #emailContainer, #solicitarContraseñaButton')
                .hide();
            $('#nombre_completo_display, #user_id_display, #email_display, #login_display').text('');
            $('#preguntas').empty();
            $('#cedula, #email').removeClass('valid invalid');
            $('#preguntas input, #preguntas select').removeClass('is-invalid is-valid');
        }

        function mostrarAlerta(mensaje, tipo) {
            const alertDiv = $('#alert');
            alertDiv.removeClass('alert-success alert-danger')
                .addClass(tipo === 'success' ? 'alert alert-success' : 'alert alert-danger')
                .html(mensaje)
                .show();
            setTimeout(() => alertDiv.hide(), 5000);
        }
    </script>
    <script src="{{ asset('assets/js/funciones.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>