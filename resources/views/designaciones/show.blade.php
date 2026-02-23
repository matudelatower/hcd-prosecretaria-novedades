@extends('layouts.app')

@section('title', 'Detalles de Designación')
@section('page-title', 'Detalles de Designación')
@section('breadcrumb', 'Detalles de Designación')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Información de la Designación</h3>
                <div class="card-tools">
                    <a href="{{ route('designaciones.edit', $designacion) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Área</label>
                            <p class="form-control-plaintext">
                                <a href="{{ route('areas.show', $designacion->area) }}" class="text-decoration-none">
                                    {{ $designacion->area->nombre }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Responsable</label>
                            <p class="form-control-plaintext">
                                <a href="{{ route('responsables.show', $designacion->responsable) }}" class="text-decoration-none">
                                    {{ $designacion->responsable->nombre_completo }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha Inicio</label>
                            <p class="form-control-plaintext">{{ $designacion->fecha_inicio->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha Fin</label>
                            <p class="form-control-plaintext">{{ $designacion->fecha_fin ? $designacion->fecha_fin->format('d/m/Y') : 'Indefinida' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Periodicidad</label>
                            <p class="form-control-plaintext">
                                <span class="badge badge-info">
                                    {{ ucfirst($designacion->periodicidad) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $designacion->activa() ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $designacion->activa() ? 'Activa' : 'Inactiva' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Observaciones</label>
                    <p class="form-control-plaintext">{{ $designacion->observaciones ?: 'Sin observaciones' }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Creación</label>
                            <p class="form-control-plaintext">{{ $designacion->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Última Actualización</label>
                            <p class="form-control-plaintext">{{ $designacion->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información Adicional</h3>
            </div>
            <div class="card-body">
                <h6>Detalles de la Designación</h6>
                <ul class="list-unstyled">
                    <li><strong>Área:</strong> {{ $designacion->area->nombre }}</li>
                    <li><strong>Responsable:</strong> {{ $designacion->responsable->nombre_completo }}</li>
                    <li><strong>Periodicidad:</strong> {{ ucfirst($designacion->periodicidad) }}</li>
                    <li><strong>Estado:</strong> 
                        <span class="badge {{ $designacion->activa() ? 'bg-success' : 'bg-secondary' }}">
                            {{ $designacion->activa() ? 'Activa' : 'Inactiva' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Acciones</h3>
            </div>
            <div class="card-body">
                <div class="btn-group-vertical w-100">
                    <a href="{{ route('designaciones.edit', $designacion) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Designación
                    </a>
                    <form action="{{ route('designaciones.destroy', $designacion) }}" method="POST" onsubmit="return confirm('¿Está seguro que desea eliminar esta designación?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Eliminar Designación
                        </button>
                    </form>
                    <a href="{{ route('designaciones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
