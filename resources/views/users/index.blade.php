@extends('layouts.app')

@section('title', 'Listado de Usuarios')
@section('page-title', 'Usuarios')
@section('breadcrumb', 'Usuarios')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Usuarios del Sistema</h3>
                <div class="card-tools">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Responsable Asociado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="image mr-3">
                                            <i class="fas fa-user-circle img-circle elevation-2" style="font-size: 2rem;"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            @if($user->id === Auth::id())
                                                <br><small class="text-info"><i class="fas fa-user"></i> Usuario actual</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                        <i class="fas fa-{{ $user->role == 'admin' ? 'crown' : 'user' }}"></i> 
                                        {{ $user->role == 'admin' ? 'Administrador' : 'Responsable' }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->responsable)
                                        <a href="{{ route('responsables.show', $user->responsable) }}" class="text-decoration-none">
                                            {{ $user->responsable->nombre_completo }}
                                        </a>
                                    @else
                                        <span class="text-muted">Sin responsable asociado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar este usuario?')" title="Eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay usuarios registrados</p>
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
