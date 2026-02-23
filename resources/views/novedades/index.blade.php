@extends('layouts.app')

@section('title', 'Listado de Novedades')
@section('page-title', 'Novedades')
@section('breadcrumb', 'Novedades')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Novedades</h3>
                <div class="card-tools">
                    <a href="{{ route('novedades.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Novedad
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Área</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($novedades as $novedad)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-start">
                                        @if($novedad->imagenes && $novedad->imagenes->count() > 0)
                                            <div class="mr-3">
                                                <img src="{{ asset('storage/novedades/' . $novedad->imagenes->first()->imagen) }}" 
                                                     alt="Imagen" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($novedad->descripcion, 80) }}</strong>
                                            @if($novedad->imagenes && $novedad->imagenes->count() > 0)
                                                <br><small class="text-muted"><i class="fas fa-images"></i> {{ $novedad->imagenes->count() }} imagen(es)</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge 
                                        {{ $novedad->tipo == 'incidencia' ? 'bg-danger' : '' }}
                                        {{ $novedad->tipo == 'mantenimiento' ? 'bg-warning' : '' }}
                                        {{ $novedad->tipo == 'evento' ? 'bg-info' : '' }}
                                        {{ $novedad->tipo == 'otro' ? 'bg-secondary' : '' }}">
                                        {{ ucfirst($novedad->tipo) }}
                                    </span>
                                </td>
                                <td>{{ $novedad->fecha->format('d/m/Y') }}</td>
                                <td>{{ $novedad->area->nombre }}</td>
                                <td>{{ $novedad->responsable ? $novedad->responsable->nombre_completo : '-' }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $novedad->estado == 'pendiente' ? 'bg-warning' : '' }}
                                        {{ $novedad->estado == 'en_progreso' ? 'bg-info' : '' }}
                                        {{ $novedad->estado == 'resuelto' ? 'bg-success' : '' }}">
                                        {{ ucfirst($novedad->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('novedades.show', $novedad) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('novedades.edit', $novedad) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('novedades.destroy', $novedad) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar esta novedad?')">
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
                                    <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay novedades registradas</p>
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
