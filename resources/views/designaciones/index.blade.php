@extends('layouts.app')

@section('title', 'Listado de Designaciones')
@section('page-title', 'Designaciones')
@section('breadcrumb', 'Designaciones')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Designaciones</h3>
                <div class="card-tools">
                    <a href="{{ route('designaciones.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Designación
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Área</th>
                            <th>Responsable</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Periodicidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($designaciones as $designacion)
                            <tr>
                                <td>
                                    <a href="{{ route('areas.show', $designacion->area) }}" class="text-decoration-none">
                                        {{ $designacion->area->nombre }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('responsables.show', $designacion->responsable) }}" class="text-decoration-none">
                                        {{ $designacion->responsable->nombre_completo }}
                                    </a>
                                </td>
                                <td>{{ $designacion->fecha_inicio->format('d/m/Y') }}</td>
                                <td>{{ $designacion->fecha_fin ? $designacion->fecha_fin->format('d/m/Y') : 'Indefinida' }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ ucfirst($designacion->periodicidad) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $designacion->activa() ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $designacion->activa() ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('designaciones.show', $designacion) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('designaciones.edit', $designacion) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('designaciones.destroy', $designacion) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar esta designación?')" title="Eliminar">
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
                                <td colspan="7" class="text-center">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay designaciones registradas</p>
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
