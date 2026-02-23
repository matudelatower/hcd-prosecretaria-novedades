@extends('layouts.app')

@section('title', 'Editar Responsable')
@section('page-title', 'Editar Responsable')
@section('breadcrumb', 'Editar Responsable')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Datos del Responsable</h3>
            </div>
            <form action="{{ route('responsables.update', $responsable) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre', $responsable->nombre) }}" required>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                               id="apellido" name="apellido" value="{{ old('apellido', $responsable->apellido) }}" required>
                        @error('apellido')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dni">DNI <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror" 
                               id="dni" name="dni" value="{{ old('dni', $responsable->dni) }}" required>
                        @error('dni')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" name="telefono" value="{{ old('telefono', $responsable->telefono) }}">
                        @error('telefono')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ $responsable->activo ? 'checked' : '' }}>
                            <label class="custom-control-label" for="activo">Activo</label>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="crear_usuario" name="crear_usuario" value="1" {{ $responsable->user ? 'checked' : '' }}>
                            <label class="custom-control-label" for="crear_usuario">
                                <strong>Gestionar usuario de acceso al sistema</strong>
                            </label>
                        </div>
                        <small class="form-text text-muted">Si marca esta opción, podrá crear o actualizar el usuario para que el responsable pueda iniciar sesión.</small>
                    </div>

                    <div id="campos_usuario" style="display: {{ $responsable->user ? 'block' : 'none' }};">
                        <div class="card card-info">
                            <div class="card-header">
                                <h5 class="card-title">Datos de Acceso al Sistema</h5>
                            </div>
                            <div class="card-body">
                                @if($responsable->user)
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Este responsable ya tiene un usuario creado. Puede actualizar los datos o eliminar el usuario.
                                        <br><strong>Rol actual:</strong> <span class="badge {{ $responsable->user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                            {{ $responsable->user->role == 'admin' ? 'Administrador' : 'Responsable' }}
                                        </span>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="email_usuario">Email de usuario <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email_usuario') is-invalid @enderror" 
                                           id="email_usuario" name="email_usuario" value="{{ old('email_usuario', $responsable->user->email ?? '') }}">
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
                                        <option value="responsable" {{ old('role', $responsable->user->role ?? '') == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                        <option value="admin" {{ old('role', $responsable->user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrador</option>
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
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" placeholder="Dejar en blanco para mantener actual">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" onclick="generarPassword()">
                                                <i class="fas fa-key"></i> Generar
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Nueva contraseña para el acceso al sistema</small>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                @if($responsable->user)
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="eliminar_usuario" name="eliminar_usuario" value="1">
                                            <label class="custom-control-label text-danger" for="eliminar_usuario">
                                                <strong>Eliminar usuario del sistema</strong>
                                            </label>
                                        </div>
                                        <small class="form-text text-danger">Si marca esta opción, el responsable ya no podrá iniciar sesión.</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-2"></i>Actualizar Responsable
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
                    Modifique los datos del responsable. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                </p>
                <hr>
                <h6>Notas:</h6>
                <ul class="mb-0">
                    <li>El DNI debe ser único</li>
                    <li>Los responsables inactivos no podrán ser asignados</li>
                    <li>Si crea un usuario, el responsable podrá iniciar sesión</li>
                    <li>Los administradores pueden gestionar todo el sistema</li>
                    <li>Los responsables solo pueden cargar novedades</li>
                    @if($responsable->user)
                        <li class="text-info"><i class="fas fa-user"></i> Usuario actual: {{ $responsable->user->email }}</li>
                        <li class="text-info"><i class="fas fa-shield-alt"></i> Rol: {{ $responsable->user->role == 'admin' ? 'Administrador' : 'Responsable' }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('crear_usuario').addEventListener('change', function() {
    var camposUsuario = document.getElementById('campos_usuario');
    camposUsuario.style.display = this.checked ? 'block' : 'none';
    
    if (this.checked && !document.getElementById('email_usuario').value) {
        // Generar email sugerido si está vacío
        var nombre = document.getElementById('nombre').value.toLowerCase().replace(' ', '.');
        var apellido = document.getElementById('apellido').value.toLowerCase().replace(' ', '.');
        var emailSugerido = nombre + '.' + apellido + '@hcd.gov';
        document.getElementById('email_usuario').value = emailSugerido;
    }
});

function generarPassword() {
    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var password = '';
    for (var i = 0; i < 8; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('password').value = password;
}
</script>
@endsection
