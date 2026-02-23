@extends('layouts.app')

@section('title', 'Listado de Áreas')
@section('page-title', 'Áreas')
@section('breadcrumb', 'Áreas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Áreas</h3>
                <div class="card-tools">
                    <a href="{{ route('areas.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Área
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Padre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($areas as $area)
                            <tr>
                                <td>
                                    <strong>{{ $area->nombre }}</strong>
                                    @if($area->descripcion)
                                        <br><small class="text-muted">{{ Str::limit($area->descripcion, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $area->codigo }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $area->tipo == 'edificio' ? 'bg-purple' : '' }}
                                        {{ $area->tipo == 'oficina' ? 'bg-info' : '' }}
                                        {{ $area->tipo == 'area' ? 'bg-success' : '' }}">
                                        {{ ucfirst($area->tipo) }}
                                    </span>
                                </td>
                                <td>{{ $area->padre ? $area->padre->nombre : '-' }}</td>
                                <td>
                                    <span class="badge {{ $area->activo ? 'bg-success' : 'bg-danger' }}">
                                        {{ $area->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('areas.show', $area) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('areas.edit', $area) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('areas.destroy', $area) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar esta área?')">
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
                                    No hay áreas registradas
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
