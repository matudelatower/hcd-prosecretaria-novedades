@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')
@section('breadcrumb', 'Editar Usuario')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Datos del Usuario</h3>
            </div>
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        <small class="form-text text-muted">Este email se usará para iniciar sesión en el sistema</small>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Rol <span class="text-danger">*</span></label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Seleccionar rol...</option>
                            <option value="responsable" {{ old('role', $user->role) == 'responsable' ? 'selected' : '' }}>Responsable</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
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
                        <label for="password">Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" id="togglePasswordBtn">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Dejar en blanco para mantener actual">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="generarPassword()">
                                    <i class="fas fa-key"></i> Generar
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="copiarPassword()" id="copiarBtn">
                                    <i class="fas fa-copy"></i> Copiar
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Deje en blanco para mantener la contraseña actual</small>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-2"></i>Actualizar Usuario
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
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
                    Modifique los datos del usuario. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                </p>
                <hr>
                <h6>Notas:</h6>
                <ul class="mb-0">
                    <li>El email debe ser único en el sistema</li>
                    <li>La contraseña debe tener al menos 6 caracteres si se cambia</li>
                    <li>Los administradores pueden gestionar todo el sistema</li>
                    <li>Los responsables solo pueden cargar novedades</li>
                    <li>Puede generar una contraseña segura automáticamente</li>
                    @if($user->id === Auth::id())
                        <li class="text-info"><i class="fas fa-info-circle"></i> Este es tu usuario actual</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
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
