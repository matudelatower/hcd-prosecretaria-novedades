@extends('layouts.app')

@section('title', 'Detalles del Usuario')
@section('page-title', 'Detalles del Usuario')
@section('breadcrumb', 'Detalles del Usuario')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Información del Usuario</h3>
                <div class="card-tools">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre Completo</label>
                            <p class="form-control-plaintext">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rol</label>
                            <p>
                                <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    <i class="fas fa-{{ $user->role == 'admin' ? 'crown' : 'user' }}"></i> 
                                    {{ $user->role == 'admin' ? 'Administrador' : 'Responsable' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Responsable Asociado</label>
                            <p>
                                @if($user->responsable)
                                    <a href="{{ route('responsables.show', $user->responsable) }}" class="text-decoration-none">
                                        {{ $user->responsable->nombre_completo }}
                                    </a>
                                @else
                                    <span class="text-muted">Sin responsable asociado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Creación</label>
                            <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Última Actualización</label>
                            <p class="form-control-plaintext">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($user->id === Auth::id())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Este es tu usuario actual
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permisos del Rol</h3>
            </div>
            <div class="card-body">
                @if($user->role === 'admin')
                    <h6><i class="fas fa-crown text-danger"></i> Permisos de Administrador</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Gestionar Áreas</li>
                        <li><i class="fas fa-check text-success"></i> Gestionar Responsables</li>
                        <li><i class="fas fa-check text-success"></i> Gestionar Designaciones</li>
                        <li><i class="fas fa-check text-success"></i> Gestionar Usuarios</li>
                        <li><i class="fas fa-check text-success"></i> Gestionar Novedades</li>
                    </ul>
                @else
                    <h6><i class="fas fa-user text-primary"></i> Permisos de Responsable</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Cargar Novedades</li>
                        <li><i class="fas fa-check text-success"></i> Ver Dashboard</li>
                        <li><i class="fas fa-times text-danger"></i> No puede gestionar Áreas</li>
                        <li><i class="fas fa-times text-danger"></i> No puede gestionar Responsables</li>
                        <li><i class="fas fa-times text-danger"></i> No puede gestionar Designaciones</li>
                        <li><i class="fas fa-times text-danger"></i> No puede gestionar Usuarios</li>
                    </ul>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Acciones</h3>
            </div>
            <div class="card-body">
                <div class="btn-group-vertical w-100">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Usuario
                    </a>
                    @if($user->id !== Auth::id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Está seguro que desea eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar Usuario
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
