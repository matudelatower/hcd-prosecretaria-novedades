@extends('layouts.app')

@section('title', 'Crear Responsable')
@section('page-title', 'Nuevo Responsable')
@section('breadcrumb', 'Nuevo Responsable')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos del Responsable</h3>
            </div>
            <form action="{{ route('responsables.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                               id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                        @error('apellido')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dni">DNI <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror" 
                               id="dni" name="dni" value="{{ old('dni') }}" required>
                        @error('dni')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" name="telefono" value="{{ old('telefono') }}">
                        @error('telefono')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" checked>
                            <label class="custom-control-label" for="activo">Activo</label>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="crear_usuario" name="crear_usuario" value="1">
                            <label class="custom-control-label" for="crear_usuario">
                                <strong>Crear usuario para acceso al sistema</strong>
                            </label>
                        </div>
                        <small class="form-text text-muted">Si marca esta opción, podrá crear un usuario para que el responsable pueda iniciar sesión.</small>
                    </div>

                    <div id="campos_usuario" style="display: none;">
                        <div class="card card-info">
                            <div class="card-header">
                                <h5 class="card-title">Datos de Acceso al Sistema</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email_usuario">Email de usuario <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email_usuario') is-invalid @enderror" 
                                           id="email_usuario" name="email_usuario" value="{{ old('email_usuario') }}">
                                    <small class="form-text text-muted">Este email se usará para iniciar sesión en el sistema</small>
                                    @error('email_usuario')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role">Rol <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                        <option value="">Seleccionar rol...</option>
                                        <option value="responsable" {{ old('role') == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                    <small class="form-text text-muted">
                                        <strong>Responsable:</strong> Solo puede cargar novedades<br>
                                        <strong>Administrador:</strong> Puede gestionar todo el sistema
                                    </small>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" id="togglePasswordBtn">
                                                <i class="fas fa-eye" id="toggleIcon"></i>
                                            </button>
                                        </div>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" placeholder="Mínimo 6 caracteres">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" onclick="generarPassword()">
                                                <i class="fas fa-key"></i> Generar
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="copiarPassword()" id="copiarBtn">
                                                <i class="fas fa-copy"></i> Copiar
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Contraseña para el acceso al sistema</small>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Guardar Responsable
                    </button>
                    <a href="{{ route('responsables.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Complete los datos del responsable. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                </p>
                <hr>
                <h6>Notas:</h6>
                <ul class="mb-0">
                    <li>El DNI debe ser único</li>
                    <li>Los responsables inactivos no podrán ser asignados</li>
                    <li>Si crea un usuario, el responsable podrá iniciar sesión</li>
                    <li>Los administradores pueden gestionar todo el sistema</li>
                    <li>Los responsables solo pueden cargar novedades</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('crear_usuario').addEventListener('change', function() {
    var camposUsuario = document.getElementById('campos_usuario');
    camposUsuario.style.display = this.checked ? 'block' : 'none';
    
    if (this.checked) {
        // Generar email sugerido
        var nombre = document.getElementById('nombre').value.toLowerCase().replace(' ', '.');
        var apellido = document.getElementById('apellido').value.toLowerCase().replace(' ', '.');
        var emailSugerido = nombre + '.' + apellido + '@hcd.gov';
        document.getElementById('email_usuario').value = emailSugerido;
        
        // Por defecto, asignar rol de responsable
        document.getElementById('role').value = 'responsable';
    }
});

function generarPassword() {
    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var password = '';
    for (var i = 0; i < 8; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('password').value = password;
    mostrarMensaje('¡Contraseña generada!', 'success');
}

function togglePassword() {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

function copiarPassword() {
    var passwordInput = document.getElementById('password');
    var password = passwordInput.value;
    
    if (!password) {
        mostrarMensaje('¡Primero genera una contraseña!', 'warning');
        return;
    }
    
    // Copiar al portapapeles
    navigator.clipboard.writeText(password).then(function() {
        mostrarMensaje('¡Contraseña copiada al portapapeles!', 'success');
    }).catch(function(err) {
        // Fallback para navegadores antiguos
        passwordInput.select();
        document.execCommand('copy');
        mostrarMensaje('¡Contraseña copiada!', 'success');
    });
}

function mostrarMensaje(mensaje, tipo) {
    // Crear alerta flotante
    var alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-' + tipo + ' alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
    alertDiv.innerHTML = 
        '<button type="button" class="close" data-dismiss="alert">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' + mensaje;
    
    document.body.appendChild(alertDiv);
    
    // Auto-eliminar después de 3 segundos
    setTimeout(function() {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 3000);
}
</script>
@endsection
