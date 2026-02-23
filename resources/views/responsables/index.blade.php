@extends('layouts.app')

@section('title', 'Listado de Responsables')
@section('page-title', 'Responsables')
@section('breadcrumb', 'Responsables')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Responsables</h3>
                <div class="card-tools">
                    <a href="{{ route('responsables.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Responsable
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Usuario Sistema</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($responsables as $responsable)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="image mr-3">
                                            <i class="fas fa-user-circle img-circle elevation-2" style="font-size: 2rem;"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $responsable->nombre_completo }}</strong>
                                            @if($responsable->user)
                                                <br><small class="text-success"><i class="fas fa-user-check"></i> Tiene acceso al sistema</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $responsable->dni }}</td>
                                <td>{{ $responsable->telefono ?: '-' }}</td>
                                <td>
                                    @if($responsable->user)
                                        <div>
                                            <span class="badge {{ $responsable->user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                                <i class="fas fa-{{ $responsable->user->role == 'admin' ? 'crown' : 'user' }}"></i> 
                                                {{ $responsable->user->role == 'admin' ? 'Administrador' : 'Responsable' }}
                                            </span>
                                            <br><small class="text-muted">{{ $responsable->user->email }}</small>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times"></i> Sin usuario
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $responsable->activo ? 'bg-success' : 'bg-danger' }}">
                                        {{ $responsable->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('responsables.show', $responsable) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('responsables.edit', $responsable) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('responsables.destroy', $responsable) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar este responsable?')" title="Eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay responsables registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
